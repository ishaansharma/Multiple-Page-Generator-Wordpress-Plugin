<?php
    include( MY_PLUGIN_PATH . 'view/functions/CreatePages.php');
    include( MY_PLUGIN_PATH . 'view/functions/createLayout.php');
?>
<!-- excel file reader inputs -->
<input type="file" id="excelfile" onchange="Export()" />
<!-- button that gets all the data from excel file -->
<input type="button" id="viewfile" value="Convert to the Pages" onclick="retrieveData()" class="button button-primary" />

<?php	
	createLayout();
?>
<script>
//script for count characters in textarea
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
