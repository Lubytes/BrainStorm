<?php
//start the session. if the user is logged in, display creation form.
session_name('project');  
session_start();
require_once('header.php');

$gID = $_GET["gID"];
$username = '';
$description = '';
$groupname = '';
$grouplist = '';
$joinbutton = '';
$groupmembers = array();
$nameErr = $descErr = $groupErr = $loginErr = "";
$g = $d = $l = '0';
$val = true; //tests for validation




if ($_SESSION["loggedIn"] == true) {
	$l = '0';
	$username = $_SESSION["username"];

} else {
	$l = '1'; //user isn't logged in
	$loginErr = "You must be logged in to manage a group.";

}

//connecting to the database
	if (file_exists('cred/cred.php')){
		include('cred/cred.php');
	}
	//set credentials if they are not set already
	if (!isset($dsn)) {
		$dsn = 'mysql:host=localhost;dbname=brainstorm;port=8889';
	}
	if (!isset($dbname)) {
		$dbname = 'root';
	}
	if (!isset($dbpword)) {
		$dbpword = 'root';
	}

	try {
		$dbh = new PDO($dsn, $dbname, $dbpword);
		
		//get the group names that this user belongs to
		$stmt = $dbh->prepare('SELECT * FROM groups WHERE groupID=:gID');
		$stmt->bindParam(':gID', $gID);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$get=$stmt->fetch(PDO::FETCH_ASSOC);
			$groupname = $get['groupname'];
			$groupdesc = $get['description'];
		} else {
			$g = '1';
			$groupErr = 'This group doesn\'t exist.';
		}
		
		$stmt = $dbh->prepare('SELECT * FROM in_group WHERE groupID=:gID AND username=:username');
		$stmt->bindParam(':gID', $gID);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		if ($stmt->rowCount() < 1){
			$joinbutton = '<input type="submit" name="submit_join" value="Request Membership" class="btn btn-default">';
		}
		
		//close the connection
		$dbh = null;

	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	} 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	try {
		$dbh = new PDO($dsn, $dbname, $dbpword);
		//if user exists, add to group request
		if ($l=='0'){
			$stmt = $dbh->prepare('INSERT INTO pending_group(groupID, username) VALUES(:g, :u)');
			$stmt->bindParam(':u', $username);
			$stmt->bindParam(':g', $gID);
			$stmt->execute();
		}
		//close the connection
		$dbh = null;

	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	} 

}
	
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>
	<style>
	.error {color: #3366ff;}
	</style>
	<h1 class="text-center">Have a new idea? Want to improve other ideas?</h1>
	
	<!-- Validation Boolean and Display-->
	<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($l=="1") {echo $loginErr."<br><br>"; $val = false; }}?></span>
	<span class="error"> <?php if ($g=="1") {echo $groupErr."<br><br>"; $val = false; }?></span>

	
      
	
	
	<div id="groups">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title"><?php echo $groupname; ?></h2>
          </div>
          <div class="panel-body">  
          	<?php echo $groupdesc; ?>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?gID=$gID";?>" method="post" >
            	<div class="form-group">  
				  <div >
					<?php echo $joinbutton ?>
				  </div>
				</div>
            </div>
        	</form>

          </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->
      </div> <!-- /#groups -->



<?php

require_once('footer.php');
?>
