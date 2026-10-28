<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace enrol_apply;

use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Tests for the application flow: request, notify reviewers, confirm, defer and cancel.
 *
 * @package    enrol_apply
 * @copyright  2026 Libreria de Satoshi
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[CoversClass(\enrol_apply_plugin::class)]
final class lib_test extends \advanced_testcase {
    /** @var \enrol_apply_plugin */
    private $plugin;

    #[\Override]
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
        set_config('enrol_plugins_enabled', 'manual,apply');
        $this->plugin = enrol_get_plugin('apply');
    }

    /**
     * A course with an enrol_apply instance.
     *
     * @param array $fields instance fields over the defaults
     * @param array $course course fields
     * @return array [course, instance]
     */
    private function course_with_instance(array $fields = [], array $course = []): array {
        global $DB;
        $course = $this->getDataGenerator()->create_course($course + ['fullname' => 'Basic rules for writing prompts']);
        $id = $this->plugin->add_instance($course, $fields + $this->plugin->get_instance_defaults());
        return [$course, $DB->get_record('enrol', ['id' => $id], '*', MUST_EXIST)];
    }

    /**
     * The user's enrolment in the instance.
     *
     * @param \stdClass $instance
     * @param int $userid
     * @return \stdClass|false
     */
    private function enrolment(\stdClass $instance, int $userid) {
        global $DB;
        return $DB->get_record('user_enrolments', ['enrolid' => $instance->id, 'userid' => $userid]);
    }

    public function test_new_instances_ask_for_no_profile_fields(): void {
        [, $instance] = $this->course_with_instance();
        $this->assertEquals(0, $instance->customint1);
        $this->assertEquals(0, $instance->customint2);
    }

    public function test_applying_leaves_a_suspended_enrolment_with_the_comment(): void {
        global $DB;
        [, $instance] = $this->course_with_instance();
        $student = $this->getDataGenerator()->create_user();
        $this->redirectMessages();

        $this->plugin->apply($instance, $student->id, (object) ['applydescription' => 'Applied on the website']);

        $ue = $this->enrolment($instance, $student->id);
        $this->assertEquals(ENROL_USER_SUSPENDED, $ue->status);
        $this->assertEquals(0, $ue->timeend);
        $this->assertSame('Applied on the website',
            $DB->get_field('enrol_apply_applicationinfo', 'comment', ['userenrolmentid' => $ue->id]));
        $this->assertFalse(is_enrolled(\context_course::instance($instance->courseid), $student, '', true));
    }

    public function test_reviewers_are_notified_once_each_with_the_applicant_email(): void {
        [$course, $instance] = $this->course_with_instance(['customtext3' => '$@ALL@$']);
        $generator = $this->getDataGenerator();
        $teacher = $generator->create_user();
        $generator->enrol_user($teacher->id, $course->id, 'editingteacher');
        $manager = $generator->create_user();
        $generator->role_assign($this->get_role('manager'), $manager->id);
        // The teacher is a course reviewer and also chosen globally: still one message.
        $this->plugin->set_config('notifyglobal', $manager->id . ',' . $teacher->id);
        $student = $generator->create_user(['email' => 'ana@example.com']);
        $sink = $this->redirectMessages();

        $this->plugin->apply($instance, $student->id, (object) []);

        $messages = $sink->get_messages();
        $to = array_map(fn($m) => (int) $m->useridto, $messages);
        sort($to);
        $expected = [(int) $teacher->id, (int) $manager->id];
        sort($expected);
        $this->assertSame($expected, $to);
        foreach ($messages as $message) {
            $this->assertSame('application', $message->eventtype);
            $this->assertSame('New request to join a course', $message->subject);
            $this->assertStringContainsString('ana@example.com', $message->fullmessagehtml);
            $this->assertStringNotContainsString(get_string('comment', 'enrol_apply'), $message->fullmessagehtml);
        }
    }

    public function test_a_site_admin_chosen_in_the_settings_is_notified(): void {
        [, $instance] = $this->course_with_instance();
        $admin = get_admin();
        $this->plugin->set_config('notifyglobal', $admin->id);
        $student = $this->getDataGenerator()->create_user();
        $sink = $this->redirectMessages();

        $this->plugin->apply($instance, $student->id, (object) []);

        $this->assertSame([(int) $admin->id], array_map(fn($m) => (int) $m->useridto, $sink->get_messages()));
    }

    public function test_confirming_enrols_the_student_and_emails_the_default_text(): void {
        // The course starts in the future: the confirmation is still sent.
        [$course, $instance] = $this->course_with_instance([], ['startdate' => time() + 60 * DAYSECS]);
        $student = $this->getDataGenerator()->create_user(['firstname' => 'Ana']);
        $this->plugin->apply($instance, $student->id, (object) []);
        $this->setAdminUser();
        $sink = $this->redirectMessages();

        $this->plugin->confirm_enrolment([$this->enrolment($instance, $student->id)->id]);

        $this->assertEquals(ENROL_USER_ACTIVE, $this->enrolment($instance, $student->id)->status);
        $this->assertTrue(is_enrolled(\context_course::instance($course->id), $student, '', true));
        $messages = $sink->get_messages();
        $this->assertCount(1, $messages);
        $this->assertEquals($student->id, $messages[0]->useridto);
        $this->assertSame('confirmation', $messages[0]->eventtype);
        $this->assertSame('You are enrolled in Basic rules for writing prompts', $messages[0]->subject);
        $this->assertStringContainsString('Hi Ana,', $messages[0]->fullmessagehtml);
        $this->assertStringContainsString((new \moodle_url('/course/view.php', ['id' => $course->id]))->out(false),
            $messages[0]->fullmessagehtml);
    }

    public function test_configured_email_texts_replace_the_defaults(): void {
        $this->plugin->set_config('confirmmailsubject', 'Welcome');
        $this->plugin->set_config('confirmmailcontent', '<p>{firstname}, see you in {content}.</p>');
        [, $instance] = $this->course_with_instance();
        $student = $this->getDataGenerator()->create_user(['firstname' => 'Ana']);
        $this->plugin->apply($instance, $student->id, (object) []);
        $this->setAdminUser();
        $sink = $this->redirectMessages();

        $this->plugin->confirm_enrolment([$this->enrolment($instance, $student->id)->id]);

        $message = $sink->get_messages()[0];
        $this->assertSame('Welcome', $message->subject);
        $this->assertSame('<p>Ana, see you in Basic rules for writing prompts.</p>', $message->fullmessagehtml);
    }

    public function test_deferring_puts_the_request_on_the_waiting_list_and_it_can_still_be_confirmed(): void {
        [, $instance] = $this->course_with_instance();
        $student = $this->getDataGenerator()->create_user();
        $this->plugin->apply($instance, $student->id, (object) []);
        $this->setAdminUser();
        $sink = $this->redirectMessages();
        $ueid = $this->enrolment($instance, $student->id)->id;

        $this->plugin->wait_enrolment([$ueid]);

        $this->assertEquals(ENROL_APPLY_USER_WAIT, $this->enrolment($instance, $student->id)->status);
        $this->assertSame('waitinglist', $sink->get_messages()[0]->eventtype);
        $this->assertSame('Your request to join Basic rules for writing prompts is on the waiting list',
            $sink->get_messages()[0]->subject);

        $this->plugin->confirm_enrolment([$ueid]);
        $this->assertEquals(ENROL_USER_ACTIVE, $this->enrolment($instance, $student->id)->status);
    }

    public function test_cancelling_removes_the_request_and_tells_the_student(): void {
        global $DB;
        [, $instance] = $this->course_with_instance();
        $student = $this->getDataGenerator()->create_user();
        $this->plugin->apply($instance, $student->id, (object) []);
        $this->setAdminUser();
        $sink = $this->redirectMessages();
        $ueid = $this->enrolment($instance, $student->id)->id;

        $this->plugin->cancel_enrolment([$ueid]);

        $this->assertFalse($this->enrolment($instance, $student->id));
        $this->assertFalse($DB->record_exists('enrol_apply_applicationinfo', ['userenrolmentid' => $ueid]));
        $this->assertSame('Your request to join Basic rules for writing prompts was not accepted',
            $sink->get_messages()[0]->subject);
    }

    public function test_the_enrolment_page_shows_the_request_in_cores_enrolment_card(): void {
        global $PAGE;
        [$course, $instance] = $this->course_with_instance(['name' => 'Apply for a scholarship']);
        $this->setUser($this->getDataGenerator()->create_user());
        $PAGE->set_url('/enrol/index.php', ['id' => $course->id]);
        $PAGE->set_course($course);

        $html = $this->plugin->enrol_page_hook($instance);

        $this->assertStringContainsString('data-enrol="apply"', $html);
        $this->assertStringContainsString('<h3 class="mb-0">Apply for a scholarship</h3>', $html);
        $this->assertStringContainsString('full-width-labels', $html);
        $this->assertStringContainsString(get_string('requestaccess', 'enrol_apply'), $html);
    }

    public function test_someone_without_the_capability_cannot_confirm(): void {
        [, $instance] = $this->course_with_instance();
        $student = $this->getDataGenerator()->create_user();
        $this->plugin->apply($instance, $student->id, (object) []);
        $this->setUser($this->getDataGenerator()->create_user());

        $this->plugin->confirm_enrolment([$this->enrolment($instance, $student->id)->id]);

        $this->assertEquals(ENROL_USER_SUSPENDED, $this->enrolment($instance, $student->id)->status);
    }

    /**
     * Role id by shortname.
     *
     * @param string $shortname
     * @return int
     */
    private function get_role(string $shortname): int {
        global $DB;
        return (int) $DB->get_field('role', 'id', ['shortname' => $shortname], MUST_EXIST);
    }
}
