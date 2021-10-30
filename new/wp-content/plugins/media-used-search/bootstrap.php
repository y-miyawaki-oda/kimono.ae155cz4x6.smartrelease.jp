<?php
/**
	Plugin Name: Media Used Search
	Plugin URI:
	Description: If you are using a custom field associated with the post to image, to view the post that you are using the media list. Further images can be searched for that post by applying a search posts titles are used.
	Version: 1.0.0
	Author: iga-ryo
	Author URI:
	Text Domain: media-used-search
	Domain Path: /languages/
	License: GPLv2 or later

	Copyright 2015 iga-ryo

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */
//	定義文
define('MUS_PLUGIN_FULL_PATH', __FILE__);

if ( is_admin() ) {

	require_once( plugin_dir_path( MUS_PLUGIN_FULL_PATH ) . 'assets-setting.php' );
	require_once( plugin_dir_path( MUS_PLUGIN_FULL_PATH ) . 'media-used-search.php' );
	
	new Media_Used_Search();
}

