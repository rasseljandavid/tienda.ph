{*
 * Copyright (c) 2004-2015 OIC Group, Inc.
 * Written and Designed by James Hunt
 *
 * This file is part of Exponent
 *
 * Exponent is free software; you can redistribute
 * it and/or modify it under the terms of the GNU
 * General Public License as published by the Free
 * Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 *
 * GPL: http://www.gnu.org/licenses/gpl.txt
 *
 *}

{if !$error}
    {if $is_email == 1}
        <style type="text/css" media="screen">
            {$css}
        </style>
    {else}
        {css unique="default-report" corecss="tables,button"}

        {/css}
    {/if}
    <div class="module forms show">
        {permissions}
            <div class="item-actions">
                {if $permissions.edit}
                    {icon class=edit action=enterdata forms_id=$f->id id=$record_id title='Edit this record'|gettext}
                {/if}
                {if $permissions.delete}
                    {icon class=delete action=delete forms_id=$f->id id=$record_id title='Delete this record'|gettext}
                {/if}
            </div>
        {/permissions}
        {if empty($config.report_def)}
            <table border="0" cellspacing="0" cellpadding="0" class="exp-skin-table">
                <thead>
                    <tr>
                        <th colspan="2">
                            <{$config.heading_level|default:'h2'}>{$title}</{$config.heading_level|default:'h2'}>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$fields key=fieldname item=value}
                        <tr class="{cycle values="even,odd"}">
                            <td>{$captions[$fieldname]}</td>
                            <td>
                                {if $fieldname == 'email'}
                                    <a href="mailto:{$value}">{$value}</a>
                                {else}
                                    {$value}
                                {/if}
                            </td>
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        {else}
            <{$config.heading_level|default:'h2'}>{$title}</{$config.heading_level|default:'h2'}>
            {eval var=$config.report_def}
            {clear}{br}
        {/if}
        {if !empty($referrer)}
            <p>{'Referrer'|gettext}: {$referrer}</p>
        {/if}
        {if !$is_email}
            {*<a class="{button_style}" href="{$backlink}">{'Back'|gettext}</a>*}
            {icon button=true link=$backlink text='Back'|gettext}
        {/if}
        {if empty($f) && $permissions.configure}
            {permissions}
                <div class="module-actions">
                    <div class="msg-queue notice" style="text-align:center">
                        <p>{'You MUST assign a form to use this module!'|gettext} {icon action="manage" select=true}</p>
                    </div>
                </div>
            {/permissions}
        {/if}
    </div>
{/if}