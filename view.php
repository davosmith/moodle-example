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
 * Main entry point
 *
 * @package   mod_example
 * @copyright 2014 Davo Smith, Synergy Learning
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
require_once(dirname(__FILE__).'/../../config.php');
require_once($CFG->dirroot.'/mod/example/update_form.php');

$cmid = required_param('id', PARAM_INT);

$cm = get_coursemodule_from_id('example', $cmid, 0, false, MUST_EXIST);
$example = $DB->get_record('example', array('id' => $cm->instance), '*', MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);

$url = new moodle_url('/mod/example/view.php', array('id' => $cm->id));
$PAGE->set_url($url);

require_login($course, true, $cm);

$context = context_module::instance($cm->id);

require_capability('mod/example:view', $context);

add_to_log($course->id, 'example', 'view', 'view.php?id='.$cm->id, $example->id, $cm->id);

if (has_capability('mod/example:update', $context)) {
    $form = new example_update_form();

    $formdata = new stdClass();
    $formdata->id = $cm->id;
    $formdata->message = $example->message;
    $form->set_data($formdata);

    if ($data = $form->get_data()) {
        $upd = new stdClass();
        $upd->id = $example->id;
        $upd->message = $data->message;

        $DB->update_record('example', $upd);

        redirect($PAGE->url);
    }
}

$title = get_string('pluginname', 'mod_example');
$PAGE->set_title($title);
$PAGE->set_heading($title);

echo $OUTPUT->header();

echo format_module_intro('example', $example, $cm->id);

echo $OUTPUT->box_start('examplemessage');
if ($example->message) {
    echo format_text($example->message, FORMAT_PLAIN);
} else {
    echo get_string('nomessage', 'mod_example');
}
echo $OUTPUT->box_end();

$form->display();

echo $OUTPUT->footer();
