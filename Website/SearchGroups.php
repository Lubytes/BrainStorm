<?php
//start the session. if the user is logged in, display creation form.
session_name('project');  
//session_start();
require_once('header.php');


$username = '';
$description = '';
$groupname = '';
$results = '';
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

} else {
	$l = '1'; //user isn't logged in
	$loginErr = "You must be logged in to manage a group.";
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {

	echo '<style>
			#groups {
				visibility: visible;
				display: block;
			}
		</style>';
		
		$keywords = $_POST['keywords'];
		$key = explode(" ", $keywords);
		//print_r($key);
		
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
		
			//search by keyword
			$stmt = $dbh->prepare("SELECT * FROM groups WHERE groupname LIKE :keyword");
			$kw = '%'.$keywords.'%';
			$stmt->bindParam(':keyword', $kw, PDO::PARAM_STR);
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					$results .= '<p><a href="Group.php?gID='.$row['groupID'].'">'.$row['groupname'].'</a></p>';
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
	<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if ($l=="1") {echo $loginErr."<br><br>"; $val = false; }}?></span>

	
      <div id="selection">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title">Search Group</h2>
          </div>
          <div class="panel-body">  

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >

            <div class="form-group">        
              <div >
                <input type="text" value="<?php if (!empty($_POST['keywords'])) echo htmlspecialchars($_POST['keywords']); ?>" name="keywords" id="keywords" class="form-control" placeholder="Search" autofocus autocomplete="off">
              </div>
            </div>

            <div class="form-group">  
              <div >
                <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit_search" value="Search" class="btn btn-default">
              </div>
            </div>
            
            </form>


          </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->
      </div> <!-- /#selection -->
	
	
	<div id="groups">
        <div class="panel panel-default" style="clear: both;">
          <div class="panel-heading">
            <h2 class="panel-title">Results</h2>
          </div>
          <div class="panel-body">  
			
            <?php echo $results; ?>

          </div> <!-- /.panel-body -->
        </div> <!-- /.panel -->
      </div> <!-- /#groups -->



<?php

require_once('footer.php');
?>
