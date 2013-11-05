<?php 
/*
Plugin Name: Really Simple UA Switcher
Plugin URI: http://digitalcube.jp
Description: 
Author: megumithemes
Version: 1.0
Author URI: http://digitalcube.jp

Copyright 2013 megumithemes (email : info@digitalcube.jp)

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

require(dirname(__FILE__).'/vendor/autoload.php');

$ua = $_SERVER['HTTP_USER_AGENT'];
$pattern = '/(iPhone|iPod|incognito|webmate|Android|dream|CUPCAKE|froyo|BlackBerry|webOS|s8000|bada|IEMobile|Googlebot\-Mobile|AdsBot\-Google)/i';
$pattern = apply_filters( 'rsus_regular_expression', $pattern );
$switch_theme = apply_filters( 'rsus_switch_theme_name','' );

if ( !empty($pattern) && !empty($switch_theme) && isset($ua) && preg_match( $pattern, $ua ) ) {
    $theme = new Megumi_SwitchTheme($switch_theme);
    $theme->apply();
}
