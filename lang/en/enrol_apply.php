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

// The name of your plug-in. Displayed on admin menus.
$string['enrolname'] = 'Enrolment upon approval';
$string['pluginname'] = 'Enrolment upon approval';
$string['pluginname_desc'] = 'With this plugin users request access to a course, and a site manager or teacher confirms it before they are enrolled.';

$string['confirmmail_heading'] = 'Confirmation email';
$string['confirmmail_desc'] = '';
$string['confirmmailsubject'] = 'Confirmation email subject';
$string['confirmmailsubject_desc'] = 'Leave empty to use the default text, in each student\'s language.';
$string['confirmmailcontent'] = 'Confirmation email content';
$string['confirmmailcontent_desc'] = 'Leave empty to use the default text, in each student\'s language. Special marks replaced with data from Moodle: {firstname}, {lastname}, {username}, {content} (the course name), {courseurl} (the course link), {timeend} (the enrolment end date).';

$string['waitmail_heading'] = 'Waiting list email';
$string['waitmail_desc'] = '';
$string['waitmailsubject'] = 'Waiting list mail subject';
$string['waitmailsubject_desc'] = 'Leave empty to use the default text, in each student\'s language.';
$string['waitmailcontent'] = 'Waiting list mail content';
$string['waitmailcontent_desc'] = 'Leave empty to use the default text, in each student\'s language. Special marks replaced with data from Moodle: {firstname}, {lastname}, {username}, {content} (the course name), {courseurl} (the course link).';

$string['cancelmail_heading'] = 'Cancelation email';
$string['cancelmail_desc'] = '';
$string['cancelmailsubject'] = 'Cancelation email subject';
$string['cancelmailsubject_desc'] = 'Leave empty to use the default text, in each student\'s language.';
$string['cancelmailcontent'] = 'Cancelation email content';
$string['cancelmailcontent_desc'] = 'Leave empty to use the default text, in each student\'s language. Special marks replaced with data from Moodle: {firstname}, {lastname}, {username}, {content} (the course name), {courseurl} (the course link).';

$string['notify_heading'] = 'Notification settings';
$string['notify_desc'] = 'Define who gets notified about new enrolment applications.';
$string['notifycoursebased'] = "New enrolment application notification (instance based, eg. course teachers)";
$string['notifycoursebased_desc'] = "Default for new instances: Notify everyone who have the 'Manage apply enrolment' capability for the corresponding course (eg. teachers and managers)";
$string['notifyglobal'] = "New enrolment application notification (global, eg. global managers and admins)";
$string['notifyglobal_desc'] = "Define who gets notified about new enrolment applications for any course.";

$string['messageprovider:application'] = 'Course enrolment application notifications';
$string['messageprovider:confirmation'] = 'Course enrolment application confirmation notifications';
$string['messageprovider:cancelation'] = 'Course enrolment application cancelation notifications';
$string['messageprovider:waitinglist'] = 'Course enrolment application defer notifications';

$string['newapplicationnotification'] = 'There is a new course enrolment application awaiting review.';
$string['applicationconfirmednotification'] = 'Your course enrolment application was confirmed.';
$string['applicationcancelednotification'] = 'Your course enrolment application was canceled.';
$string['applicationdeferrednotification'] = 'Your course enrolment application was deferred (you are currently on the waiting list).';

$string['confirmusers'] = 'Enrolment applications';
$string['confirmusers_desc'] = 'Users in gray colored rows are on the waiting list.';

$string['coursename'] = 'Course';
$string['applyuser'] = 'Name';
$string['applyusermail'] = 'Email';
$string['applydate'] = 'Requested on';
$string['btnconfirm'] = 'Confirm requests';
$string['btnwait'] = 'Defer requests';
$string['btncancel'] = 'Cancel requests';
$string['enrolusers'] = 'Enrol users';

$string['status'] = 'Allow Course enrol confirmation';
$string['newenrols'] = 'Allow new course enrol request';
$string['confirmenrol'] = 'Manage application';

$string['apply:config'] = 'Configure apply enrol instances';
$string['apply:manage'] = 'Manage user enrolments';
$string['apply:manageapplications'] = 'Manage apply enrolment';
$string['apply:unenrol'] = 'Cancel users from the course';
$string['apply:unenrolself'] = 'Cancel self from the course';

$string['notification'] = '<b>Request sent.</b> We will email you when it is confirmed.';

