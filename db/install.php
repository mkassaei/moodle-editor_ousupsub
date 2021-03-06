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
 * ousupsub upgrade script.
 *
 * @package    editor_ousupsub
 * @copyright  2014 Damyon Wiese
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Make the ousupsub an editor for.
 *
 * @return bool
 */
function xmldb_editor_ousupsub_install() {
    global $CFG;

    // Add ousupsub to texteditors.
    $currenteditors = $CFG->texteditors;
    $neweditors = array();

    $list = explode(',', $currenteditors);

    foreach ($list as $editor) {
        if ($editor != 'ousupsub') {
            array_push($neweditors, $editor);
        }
    }
    array_push($neweditors, 'ousupsub');

    set_config('texteditors', implode(',', $neweditors));

    return true;
}
