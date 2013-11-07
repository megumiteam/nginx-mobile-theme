<?php 
/*
Plugin Name: Nginx Mobile Theme
Plugin URI: http://ninjax.cc/
Description: This plugin allows you to switch theme according to the User Agent on the Nginx reverse proxy.
Author: miyauchi, megumithemes
Version: 1.0.0
Author URI: http://ninjax.cc/

Copyright 2013 megumithemes (email : info@ninjax.cc)

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

$amimoto_mobile = new Nginx_Mobile_Theme();
$amimoto_mobile->init();

class Nginx_Mobile_Theme{

private $mobile_detects = array('@smartphone');
private $nginxcc = 'nginx-cache-controller/nginx-champuru.php';

public function init()
{
    add_action('plugins_loaded', array($this, 'plugins_loaded'), 9999);
}

public function plugins_loaded()
{
    if (!has_filter('nginxmobile_mobile_themes')) {
        add_action('customize_register', array($this, 'customize_register'));
    }

    $mobile_detect = $this->mobile_detect();
    if ($mobile_detect) {
        $mobile_theme = get_option("nginxmobile_mobile_themes");
        /**
         * Filter the theme slug for mobile
         *
         * @param string $mobile_theme theme slug
         */
        $mobile_theme = apply_filters('nginxmobile_mobile_themes', $mobile_theme);
        $detect = str_replace('@', '', $mobile_detect);
        if (isset($mobile_theme[$detect]) && $mobile_theme[$detect]) {
            $this->switch_theme($mobile_theme[$detect]);
        }

        add_filter(
            'nginxchampuru_get_the_url',
            array($this, 'nginxchampuru_get_the_url')
        );
    }
}

public function customize_register($wp_customize)
{
    $all_themes = wp_get_themes();
    $themes = array();
    foreach ($all_themes as $theme_name => $theme) {
        $themes[$theme_name] = $theme->get('Name');
    }

    $wp_customize->add_section('nginxmobile', array(
        'title'          => 'Mobile Theme',
        'priority'       => 9999,
    ));

    foreach ($this->get_mobile_detects() as $detect) {
        $detect = str_replace('@', '', $detect);
        $current_theme = wp_get_theme();
        $wp_customize->add_setting('nginxmobile_mobile_themes['.$detect.']', array(
            'default'        => $current_theme->get_stylesheet(),
            'type'           => 'option',
            'capability'     => 'switch_themes',
        ));

        $wp_customize->add_control('nginxmobile_mobile_themes-'.$detect, array(
            'settings' => 'nginxmobile_mobile_themes['.$detect.']',
            'label'    => ucfirst($detect).' theme',
            'section'  => 'nginxmobile',
            'type'     => 'select',
            'choices'  => $themes
        ));
    }
}

public function nginxchampuru_get_the_url($url)
{
    $mobile_detect = $this->mobile_detect();
    return $mobile_detect.$url;
}

private function get_mobile_detects()
{
    /**
     * Filter the mobile detects
     *
     * @param array $mobile_detects An array of determined result of user agent
     */
    return apply_filters("nginxmobile_mobile_detects", $this->mobile_detects);
}

private function switch_theme($theme)
{
    $theme = new Megumi_SwitchTheme($theme);
    $theme->apply();
}

private function mobile_detect()
{
    $mobile_detect = '';

    if (isset($_SERVER['HTTP_X_UA_DETECT']) && $_SERVER['HTTP_X_UA_DETECT']) {
        $mobile_detect = $_SERVER['HTTP_X_UA_DETECT'];
    }

    /**
     * Filter the determined user-agent by nginx
     *
     * @param string $mobile_detect ktai or smartphone or smartphone.off on Nginx
     */
    return apply_filters("nginxmobile_mobile_detect", $mobile_detect);
}

} // end class

// EOF
