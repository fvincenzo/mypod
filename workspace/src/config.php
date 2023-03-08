<?php
    /*
    * CONFIGURATION VARIABLES:
    * For more info on these settings, see the instructions at
    *
    * http://www.apple.com/itunes/podcasts/specs.html
    *
    * and the RSS 2.0 spec at
    *
    * http://www.rssboard.org/rss-specification
    */


    // ============================================ General Configuration Options

    // Location of MP3's on server. TRAILING SLASH REQ'D.
    $files_dir = getcwd().'/podcasts/';

    // Location of getid3 folder, leave blank to disable. TRAILING SLASH REQ'D.
    $getid3_dir = "vendor/james-heinrich/getid3/getid3/";

    // ====================================================== Generic feed options

    // Your feed's title
    $feed_title = "My Podcasts";

    // 'More info' link for your feed
    $feed_link = getenv("MYPOD_DOMAIN");

    // Files URL
    $files_url = $feed_link.'/';

    // Brief description
    $feed_description = "My Private Podcast";

    // Copyright / license information
    $feed_copyright = "Various Authors " . date("Y");

    // How often feed readers check for new material (in seconds) -- mostly ignored by readers
    $feed_ttl = 60 * 60 * 24;

    // Language locale of your feed, eg en-us, de, fr etc. See http://www.rssboard.org/rss-language-codes
    $feed_lang = "en-gb";


    // ============================================== iTunes-specific feed options

    // You, or your organisation's name
    $feed_author = "My Private Podcast";

    // Feed author's contact email address
    $feed_email="";

    // Url of a 170x170 .png image to be used on the iTunes page
    $feed_image = $feed_link . "/img/itunes_logo.png";

    // If your feed contains explicit material or not (yes, no, clean)
    $feed_explicit = "clean";

    // iTunes major category of your feed
    $feed_category = "General";

    // iTunes minor category of your feed
    $feed_subcategory = "";
?>