YUI.add('moodle-ousupsub_superscript-button', function (Y, NAME) {

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

/*
 * @package    ousupsub_superscript
 * @copyright  2014 Rosiana Wijaya <rwijaya@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * @module     moodle-ousupsub_superscript-button
 */

/**
 * ousupsub text editor superscript plugin.
 *
 * @namespace M.ousupsub_superscript
 * @class button
 * @extends M.editor_ousupsub.EditorPlugin
 */

Y.namespace('M.ousupsub_superscript').Button = Y.Base.create('button', Y.M.editor_ousupsub.EditorPlugin, [], {
    initializer: function() {
        this.addBasicButton({
            exec: 'superscript',

            // Watch the following tags and add/remove highlighting as appropriate:
            tags: 'sup'
        });
    }
});


}, '@VERSION@', {"requires": ["moodle-editor_ousupsub-plugin"]});
