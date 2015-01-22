<!DOCTYPE html>
<html id="yui_3_17_2_3_1421681604257_368" class="yui3-js-enabled" dir="ltr" xml:lang="en" lang="en"><div class="" id="yui3-css-stamp" style="position: absolute !important; visibility: hidden !important"></div><head>
    <title>OU SupSub demo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript">
//<![CDATA[
var M = {}; M.yui = {};
M.pageloadstarttime = new Date();
M.pathname = window.location.pathname;
M.fileroot = M.pathname.substring(0, M.pathname.lastIndexOf('/'));
M.protocol = window.location.protocol;
M.host  = window.location.host ;
M.cfg = {"wwwroot":M.protocol + "//" + M.host + M.fileroot,"sesskey":"","loadingicon":"l","themerev":-1,"slasharguments":1,"theme":"clean","jsrev":-1,"svgicons":true,"developerdebug":true};

console.log('M.cfg.wwwroot = ' + M.cfg.wwwroot);

//]]>
</script>
<script src="http://yui.yahooapis.com/3.17.2/build/yui/yui-min.js"></script>
<script src="resources/moodle-editor_ousupsub-editor.js"></script>
<script src="resources/moodle-editor_ousupsub-manager.js"></script>
<script src="resources/moodle-editor_ousupsub-menu.js"></script>
<script src="resources/moodle-editor_ousupsub-plugin.js"></script>
<script src="resources/moodle-editor_ousupsub-rangy.js"></script>
<script src="resources/moodle-ousupsub_subscript-button.js"></script>
<script src="resources/moodle-ousupsub_superscript-button.js"></script>

<script id="firstthemesheet" type="text/css">/** Required in order to fix style inclusion problems in IE with YUI **/</script>

<link rel="stylesheet" type="text/css" href="resources/styles_debug.css">
<link rel="stylesheet" type="text/css" href="resources/styles_debug_049.css">
<script type="text/javascript" src="resources/javascript-static.js"></script>
</head>

<body class="dir-ltr lang-en jsenabled">

<script type="text/javascript">
//<![CDATA[
document.body.className += ' jsenabled';
//]]>
</script>

<form autocomplete="off" action="" method="post" accept-charset="utf-8" id="mform1" class="mform" onsubmit="try { var myValidator = validate_user_editadvanced_form; } catch(e) { return true; } return myValidator(this);">
	
		<div id="yui_3_17_2_3_1421681604257_849" class="fcontainer clearfix">
			<div id="fitem_id_description_editor" class="fitem fitem_feditor ">
				<div class="felement feditor">
					<div>
						<div class="editor_ousupsub">
						</div>
						<textarea style="display: none;" id="id_description_editor" name="description_editor[text]" rows="15" cols="80" spellcheck="true" hidden="hidden">&lt;p&gt;Superscript and Subscript&lt;/p&gt;</textarea>
					</div>
					<div><input name="description_editor[format]" value="1" type="hidden"></div>
					<input name="description_editor[itemid]" value="774037094" type="hidden">
					<noscript><div><object type='text/html' data='' height='160' width='600' style='border:1px solid #000'></object></div></noscript>
				</div>

			</div>
		</div>
	
</form>

<script type="text/javascript">
//<![CDATA[
M.str = {"moodle":{"error":"Error","morehelp":"More help","changesmadereallygoaway":"You have made changes. Are you sure you want to navigate away and lose your changes?"},
		"ousupsub_subscript":{"pluginname":"Subscript"},"ousupsub_superscript":{"pluginname":"Superscript"},"editor_ousupsub":{"editor_command_keycode":"Cmd + {$a}","editor_control_keycode":"Ctrl + {$a}","plugin_title_shortcut":"{$a->title} [{$a->shortcut}]"},"error":{"serverconnection":"Error connecting to the server"}};
//]]>
</script>

<script type="text/javascript">
//<![CDATA[
YUI().use('node', function(Y) {
Y.use("moodle-editor_ousupsub-editor","moodle-ousupsub_subscript-button","moodle-ousupsub_superscript-button",function() {YUI.M.editor_ousupsub.createEditor(
{"elementid":"id_description_editor","content_css":"","contextid":0,"language":"en","directionality":"ltr","plugins":[{"group":"style1","plugins":[{"name":"subscript","params":[]},{"name":"superscript","params":[]}]}],"pageHash":""});
});
 

});
//]]>
</script>
			</div>
		</div>
	</body>
</html>