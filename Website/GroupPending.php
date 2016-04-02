<?php
//start the session. if the user is logged in, display creation form.
session_name('project');  
session_start();
require_once('header.php');


$username = '';
$list = $_POST['checkusers'];
$gID = $_POST['gID'];
$end = "";

if ($_SESSION["loggedIn"] == true) {
	$username = $_SESSION["username"];
} else {
	$l = '1'; //user isn't logged in
	echo '<p>How did you get here? You can\'t do anything while logged out.</p>';
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
	
	if (isset($_POST['submit_approve'])){
		//for each name selected, add to group and remove from pending
		for($i=0; $i<count($list); $i++){
			$stmt = $dbh->prepare('INSERT INTO in_group(groupID, username) VALUES(:g, :u)');
			$stmt->bindParam(':u', $list[$i], PDO::PARAM_STR);
			$stmt->bindParam(':g', $gID, PDO::PARAM_INT);
			$stmt->execute();
		
			$stmt = $dbh->prepare('DELETE FROM pending_group WHERE groupID=:gi AND username=:un');
			$stmt->bindParam(':un', $list[$i], PDO::PARAM_STR);
			$stmt->bindParam(':gi', $gID, PDO::PARAM_INT);
			$stmt->execute();
			$end .= "$list[$i] is added to the group. <a href='ManageGroups.php'>Manage more groups</a><br />";
		}
	} else {
		//just delete the rejected user from pending
		for($i=0; $i<count($list); $i++){
			$stmt = $dbh->prepare('DELETE FROM pending_group WHERE groupID=:gi AND username=:un');
			$stmt->bindParam(':un', $list[$i], PDO::PARAM_STR);
			$stmt->bindParam(':gi', $gID, PDO::PARAM_INT);
			$stmt->execute();
			$end .= "$list[$i] is rejected. <a href='ManageGroups.php'>Manage more groups</a><br />";
		}
	}
	

	//close the connection
	$dbh = null;

} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
} 



	
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

?>
	
	
	
	<div id="groups">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            
            <?php echo $end; ?>

          </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->
      </div> <!-- /#groups -->



<?php

require_once('footer.php');
?>
