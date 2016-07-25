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

/**
 * @subpackage Definitions
 * @package Modules
 */
return array(
	'id'=>array(
		DB_FIELD_TYPE=>DB_DEF_ID,
		DB_PRIMARY=>true,
		DB_INCREMENT=>true),
	'title'=>array(
		DB_FIELD_TYPE=>DB_DEF_STRING,
		DB_FIELD_LEN=>200),
	'sef_url'=>array(
		DB_FIELD_TYPE=>DB_DEF_STRING,
		DB_FIELD_LEN=>200),
    'canonical'=>array(
   		DB_FIELD_TYPE=>DB_DEF_STRING,
   		DB_FIELD_LEN=>800),
	'meta_title'=>array(
		DB_FIELD_TYPE=>DB_DEF_STRING,
		DB_FIELD_LEN=>255),
	'meta_keywords'=>array(
		DB_FIELD_TYPE=>DB_DEF_STRING,
		DB_FIELD_LEN=>10000),
	'meta_description'=>array(
		DB_FIELD_TYPE=>DB_DEF_STRING,
		DB_FIELD_LEN=>10000),
    'meta_fb'=>array(
   		DB_FIELD_TYPE=>DB_DEF_STRING,
   		DB_FIELD_LEN=>10000),
    'noindex'=>array(
   		DB_FIELD_TYPE=>DB_DEF_BOOLEAN),
    'nofollow'=>array(
   		DB_FIELD_TYPE=>DB_DEF_BOOLEAN),
	'body'=>array(
		DB_FIELD_TYPE=>DB_DEF_STRING,
		DB_FIELD_LEN=>100000),
    'file_type'=>array(
   		DB_FIELD_TYPE=>DB_DEF_STRING,
   		DB_FIELD_LEN=>200),
    'poster'=>array(
   		DB_FIELD_TYPE=>DB_DEF_INTEGER),
   	'created_at'=>array(
   		DB_FIELD_TYPE=>DB_DEF_TIMESTAMP),
   	'editor'=>array(
   		DB_FIELD_TYPE=>DB_DEF_INTEGER),
   	'edited_at'=>array(
   		DB_FIELD_TYPE=>DB_DEF_TIMESTAMP),
    'publish'=>array(
   		DB_FIELD_TYPE=>DB_DEF_TIMESTAMP),
    'location_data'=>array(
   		DB_FIELD_TYPE=>DB_DEF_STRING,
   		DB_FIELD_LEN=>250,
   		DB_INDEX=>10),
	'downloads'=>array(
		DB_FIELD_TYPE=>DB_DEF_INTEGER),
	'rank'=>array(
		DB_FIELD_TYPE=>DB_DEF_INTEGER),
    'disable_comments'=>array(
   		DB_FIELD_TYPE=>DB_DEF_BOOLEAN),
    'ext_file'=>array(
   		DB_FIELD_TYPE=>DB_DEF_STRING,
   		DB_FIELD_LEN=>255),
);

?>
