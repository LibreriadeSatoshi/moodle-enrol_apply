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

/**
 * @package    enrol_apply
 * @copyright  emeneo.com (http://emeneo.com/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     emeneo.com (http://emeneo.com/)
 * @author     Johannes Burk <johannes.burk@sudile.com>
 */

/** The user is put onto a waiting list and therefore the enrolment not active (used in user_enrolments->status) */
define('ENROL_APPLY_USER_WAIT', 2);

/** The request form has no comment field. */
define('ENROL_APPLY_COMMENT_OFF', 0);
/** The request form has a comment field the user can leave empty. */
define('ENROL_APPLY_COMMENT_OPTIONAL', 1);
/** The request form has a comment field the user must fill in. */
define('ENROL_APPLY_COMMENT_REQUIRED', 2);
require_once($CFG->dirroot.'/group/lib.php');

class enrol_apply_plugin extends enrol_plugin {

    /**
     * Add new instance of enrol plugin with default settings.
     * @param object $course
     * @return int id of new instance
     */
    public function add_default_instance($course) {
        $fields = $this->get_instance_defaults();
        return $this->add_instance($course, $fields);
    }

    public function allow_unenrol(stdClass $instance) {
        // Users with unenrol cap may unenrol other users manually.
        return true;
    }
    public function roles_protected() {
        // Users may tweak the roles later.
        return false;
    }

    public function allow_apply(stdClass $instance) {
        if ($instance->status != ENROL_INSTANCE_ENABLED) {
            return get_string('cantenrol', 'enrol_apply');
        }
        if (!$instance->customint6) {
            // New enrols not allowed.
            return get_string('cantenrol', 'enrol_apply');
        }
        return true;
    }
    /**
     * Prevent to unenrol an user with a pending application
     *
     * @param stdClass $instance course enrol instance
     * @param stdClass $ue record from user_enrolments table, specifies user
     * @return bool
     */
    public function allow_unenrol_user(stdClass $instance, stdClass $ue) {
        global $DB;
        /*
        if ($DB->record_exists('enrol_apply_applicationinfo', ['userenrolmentid' => $ue->id])) {
            return false; // This line cause some issues with the unenrol of some users without resolving the application first.
        }
        */
        return parent::allow_unenrol_user($instance, $ue);
    }
    public function allow_manage(stdClass $instance) {
        // Users with manage cap may tweak period and status.
        return true;
    }
    /**
     * Returns link to page which may be used to add new instance of enrolment plugin in course.
     * Multiple instances supported.
     * @param int $courseid
     * @return moodle_url page url
     */
    public function get_newinstance_link($courseid) {
        $context = context_course::instance($courseid, MUST_EXIST);

        if (!has_capability('moodle/course:enrolconfig', $context) or !has_capability('enrol/apply:config', $context)) {
            return null;
        }
        return new moodle_url('/enrol/apply/edit.php', array('courseid' => $courseid));
    }

    public function enrol_page_hook(stdClass $instance) {
        global $CFG, $OUTPUT, $USER, $DB;

        if (isguestuser()) {
            // Can not enrol guest!
            return null;
        }

        $allowapply = $this->allow_apply($instance);
        if ($allowapply !== true) {
            return $this->enrol_page_card($instance, $this->enrol_page_message($allowapply, 'warning'));
        }

        if ($DB->record_exists('user_enrolments', array('userid' => $USER->id, 'enrolid' => $instance->id))) {
            return $this->enrol_page_card($instance, $this->enrol_page_message(get_string('notification', 'enrol_apply'), 'success'));
        }

        if ($instance->customint3 > 0) {
            // Max enrol limit specified.
            $count = $DB->count_records('user_enrolments', array('enrolid' => $instance->id));
            if ($count >= $instance->customint3) {
                return $this->enrol_page_card($instance, $this->enrol_page_message(
                    get_string('maxenrolledreached_left', 'enrol_apply') . " ($count) " .
                    get_string('maxenrolledreached_right', 'enrol_apply'), 'warning'));
            }
        }

        require_once("$CFG->dirroot/enrol/apply/apply_form.php");

        // Labels above their fields: the form sits in a card, not on a full-width page.
        $form = new enrol_apply_apply_form(null, $instance, 'post', '', ['class' => 'full-width-labels']);

        if ($data = $form->get_data()) {
            // Only process when form submission is for this instance (multi instance support).
            if ($data->instance == $instance->id) {
                $this->apply($instance, $USER->id, $data);
                return $this->enrol_page_card($instance, $this->enrol_page_message(get_string('notification', 'enrol_apply'), 'success'));
            }
        }

        return $this->enrol_page_card($instance, $form->render());
    }

