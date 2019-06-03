<?php

function createLayout(){
	echo'<div id="pagesList" class="pagesList"><h2>Created Pages List</h2><div></div></div>
	<form action="" method="POST">
		<div  class="myForm">
		<div class="extras">
			<div class="title">
				<h2>Page Title</h2>
				<div class="extras-keywords-div" id="page-title-keywords-container"><span>Keywords : </span></div>
				<textarea name="page-title" id="page-title-textarea" rows="1"></textarea>
			</div>
			<div class="seo-title">
			<h2>SEO Title</h2>
			<div class="extras-keywords-div" id="seo-title-keywords-container"><span>Keywords : </span></div>
				<textarea name="seo-title" id="seo-title-textarea" rows="1"></textarea>
			</div>
			<div class="seo-title">
			<h2>Meta Description</h2>
				<div class="extras-keywords-div" id="meta-description-keywords-container"><span>Keywords : </span></div>
				<textarea name="meta-description" id="meta-description-textarea" rows="3"></textarea>
				<span id="count"></span>
				<p>Every now and then, Google changes the length. Nowadays, you’ll mostly 
				see meta descriptions of up to 155 characters, with some outliers of 300 characters. At least, try to get crucial 
				information in the first 155 characters of your meta description.</p>
				
			</div>
		</div>
		<div class="content">
			<h2>Content</h2>';
			wp_editor('', 'content');
echo'</div>
        </div> 
<input type="hidden" name="JSON" value="" id="json"/>
<input type="submit" class="form-submit" value="Create" name="createPages" onClick="addJson() " />
</form>';

}

?>