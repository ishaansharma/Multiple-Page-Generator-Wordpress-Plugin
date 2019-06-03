<?php
//TODO 
//Move all the functions to the different file.
//---------------------------------------------------------------------------------
if ($_POST['title']) {
    //Converting to the array by new line and storing it to the title
    $titles = explode("\n", $_POST["title"]);
    //Foreach loop for reading each line to generate new pages
    foreach ($titles as $title) {
        if ($title != '') {//checking if new line is not empty!
            //replacing all the variables with keywords for the content
            $content = preg_replace('/\bvar\b/u', $title, $_POST['content']);
            //replacing all the variables with keywords for the meta description
            $meta = preg_replace('/\bvar\b/u', $title, $_POST['desc']);
            //preparing the pages information for inserting to the db
            $preparedPage = [
                'post_type' => "page",
                'post_title' => $title,
                'post_name' => $title,
                'post_content' => $content,
                'meta_input' => array(
                    'description' => $meta,
                ),
            ];

            //Inserting the page and storing the page id to the $postId that we will use to insert SEO information
            $postId = wp_insert_post($preparedPage, $wp_error = true);

            //THREE FUNCTIONS DOWN BELLOW WILL TAKE CARE OF THE SEO TITLE, SEO KEYWORDS, SEO DESCRIPTION
            //SEO TITLE FUNCTION
            update_post_meta($postId, '_yoast_wpseo_title', $title);

            //SEO KEYWORD FUNCTION
            update_post_meta($postId, '_yoast_wpseo_focuskw', 'keyword1 keyword2');

            //SEO META DESCRIPTION FUNCTION
            update_post_meta($postId, '_yoast_wpseo_metadesc', $meta);

        }//end of the if statement for checking new line

    }//end of the loop foreach

}//end of the if statement if posted something

?>

<!-- Basic html form -->
<form action="" method="POST">
	<p>Keywords please (it will generate pages and title whatever keyword is used in new line)</p>
    <textarea name="title" id="" cols="30" rows="10"style="resize:none;" class="lined"></textarea>
	<p>Meta Description (add keyword by typing var)</p>
	<textarea name="desc" id="" cols="30" rows="10"style="resize:none; display:block;"></textarea>
	<p>Content for the pages (add keyword by typing var)</p>

	
	<?php 
	wp_editor('','content');
	?>
	
	<button type="submit">
		Create new Page
	</button>
</form>
<script>
	var parent = document.getElementById('wp-content-editor-container');
	var firstChild = parent.firstChild;
	var div = document.createElement('div');
	div.setAttribute('class', 'quicktags-toolbar');
// 	var select = document.createElement('select');
// 	select.setAttribute('id', 'test');
// 	select.innerHTML = "<option value='city'>City</option><option value='phone'>Zip</option>";
// 	div.appendChild(select);
	
	var button = document.createElement('button');
	button.innerHTML = 'city';
	button.setAttribute('class','ed_button button button-small');
	button.setAttribute('type','button');
	button.setAttribute('value','_city_');
	button.setAttribute('onClick','addToTheTextarea(this)');
	div.appendChild(button);
	parent.insertBefore(div, firstChild);
	console.log(parent);
</script>


<script>
	function addToTheTextarea(element){
		var textarea = document.getElementById('content');
		textarea.value +=element.value;

	}
</script>
<?php


	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<p>Pages Created</p>";
}
?>