    /**
     * The instance's block on the enrolment page, in core's enrolment card (as enrol_self and enrol_fee): the
     * instance name, or "Request access", as its header.
     *
     * @param stdClass $instance
     * @param string $body
     * @return string
     */
    private function enrol_page_card(stdClass $instance, string $body): string {
        global $OUTPUT;
        $header = $instance->name !== null && trim($instance->name) !== '' ?
            format_string($instance->name, true, ['context' => context_course::instance($instance->courseid)]) :
            get_string('requestaccess', 'enrol_apply');
        return $OUTPUT->render(new \core_enrol\output\enrol_page(instance: $instance, header: $header, body: $body));
    }

    /**
     * A message inside the enrolment card.
     *
     * @param string $message
     * @param string $type a notification type: info, success, warning
     * @return string
     */
    private function enrol_page_message(string $message, string $type): string {
        global $OUTPUT;
        $notification = new \core\output\notification($message, $type, false);
        $notification->set_extra_classes(['mb-0']);
        return $OUTPUT->render($notification);
    }

    /**
     * Records a user's application: a suspended enrolment until it is confirmed, the comment, the instance's groups,
     * and the notifications to the people who review applications.
     *
     * @param stdClass $instance enrol_apply instance
     * @param int $userid the applicant
     * @param stdClass $data the submitted form (applydescription and profile fields, when the form shows them)
     * @return void
     */
    public function apply(stdClass $instance, int $userid, stdClass $data): void {
        global $DB;

        $timestart = time();
        $timeend = $instance->enrolperiod ? $timestart + $instance->enrolperiod : 0;
        $this->enrol_user($instance, $userid, $instance->roleid, $timestart, $timeend, ENROL_USER_SUSPENDED);
        $userenrolment = $DB->get_record('user_enrolments', ['userid' => $userid, 'enrolid' => $instance->id], 'id', MUST_EXIST);
        $DB->insert_record('enrol_apply_applicationinfo', (object) [
            'userenrolmentid' => $userenrolment->id,
            'comment' => $data->applydescription ?? '',
        ], false);

        foreach ($DB->get_records('enrol_apply_groups', ['enrolid' => $instance->id]) as $group) {
            groups_add_member($group->groupid, $userid);
        }

        $this->send_application_notification($instance, $userid, $data);
    }

    public function get_action_icons(stdClass $instance) {
        global $OUTPUT;

        if ($instance->enrol !== 'apply') {
            throw new coding_exception('invalid enrol instance!');
        }
        $context = context_course::instance($instance->courseid);

        $icons = array();

        if (has_capability('enrol/apply:config', $context)) {
            $editlink = new moodle_url("/enrol/apply/edit.php", array('courseid' => $instance->courseid, 'id' => $instance->id));
            $icons[] = $OUTPUT->action_icon($editlink, new pix_icon(
                't/edit',
                get_string('edit'),
                'core',
                array('class' => 'iconsmall')));
        }

        if (has_capability('enrol/apply:manageapplications', $context)) {
            $managelink = new moodle_url("/enrol/apply/manage.php", array('id' => $instance->id));
            $icons[] = $OUTPUT->action_icon($managelink, new pix_icon(
                'i/users',
                get_string('confirmenrol', 'enrol_apply'),
                'core',
                array('class' => 'iconsmall')));

            $infolink = new moodle_url("/enrol/apply/info.php", array('id' => $instance->id));
            $icons[] = $OUTPUT->action_icon($infolink, new pix_icon(
                'i/files',
                get_string('submitted_info', 'enrol_apply'),
                'core',
                array('class' => 'iconsmall')));
        }

        return $icons;
    }