$string['mailtoteacher_suject'] = 'New request to join a course';
$string['editdescription'] = 'Text above the request button';
$string['comment'] = 'Comment';
$string['applycomment'] = 'Comment';
$string['applymanage'] = 'Manage enrolment applications';

$string['status_desc'] = 'Allow course access of internally enrolled users.';
$string['user_profile'] = 'User Profile';

$string['show_standard_user_profile'] = 'Show standard user profile fields on enrolment screen';
$string['show_extra_user_profile'] = 'Show extra user profile fields on enrolment screen';

//$string['custom_label'] = 'Custom label "{replace_title}"';
$string['custom_label'] = 'Custom label';

$string['maxenrolled'] = 'Max enrolled users';
$string['maxenrolled_help'] = 'Specifies the maximum number of users that can self enrol. 0 means no limit.';
$string['maxenrolledreached_left'] = 'Maximum number of users allowed';
$string['maxenrolledreached_right'] = 'has already been reached.';

$string['cantenrol'] = 'Enrolment is disabled or inactive';

$string['maxenrolled_tip_1'] = 'out of';
$string['maxenrolled_tip_2'] = 'seats already booked.';

$string['defaultperiod'] = 'Default enrolment duration';
$string['defaultperiod_desc'] = 'Default length of time that the enrolment is valid. If set to zero, the enrolment duration will be unlimited by default.';
$string['defaultperiod_help'] = 'Default length of time that the enrolment is valid, starting with the moment the user is enrolled. If disabled, the enrolment duration will be unlimited by default.';
$string['expiry_heading'] = 'Expiry settings';
$string['expiry_desc'] = '';
$string['expiredaction'] = 'Enrolment expiry action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from course during course unenrolment.';

$string['submitted_info'] = 'Enrol info';
$string['privacy:metadata'] = 'The Enrolment upon approval plugin does not store any personal data.';

$string['enrolperiod'] = 'Enrolment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrolment is valid. If set to zero, the enrolment duration will be unlimited by default.';
$string['enrolperiod_help'] = 'Length of time that the enrolment is valid, starting with the moment the user enrols themselves. If disabled, the enrolment duration will be unlimited.';

$string['expirynotifyall'] = 'Teacher and enrolled user';
$string['expirynotifyenroller'] = 'Teacher only';

$string['group'] = 'Group assignement';
$string['group_help'] = 'You can assign none or multiples groups';

$string['opt_commentaryzone'] = 'Commentary field';
$string['opt_commentaryzone_help'] = 'Yes: a comment field in the request form. Yes, required: the request can\'t be sent with it empty.';

$string['expirymessageenrollersubject'] = 'Apply enrolment expiry notification';
$string['expirymessageenrollerbody'] = 'Apply enrolment in the course \'{$a->course}\' will expire within the next {$a->threshold} for the following users:

    {$a->users}

To extend their enrolment, go to {$a->extendurl}';
$string['expirymessageenrolledsubject'] = 'Apply enrolment expiry notification';
$string['expirymessageenrolledbody'] = 'Dear {$a->user},

This is a notification that your enrolment in the course \'{$a->course}\' is due to expire on {$a->timeend}.

If you need help, please contact {$a->enroller}.';

$string['sendexpirynotificationstask'] = "Apply enrolment send expiry notifications task";

$string['messageprovider:expiry_notification'] = 'Apply enrolment expiry notifications';

$string["profileoption"] = "Profile Field to Show in Table";
$string['requestaccess'] = 'Request access';
$string['requestintro'] = 'Admission to this course is by application. Request access and we will email you when it is confirmed.';
$string['confirmation_defaultsubject'] = 'You are enrolled in {$a}';
$string['confirmation_defaultcontent'] = '<p>Hi {firstname},</p><p>Your request was confirmed: you are now enrolled in <a href="{courseurl}">{content}</a>. You will also find it in My courses.</p>';
$string['waitinglist_defaultsubject'] = 'Your request to join {$a} is on the waiting list';
$string['waitinglist_defaultcontent'] = '<p>Hi {firstname},</p><p>Your request to join <a href="{courseurl}">{content}</a> is on the waiting list. We will email you if a place opens up.</p>';
$string['cancelation_defaultsubject'] = 'Your request to join {$a} was not accepted';
$string['cancelation_defaultcontent'] = '<p>Hi {firstname},</p><p>Your request to join {content} was not accepted this time.</p>';
$string['commentrequired'] = 'Yes, required';
$string['sendapplication'] = 'Send application';
