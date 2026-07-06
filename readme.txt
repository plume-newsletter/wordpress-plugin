=== Plume Newsletter ===
Contributors: plumenewsletter
Tags: newsletter, signup form, email, subscribe, plume
Requires at least: 5.8
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 0.1.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add a signup form to your WordPress site that enrolls subscribers into a Plume list via double opt-in.

== Description ==

Plume Newsletter adds an email signup form to your site. Submissions are sent to your own Plume instance's public subscribe endpoint, which emails the subscriber a confirmation link (double opt-in). The plugin stores no API key — only your Plume base URL and a list ID.

* `[plume_signup]` shortcode (works in the block editor, classic editor, and page builders)
* A "Plume Signup" widget for sidebars and footers
* Double opt-in — subscribers confirm by email before they are active
* Spam protection with a honeypot and time-trap (no CAPTCHA, no tracking)
* No API key or secret stored

== Installation ==

1. Upload and activate the plugin.
2. Go to Settings → Plume and enter your Plume base URL (e.g. https://app.yourplume.com) and a list ID from your Plume dashboard.
3. Add `[plume_signup]` to any page or post, or add the "Plume Signup" widget.

== Frequently Asked Questions ==

= Does this need a Plume API key? =
No. It uses Plume's public double-opt-in subscribe endpoint, so no key is stored.

= Where do I find my list ID? =
In your Plume dashboard under Lists.

= I use full-page caching. Anything to know? =
Yes. Exclude the page holding the form from full-page caching. The form carries a one-time security token and a timing check that are both baked into cached HTML — under aggressive caching a legitimate submission can be silently treated as "check your email" without creating a subscriber, and the timing-based spam check is weakened (the honeypot still applies). Most caching plugins let you exclude a single page or URL.

== Privacy ==

The email address and optional name a visitor submits are sent to the Plume instance you configure. The plugin stores nothing locally beyond the base URL and list ID settings.

== Changelog ==

= 0.1.2 =
* Added a translation template (languages/plume-newsletter.pot). No functional changes.

= 0.1.1 =
* Code-quality pass: WordPress Coding Standards compliance (Plugin Check clean), no functional changes.

= 0.1.0 =
* Initial release: signup shortcode + widget, double opt-in, honeypot/time-trap spam protection.
