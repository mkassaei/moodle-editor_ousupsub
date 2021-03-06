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
 * Builds a standalone demonstration version of the ousupsub editor
 *
 * This script is designed to run from the command line and is safe to re-run at any time when
 * the plugin is updated.
 *
 * @package editor_ousupsub
 * @copyright 2015 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

if (isset($_SERVER['REMOTE_ADDR'])) {
    die(); // No access from web!
}

// Is not really necessary but adding it as is a CLI_SCRIPT.
define('CLI_SCRIPT', true);
define('CACHE_DISABLE_ALL', true);

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->dirroot . '/course/lib.php');

error_reporting(E_ALL | E_STRICT);
error_reporting(-1);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);

ousupsub_texteditor_standalone_builder::create_standalone();

/**
 * Creates demonstration editor.
 */
class ousupsub_texteditor_standalone_builder {
    private static $paths = array(
        'root' => 'standalone',
        'index' => 'index.html',
        'ousupsubjs' => 'moodle-editor_ousupsub.js',
        'stylecss' => 'styles.css',
        'readme' => 'readme.txt',
        'readmestandalone' => 'readme_standalone.txt',
        'yuiversion' => '3.17.2',
        'wwwroot' => '../../..'
    );
    private static $yuisuffix = '-min';
    public static function create_standalone () {
        self::delete_standalone();
        self::create_standalone_folder();
        self::create_readme_file();
        self::create_index_page();
        self::copy_icons();
        self::create_css_file();
        self::create_javascript_files();
    }

    public static function delete_standalone () {
        $path = self::create_path('root');
        if ($result = self::delete_folder($path)) {
            self::echo_result("Emptied standalone folder.");
        }
    }

