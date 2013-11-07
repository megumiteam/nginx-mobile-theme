=== Nginx Mobile Themes ===
Contributors: miyauchi,megumithemes
Tags: nginx, mobile, theme, smartphone, tablet, iphone, ipad, android
Requires at least: 3.7.1
Tested up to: 3.7.1
Stable tag: 1.0.0

This plugin allows you to switch theme according to the User Agent on the Nginx reverse proxy.

== Description ==

This plugin allows you to switch theme according to the User Agent on the Nginx reverse proxy.

Nginx Mobile Theme requires WordPress 3.7+ with Nginx Cache Controller 2.0.0+.

* You can flush cache automatically. It is requires [Nginx Cache Controller](http://wordpress.org/plugins/nginx-champuru/)
* Allow you to switch theme according to the user-agent.
* Allow you to customize multiple mobile device support via filter-hook.

= Nginx Configuration =

Add mobile device detection to the nginx.conf like following.

`if ($http_user_agent ~* '(iPhone|iPod|incognito|webmate|Android|dream|CUPCAKE|froyo|BlackBerry|webOS|s8000|bada|IEMobile|Googlebot\-Mobile|AdsBot\-Google)') {
    set $mobile "@smartphone";
}`

Set proxy_cache_key like following.

`proxy_cache_key "$scheme://$host$request_uri$mobile";`

Send 404 header when visit to `http://example.com/@smartphone`.

`location ~* @smartphone { access_log /dev/null; log_not_found off; return 404; }`

Send custom request header to the backend.

`proxy_set_header X-UA-Detect $mobile;`

Nginx Mobile Theme will switch theme when '@smartphone' is received in the `$_SERVER['HTTP_X_UA_DETECT']`.

= How to use =

1. Please access to the theme-customizer in the WordPress admin area.
2. Please select Mobile Theme in the drop-down.
3. Click to save "Save & Publish" button.

= Multiple mobile device support =

1. Add custom mobile detection to the nginx.conf.
2. Add custom mobile detects via `nginxmobile_mobile_detects` filter-hook.

== Installation ==

1. Upload `nginx-mobile-theme` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Screenshots ==

1. theme-customizer

== Changelog ==

= 1.0.0 =
* first release.
