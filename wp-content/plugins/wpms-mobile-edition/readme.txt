=== WordPress Multi Site Mobile Edition ===
Contributors: RavanH
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=ravanhagen%40gmail%2ecom&item_name=WPMS%20Mobile%20Edition&item_number=0%2e4&no_shipping=0&tax=0&bn=PP%2dDonationsBF&charset=UTF%2d8&lc=us
Tags: mobile, pda, wireless, cellphone, phone, iphone, touch, webkit, android, blackberry, carrington, multi site, multisite, multi-site
Requires at least: 3.0
Tested up to: 3.1
Stable tag: 0.4

Makes sites use the Carrington Mobile theme designed for mobile devices when visitors come to any site on your network with a mobile device.

== Description ==

WordPress Multi Site Mobile Edition is a conversion of the famous WordPress Mobile Edition plugin suitable for WP3+ in both normal _and multi-site_ mode. It will make WordPress use the Carrington Mobile theme designed for mobile devices when visitors come to your site _or any site on your network_ with a mobile device.

See your single site or all sites in your network jump from less than 2 to nearly 5 out of 5 score on [MobiReady](http://ready.mobi/)

Mobile browsers are automatically detected, the list of mobile browsers can be customized on either **Super Admin > Mobile** or **Appearance > Mobile** depending on your setup. 

TODO: Optionally disallow individual site owners to change the settings for their site.

= Translations =

None yet... Please submit yours and get mentioned here :)

== Installation ==

Quick installation: [Install now](http://coveredwebservices.com/wp-plugin-install/?plugin=wpms-mobile-edition) !

 &hellip; OR &hellip;

Search for "wpms mobile edition" and install from your slick **Plugins > Add New** back-end page.

 &hellip; OR &hellip;

Follow these steps:

1. Download the archive and either drop the included /wpms-mobile-edition/ directory with its content in your /plugins/ directory or drop only the content of wpms-mobile-edition.php file in your /mu-plugins/ directory.
2. Download and install the latest [Carrington Mobile theme](http://carringtontheme.com/themes/) or do a search and install from that slick new theme installation on **Appearance > Themes > Install Themes** on your WordPress back-end. Do NOT activate the theme, it only needs to be installed.
3. If you installed in /plugins/ you can now choose to either 'Activate' or 'Network Activate' from the main site.

Done!

== Frequently Asked Questions ==

= Does this plugin include any mobile themes ? =

No, you need to install one yourself. After plugin activation, you will get instructions for easy automated installation of compatible Mobile themes hosted on WordPress Extend. At this point ( version 0.3 ) this is only Carrington Mobile.

= Is this compatible with the WP plugin auto-upgrade feature? =

Yes.

= Is this compatible with Multi Site mode? =

Yes.

= Can I install it in the /mu-plugins/ folder? =

Yes.

= Is this compatible with WP (Super) Cache or others ? =

Yes, it is compatible with WP Super Cache 0.9+ (using WP Cache mode). Be sure to activate the Mobile option. It has also been tested on Quick Cache where you need to copy the list of mobile and touch browsers to the No-Cache User-Agent Patterns section.

= Does this create a mobile admin interface too? =

No, it does not.

= Does this serve a mobile interface to mobile web search crawlers? =

Yes, to Google and Yahoo mobile search crawlers. You can add any others by adding their user agents in the plugin's Settings page.

= Does this support iPhones and other "touch" browsers? =

Yes, the mobile theme Carrington Mobile has a customized interface for advanced mobile browsers and special styling to make things "finger-sized" for touch browsers.

= My mobile device isn't automatically detected, what do I do? =

Visit the settings page and use the link there to identify your mobile browser's User Agent.

Then add that to the list of mobile browsers in your settings.

= Does this conflict with other iPhone theme plugins? =

Remove the iPhone from the list of detected browsers, then the other iPhone theme should work as normal.

= Can I create a link normal visitors can see the mobile version? =

Yes. The link can be added to your theme by using the wpms_mobile_link() template tag:

`<?php if (function_exists('wpms_mobile_link')) { wpms_mobile_link(); } ?>`

This will output HTML code like `<a href="?wpmsme_action=show_mobile">Mobile Edition</a>` on you blog page.

When a user follows that link, the mobile version will be displayed with after each post/page content a link back to the **Standard Edition**.

Note: this does not work well if you have WP Cache enabled.


= Why are recent posts shown on every page? =

This is a feature of the plugin to allow easy access to recent content.


= How do I customize the display of the mobile interface? =

You will need to edit the templates is the /carrington-mobile/ theme folder. Any changes you make there will affect the display of the mobile interface.

== Screenshots ==

You can see the mobile theme in action here: http://mobile.carringtontheme.com


== Other Notes ==

= API =

**FILTERS**

	mobile_browsers
		filters the mobile browsers user agents (array)
	touch_browsers
		filters the touch browsers user agents (array)
	mobile_theme
		filters the mobile theme (theme dirname)
	check_mobile
		filters the check mobile bolean (true or false)

Example: filter `check_mobile` allows you to affect if a mobile browser is detected.
`
function your_mobile_check_function($mobile_status) {
	// do your logic, set $mobile_status to true/false as needed
	return $mobile_status;
}
add_filter('check_mobile', 'your_mobile_check_function');
`

**ACTIONS**

	wpmsme_settings_form_top
		hook at the beginning of the settings page
	wpmsme_settings_form_bottom
		hook at the end of the settings page

Example: action `wpmsme_settings_form` allows you to add to the settings page for this plugin. Handling form posts and other activities from anything you add to this form should be done in your plugin.
`
function your_settings_form() {
	// create your form here - don't forget to catch the form submission as well
}
add_action('wpmsme_settings_form', 'your_settings_form');
`

== Changelog ==

= 0.5 =
* TODO: add Super Admin options page
* TODO: add new Mobile themes

= 0.4 =
* bugfix: mobile link incomplete

= 0.3 =
* improved options sanitization
* moved Mobile settings page to Appearance section
* removed external css and js back-end files

= 0.2 =
* conversion to WP register_setting for options handling

= 0.1 =
* conversion from original WordPress Mobile Edition for Multi-Site mode

== Update Notice ==

= 0.4 =
* bugfix: mobile link incomplete
