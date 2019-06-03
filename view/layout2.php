<?php
	include( MY_PLUGIN_PATH . 'view/functions/CreatePages.php');
	include( MY_PLUGIN_PATH . 'view/functions/createLayout.php');
?>
<div class="page">
	<h2>Add Keywords</h2>
	<p>Enter Keywords down bellow. After entered key and value hit enter to add another keyword for this page</p>
	
        <div class="page-keywords">
            <div class="keyword">
                <input type="text" placeholder="Key" name="key">
				<label> = <input onkeypress="createKeywords(event,this)"class="keyword-value" placeholder="Value" name="value" /></label>
			</div>
		</div>

		<div class="keywords-page-buttons"><div class="add-media-button"><?php media_buttons('media-value');?><span id="mediaUploadStatus"> No Image</span>
					<input id="media-value" type="hidden" name="media-value">
		</div>

	<div class="Create-page-button">
		<button onclick="createPage(),retrieveData()">Create Page</button>
	</div>
</div>


    </div>
    
<?php
	createLayout();
?>

<script>
//adds image uploaded when image chosen.
document.getElementById('media-value').addEventListener('change', function(){
	document.getElementById('mediaUploadStatus').innerHTML = " Image Uploaded &#10004;";
});
//counter characters in textarea
document.getElementById('meta-description-textarea').onkeyup = function() {
    document.getElementById('count').innerHTML = "Characters: " + (this.value.length);
};
</script>

	<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $create_pages = new CreatePages();
    $create_pages->insertPages($_POST);
}
?>
