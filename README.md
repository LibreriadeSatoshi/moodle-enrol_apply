# Enrolment upon approval for Moodle 5.1

Fork of [emeneo/moodle-enrol_apply](https://github.com/emeneo/moodle-enrol_apply) for Moodle 5.1: users request access
to a course, and a site manager or teacher confirms it before they are enrolled. Changes from upstream:

- Works on Moodle 5.1 (`version.php`), with PHPUnit tests in `tests/`.
- Emails to students use the plugin's default text in each student's language when the subject or content setting is
  empty (en, es, pt_br), and a `{courseurl}` mark for the course link.
- Reviewers are notified once each, in their language, with the applicant's email; the course reviewers' message is
  sent (it was built but never sent) and site admins can be chosen in "New enrolment application notification (global)".
- The request form asks for no profile fields by default and its button says "Request access".
- Complete es and pt_br translations.

# Description
The enrolment plugin "enrol on approval" add an approval step into the course enrolment process.
Users will be informed by mail as soon as their course application has been approved/rejected.

* Moodle Forum: https://moodle.org/mod/forum/discuss.php?d=189334
* Moodle Plugins Directory: https://moodle.org/plugins/view.php?plugin=enrol_apply

# Installation
## Install from moodle.org
* go to https://moodle.org/plugins/view.php?plugin=enrol_apply and use the "Install now" Button

## Install with git
* use a command line interface of your choice on the destination system (server with moodle installation)
* switch to the moodle enrol folder: cd /path/to/moodle/enrol/
* git clone https://github.com/emeneo/apply.git
* navigate on your moodle page to admin --> notifivations and follow the instructions

## Install from zip
* download zip file from github: https://github.com/emeneo/apply/archive/master.zip
* unpack zip file to /path/to/moodle/enrol/
* navigate on your moodle page to admin --> notifivations and follow the instructions
