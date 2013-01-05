<?php
/*
Name: copy_box.php
Author: Tim Milligan
Description: Copies specific boxes and packages from one skin to another.
Version: 1.0
*/

// Thesis 2 skin you're trying to generate the seed for:
$original_skin = 'thesis_classic';
$new_skin = 'thesis_blank';

// Initialize arrays
$seed = array();
$items = array('boxes', 'packages');

// Connect to WP
define('WP_USE_THEMES', false);
define('WP_DEBUG', false);
require('wp-blog-header.php');

echo "<pre>";
foreach ($items as $item) {
	echo "<h1>".$item."</h1>\n\n";
	$seed[$item] = get_option(sprintf('%s_%s', $original_skin, $item), '');
	//update_option(sprintf('%s_%s', $new_skin, $item), $seed[$item]);
	print_r($seed[$item]);
}
echo "\n\n";
foreach ($seed['boxes'] as $box) {
	print_r($box);
}
echo "\n\n KEY = " . find_parent($seed['boxes'], 'TEST');
//echo "[$new_skin] seeded with [$original_skin] data.";

function find_parent($array, $needle, $parent = null) {
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $pass = $parent;
            if (is_string($key)) {
                $pass = $key;
            }
            $found = find_parent($value, $needle, $pass);
            if ($found !== false) {
                return $found;
            }
        } elseif ($key === '_name' && $value === $needle) {
            return $parent;
        }
    }

    return false;
}