    public static function delete_folder($dir) {
        if (!$dir) {
            return false;
        }
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file") && !is_link($dir)) ? self::delete_folder("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    /*
     * Create the root folder.
     */
    public static function create_standalone_folder() {
        $path = self::create_path('root/resources');
        self::create_folder($path);
    }

    /*
     * Create the language string.
     */
    public static function create_language_string() {
        $components = array('moodle' => array("error", "morehelp", "changesmadereallygoaway"),
                            'ousupsub_subscript' => array("pluginname"),
                            'ousupsub_superscript' => array("pluginname"),
                            'editor_ousupsub' => array("editor_command_keycode", "editor_control_keycode",
                                    "plugin_title_shortcut", "plugin_title_shortcut"),
                            'error' => array("serverconnection"));

        $output = '{';
        foreach ($components as $component => $keys) {
            $output .= strlen($output) > 1 ? ',' : '';
            $output .= '"' . $component .'":{';
            $string = '';
            foreach ($keys as $key) {
                $string .= strlen($string) ? ',' : '';
                $string .= '"' . $key .'":"' . get_string($key, $component) . '"';
            }
            $output .= $string . '}';
        }
        $output .= '}';
        self::echo_result("Create language strings.");
        return $output;
    }

    /*
     * Create readme file.
     */
    public static function create_readme_file() {

        // Create the readme file. The unconventional indenting is required to produce conventional
        // indenting in the file produced.
        $contents = '
This folder contains the files for the standalone superscript subscript editor.
index.html contains a demonstration of the of the editor and the required resources are in the resources folder

To view a demonstration of the editor, download the standalone folder to your desktop and open the index.html file
in a browser.

You will then see a text editor with two buttons. One for superscript and one for subscript
Features
The features we aim to deliver are:
* Display either Sup/sub buttons or both
* Clean up html output: Only sup/sup html tags and alphanumeric text should be allowed
*

';
        $pathfrom = self::create_path('readmestandalone');
        $contents = file_get_contents($pathfrom);

        // Path to save file to.
        $pathto = self::create_path('root/readme');
        if ($result = file_put_contents($pathto, $contents, 0)) {
            self::echo_result("Created readme.txt.");
        }
    }
    /*
     * Create the index page.
     */
    public static function create_index_page() {
        $ousupsubjspath = self::create_path('resources/ousupsubjs');
        $stylespath = self::create_path('resources/stylecss');
        $yuijspath = self::create_path('resources/yui/yuiversion/yui/yui'.self::$yuisuffix.'.js');

        $data = '<!DOCTYPE html>
<html id="yui_3_17_2_3_1421681604257_368" class="yui3-js-enabled" dir="ltr" xml:lang="en" lang="en">
    <div class="" id="yui3-css-stamp" style="position: absolute !important; visibility: hidden !important"></div>
    <head>
    <title>OU SupSub demo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" src="'.$yuijspath.'"></script>
<script type="text/javascript" src="'.$ousupsubjspath.'"></script>

<script id="firstthemesheet" type="text/css">/** Required in order to fix style inclusion problems in IE with YUI **/</script>

<link rel="stylesheet" type="text/css" href="'.$stylespath.'">

</head>

<body class="dir-ltr lang-en jsenabled">

<script type="text/javascript">
//<![CDATA[
document.body.className += " jsenabled";
//]]>
</script>

<form autocomplete="off" action="" method="post" accept-charset="utf-8" id="mform1" class="mform"
        onsubmit="try { var myValidator = validate_user_editadvanced_form; } catch(e) { return true; } return myValidator(this);">
        <div class="fcontainer clearfix">
            <div id="fitem_id_description_editor" class="fitem fitem_feditor ">
                <div class="fitemtitle"><label for="id_description_editor">Both Superscript and Subscript allowed</label></div>
                <div class="felement feditor">
                    <div>
                        <div class="editor_ousupsub"></div>
                        <textarea style="display: none;" id="id_description_editor" name="description_editor[text]"
                            rows="2" cols="80" spellcheck="true" hidden="hidden"
                            >&lt;p&gt;Superscript and Subscript&lt;/p&gt;</textarea>
                    </div>
                    <div><input name="description_editor[format]" value="1" type="hidden"></div>
                    <input name="description_editor[itemid]" value="774037094" type="hidden">
                    <noscript><div>
                        <object type="text/html" data="" height="160" width="600" style="border:1px solid #000"></object>
                    </div></noscript>
                </div>
            </div>
        </div>

        <div class="fcontainer clearfix">
            <div id="fitem_id_sup_editor" class="fitem fitem_feditor ">
                <div class="fitemtitle"><label for="id_sup_editor">Superscript only allowed</label></div>
                <div class="felement feditor">
                    <div>
                        <div class="editor_ousupsub"></div>
                        <textarea style="display: none;" id="id_sup_editor" name="sup_editor[text]"
                            rows="2" cols="10" spellcheck="true" hidden="hidden"
                            >&lt;p&gt;Superscript only&lt;/p&gt;</textarea>
                    </div>
                    <div><input name="sup_editor[format]" value="1" type="hidden"></div>
                    <input name="sup_editor[itemid]" value="774037095" type="hidden">
                    <noscript><div>
                        <object type="text/html" data="" height="60" width="600" style="border:1px solid #000"></object>
                    </div></noscript>
                </div>
            </div>
        </div>

        <div class="fcontainer clearfix">
            <div id="fitem_id_sub_editor" class="fitem fitem_feditor ">
                <div class="fitemtitle"><label for="id_sub_editor">Subscript only allowed</label></div>
                <div class="felement feditor">
                    <div>
                        <div class="editor_ousupsub"></div>
                        <textarea style="display: none;" id="id_sub_editor" name="sub_editor[text]"
                            rows="2" cols="10" spellcheck="true" hidden="hidden"
                            >&lt;p&gt;Subscript only&lt;/p&gt;</textarea>
                    </div>
                    <div><input name="sub_editor[format]" value="1" type="hidden"></div>
                    <input name="sub_editor[itemid]" value="774037095" type="hidden">
                    <noscript><div>
                        <object type="text/html" data="" height="60" width="600" style="border:1px solid #000"></object>
                    </div></noscript>
                </div>
            </div>
        </div>
</form>

<script type="text/javascript">
//<![CDATA[
        init_ousupsub("id_sup_editor", {"superscript":true});
        init_ousupsub("id_sub_editor", {"subscript":true});
        init_ousupsub("id_description_editor", {"subscript":true, "superscript":true});
//]]>
</script>
			</div>
		</div>
	</body>
</html>';
        $path = self::create_path('root/index');
        if ($result = file_put_contents($path, $data, 0)) {
                self::echo_result("Create index file.");
        }
    }

    /*
     * Copy button icons.
     */
    public static function copy_icons() {
        $names = array('subscript', 'superscript');

        // Default moodle icons
        /*
        foreach ($names as $name) {
            $source = self::create_path('../../../pix/e/'.$name.'.svg');
            $destination = self::create_path('root/resources/core_editor_'.$name.'.svg');
            if ($result = copy($source, $destination)) {
                self::echo_result("Copy moodle ".$name." icon.");
            }
        }*/

        // OU sup sub icons
        foreach ($names as $name) {
            $source = self::create_path('pix/'.$name.'.svg');
            $destination = self::create_path('root/resources/core_editor_'.$name.'.svg');
            if ($result = copy($source, $destination)) {
                self::echo_result("Copy ousupsub ".$name." icon.");
            }
        }
    }

    /*
     * Create CSS file.
     */
    public static function create_css_file() {

        // Create the static file. The unconventional indenting is required to produce conventional
        // indenting in the file produced.
        $contents = '
body {
  font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
  font-size: 14px;
  line-height: 20px;
  color: #333;
  background-color: #fff;
}';
        $pathfrom = self::create_path('stylecss');
        $contents .= file_get_contents($pathfrom);

        // Path to save file to.
        $pathto = self::create_path('root/resources/stylecss');
        if ($result = file_put_contents($pathto, $contents, 0)) {
            self::echo_result("Created styles.css.");
        }
    }

    /*
     * Copy the javascript files required by the editor.
     */
    public static function create_javascript_files() {

        // Read files into memory.
        // Create the static file.
        $combinedcontents = self::create_javascript_static();

        // Load the YUI editor files.
        // path to get the editor yui files from.
        $editoryuipath = 'yui/build/moodle-editor_ousupsub-manager/moodle-editor_ousupsub-manager.js';
        $names = array('editor', 'manager', 'plugin', 'rangy');
        foreach ($names as $name) {
            $path = str_replace('manager', $name, $editoryuipath);
            $contents = file_get_contents($path);
            if ($name == 'plugin') {
                $contents = str_replace("config.icon = 'e/'", "config.icon = 'editor_'", $contents);
            }
            $combinedcontents .= $contents;
        }

        // Plugin button icons.
        $buttonsuperscriptyuipath = 'plugins/superscript/yui/build/moodle-ousupsub_superscript-button/';
        $buttonsuperscriptyuipath .= 'moodle-ousupsub_superscript-button.js';
        $combinedcontents .= file_get_contents($buttonsuperscriptyuipath);

        $buttonsubscriptyuipath = 'plugins/subscript/yui/build/moodle-ousupsub_subscript-button/';
        $buttonsubscriptyuipath .= 'moodle-ousupsub_subscript-button.js';
        $combinedcontents .= file_get_contents($buttonsubscriptyuipath);

        // Save combined file.
        $combinedpath = self::create_path('root/resources/ousupsubjs');
        if ($result = file_put_contents ( $combinedpath, $combinedcontents, 0)) {
            self::echo_result("Copied editor javascript files.");
        }

        self::copy_yui_javascript_files();
    }

    /*
     * Create the general javascript functions.
     */
    public static function create_javascript_static() {
        $lang = self::create_language_string();
        // The unconventional indenting is required to produce conventional
        // indenting in the file produced.
        $data = '// Miscellaneous core Javascript functions for Moodle
// Global M object is initilised in inline javascript

var M = {}; M.yui = {};
M.pageloadstarttime = new Date();
M.pathname = window.location.pathname;
M.fileroot = M.pathname.substring(0, M.pathname.lastIndexOf("/"));
M.protocol = window.location.protocol;
M.host  = window.location.host ;
M.cfg = {"wwwroot":M.protocol + "//" + M.host + M.fileroot,"sesskey":"","loadingicon":"l",
                "themerev":-1,"slasharguments":1,"theme":"clean","jsrev":-1,"svgicons":true,"developerdebug":true};

function init_ousupsub(id, params) {
    M.str = '.$lang.'
    plugins = [];
    if (params.superscript) {
        plugins[plugins,length] = {"name":"superscript","params":[]};
    }
    if (params.subscript) {
        plugins[plugins.length] = {"name":"subscript","params":[]};
    }
    var YUI_config = {
                         base: "resources/yui/3.17.2/"
                      }
    YUI().use("node", function(Y) {
    Y.use("moodle-editor_ousupsub-editor","moodle-ousupsub_subscript-button","moodle-ousupsub_superscript-button",
            function() {YUI.M.editor_ousupsub.createEditor(
            {"elementid":id,"content_css":"","contextid":0,"language":"en",
                "directionality":"ltr","plugins":[{"group":"style1","plugins":plugins}],"pageHash":""});
    });

    });
};
/**
 * Various utility functions
 */
M.util = M.util || {};

/**
 * Returns url for images.
 * @param {String} imagename
 * @param {String} component
 * @return {String}
 */
M.util.image_url = function(imagename, component) {

    if (!component || component == \'\' || component == \'moodle\' || component == \'core\') {
        component = \'core\';
    }

    var url = M.cfg.wwwroot + \'/resources/\';
    var suffix = \'.svg\'
	url += component + \'_\' + imagename;
	if (!M.cfg.svgicons) {
		url += \'.png\';
	}

	url += suffix;
    return url;
};

/**
 * Returns a string registered in advance for usage in JavaScript
 *
 * If you do not pass the third parameter, the function will just return
 * the corresponding value from the M.str object. If the third parameter is
 * provided, the function performs {$a} placeholder substitution in the
 * same way as PHP get_string() in Moodle does.
 *
 * @param {String} identifier string identifier
 * @param {String} component the component providing the string
 * @param {Object|String} a optional variable to populate placeholder with
 */
M.util.get_string = function(identifier, component, a) {
    var stringvalue;

    if (M.cfg.developerdebug) {
        // creating new instance if YUI is not optimal but it seems to be better way then
        // require the instance via the function API - note that it is used in rare cases
        // for debugging only anyway
        // To ensure we don\'t kill browser performance if hundreds of get_string requests
        // are made we cache the instance we generate within the M.util namespace.
        // We don\'t publicly define the variable so that it doesn\'t get abused.
        if (typeof M.util.get_string_yui_instance === \'undefined\') {
            M.util.get_string_yui_instance = new YUI({ debug : true });
        }
        var Y = M.util.get_string_yui_instance;
    }

    if (!M.str.hasOwnProperty(component) || !M.str[component].hasOwnProperty(identifier)) {
        stringvalue = \'[[\' + identifier + \',\' + component + \']]\';
        if (M.cfg.developerdebug) {
            console.log(\'undefined string \' + stringvalue, \'warn\', \'M.util.get_string\');
        }
        return stringvalue;
    }

    stringvalue = M.str[component][identifier];

    if (typeof a == \'undefined\') {
        // no placeholder substitution requested
        return stringvalue;
    }

    if (typeof a == \'number\' || typeof a == \'string\') {
        // replace all occurrences of {$a} with the placeholder value
        stringvalue = stringvalue.replace(/\{\$a\}/g, a);
        return stringvalue;
    }

    if (typeof a == \'object\') {
        // replace {$a->key} placeholders
        for (var key in a) {
            if (typeof a[key] != \'number\' && typeof a[key] != \'string\') {
                if (M.cfg.developerdebug) {
                    console.log(\'invalid value type for $a->\' + key, \'warn\', \'M.util.get_string\');
                }
                continue;
            }
            var search = \'{$a->\' + key + \'}\';
            search = search.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, \'\\$&\');
            search = new RegExp(search, \'g\');
            stringvalue = stringvalue.replace(search, a[key]);
        }
        return stringvalue;
    }

    if (M.cfg.developerdebug) {
        console.log(\'incorrect placeholder type\', \'warn\', \'M.util.get_string\');
    }
    return stringvalue;
};

/**
 * Test function created to develop behat test.
 *
 * @method selectText
 * @param {String} id
 */
function RangySelectText (id, startquery, startoffset, endquery, endoffset) {
        var e = document.getElementById(id+\'editable\'),
            r = rangy.createRange();

        e.focus();
        if (startquery || startoffset || endquery || endoffset) {
            // Set defaults for testing.
            startoffset = startoffset?startoffset:0;
            endoffset = endoffset?endoffset:0;

            // Find the text nodes from the Start/end queries or default to the editor node.
            var startnode = startquery?e.querySelector(startquery): e.firstChild;
            var endnode = endquery?e.querySelector(endquery):e.firstChild;
            r.setStart(startnode.firstChild, startoffset);
            r.setEnd(endnode.firstChild, endoffset);
        }
        else {
            r.selectNodeContents(e.firstChild);
        }
        var s = rangy.getSelection();
        s.setSingleRange(r);
        YUI.M.editor_ousupsub.getEditor(id)._selections = [r];
}

'; // Leave extra space to separate from other scripts it will be appended to.
        return $data;
    }

    /*
     * Copy YUI js files.
     */
    public static function copy_yui_javascript_files() {
        $source = self::create_path('wwwroot/lib/yuilib/yuiversion');
        $destination = self::create_path('root/resources/yui/yuiversion');
        $names = array('attribute-base', 'attribute-complex', 'attribute-core', 'attribute-extras',
                'attribute-observable', 'base-base', 'base-build', 'base-core', 'base-observable',
                'base-pluginhost', 'classnamemanager', 'datatype-xml-parse', 'dom-base',
                'dom-core', 'dom-screen', 'dom-style', 'escape', 'event-base', 'event-custom-base',
                'event-custom-complex', 'event-delegate', 'event-flick', 'event-focus', 'event-hover',
                'event-key', 'event-mouseenter', 'event-mousewheel', 'event-move', 'event-outside',
                'event-resize', 'event-simulate', 'event-synthetic', 'event-tap', 'event-touch',
                'event-valuechange', 'handlebars-base', 'handlebars-compiler', 'io-base', 'io-form',
                'io-upload-iframe', 'io-queue', 'io-xdr', 'node-base', 'node-core',
                'node-event-delegate', 'node-pluginhost', 'node-screen', 'node-style', 'oop', 'overlay',
                'pluginhost-base', 'pluginhost-config', 'querystring-stringify-simple', 'queue-promote',
                'selector', 'selector-native', 'timers', 'transition', 'widget-base',
                'widget-htmlparser', 'widget-position', 'widget-position-align',
                'widget-position-constrain', 'widget-skin', 'widget-stack', 'widget-stdmod',
                'widget-uievents', 'yui', 'yui-throttle');
        foreach ($names as $name) {
            $folderpath = '/'.$name;
            self::create_folder($destination.$folderpath);
            $modulepath = $folderpath.'/'.$name.self::$yuisuffix.'.js';
            if ($result = copy($source.$modulepath, $destination.$modulepath)) {
                self::echo_result("Copy YUI module ".$name."icon.");
            }
        }

        $cssnames = array('widget-base', 'widget-stack', 'overlay');
        foreach ($cssnames as $name) {
            $folderpath = '/'.$name.'/assets/skins/sam';
            self::create_folder($destination.$folderpath);
            $cssmodulepath = $folderpath.'/'.$name.'.css';
            if ($result = copy($source.$cssmodulepath, $destination.$cssmodulepath)) {
                self::echo_result("Copy YUI skin ".$name.".");
            }
        }
    }

    /*
     * Create a folder on the file system give a path.
     */
    public static function create_folder($path) {
        global $CFG;
        if (!file_exists($path)) {
            $result = mkdir($path, $CFG->directorypermissions, true);
        }

        return true;
    }

    /*
     * Create a php folder path given keys from the $paths array.
     */
    public static function create_path ($ids) {
        $keys = explode('/', $ids);
        $path = '';
        foreach ($keys as $key) {
            $path .= strlen($path) ? '/' : '';
            $path .= array_key_exists($key, self::$paths) ? self::$paths[$key] : $key;
        }
        return $path;
    }

    /*
     * Create a folder on the file system give a path.
     */
    public static function echo_result($msg) {
        echo $msg."\r\n";
    }
}
