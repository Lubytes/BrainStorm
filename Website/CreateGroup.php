<?php
//start the session. if the user is logged in, display creation form.
session_name('project');  
session_start();
require_once('header.php');


$username = '';
$description = '';
$groupname = '';
$nameErr = $descErr = $loginErr = "";
$g = $d = $l = '0';
$val = true; //tests for validation
$successMessage = "<h3>Group created successfully!</h3>";

if ($_SESSION["loggedIn"] == true) {
	$l = '0';
	$username = $_SESSION["username"];
	echo '<style>
			#create {
				visibility: visible;
			}
			</style>';
} else {
	$l = '1'; //user isn't logged in
	$loginErr = "You must be logged in to create a group.";
	echo '<style>
			#create {
				visibility: hidden;
			}
			</style>';
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

		if (empty($_POST['groupname'])){
			$g = '1';
			$val = false;
			$nameErr = "You must include a group name.";
		} else {
			 //check for the groupname in the db
			 $groupname = test_input($_POST['groupname']);
			 $stmt = $dbh->prepare('SELECT * from groups WHERE groupname=:groupname AND creator=:username');
			 $stmt->bindParam(':groupname', $groupname, PDO::PARAM_STR);
			 $stmt->bindParam(':username', $username, PDO::PARAM_STR);
			 $stmt->execute();
			 if ($stmt->rowCount() > 0){
				$nameErr = "Groupname is not unique to you. You cannot creat multiple groups with the same name.";
				$g = "1";
				$val = false;
			 } else {
				$g = '0';
			 }
		}
	
		if (empty($_POST['description'])){
			$d = '1';
			$val = false;
			$descErr = "You must include a group description.";
		} else {
			$d = '0';
			$description = test_input($_POST['description']);
		}
	
		if ($val==true){
		//if everything is good, add group to db
		$stmt = $dbh->prepare("INSERT INTO groups (creator, groupname, description)
							VALUES (:username, :groupname, :description)");
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);
		$stmt->bindParam(':groupname', $groupname, PDO::PARAM_STR);
		$stmt->bindParam(':description', $description, PDO::PARAM_STR);
		$stmt->execute();

		//get the group ID
		$stmt = $dbh->prepare('SELECT * from groups WHERE groupname=:groupname AND creator=:username');
		 $stmt->bindParam(':groupname', $groupname, PDO::PARAM_STR);
		 $stmt->bindParam(':username', $username, PDO::PARAM_STR);
		 $stmt->execute();
		 if ($stmt->rowCount() > 0){
			$check = $stmt->fetch(PDO::FETCH_ASSOC);
			$groupID = $check['groupID'];
		 }
		 
		 //echo $groupID;

		//add the creator to the group
		$stmt2 = $dbh->prepare("INSERT INTO in_group (username, groupID)
							VALUES (:creator, :groupID)");
		$stmt2->bindParam(':creator', $username, PDO::PARAM_STR);
		$stmt2->bindParam(':groupID', $groupID, PDO::PARAM_INT);
		$stmt2->execute();
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
	<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($g == "1") {echo $nameErr."<br><br>"; $val = false; }}?></span>
	<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($d=="1") {echo $descErr."<br><br>"; $val = false; }}?></span>
	<span class="error"> <?php if ($l=="1") {echo $loginErr."<br><br>"; $val = false; }?></span>
	<span class="success"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($val=="1") {echo $successMessage."<br><br>"; }}?></span>
	
      <div id="create">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title">Create A New Group</h2>
          </div>
          <div class="panel-body">  

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

            <div class="form-group">        
              <div >
                <input type="text" value="<?php if (!empty($_POST['groupname'])) echo htmlspecialchars($_POST['groupname']); ?>" name="groupname" id="groupname" class="form-control" placeholder="Group Name" autofocus autocomplete="off">
              </div>
            </div>

            <div class="form-group">
				<label for="description">Description:</label>
				<textarea name="description" class="form-control" rows="5" id="description" value="<?php if (!empty($_POST['description'])) echo htmlspecialchars($_POST['description']); ?>"></textarea>
			</div>

            <div class="form-group">  
              <div >
                <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit_login" value="Submit" class="btn btn-default">
              </div>
            </div>
            
            </form>


          </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->
      </div> <!-- /#create -->




<?php

require_once('footer.php');
?>
