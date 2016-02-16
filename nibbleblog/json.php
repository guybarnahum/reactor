<?php
require('admin/boot/feed.bit');

// Get the last update (the date of the last published post)
$updated = Date::atom(time());
if(isset($posts[0]))
{
	$last_post = $posts[0];
	$updated = Date::atom($last_post['pub_date_unix']);
}

// Get the domain name
$domain = parse_url($settings['url']);
$domain = 'http://'.$domain['host'];

// =====================================================================
// Posts Array
// =====================================================================

$res = [    'name'      => $settings[ 'name'   ],
            'slogan'    => $settings[ 'slogan' ],
            'updated'   => $updated,
            'data'      => []
     ];
    
foreach($posts as $post)
{
	// Post, absolute permalink
	$permalink = htmlspecialchars(Post::permalink(true),ENT_QUOTES, 'UTF-8');

	// Post, publish date on atom format
	$date = htmlspecialchars(Date::atom($post['pub_date_unix']),ENT_QUOTES, 'UTF-8');

	// Post, category name
	$category = htmlspecialchars(Post::category(),ENT_QUOTES, 'UTF-8');

	// Post, full content
	// Absolute images src
    $content = Post::content(true);
	$content = preg_replace("/(src)\=\"([^(http|data:image)])(\/)?/", "$1=\"$domain$2", $content);
    $content = htmlspecialchars($content,ENT_QUOTES, 'UTF-8');
    
	// Post, title
    $title = htmlspecialchars(Post::title(),ENT_QUOTES, 'UTF-8');

	// Entry
    $res[ 'data' ][] = [ 'title'    => $title,
                         'content'  => $content,
                         'url'      => $permalink,
                         'updated'  => $date,
                         'category' => $category,
                        ];
}

echo json_encode( (object)$res);

?>