    /**
     * Is it possible to hide/show enrol instance via standard UI?
     * @param  stdClass $instance
     * @return bool
     */
    public function can_hide_show_instance($instance) {
            $context = context_course::instance($instance->courseid);
            return has_capability('enrol/apply:config', $context);
    }

    /**
     * Is it possible to delete enrol instance via standard UI?
     *
     * @param stdClass $instance
     * @return bool
     */
    public function can_delete_instance($instance) {
            $context = context_course::instance($instance->courseid);
            return has_capability('enrol/apply:config', $context);
    }

    /**
     * Sets up navigation entries.
     *
     * @param stdClass $instancesnode
     * @param stdClass $instance
     * @return void
     */
    public function add_course_navigation($instancesnode, stdClass $instance) {
        if ($instance->enrol !== 'apply') {
             throw new coding_exception('Invalid enrol instance type!');
        }

        $context = context_course::instance($instance->courseid);
        if (has_capability('enrol/apply:config', $context)) {
            $managelink = new moodle_url('/enrol/apply/edit.php', array('courseid' => $instance->courseid, 'id' => $instance->id));
            $instancesnode->add($this->get_instance_name($instance), $managelink, navigation_node::TYPE_SETTING);
        }
    }

    public function get_user_enrolment_actions(course_enrolment_manager $manager, $ue) {
        $actions = array();
        $context = $manager->get_context();
        $instance = $ue->enrolmentinstance;
        $params = $manager->get_moodlepage()->url->params();
        $params['ue'] = $ue->id;
        if ($this->allow_unenrol_user($instance, $ue) && has_capability("enrol/apply:unenrol", $context)) {
            $url = new moodle_url('/enrol/unenroluser.php', $params);
            $actions[] = new user_enrolment_action(
                new pix_icon('t/delete', ''),
                get_string('unenrol', 'enrol'),
                $url,
                array('class' => 'unenrollink', 'rel' => $ue->id));
        }
        if ($this->allow_manage($instance) && has_capability("enrol/apply:manage", $context)) {
            $url = new moodle_url('/enrol/editenrolment.php', $params);
            $actions[] = new user_enrolment_action(new pix_icon('t/edit', ''), get_string('edit'), $url, array('class'=>'editenrollink', 'rel'=>$ue->id));
        }
        return $actions;
    }

    /**
     * Returns defaults for new instances.
     * @return array
     */
    public function get_instance_defaults() {
        $fields = array();
        $fields['status']          = $this->get_config('status');
        $fields['roleid']          = $this->get_config('roleid', 0);
        $fields['customint1']      = $this->get_config('show_standard_user_profile');
        $fields['customint2']      = $this->get_config('show_extra_user_profile');
        $fields['customtext2']     = '';
        $fields['customtext3']     = $this->get_config('notifycoursebased') ? '$@ALL@$' : '';
        $fields['enrolperiod']     = $this->get_config('enrolperiod', 0);
        $fields['customint3']      = $this->get_config('maxenrolled');
        $fields['customint4']      = $this->get_config('sendcoursewelcomemessage');
        $fields['customint5']      = 0;
        $fields['customint6']      = $this->get_config('newenrols');

        return $fields;
    }

    function check_privileges($courseid,$userid){
        global $DB;
        //check for sistem privilege
        $context = context_system::instance();
        if(has_capability('enrol/apply:manageapplications', $context)){
            return true;
        }
        $context = context_course::instance($courseid, MUST_EXIST);
        if(has_capability('enrol/apply:manageapplications', $context)){
            return true;
        }
        $contextuser = $DB->get_record("context",array("instanceid"=>$userid,"contextlevel"=>CONTEXT_USER));
        $context = context::instance_by_id($contextuser->id);
        if(has_capability('enrol/apply:manageapplications', $context)){
            return true;
        }
    }

