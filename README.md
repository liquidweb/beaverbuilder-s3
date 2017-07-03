# Beaver Builder + Amazon S3

[Human Made has a fantastic plugin for automatically offloading WordPress uploads to Amazon S3](https://github.com/humanmade/S3-Uploads), but the process involves rewriting the results of `wp_upload_dir()`, which is used by plugins and themes to determine where the site's `uploads/` directory lives. [Beaver Builder](https://www.wpbeaverbuilder.com/), meanwhile, writes its cache to disk for improved performance; it's preferred cache directory? `uploads/bb-plugin/cache`. Starting to see a problem?

This plugin ensures that Beaver Builder is still able to write to the local filesystem, while attachment media is still uploaded to and served from Amazon S3.


## Installation

Clone or download this repository into your site's plugin directory (`wp-content/plugins` by default), then activate the plugin via the "Plugins" screen within the WordPress admin panel.

This plugin may also be installed as a "must-use" (MU) plugin — simply copy `beaverbuilder-s3.php` into `wp-content/mu-plugins` — no activation necessary!