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
 * Main library code
 *
 * @package   mod_example
 * @copyright 2014 Davo Smith, Synergy Learning
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
defined('MOODLE_INTERNAL') || die();

function example_add_instance($data, $mform = null) {
    global $DB;
    return $DB->insert_record('example', $data);
}

function example_update_instance($data, $mform) {
    global $DB;

    $data->id = $data->instance;
    $DB->update_record('example', $data);

    return true;
}

function example_delete_instance($id) {
    global $DB;

    $DB->delete_records('example', array('id' => $id));

    return true;
}
