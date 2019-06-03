<?php
class CreatePages{
    function insertPages($POST){
        $pages = json_decode(stripslashes($POST['JSON']));

    //Foreach loop for reading each line to generate new pages
    foreach ($pages as $page => $keys) {
        $content = $POST['content'];
        $meta = $POST['meta-description'];
        $seoTitle = $POST['seo-title'];
        $title = $POST['page-title'];
        $postStatus = $POST['postStatus'];
        $parentPage = $POST['page_id'];
		$keywords ="";
        foreach ($keys as $key => $value) {
            $content = preg_replace("/\b$key\b/u", $value, $content);
            $meta = preg_replace("/\b$key\b/u", $value, $meta);
            $seoTitle = preg_replace("/\b$key\b/u", $value, $seoTitle);
			$title = preg_replace("/\b$key\b/u", $value, $title);

        }
        foreach($keys as $key => $value){
            $content = preg_replace("/\b\_\w+_\b/u", "", $content);
            $meta = preg_replace("/\b\_\w+_\b/u", "", $meta);
            $seoTitle = preg_replace("/\b\_\w+_\b/u", "", $seoTitle);
			$title = preg_replace("/\b\_\w+_\b/u", "", $title);
        }
     
        //preparing the pages information for inserting to the db
        $preparedPage = [
            'post_type' => "page",
            'post_title' => $title,
            'post_name' => $title,
            'post_content' => $content,
            'post_parent' => $parentPage,
            'post_status' => $postStatus,
        ];

        //Inserting the page and storing the page id to the $postId that we will use to insert SEO information
        $postId = wp_insert_post($preparedPage, $wp_error = true);

        //THREE FUNCTIONS DOWN BELLOW WILL TAKE CARE OF THE SEO TITLE, SEO KEYWORDS, SEO DESCRIPTION
        //SEO TITLE FUNCTION
        update_post_meta($postId, '_yoast_wpseo_title', $seoTitle);

        //SEO KEYWORD FUNCTION
        // update_post_meta($postId, '_yoast_wpseo_focuskw', );

        //SEO META DESCRIPTION FUNCTION
        update_post_meta($postId, '_yoast_wpseo_metadesc', $meta);

    } //end of the loop foreach
    }
}
?>
