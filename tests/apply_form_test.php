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
 * Tests for the request form's comment field: off, optional or required.
 *
 * @package    enrol_apply
 * @copyright  2026 Libreria de Satoshi
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[CoversClass(\enrol_apply_apply_form::class)]
final class apply_form_test extends \advanced_testcase {
    #[\Override]
    public static function setUpBeforeClass(): void {
        global $CFG;
        require_once($CFG->dirroot . '/enrol/apply/lib.php');
        require_once($CFG->dirroot . '/enrol/apply/apply_form.php');
        parent::setUpBeforeClass();
    }

    /**
     * The request form of a new instance with the given comment setting, submitted with $comment.
     *
     * @param int $setting ENROL_APPLY_COMMENT_*
     * @param string|null $comment the submitted comment; null submits the form without the field
     * @return \enrol_apply_apply_form
     */
    private function submitted_form(int $setting, ?string $comment): \enrol_apply_apply_form {
        global $DB;
        $this->resetAfterTest();
        $this->setUser($this->getDataGenerator()->create_user());
        $plugin = enrol_get_plugin('apply');
        $course = $this->getDataGenerator()->create_course();
        $id = $plugin->add_instance($course, ['customint7' => $setting] + $plugin->get_instance_defaults());
        $instance = $DB->get_record('enrol', ['id' => $id], '*', MUST_EXIST);
        $data = ['id' => $course->id, 'instance' => $instance->id];
        if ($comment !== null) {
            $data['applydescription'] = $comment;
        }
        \enrol_apply_apply_form::mock_submit($data, [], 'post', $instance->id . '_enrol_apply_apply_form');
        return new \enrol_apply_apply_form(null, $instance);
    }

    public function test_a_required_comment_cannot_be_left_empty(): void {
        $this->assertNull($this->submitted_form(ENROL_APPLY_COMMENT_REQUIRED, '')->get_data());
    }

    public function test_a_required_comment_with_text_is_accepted(): void {
        $data = $this->submitted_form(ENROL_APPLY_COMMENT_REQUIRED, 'I build on Lightning')->get_data();
        $this->assertSame('I build on Lightning', $data->applydescription);
    }

    public function test_an_optional_comment_can_be_left_empty(): void {
        $this->assertNotNull($this->submitted_form(ENROL_APPLY_COMMENT_OPTIONAL, '')->get_data());
    }

    public function test_without_the_field_the_request_is_just_the_button(): void {
        $form = $this->submitted_form(ENROL_APPLY_COMMENT_OFF, null);
        $this->assertNotNull($form->get_data());
        $this->assertStringNotContainsString('applydescription', $form->render());
    }
}
