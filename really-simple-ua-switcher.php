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

$amimoto_mobile = new Amimoto_Mobile();
$amimoto_mobile->init();

class Amimoto_Mobile {

public function init()
{
    add_action('plugins_loaded', array($this, 'plugins_loaded'), 9999);

    if (!defined('AMIMOTO_MOBILE_THEME') || !AMIMOTO_MOBILE_THEME) {
        add_action('customize_register', array($this, 'customize_register'));
    }
}

public function customize_register($wp_customize)
{
    $wp_customize->add_section('amimob', array(
        'title'          => 'Mobile Theme',
        'priority'       => 9999,
    ));

    $current_theme = wp_get_theme();
    $wp_customize->add_setting('amimob_mobile_theme', array(
        'default'        => $current_theme->get_stylesheet(),
        'type'           => 'option',
        'capability'     => 'switch_themes',
    ));

    $all_themes = wp_get_themes();
    $themes = array();
    foreach ($all_themes as $theme_name => $theme) {
        $themes[$theme_name] = $theme->get('Name');
    }

    $wp_customize->add_control('amimob_mobile_theme', array(
        'settings' => 'amimob_mobile_theme',
        'label'    =>'Mobile Theme',
        'section'  => 'amimob',
        'type'     => 'select',
        'choices'  => $themes
    ));
}

public function plugins_loaded()
{
    $mobile_detect = $this->mobile_detect();
    if ($mobile_detect) {
        if (defined('AMIMOTO_MOBILE_THEME') && AMIMOTO_MOBILE_THEME) {
            $mobile_theme = AMIMOTO_MOBILE_THEME;
        } else {
            $current_theme = wp_get_theme();
            $mobile_theme = get_option(
                "amimob_mobile_theme",
                $current_theme->get_stylesheet()
            );
        }
        /*
         * Filter the theme slug for mobile
         *
         * @param string $mobile_theme theme slug
         */
        $mobile_theme = apply_filters(
            'amimob_mobile_theme-'.$mobile_detect,
            $mobile_theme
        );
        $this->switch_theme($mobile_theme);

        add_filter(
            'nginxchampuru_get_the_url',
            array($this, 'nginxchampuru_get_the_url')
        );
    }
}

public function nginxchampuru_get_the_url($url)
{
    $mobile_detect = $this->mobile_detect();
    return $url.$mobile_detect;
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
        // ktai or smartphone or smartphone.off on Amimoto
        $mobile_detect = $_SERVER['HTTP_X_UA_DETECT'];
    } elseif (function_exists('wp_is_mobile') && wp_is_mobile()) {
        $mobile_detect = '@smartphone';
    }

    /*
     * Filter the determined user-agent by nginx
     *
     * @param string $mobile_detect ktai or smartphone or smartphone.off on Amimoto
     */
    return apply_filters("amimob_mobile_detect", $mobile_detect);
}

} // end class

// EOF
