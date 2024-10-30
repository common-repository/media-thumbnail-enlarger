=== Media Library Thumbnail Enhancer ===
Contributors: nickciske
Donate link: http://thoughtrefinery.com/contact/say-thank-you/
Tags: media library, thumbnail, column
Requires at least: 3.5.2
Tested up to: 3.8.1
Stable tag: 1.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Enhances media library thumbnails by making them larger and replacing the bundled icons with scalable SVG versions.

== Description ==

Makes media library thumbnails match the WordPress thumbnail size or allows you to choose a new size in Settings: Media (or hard code a custom size named 'mte_thumbnail').

Also replaces the default "Crystal" file type icons with smoothly scaling SVG icons that better match the WordPress 3.8+ design.

== Screenshots ==

1. Without the plugin active
1. Using the default 150x150 WordPress thumbnail size
1. Using a somewhat ridiculous 600x600 thumbnail size

== Installation ==

1. Upload the `plugin` folder to the `/wp-content/plugins/` directory or install via the Add New Plugin menu
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Optional: Enter a media library thumbnail size under Settings: Media
1. Optional: Define a custom size called 'mte_thumbnail' in functions.php

== Frequently Asked Questions ==

= Is there an options screen where I can set a custom thumbnail size? =

Yes! Just go to _Settings: Media_ and look for "Media Library Thumbnails".

Note that this will not appear if the size has been hardcoded (see next FAQ).

= Is there a way to hardcode the custom thumbnail size? =

To set a custom size, add the line below to functions.php (or a plugin) and adjust the dimensions as needed.

`add_image_size( 'mte_thumbnail', 300, 300, true );`

= I chose a custom thumbnail size. Why aren't the thumbnails appearing at that size? =

You may need to rebuild your thumbnails:
https://wordpress.org/plugins/ajax-thumbnail-rebuild/

Or install WP_Thumb so they can be generated on the fly:
http://wordpress.org/plugins/wp-thumb/

== Changelog ==

= 1.3 =
* Add option to enalarge thumbnails in media library modal (pop-up)

= 1.2.4 =
* Fix issue with misaligned icons in the insert media modal

= 1.2.3 =
* Revise name to better reflect additional features
* Add banner

= 1.2.2 =
* Readme fixes

= 1.2.1 =
Fix intitial run bug where mte_thumbnail_ud was being incorrectly defined

= 1.2 =
* Add size options to Settings: Media
* FAQ revisions

= 1.1.1 =
* Fix archive icon color
* Tweak icon license text

= 1.1 =
* FAQ updates
* Replace WordPress bundled Crystal icons with SVG icons

= 1.0.3 =
* Fix column sizing bug

= 1.0.2 =
* Fix 1.0.1 partial deploy

= 1.0.1 =
* Add screenshots

= 1.0 =
* Initial release