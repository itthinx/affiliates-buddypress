=== Affiliates BuddyPress ===
Contributors: itthinx, proaktion, eggemplo
Donate link: http://www.itthinx.com/plugins/affiliates-buddypress
Tags: affiliates, itthinx, buddypress, profile
Requires at least: 4.0.0
Tested up to: 4.6
Stable tag: 1.0.1
License: GPLv3

Affiliates integration with BuddyPress.

== Description ==

[Affiliates](https://wordpress.org/plugins/affiliates/) integration with [BuddyPress](https://wordpress.org/plugins/buddypress/) that allows to display affiliate content in the BuddyPress user profile - both plugins are required to make sensible use of this integration.

You would use this plugin to display the page content of a specific page intended to be seen by affiliates, or by potential affiliates who would like to sign up, and have it integrated within the user profile section that BuddyPress provides.

Setup is pretty straight-forward: You need to have BuddyPress installed and the Affiliates plugin. Go to Affiliates > BuddyPress and select the page that should provide the content to be shown to affiliates or potential affiliates in the user profile section.
The plugin will add a new entry to the BuddyPress profile menu where the content of the selected page is embedded. It's recommended to generate the default affiliate area and use that page, this generic affiliate area is sufficient for many deployments.
Please refer to the [Pages](http://docs.itthinx.com/document/affiliates/setup/settings/pages/) section in the documentation of the Affiliates plugin for details.
Then go to Affiliates > BuddyPress and select the page in the dropdown provided there and hit the Save button. Now visit the front end user profile pages provided by BuddyPress and you should see there is a new entry named after the title of the selected page.
If you have chosen to use the default affiliate area, then this allows non-affiliates to join the affiliate program. Those that have already signed up, will see their affiliate resources and stats there.

== Installation ==

1. Upload or extract the `affiliates-buddypress` folder to your site's `/wp-content/plugins/` directory. Or you could use the *Add new* option found in the *Plugins* menu in WordPress.
2. Enable the plugin from the *Plugins* menu in WordPress.
3. A new *BuddyPress* submenu will appear in the Affiliates menu.
4. Select your Affiliate Area page from Affiliates > BuddyPress.
5. Your affiliates have a new tab in their profile page with the Affiliates page.

== Frequently Asked Questions ==

= I don't know which page I should choose. What if I haven't set up an affiliate area yet? =

You can create your Affiliate Area pages using the Affiliates shortcodes and/or using the generation page system from Affiliates > Settings.
Please refer to the [Settings > Pages](http://docs.itthinx.com/document/affiliates/setup/settings/pages/) section in the documentation for details.

== Screenshots ==

1. Overview - shows the new Affiliates tab added on the BuddyPress user profile page.
2. Submenu - the BuddyPress submenu item.
3. Settings - where plugin options are maintained

== Changelog ==

= 1.0.1 =
* Fixed stylesheet URL.

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.1 =
* This release fixes an issue with the URL of the admin stylesheet.
