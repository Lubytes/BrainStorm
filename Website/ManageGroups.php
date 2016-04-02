<?php
//start the session. if the user is logged in, display creation form.
session_name('project');  
//session_start();
require_once('header.php');


$username = '';
$description = '';
$groupname = '';
$grouplist = '';
$memberpend = '';
$memberlist = '';
$gID = '';
$groupmembers = array();
$nameErr = $descErr = $loginErr = "";
$g = $d = $l = '0';
$val = true; //tests for validation


echo '<style>
		#groups {
			visibility: hidden;
			display: none;
		}
	</style>';

if ($_SESSION["loggedIn"] == true) {
	$l = '0';
	$username = $_SESSION["username"];
	echo '<style>
			#selection {
				visibility: visible;
				display: block;
			}
			</style>';
} else {
	$l = '1'; //user isn't logged in
	$loginErr = "You must be logged in to manage a group.";
	echo '<style>
			#selection {
				visibility: hidden;
				display: none;
				max-height:0;
				line-height:0;
				height: 0;
				overflow: hidden;
			}
			</style>';
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
		$stmt = $dbh->prepare('SELECT * FROM groups WHERE creator=:username');
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$ID = $row['groupID'];
				$gName = $row['groupname'];
				$grouplist.='<option value="'.$ID.'">'.$gName.'</option>';
			}
			//$groupID = $check['groupID'];
		}
		//close the connection
		$dbh = null;

	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	} 


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	echo '<style>
			#groups {
				visibility: visible;
				display: block;
			}
		</style>';
		
		$gID = test_input($_POST["groupbox"]);
		
		try {
			$dbh = new PDO($dsn, $dbname, $dbpword);
		
			//get the right group
			$stmt = $dbh->prepare('SELECT * FROM groups WHERE groupID=:groupID');
			$stmt->bindParam(':groupID', $gID, PDO::PARAM_INT);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					$groupname = $row['groupname'];
					$creator = $row['creator'];
				}
				//$groupID = $check['groupID'];
			}
			//get the right members
			$stmt = $dbh->prepare('SELECT * FROM in_group WHERE groupID=:groupID');
			$stmt->bindParam(':groupID', $gID, PDO::PARAM_INT);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				$i = 0;
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					$groupmembers[$i] = $row['username'];
					if ($groupmembers[$i]==$creator){
						$memberlist .= '<p>Creator: <a href="profile.php?uID='.$groupmembers[$i].'">'.$groupmembers[$i].'</a></p>';
					} else {
						$memberlist .= '<div class="checkbox"><label><input type="checkbox" name="checkusers[]" value="'.$groupmembers[$i].'">
									<a href="profile.php?uID='.$groupmembers[$i].'">'.$groupmembers[$i].'</a></label></div>';
					}
					$i++;
				}
				//$groupID = $check['groupID'];
			}
			
			//get the pending members
			$stmt = $dbh->prepare('SELECT * FROM pending_group WHERE groupID=:groupID');
			$stmt->bindParam(':groupID', $gID, PDO::PARAM_INT);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				$i = 0;
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					$groupmembers[$i] = $row['username'];
					$memberpend .= '<div class="checkbox"><label><input type="checkbox" name="checkusers[]" value="'.$groupmembers[$i].'">
									<a href="profile.php?username='.$groupmembers[$i].'">'.$groupmembers[$i].'</a></label></div>';
					$i++;
				}
				//$groupID = $check['groupID'];
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

	
      <div id="selection">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title">Choose a group to manage</h2>
          </div>
          <div class="panel-body">  

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

            <div class="form-group">        
              <div >
                <select name = "groupbox" class="combobox">

					//dropdown contents
					<?php echo $grouplist; ?>
					
				  </select>
              </div>
            </div>

            <div class="form-group">  
              <div >
                <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit_login" value="Submit" class="btn btn-default">
              </div>
            </div>
            
            </form>


          </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->
      </div> <!-- /#selection -->
	
	
	<div id="groups">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title">Manage <?php echo $groupname; ?></h2>
          </div>
          <div class="panel-body">  
			<h4>Current Members</h4>
			<form action="GroupUserRemove.php" method="post" >
			<div class="form-group">
				<div class="form-group"> 
            		<?php echo $memberlist ?>
            		<input type="hidden" name="gID" value="<?php echo $gID; ?>" />
            	</div>
            	<div class="form-group">  
				  <div >
					<input type="submit" name="submit_login" value="Remove Selected Members" class="btn btn-default">
				  </div>
				</div>
            </div>
        	</form>
            <h4>Pending Members</h4>
            <form action="GroupPending.php" method="post" >
			<div class="form-group">
				<div class="form-group"> 
            		<?php echo $memberpend ?>
            		<input type="hidden" name="gID" value="<?php echo $gID; ?>" />
            	</div>
            	<div class="form-group">  
				  <div >
					<input type="submit" name="submit_approve" value="Approve Selected Members" class="btn btn-default"> <input type="submit" name="submit_reject" value="Reject Selected Members" class="btn btn-default">
				  </div>
				</form>
            </div>
            

          </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->
      </div> <!-- /#groups -->



<?php

require_once('footer.php');
?>
