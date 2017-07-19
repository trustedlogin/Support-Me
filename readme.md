[![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/query-monitor.svg?style=flat-square)](https://wordpress.org/plugins/query-monitor/)
[![License](https://img.shields.io/badge/license-GPL_v2%2B-blue.svg?style=flat-square)](http://opensource.org/licenses/GPL-2.0)
[![Documentation](https://img.shields.io/badge/docs-stable-blue.svg?style=flat-square)](https://docs.querymonitor.com/en/stable/)
[![WordPress Tested](https://img.shields.io/wordpress/v/query-monitor.svg?style=flat-square)](https://wordpress.org/plugins/query-monitor/)
[![Build Status](https://img.shields.io/travis/johnbillion/query-monitor/master.svg?style=flat-square)](https://travis-ci.org/johnbillion/query-monitor)

=== Support Me ===
Contributors: DrewAPicture
Donate link: http://www.werdswords.com
Tags: support, account, users
Requires at least: 3.5.0
Tested up to: 4.8.0
Stable tag: 1.0.7

Allows you to generate expireable user accounts for support purposes.

== Description ==

Sometimes you just need some help, and when you're working privately with support personnel for a plugin or theme, creating temporary admin accounts can be a pain.

Support Me makes creating accounts for support purposes a snap:

* You can set support accounts to expire after a set number of minutes, hours, or days, or even not expire at all.
* Once a support account expires, it is automatically deleted.
* No more making up fake email addresses or dealing with the full user registration process. Just set an expiration, and generate an account.
* You can manage support account sessions just like any other user account.
* Easily see when Support Accounts expire in a new 'Expires' column on the Users screen

And don't worry about Support Accounts overreaching their bounds on your website. All support accounts are granted full admin privileges with the caveat that they can't create, edit, promote, or delete other users.

Support Me is also fully compatible with debugging plugins such as Debug Bar, ensuring support personnel can help you solve your problems faster so you can get back to work.

<strong>Note: Support Me requires a minimum of PHP 5.3 to be running on your web host.</strong> Help move plugin developers and WordPress forward into modern PHP by asking your host to upgrade you today.

<strong>Contribute to Support Me</strong>

This plugin is in active development <a href="https://github.com/DrewAPicture/support-me" target="_new">on GitHub</a>. Pull requests are welcome!

<strong>Thank you to our <a href="https://translate.wordpress.org/projects/wp-plugins/support-me">community translators</a> on WordPress.org:</strong>

* English (UK) – <a href="https://profiles.wordpress.org/garyj/">Gary Jones</a> (@GaryJ)
* French (France) – <a href="https://profiles.wordpress.org/fxbenard/">François-Xavier Bénard</a> (@fxbenard)
* German – <a href="https://profiles.wordpress.org/pixolin/">Bego Mario Garde</a> (@pixolin)
* German (Formal) – <a href="https://profiles.wordpress.org/pixolin/">Bego Mario Garde</a> (@pixolin)
* Italian – <a href="https://profiles.wordpress.org/wolly/">Paolo Valenti</a> (@wolly)
* Russian – <a href="https://profiles.wordpress.org/sergeybiryukov/">Sergey Biryukov</a> (@SergeyBiryukov)
* Hebrew – <a href="https://profiles.wordpress.org/ramiy/">Rami Yushuvaev</a> (@ramiy)
* Japanese – <a href="https://profiles.wordpress.org/nao/">Naoko Takano</a> (@nao)
* Nepali – <a href="https://profiles.wordpress.org/rabmalin/">Nilambar Sharma</a> (@rabmalin)

== Frequently Asked Questions ==

= Does this plugin realy require a minimum of PHP 5.3? Why? =

Modern coding practices demand the ability to leverage modern techniques. The leap in functionality and speed between PHP 5.2 and modern versions like 5.6 or 7 are exponential.

== Screenshots ==

1. The Add Support Account panel
2. Add Account confirmation panel
2. 'Expires' column in the Users list table

== Changelog ==

= 1.0.7 =

* Fix compatibility with 4.8+ (due to the reconfiguration of h1 elements on core admin screens).

= 1.0.6 =

* Added additional translator credits for Hebrew, Japanese, and Nepali.
* General i18n improvements – props @ramiy

= 1.0.5 =

* Made one complex string more easily translatable.
* Added translator credits to the readme.

= 1.0.4 =

* Added translator comments, consolidated similar strings.

= 1.0.3 =

* Added Text Domain header to whitelist for translation on .org.

= 1.0.2 =

* Tagging mania.

= 1.0.1 =

* Fixed issue with adding admin capabilities to the 'Support Account' role on activation.

= 1.0.0 =

* Initial release.