    public function confirm_enrolment($enrols) {
        global $DB;
        foreach ($enrols as $enrol) {
            $userenrolment = $DB->get_record_select(
                'user_enrolments',
                'id = :id AND (status = :enrolusersuspended OR status = :enrolapplyuserwait)',
                array(
                    'id' => $enrol,
                    'enrolusersuspended' => ENROL_USER_SUSPENDED,
                    'enrolapplyuserwait' => ENROL_APPLY_USER_WAIT),
                '*',
                MUST_EXIST);

            $instance = $DB->get_record('enrol', array('id' => $userenrolment->enrolid, 'enrol' => 'apply'), '*', MUST_EXIST);

            // Check privileges.
            if(!$this->check_privileges($instance->courseid,$userenrolment->userid)){
                continue;
            }

            // Set timestart and timeend if an enrolment duration is set.
            $userenrolment->timestart = time();
            $userenrolment->timeend   = 0;
            if ($instance->enrolperiod) {
                $userenrolment->timeend = $userenrolment->timestart + $instance->enrolperiod;
            }

            $this->update_user_enrol($instance, $userenrolment->userid, ENROL_USER_ACTIVE, $userenrolment->timestart, $userenrolment->timeend);
            $DB->delete_records('enrol_apply_applicationinfo', array('userenrolmentid' => $enrol));

            $this->notify_applicant(
                    $instance,
                    $userenrolment,
                    'confirmation',
                    get_config('enrol_apply', 'confirmmailsubject'),
                    get_config('enrol_apply', 'confirmmailcontent'));
        }
    }

    public function wait_enrolment($enrols) {
        global $DB;
        foreach ($enrols as $enrol) {
            $userenrolment = $DB->get_record(
                'user_enrolments',
                array('id' => $enrol, 'status' => ENROL_USER_SUSPENDED),
                '*', IGNORE_MISSING);

            if ($userenrolment != null) {
                $instance = $DB->get_record('enrol', array('id' => $userenrolment->enrolid, 'enrol' => 'apply'), '*', MUST_EXIST);

                // Check privileges.
                if(!$this->check_privileges($instance->courseid,$userenrolment->userid)){
                    continue;
                }
    

                $this->update_user_enrol($instance, $userenrolment->userid, ENROL_APPLY_USER_WAIT);

                $this->notify_applicant(
                    $instance,
                    $userenrolment,
                    'waitinglist',
                    get_config('enrol_apply', 'waitmailsubject'),
                    get_config('enrol_apply', 'waitmailcontent'));
            }
        }
    }

    public function cancel_enrolment($enrols) {
        global $DB;
        foreach ($enrols as $enrol) {
            $userenrolment = $DB->get_record_select(
                'user_enrolments',
                'id = :id AND (status = :enrolusersuspended OR status = :enrolapplyuserwait)',
                array(
                    'id' => $enrol,
                    'enrolusersuspended' => ENROL_USER_SUSPENDED,
                    'enrolapplyuserwait' => ENROL_APPLY_USER_WAIT),
                '*',
                MUST_EXIST);

            $instance = $DB->get_record('enrol', array('id' => $userenrolment->enrolid, 'enrol' => 'apply'), '*', MUST_EXIST);

            // Check privileges.
            if(!$this->check_privileges($instance->courseid,$userenrolment->userid)){
                continue;
            }


            $this->unenrol_user($instance, $userenrolment->userid);
            $DB->delete_records('enrol_apply_applicationinfo', array('userenrolmentid' => $enrol));

            $this->notify_applicant(
                $instance,
                $userenrolment,
                'cancelation',
                get_config('enrol_apply', 'cancelmailsubject'),
                get_config('enrol_apply', 'cancelmailcontent'));
        }
    }

    /**
     * Emails the applicant about their application, in their language. An empty subject or content in the plugin
     * settings means the plugin's default text for that type.
     *
     * @param stdClass $instance enrol_apply instance
     * @param stdClass $userenrolment the application
     * @param string $type confirmation, waitinglist or cancelation
     * @param string|false $subject the subject setting
     * @param string|false $content the content setting
     * @return void
     */
    private function notify_applicant($instance, $userenrolment, $type, $subject, $content) {
        global $CFG;
        require_once($CFG->dirroot.'/enrol/apply/notification.php');
        // Required for course_get_url() function.
        require_once($CFG->dirroot.'/course/lib.php');

        $course = get_course($instance->courseid);
        $user = core_user::get_user($userenrolment->userid);

        $this->in_language($user, function() use ($instance, $userenrolment, $type, $subject, $content, $course, $user) {
            if (trim((string) $subject) === '') {
                $subject = get_string($type . '_defaultsubject', 'enrol_apply', format_string($course->fullname));
            }
            if (trim(strip_tags((string) $content)) === '') {
                $content = get_string($type . '_defaultcontent', 'enrol_apply');
            }
            $content = $this->update_mail_content($content, $course, $user, $userenrolment);
            message_send(new enrol_apply_notification(
                $user,
                core_user::get_noreply_user(),
                $type,
                $subject,
                $content,
                course_get_url($course),
                $instance->courseid));
        });
    }

