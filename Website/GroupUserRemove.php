<?php
//start the session. if the user is logged in, display creation form.
session_name('project');  
session_start();
require_once('header.php');


$username = '';
$list = $_POST['checkusers'];
$gID = $_POST['gID'];

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
	
	//just delete the rejected user from pending
		for($i=0; $i<count($list); $i++){
			$stmt = $dbh->prepare('DELETE FROM in_group WHERE groupID=:gi AND username=:un');
			$stmt->bindParam(':un', $list[$i]);
			$stmt->bindParam(':gi', $gID);
			$stmt->execute();
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
            
            

          </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->
      </div> <!-- /#groups -->



<?php

require_once('footer.php');
?>
