=== Nginx Mobile Themes ===
Contributors: miyauchi,megumithemes
Tags: nginx, mobile, theme, smartphone, tablet, iphone, ipad, android
Requires at least: 3.7.1
Tested up to: 3.7.1
Stable tag: 1.0

This plugin switches themes according to the User Agent on the Nginx reverse proxy.

== Description ==

This plugin switches themes according to the User Agent on the Nginx reverse proxy.

= How use =
1. Using the rsus_regular_expression filter, specifies conditions with regular expressions. Default regular expression as below:
/(iPhone|iPod|incognito|webmate|Android|dream|CUPCAKE|froyo|BlackBerry|webOS|s8000|bada|IEMobile|Googlebot\-Mobile|AdsBot\-Google)/i
2. Using the rsus_switch_theme_name filter, specifies a theme name which you would like to use with the above conditions.

= Translators =
* English(en) - [megumithemes](http://profiles.wordpress.org/megumithemes/)

== Installation ==

1. Upload `nginx-mobile-theme` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Screenshots ==

== Changelog ==
= 1.0 =
* first release. 