    /**
     * Tells the people who review applications about a new one, each once and in their language: the course's
     * reviewers (instance setting), those with the capability over the applicant, and the ones chosen in the plugin
     * settings.
     *
     * @param stdClass $instance enrol_apply instance
     * @param int $userid the applicant
     * @param stdClass $data the submitted form
     * @return void
     */
    private function send_application_notification($instance, $userid, $data) {
        global $CFG, $PAGE, $DB;
        require_once($CFG->dirroot.'/enrol/apply/notification.php');
        // Required for course_get_url() function.
        require_once($CFG->dirroot.'/course/lib.php');

        $renderer = $PAGE->get_renderer('enrol_apply');

        $course = get_course($instance->courseid);
        $applicant = core_user::get_user($userid);

        // Include standard user profile fields?
        $standarduserfields = null;
        if ($instance->customint1) {
            $standarduserfields = clone $data;
            unset($standarduserfields->applydescription);
        }

        // Include extra user profile fields?
        $extrauserfields = null;
        if ($instance->customint2) {
            require_once($CFG->dirroot.'/user/profile/lib.php');
            profile_load_custom_fields($applicant);
            $extrauserfields = $applicant->profile;
        }

        $userenrolment = $DB->get_record('user_enrolments', ['userid' => $userid, 'enrolid' => $instance->id], 'id', MUST_EXIST);
        $recipients = [];
        $add = function(array $users, moodle_url $manageurl) use (&$recipients) {
            foreach ($users as $user) {
                $recipients[$user->id] ??= [$user, $manageurl];
            }
        };
        $add($this->get_notifycoursebased_users($instance), new moodle_url('/enrol/apply/manage.php', ['id' => $instance->id]));
        $add($this->get_users_from_usercapabilits($userid), new moodle_url('/enrol/apply/manage.php', ['userenrol' => $userenrolment->id]));
        $add($this->get_notifyglobal_users(), new moodle_url('/enrol/apply/manage.php'));
        unset($recipients[$userid]);

        foreach ($recipients as [$user, $manageurl]) {
            $this->in_language($user, function() use ($renderer, $course, $applicant, $manageurl, $data, $standarduserfields,
                    $extrauserfields, $user, $instance) {
                $content = $renderer->application_notification_mail_body(
                    $course,
                    $applicant,
                    $manageurl,
                    $data->applydescription ?? '',
                    $standarduserfields,
                    $extrauserfields);
                message_send(new enrol_apply_notification(
                    $user,
                    $applicant,
                    'application',
                    get_string('mailtoteacher_suject', 'enrol_apply'),
                    $content,
                    $manageurl,
                    $instance->courseid));
            });
        }
    }

    /**
     * Runs $send with the user's language as the current language, so the strings in their message are in it.
     *
     * @param stdClass $user the recipient
     * @param callable $send
     * @return void
     */
    private function in_language(stdClass $user, callable $send): void {
        $lang = !empty($user->lang) && get_string_manager()->translation_exists($user->lang, false) ? $user->lang : '';
        if ($lang === '') {
            $send();
            return;
        }
        $previous = force_current_language($lang);
        try {
            $send();
        } finally {
            force_current_language($previous);
        }
    }

