<?php

if ( is_singular() ) { // init only on single pages.
wp_enqueue_script('ajaxcomments', get_stylesheet_directory_uri().'/assets/js/ajaxcomments.js', array('jquery') ); //url to js file
wp_localize_script('ajaxcomments', 'admin_urls', array( 'admin_ajax' => admin_url( 'admin-ajax.php'), 'postCommentNonce' => wp_create_nonce( 'myajax-post-comment-nonce' ) )); // Call it after enqueue
}

/* Ajax Loading Comments
=================================== */
add_action('wp_ajax_nopriv_load_comments', 'retrieve_comments');
add_action('wp_ajax_load_comments', 'retrieve_comments');

function retrieve_comments() {

// Check nounce - security thingy
$nonce = $_POST['postCommentNonce'];
if ( ! wp_verify_nonce( $nonce, 'myajax-post-comment-nonce' ) ) {
die ( 'Busted!');
}

$postID = $_REQUEST['post_id']; // get id of comments page
$offset = $_REQUEST['start_from']; // offset on how many comments we have already shown
$args = array(
'post_id' => $postID,
'offset' => $offset,
'status' => 'approve',
'order' => 'ASC',
'number' => 3,
);
$comments = get_comments($args);
wp_list_comments(array('callback' => 'iva_comment','per_page' => '3'), $comments);
exit;
}
