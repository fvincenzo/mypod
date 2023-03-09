<?php 
header('Content-Type: application/xml; charset=utf-8');

/**
 * iTunes-Compatible RSS 2.0 MP3 subscription feed script
 * Original work by Rob W of http://www.podcast411.com/
 * Updated by Aaron Snoswell (aaronsnoswell@gmail.com)
 * Updated by Vincenzo Frascino (vincenzo.frascino@yahoo.co.uk)
 *
 * Recurses a given directory, reading MP3 ID3 tags and generating an itunes
 * compatible RSS podcast feed.
 *
 * Save this .php file wherever you like on your server. The URL for this .php
 * file /is/ the URL of your podcast feed for subscription purposes.
 */

include_once('config.php');

// If getid3 was requested, attempt to initialise the ID3 engine
$getid3_engine = NULL;
if(strlen($getid3_dir) != 0) {
    require_once($getid3_dir . 'getid3.php');
    $getid3_engine = new getID3;
}

// Write XML heading
echo '<?xml version="1.0" encoding="utf-8" ?>';

?>
<rss version="2.0" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title><?php echo $feed_title; ?></title>
        <link><?php echo $feed_link; ?></link>

        <itunes:author><?php echo $feed_author; ?></itunes:author>
        <itunes:type>serial</itunes:type>
        <itunes:owner>
            <itunes:name><?php echo $feed_author; ?></itunes:name>
            <itunes:email><?php echo $feed_email; ?></itunes:email>
        </itunes:owner>

        <itunes:image href="<?php echo $feed_image; ?>" />
        <itunes:explicit><?php echo $feed_explicit; ?></itunes:explicit>
        <itunes:category text="<?php echo $feed_category; ?>">
            <itunes:category text="<?php echo $feed_subcategory; ?>" />
        </itunes:category>

        <itunes:summary><?php echo $feed_description; ?></itunes:summary>

        <category><?php echo $feed_category; ?></category>
        <description><?php echo $feed_description; ?></description>
        
        <language><?php echo $feed_lang; ?></language>
        <copyright><?php echo $feed_copyright; ?></copyright>
        <ttl><?php echo $feed_ttl; ?></ttl>

        <?php
        $directory = opendir($files_dir) or die($php_errormsg);

        // Step through file directory
        while(false !== ($file = readdir($directory))) {
            $file_path = $files_dir . $file;

            // not . or .., ends in .mp3
            if(is_file($file_path) && strrchr($file_path, '.') == ".mp3") {
                // Initialise file details to sensible defaults
                $file_title = $file;
                $file_url = $files_url . "podcasts/" . $file;
                $file_author = $feed_author;
                $file_duration = "";
                $file_description = "";
                $file_date = date(DateTime::RFC2822, filemtime($file_path));
                $file_size = filesize($file_path);

                // Read file metadata from the ID3 tags
                if(!is_null($getid3_engine)) {
                    $id3_info = $getid3_engine->analyze($file_path);
                    getid3_lib::CopyTagsToComments($id3_info);
                    
                    $file_title = $id3_info["comments_html"]["title"][0];
                    $file_author = $id3_info["comments_html"]["artist"][0];
                    $file_duration = $id3_info["playtime_string"];
                    $file_description = $id3_info["comments_html"]["title"][0];
                
                    sscanf($file_duration, "%d:%d:%d", $fd_hours, $fd_minutes, $fd_seconds);
                    $file_duration_s = isset($fd_seconds) ? $fd_hours * 3600 + $fd_minutes * 60 + $fd_seconds : $fd_hours * 60 + $fd_minutes;
                }
        ?>

        <item>
            <itunes:episodeType>full</itunes:episodeType>
            <title><?php echo $file_title; ?></title>
            <link><?php echo $file_url; ?></link>
            
            <itunes:author><?php echo $file_author; ?></itunes:author>
            <itunes:category text="<?php echo $feed_category; ?>">
                <itunes:category text="<?php echo $feed_subcategory; ?>" />
            </itunes:category>

            <category><?php echo $feed_category; ?></category>
            <duration><?php echo $file_duration; ?></duration>
            
            <description><?php echo $file_description; ?></description>
            <pubDate><?php echo $file_date; ?></pubDate>

            <enclosure url="<?php echo $file_url; ?>" length="<?php echo $file_size; ?>" type="audio/mpeg" />
            <guid><?php echo $file_url; ?></guid>
            <author><?php echo $feed_email; ?></author>
            <itunes:duration><?php echo $file_duration_s; ?></itunes:duration>
            <itunes:explicit><?php echo $feed_explicit; ?></itunes:explicit>
        </item>
        <?php
            }
        }
        ?>

    </channel>
</rss>
<?php
    closedir($directory);
?>