    /**
     * Returns enrolled users of a course who should be notified about new course enrolment applications.
     *
     * Note: mostly copied from get_users_from_config() function in moodlelib.php.
     * @param  array $instance Enrol apply instance record.
     * @return array           Array of user IDs.
     */
    public function get_notifycoursebased_users($instance) {
        $value = $instance->customtext3;
        if (empty($value) or $value === '$@NONE@$') {
            return array();
        }

        $context = context_course::instance($instance->courseid);

        // We have to make sure that users still have the necessary capability,
        // it should be faster to fetch them all first and then test if they are present
        // instead of validating them one-by-one.
        $users = get_enrolled_users($context, 'enrol/apply:manageapplications');

        if ($value === '$@ALL@$') {
            return $users;
        }

        $result = array(); // Result in correct order.
        $allowed = explode(',', $value);
        foreach ($allowed as $uid) {
            if (isset($users[$uid])) {
                $user = $users[$uid];
                $result[$user->id] = $user;
            }
        }

        return $result;
    }

    //get user with capability to this user
    function get_users_from_usercapabilits($userid) {
        global $DB;
        $context = $DB->get_record("context",array("instanceid"=>$userid,"contextlevel"=>CONTEXT_USER));
        return get_users_by_capability(context::instance_by_id($context->id), 'enrol/apply:manageapplications');  
    }

    /**
     * Returns users who should be notified about new course enrolment applications.
     * @return array Array of user IDs.
     */
    public function get_notifyglobal_users() {
        // Site admins can be chosen too: on many sites they are the ones who review applications.
        return get_users_from_config($this->get_config('notifyglobal'), 'enrol/apply:manageapplications');
    }

    private function update_mail_content($content, $course, $user, $userenrolment) {
        $replace = array(
            'firstname' => s($user->firstname),
            'content'   => format_string($course->fullname),
            'lastname'  => s($user->lastname),
            'username'  => s($user->username),
            'timeend'   => !empty($userenrolment->timeend) ? userdate($userenrolment->timeend) : '',
            'courseurl' => course_get_url($course)->out(false),
        );
        foreach ($replace as $key => $val) {
            $content = str_replace('{' . $key . '}', $val, $content);
        }
        return $content;
    }

    /**
     * Backup execution step hook.
     *
     * @param backup_enrolments_execution_step $step
     * @param stdClass $enrol
     */
    public function backup_annotate_custom_fields(backup_enrolments_execution_step $step, stdClass $enrol) {
        // annotate customint1 as a role
        $step->annotate_id('role', $enrol->customint1);
    }

    public function restore_instance(restore_enrolments_structure_step $step, stdClass $data, $course, $oldid) {
        global $DB, $CFG;

        $data->customint1 = $step->get_mappingid('role', $data->customint1, null);

        $instanceid = $this->add_instance($course, (array)$data);
        $step->set_mapping('enrol', $oldid, $instanceid);

        //$this->sync_enrols($DB->get_record('enrol', array('id'=>$instanceid)));
    }

    public function restore_user_enrolment(restore_enrolments_structure_step $step, $data, $instance, $userid, $oldinstancestatus) {
        $this->enrol_user($instance, $userid, null, $data->timestart, $data->timeend, $oldinstancestatus);
    }

    // Start modification

    /**
     * Returns the user who is responsible for self enrolments in given instance.
     *
     * Usually it is the first editing teacher - the person with "highest authority"
     * as defined by sort_by_roleassignment_authority() having 'enrol/self:manage'
     * capability.
     *
     * @param int $instanceid enrolment instance id
     * @return stdClass user record
     */
    protected function get_enroller($instanceid) {
        global $DB;

        if ($this->lasternollerinstanceid == $instanceid and $this->lasternoller) {
            return $this->lasternoller;
        }

        $instance = $DB->get_record('enrol', array('id' => $instanceid, 'enrol' => $this->get_name()), '*', MUST_EXIST);
        $context = context_course::instance($instance->courseid);

        if ($users = get_enrolled_users($context, 'enrol/apply:manage')) {
            $users = sort_by_roleassignment_authority($users, $context);
            $this->lasternoller = reset($users);
            unset($users);
        } else {
            $this->lasternoller = parent::get_enroller($instanceid);
        }

        $this->lasternollerinstanceid = $instanceid;

        return $this->lasternoller;
    }

    // End modification


    /**
     * Enrol cron support.
     * @return void
     */
    public function cron() {
        $trace = new text_progress_trace();
        $this->process_expirations($trace);
    }

}
