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
/** @define "BASE" "../../.." */

if (!defined('EXPONENT')) {
    exit('');
}

/**
 * Text Editor Control
 *
 * @package    Subsystems-Forms
 * @subpackage Control
 */
class tinymcecontrol extends formcontrol
{

    var $rows;
    var $cols;
    var $maxchars;
    var $toolbar;
    var $tb_collapsed = false;

    static function name()
    {
        return "TinyMCE Editor";
    }

    function __construct($default = "", $rows = 5, $cols = 45)
    {
        $this->default = $default;
        $this->rows = $rows;
        $this->cols = $cols;
        $this->required = false;
        $this->maxchars = 0;
    }

    function controlToHTML($name, $label)
    {
        global $user;

        $contentCSS = '';
        $cssabs = BASE . 'themes/' . DISPLAY_THEME . '/editors/tinymce/tinymce.css';
        $css = PATH_RELATIVE . 'themes/' . DISPLAY_THEME . '/editors/tinymce/tinymce.css';
        if (THEME_STYLE != "" && is_file(
                BASE . 'themes/' . DISPLAY_THEME . '/editors/tinymce/tinymce_' . THEME_STYLE . '.css'
            )
        ) {
            $cssabs = BASE . 'themes/' . DISPLAY_THEME . '/editors/tinymce/tinymce_' . THEME_STYLE . '.css';
            $css = PATH_RELATIVE . 'themes/' . DISPLAY_THEME . '/editors/tinymce/tinymce_' . THEME_STYLE . '.css';
        }
        if (is_file($cssabs)) {
            $contentCSS = "content_css : '" . $css . "',
            ";
        }
        if ($this->toolbar === '') {
            $settings = expHTMLEditorController::getActiveEditorSettings('tinymce');
        } elseif (intval($this->toolbar) != 0) {
            $settings = expHTMLEditorController::getEditorSettings($this->toolbar, 'tinymce');
        }
        $plugins = "advlist,autolink,lists,link,image,charmap,print,preview,hr,anchor,pagebreak" .
                ",searchreplace,wordcount,visualblocks,visualchars,code,fullscreen" .
                ",insertdatetime,media,nonbreaking,save,table,contextmenu,directionality" .
                ",emoticons,paste,textcolor,importcss,quickupload";
        if (!$user->globalPerm('prevent_uploads')) {
            $upload = "plupload_basepath	: './plugins/quickupload',
                                upload_url			: '" . URL_FULL . "framework/modules/file/connector/uploader_tinymce.php',
                                upload_post_params	: {
                                    action:'upload',
                                    ajax_action:'1',
                                    json:'1'
                                },
                                upload_file_size	: '5mb',
                                upload_callback		: function(res, file, up) {
                                    if (res.status == 200) {
                                        var response = JSON.parse(res.response);
                                        return response.data;  //image path
                                    } else {
                                        return false;
                                    }
                                },
                                upload_error		: function(err, up) {
                                    console.log(err.status);
                                    console.log(err.message);
                                },";
//            $upload .= "
//            images_upload_url: '" . URL_FULL . "framework/modules/file/connector/uploader_tinymce.php',";
//            $upload .= "
//            paste_data_images: false,
//            images_upload_base_path: '" . UPLOAD_DIRECTORY . "',";
        } else {
            $upload = '';
        }
        if (!empty($settings)) {
//            $tb = stripSlashes($settings->data);
            $tb_raw = explode("\n", $settings->data);
            $tb = '';
            foreach ($tb_raw as $key=>$tbr) {
                if (!empty($tbr)) $tb .= "toolbar" . (count($tb_raw) > 1 ? $key + 1 : '') . ": \"" . trim($tbr) . "\",\n";
            }
            $skin = $settings->skin;
            $sc_brw_off   = $settings->scayt_on ? 'false' : 'true';
            $plugins    = stripSlashes($settings->plugins);
            $stylesset = stripSlashes($settings->stylesset);
            $formattags = stripSlashes($settings->formattags);
            $fontnames = stripSlashes($settings->fontnames);
        }
        if (!empty($this->additionalConfig)) {
            $additionalConfig = $this->additionalConfig;
        }
        if (!empty($this->plugin)) {
            $plugins .= ',' . $this->plugin;
        }
        // clean up (custom) plugins list from missing plugins
        if (!empty($plugins)) {
            $plugs = explode(',',trim($plugins));
            foreach ($plugs as $key=>$plug) {
                if (empty($plug) || !is_dir(BASE . 'external/editors/tinymce/plugins/' . $plug)) unset($plugs[$key]);
            }
            $plugins = implode(',',$plugs);
        }

        // set defaults
        if (empty($tb)) {
            if ($this->toolbar === 'basic') {
                $tb = "
                toolbar: 'bold italic underline removeformat | bullist numlist | link unlink',";
            } else {
                $tb = "
                toolbar1: 'undo redo | styleselect formatselect fontselect fontsizeselect | cut copy paste | bold italic underline removeformat | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
                toolbar2: 'link unlink image quickupload | print preview visualblocks fullscreen code media | forecolor backcolor emoticons";
                if (!empty($this->plugin)) {
                    $plugs = explode(',',trim($this->plugin));
                    $tb .= ' |';
                    foreach ($plugs as $key=>$plug) {
                       $tb .= ' ' . $plug;
                   }
                }
                $tb .= "',";
            }
        }
        if (MOBILE) {
            $tb .= "menubar: false,
                   toolbar_items_size: 'small',
                   statusbar: false,";
        }
        if (!MOBILE && $this->tb_collapsed) $tb .= "menubar: false, toolbar_items_size: 'small',";

        if (empty($skin) || !is_dir(BASE . 'external/editors/tinymce/skins/' . $skin)) {
            $skin = 'lightgray';
        }
        if (empty($sc_brw_off)) $sc_brw_off = 'true';
        if (empty($stylesset)) {
            $stylesset = "'default'";
        }
        if (empty($formattags)) {
            $formattags = "'p;h1;h2;h3;h4;h5;h6;pre;address;div'";
        }
        if (empty($fontnames)) {
            $fontnames = "'Andale Mono=andale mono,times;'+
                    'Arial=arial,helvetica,sans-serif;'+
                    'Arial Black=arial black,avant garde;'+
                    'Book Antiqua=book antiqua,palatino;'+
                    'Comic Sans MS=comic sans ms,sans-serif;'+
                    'Courier New=courier new,courier;'+
                    'Georgia=georgia,palatino;'+
                    'Helvetica=helvetica;'+
                    'Impact=impact,chicago;'+
                    'Symbol=symbol;'+
                    'Tahoma=tahoma,arial,helvetica,sans-serif;'+
                    'Terminal=terminal,monaco;'+
                    'Times New Roman=times new roman,times;'+
                    'Trebuchet MS=trebuchet ms,geneva;'+
                    'Verdana=verdana,geneva;'+
                    'Webdings=webdings;'+
                    'Wingdings=wingdings,zapf dingbats'
            ";
        }
        $content = "
        YUI(EXPONENT.YUI3_CONFIG).use('*', function(Y) {
            Y.Global.on(\"lazyload:cke\", function () {
                if(!Y.Lang.isUndefined(EXPONENT.editor" . createValidId($name) . ")){
                    return true;
                };
                EXPONENT.editor" . createValidId($name) . " = tinymce.init({
                    selector : '#" . createValidId($name) . "',
                    plugins : ['" . $plugins . "'],
                    " . $additionalConfig . "
                    " . $contentCSS . "
                    relative_urls : false,
                    remove_script_host : true,
                    document_base_url : '" . PATH_RELATIVE . "',
                    " . $tb . "
                    skin: '" . $skin . "',
                    image_advtab: true,
                    " . $upload . "
                    browser_spellcheck : " . $sc_brw_off . " ,
                    importcss_append: true,
                    style_formats: [
                        {title: 'Image Left',
                            selector: 'img', styles: {
                            'float' : 'left',
                            'margin': '0 10px 0 10px'
                        }},
                        {title: 'Image Right',
                            selector: 'img', styles: {
                            'float' : 'right',
                            'margin': '0 10px 0 10px'
                        }},
                        {title: 'Headers', items: [
                            {title: 'h1', block: 'h1'},
                            {title: 'h2', block: 'h2'},
                            {title: 'h3', block: 'h3'},
                            {title: 'h4', block: 'h4'},
                            {title: 'h5', block: 'h5'},
                            {title: 'h6', block: 'h6'}
                        ]},
                        {title: 'Inline', items: [
                            {title: 'Bold', inline: 'b', icon: 'bold'},
                            {title: 'Italic', inline: 'i', icon: 'italic'},
                            {title: 'Underline', inline: 'span', styles : {textDecoration : 'underline'}, icon: 'underline'},
                            {title: 'Strikethrough', inline: 'span', styles : {textDecoration : 'line-through'}, icon: 'strikethrough'},
                            {title: 'Superscript', inline: 'sup', icon: 'superscript'},
                            {title: 'Subscript', inline: 'sub', icon: 'subscript'},
                            {title: 'Code', inline: 'code', icon: 'code'},
                        ]},
                        {title: 'Blocks', items: [
                            {title: 'Paragraph', block: 'p'},
                            {title: 'Blockquote', block: 'blockquote'},
                            {title: 'Div', block: 'div'},
                            {title: 'Pre', block: 'pre'}
                        ]},
                        {title: 'Alignment', items: [
                            {title: 'Left', block: 'div', styles : {textAlign : 'left'}, icon: 'alignleft'},
                            {title: 'Center', block: 'div', styles : {textAlign : 'center'}, icon: 'aligncenter'},
                            {title: 'Right', block: 'div', styles : {textAlign : 'right'}, icon: 'alignright'},
                            {title: 'Justify', block: 'div', styles : {textAlign : 'justify'}, icon: 'alignjustify'}
                        ]},
                        {title: 'Containers', items: [
                            {title: 'section', block: 'section', wrapper: true, merge_siblings: false},
                            {title: 'article', block: 'article', wrapper: true, merge_siblings: false},
                            {title: 'blockquote', block: 'blockquote', wrapper: true},
                            {title: 'hgroup', block: 'hgroup', wrapper: true},
                            {title: 'aside', block: 'aside', wrapper: true},
                            {title: 'figure', block: 'figure', wrapper: true}
                        ]}
                    ],
                    font_names :
                        " . $fontnames . ",
                    end_container_on_empty_block: true,
                    file_picker_callback: function expBrowser (callback, value, meta) {
                        tinymce.activeEditor.windowManager.open({
                            file: '" . makelink(
                                    array("controller" => "file", "action" => "picker", "ajax_action" => 1, "update" => "tiny")
                                ) . "?filter='+meta.filetype,
                            title: '".gt('File Manager')."',
                            width: " . FM_WIDTH . ",
                            height: " . FM_HEIGHT . ",
                            resizable: 'yes'
                        }, {
                            oninsert: function (url, alt, title) {
                                // Provide file and text for the link dialog
                                if (meta.filetype == 'file') {
                                    callback(url, {text: alt, title: title});
                                }

                                // Provide image and alt text for the image dialog
                                if (meta.filetype == 'image') {
                                    callback(url, {alt: alt});
                                }

                                // Provide alternative source and posted for the media dialog
                                if (meta.filetype == 'media') {
                                    callback(url);
                                }
                            }
                        });
                        return false;
                    },
                });

            });
            if (!Y.one('#" . createValidId($name) . "').ancestor('.exp-skin-tabview')) {
                Y.Global.fire('lazyload:cke');
            }
        });
        ";

        expJavascript::pushToFoot(
            array(
                "unique" => "tinymcepu",
                "src"=>PATH_RELATIVE."external/editors/tinymce/plugins/quickupload/plupload.full.min.js"
            )
        );
        expJavascript::pushToFoot(
            array(
                "unique" => "tinymce",
                "src"=>PATH_RELATIVE."external/editors/tinymce/tinymce.min.js"
            )
        );
        expJavascript::pushToFoot(
            array(
                "unique" => "000-tinymce" . $name,
                "yui3mods" => "node,event-custom",
                "content" => $content,
            )
        );

        $html = "<!-- cke lazy -->";
        $html .= "<textarea class=\"textarea\" id=\"" . createValidId($name) . "\" name=\"$name\"";
        if ($this->focus) $html .= " autofocus";
        $html .= " rows=\"" . $this->rows . "\" cols=\"" . $this->cols . "\"";
        if ($this->accesskey != "") {
            $html .= " accesskey=\"" . $this->accesskey . "\"";
        }
        if (!empty($this->class)) {
            $html .= " class=\"" . $this->class . "\"";
        }
        if ($this->tabindex >= 0) {
            $html .= " tabindex=\"" . $this->tabindex . "\"";
        }

        $html .= ">";
        $html .= htmlentities($this->default, ENT_COMPAT, LANG_CHARSET);
        $html .= "</textarea>";
        if (!empty($this->description)) {
            $html .= "<div class=\"".(bs3()?"help-block":"control-desc")."\">" . $this->description . "</div>";
        }
        return $html;
    }

}

?>
