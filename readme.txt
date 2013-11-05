=== Simple GA Ranking  ===
Contributors: megumithemes
Tags: User Agent
Requires at least: 3.7.1
Tested up to: 3.7.1
Stable tag: 1.0

ユーザーエージェントを判定してテーマを切り分けるプラグインです。

== Description ==

ユーザーエージェントを判定してテーマを切り分けるプラグインです。

= How use =
1. rsus_regular_expressionフィルタを使用してテーマを切り分ける条件を正規表現で記述してください。デフォルトでは下記の正規表現が適用されます。
/(iPhone|iPod|incognito|webmate|Android|dream|CUPCAKE|froyo|BlackBerry|webOS|s8000|bada|IEMobile|Googlebot\-Mobile|AdsBot\-Google)/i
2. rsus_switch_theme_nameフィルタを使用して1の条件にマッチした際に切り分けを行いたいテーマ名を記述してください。

= Translators =
* English(en) - [megumithemes](http://profiles.wordpress.org/megumithemes/)

== Installation ==

1. Upload `really-simple-ua-switcher` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Screenshots ==

== Changelog ==
= 1.0 =
* first release. 
