<?php 

require __DIR__ . '/../../vendor/autoload.php';

use OpenSRS\OMA\SetRole;

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	require_once dirname(__FILE__) . "/../../opensrs/openSRS_loader.php";

	// Put the data to the Formatted array
	$callArray = array(
		"user" => $_POST["user"], 
		"role" => $_POST["role"],
		"object" => $_POST["object"]
	);

	if(!empty($_POST["token"])){
		$callArray["token"] = $_POST["token"];
	}
	// Open SRS Call -> Result
	$response = SetRole::call($callArray);

	// Print out the results
	echo (" In: ". json_encode($callArray) ."<br>");
	echo ("Out: ". $response);

} else {
	// Format
	if (isSet($_GET['format'])) {
		$tf = $_GET['format'];
	} else {
		$tf = "json";
	}
?>
<?php include("header.inc") ?>
<div class="container">
<h3>set_role</h3>
<form action="" method="post" class="form-horizontal" >
	<div class="control-group">
	    <label class="control-label">Session Token (Option)</label>
	    <div class="controls"><input type="text" name="token" value="" ></div>
	</div>
	<h4>Required</h4>
	<div class="control-group">
	    <label class="control-label">User </label>
	    <div class="controls"><input type="text" name="user" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Role </label>
	    <div class="controls"><input type="text" name="role" value=""></div>
	</div>
	<div class="control-group">
	    <label class="control-label">Object </label>
	    <div class="controls"><input type="text" name="object" value=""></div>
	</div>
	<input class="btn" value="Submit" type="submit">
</form>
</div>
	
</body>
</html>

<?php 
}
?>
