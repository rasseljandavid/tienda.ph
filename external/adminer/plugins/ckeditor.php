<?php
##################################################
#
# Copyright (c) 2004-2015 OIC Group, Inc.
#
# This file is part of Exponent
#
# Exponent is free software; you can redistribute
# it and/or modify it under the terms of the GNU
# General Public License as published by the Free
# Software Foundation; either version 2 of the
# License, or (at your option) any later version.
#
# GPL: http://www.gnu.org/licenses/gpl.txt
#
##################################################

/** Edit all fields containing "_html" by HTML editor CKeditor and display the HTML in select
* @link http://www.adminer.org/plugins/#use
* @uses CKeditor, http://www.ckeditor.com/
* @author Dave Leffler, http://www.harrisonhills.org/tech
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class AdminerCKeditor {
	/** @access protected */
	var $scripts, $options;
	
	/**
	* @param array
	* @param string in format "skin: 'custom', preInit: function () { }"
	*/
	function AdminerCKeditor($scripts = array(null), $options = "") {
		$this->scripts = $scripts;
		$this->options = $options;
	}
	
	function head() {
		foreach ($this->scripts as $script) {
			echo "<script type='text/javascript' src='" . h($script) . "'></script>\n";
		}
	}
	
	function selectVal(&$val, $link, $field) {
		// copied from tinymce.php
        if (preg_match("~body~", $field["field"]) && $val != '&nbsp;') {
			$shortened = (substr($val, -10) == "<i>...</i>");
			if ($shortened) {
				$val = substr($val, 0, -10);
			}
			//! shorten with regard to HTML tags - http://php.vrana.cz/zkraceni-textu-s-xhtml-znackami.php
			$val = preg_replace('~<[^>]*$~', '', html_entity_decode($val, ENT_QUOTES)); // remove ending incomplete tag (text can be shortened)
			if ($shortened) {
				$val .= "<i>...</i>";
			}
			if (class_exists('DOMDocument')) { // close all opened tags
				$dom = new DOMDocument;
				if (@$dom->loadHTML("<meta http-equiv='Content-Type' content='text/html; charset=utf-8'></head>$val")) { // @ - $val can contain errors
					$val = preg_replace('~.*<body[^>]*>(.*)</body>.*~is', '\\1', $dom->saveHTML());
				}
			}
		}
	}
	
	function editInput($table, $field, $attrs, $value) {
		static $lang = "";
		if (!$lang && preg_match("~text~", $field["type"]) && preg_match("~body~", $field["field"])) {
			$lang = "en";
			if (function_exists('get_lang')) { // since Adminer 3.2.0
				$lang = get_lang();
				$lang = ($lang == "zh" || $lang == "zh-tw" ? "zh_cn" : $lang);
			}
			return "<textarea$attrs id='fields-" . h($field["field"]) . "' rows='6' cols='50'>" . h($value) . "</textarea><script type='text/javascript'>
CKEDITOR.replace('fields-" . js_escape($field["field"]) . "',{
        height : '80',
        toolbarCanCollapse : true,
        toolbarStartupExpanded : false,
        scayt_autoStartup : true,
        removePlugins : 'elementspath',
        resize_enabled : false,
    });
</script>";
		}
	}
	
}
