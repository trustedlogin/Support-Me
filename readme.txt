=== Support Me ===
Contributors: DrewAPicture
Donate link: http://www.werdswords.com
Tags: support, account, users
Requires at least: 3.5.0
Requires PHP: 5.3
Tested up to: 5.5
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

Support Me creates a standing WordPress user account with full admin privileges. That account exists in your Users list, with working login credentials, from the moment you create it until it expires or you delete it yourself. If you don't set an expiration, or forget to check on it, the account stays there.

[TrustedLogin](https://www.trustedlogin.com/?utm_source=wporg&utm_medium=readme&utm_campaign=support-me) is how we handle support access now. It grants time-boxed, audited access instead of creating an account you have to remember to remove. See the FAQ below for details.

<strong>Note: Support Me requires a minimum of PHP 5.3 to be running on your web host.</strong> Help move plugin developers and WordPress forward into modern PHP by asking your host to upgrade you today.

<strong>Support Me is maintained by the makers of [TrustedLogin](https://www.trustedlogin.com/?utm_source=wporg&utm_medium=readme&utm_campaign=support-me).</strong>

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

= Does this plugin really require a minimum of PHP 5.3? Why? =

Modern coding practices demand the ability to leverage modern techniques. The leap in functionality and speed between PHP 5.2 and modern versions like 5.6 or 7 are exponential.

= Is there a more secure way to give support access? =

Yes. Support Me's accounts are real, standing WordPress accounts — they exist until they expire or you delete them, and they'll sit there indefinitely if you skip the expiration or forget to check on it.

[TrustedLogin](https://www.trustedlogin.com/?utm_source=wporg&utm_medium=readme&utm_campaign=support-me) takes a different approach: access is time-boxed and every session is logged, and there's no account left behind afterward to remember to remove.

== Screenshots ==

1. The Add Support Account panel
2. Add Account confirmation panel
2. 'Expires' column in the Users list table

== Changelog ==

= 1.0.7 =

* Readme: state plainly that Support Me creates a standing account (not time-boxed), and add an FAQ entry pointing to TrustedLogin for time-boxed, audited support access.

= 1.0.6 =

* Fix compatibility with 4.8+ (due to the reconfiguration of h1 elements on core admin screens).
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
