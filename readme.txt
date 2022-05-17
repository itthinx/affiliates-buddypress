=== Affiliates BuddyPress ===
Contributors: itthinx, proaktion, eggemplo
Donate link: https://www.itthinx.com/shop/
Tags: affiliates, itthinx, buddypress, profile
Requires at least: 5.6.0
Tested up to: 6.0
Requires PHP: 5.6.0
Stable tag: 1.3.0
License: GPLv3

Affiliates integration with BuddyPress.

== Description ==

[Affiliates](https://wordpress.org/plugins/affiliates/) integration with [BuddyPress](https://wordpress.org/plugins/buddypress/) that allows to display affiliate content in the BuddyPress user profile - both plugins are required to make sensible use of this integration.

Also supports [Affiliates Pro](https://www.itthinx.com/shop/affiliates-pro/) and [Affiliates Enterprise](https://www.itthinx.com/shop/affiliates-enterprise/).

You would use this plugin to display the page content of a specific page intended to be seen by affiliates, or by potential affiliates who would like to sign up, and have it integrated within the user profile section that BuddyPress provides.

Setup is pretty straight-forward: You need to have BuddyPress installed and [Affiliates](https://wordpress.org/plugins/affiliates/), [Affiliates Pro](https://www.itthinx.com/shop/affiliates-pro/) or [Affiliates Enterprise](https://www.itthinx.com/shop/affiliates-enterprise/). Go to Affiliates > BuddyPress and select the page that should provide the content to be shown to affiliates or potential affiliates in the user profile section.

The plugin will add a new entry to the BuddyPress profile menu where the content of the selected page is embedded. It's recommended to generate the default affiliate area and use that page, this generic affiliate area is sufficient for many deployments.

Please refer to the [Pages](https://docs.itthinx.com/document/affiliates/setup/settings/pages/) section in the documentation of the Affiliates plugin for details - or the corresponding documentation entries for [Affiliates Pro / Settings / Pages](https://docs.itthinx.com/document/affiliates-pro/setup/settings/pages/) or [Affiliates Enterprise / Settings / Pages](https://docs.itthinx.com/document/affiliates-enterprise/setup/settings/pages/).

Then go to Affiliates > BuddyPress and select the page in the dropdown provided there and hit the Save button. Now visit the front end user profile pages provided by BuddyPress and you should see there is a new entry named after the title of the selected page.

If you have chosen to use the default affiliate area, then this allows non-affiliates to join the affiliate program. Those that have already signed up, will see their affiliate resources and stats there.

== Installation ==

1. Upload or extract the `affiliates-buddypress` folder to your site's `/wp-content/plugins/` directory. Or you could use the *Add new* option found in the *Plugins* menu in WordPress.
2. Enable the plugin from the *Plugins* menu in WordPress.
3. A new *BuddyPress* submenu item will appear in the Affiliates menu.
4. Select your Affiliate Area page from Affiliates > BuddyPress.
5. Your affiliates have a new tab in their profile page with the Affiliates page.

== Frequently Asked Questions ==

= I don't know which page I should choose. What if I haven't set up an affiliate area yet? =

You can create your Affiliate Area pages using the Affiliates shortcodes or blocks, or by using the generation page system from Affiliates > Settings.
The extension also provides an option to include all pages in those offered for selection.

Please also refer to these pages in the docmentation for details: [Affiliates / Settings / Pages](https://docs.itthinx.com/document/affiliates/setup/settings/pages/) or [Affiliates Pro / Settings / Pages](https://docs.itthinx.com/document/affiliates-pro/setup/settings/pages/) or [Affiliates Enterprise / Settings / Pages](https://docs.itthinx.com/document/affiliates-enterprise/setup/settings/pages/)

= I would like to choose a page that is not included, for example from a custom post type. How? =

Use the `affiliates_buddypress_select_post_ids_args` filter to adjust the parameters used to offer pages for selection.

== Screenshots ==

1. Overview - shows the new Affiliates tab added on the BuddyPress user profile page.
2. Submenu - the BuddyPress submenu item.
3. Settings - where plugin options are maintained

== Changelog ==

See [changelog.txt](https://github.com/itthinx/affiliates-buddypress/blob/master/changelog.txt).

== Upgrade Notice ==

Tested with the latest version of WordPress.
