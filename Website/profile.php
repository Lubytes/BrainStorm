<?php
//start the session. if the user is logged in, display creation form.
session_name('project');  
session_start();

//session vars
$username = $_SESSION["username"];
$isAdmin = $_SESSION["isAdmin"];
$loggedIn = $_SESSION["loggedIn"];
$status = $_SESSION["status"];
$img = $_SESSION["img"];

//we want to get the uID from the URL
$uID = htmlspecialchars($_GET["uID"]);
$displayName = "";
$displayProfile = "";
$displayImg = "";
$displayGender = "";
$groupList = "";

$postsList = "";

$modal = "";

$isFollowing =0;

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
	
		//get user info
		$stmt = $dbh->prepare("SELECT * FROM users WHERE username=:uID");
		$stmt->bindParam(':uID', $uID, PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$displayName = $row["displayName"];
				$displayProfile = $row["description"];
				$displayImg = $row["picture"];
				$displayGender = $row["gender"];
				
				//fill empty images
				if (empty($displayImg)){
					//blank profile image here
					$displayImg = "img/profile/blank.png";
				}
				
			}
		}
	
	//get if following
	$stmt = $dbh->prepare("SELECT * FROM follows WHERE username=:uID AND follower=:username");
	$stmt->bindParam(':uID', $uID, PDO::PARAM_STR);
	$stmt->bindParam(':username', $username, PDO::PARAM_STR);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {$isFollowing =1;}
			
	//get the user's groups
	$stmt = $dbh->prepare("SELECT * FROM in_group JOIN groups ON groups.groupID=in_group.groupID WHERE in_group.username=:uID");
	$stmt->bindParam(':uID', $uID, PDO::PARAM_STR);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			//get all groups and their names
			$groupID = $row["groupID"];
			$groupname = $row["groupname"];
			$groupList .= '<a href="Group.php?gID='.$groupID.'" class="list-group-item">'.$groupname.'</a>';		
		}
	}
	
	//get the user's posts
	$stmt = $dbh->prepare("SELECT * FROM posts JOIN groups ON posts.groupID=groups.groupID WHERE username=:uID ORDER BY DATE_TIME DESC");
	$stmt->bindParam(':uID', $uID, PDO::PARAM_STR);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			//get all groups and their names
			$postsList .= create_post($row["post_ID"], $row["head"], $row["type"], $row["date_time"], $row["content"], 
			$row["title"], $row["image"], $row["rating"], $row["username"], $row["groupID"], $row["groupname"]);		
		}
	}
	
	//close the connection
	$dbh = null;
	
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	} 
	
	
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modal'])) {
	
	
	$modal = test_input($_POST["modal"]);
	
	//here's where to do the bio stuff
	if ( $modal=="bio" ) {
	
		$dname = test_input($_POST["dname"]);
		$bio = test_input($_POST["bio"]);
	
		try {
			$dbh = new PDO($dsn, $dbname, $dbpword);

		   //if bio form and display name change
		   if (empty($_POST["dname"])) {
			 //don't change
		   } else {
			 //change
				$stmt = $dbh->prepare("UPDATE users SET displayName=:dname WHERE username=:username");
				$stmt->bindParam(':username', $username, PDO::PARAM_STR);
				$stmt->bindParam(':dname', $dname, PDO::PARAM_STR);
				$stmt->execute();
	 
		   }
			//Display Name Validation
		   if (empty($_POST["bio"])) {
			 //don't change
		   } else {

			 //change
			 $stmt = $dbh->prepare("UPDATE users SET description=:bio WHERE username=:username");
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':bio', $bio, PDO::PARAM_STR);
			$stmt->execute();
		   } 
   
   
			//close the connection
			$dbh = null;

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		header("Location: profile.php?uID=".$username);
	}
	
	//here's where to do the img stuff
	if ( $modal=="image" ) {
		try {
			$valid_image = true;
			$dbh = new PDO($dsn, $dbname, $dbpword);

		   //put the form stuff here

			if ($_FILES['image']['type'] == 'image/png' ) {

			  $temp1 = explode(".", $_FILES["image"]["name"]);
			  $newname1 = $username. '-profile' . '.' . end($temp1);

			  move_uploaded_file($_FILES['image']['tmp_name'], './img/profile/'. $newname1);
			  chmod("./img/profile/".$newname1, 0777);


			} 
			else if ($_FILES['image']['type'] == 'image/gif') {

			  $temp1 = explode(".", $_FILES["image"]["name"]);
			  $newname1 = $username. '-profile' . '.' . end($temp1);

			  move_uploaded_file($_FILES['image']['tmp_name'], './img/profile/'. $newname1);
			  chmod("./img/profile/".$newname1, 0777);


			} 
			else if ( $_FILES['image']['type'] == 'image/jpeg' ) {

			  $temp1 = explode(".", $_FILES["image"]["name"]);
			  $newname1 = $username. '-profile' . '.' . end($temp1);

			  move_uploaded_file($_FILES['image']['tmp_name'], './img/profile/'. $newname1);
			  chmod("./img/profile/".$newname1, 0777);


			} 
			else if ( $_FILES['image']['type'] == 'image/jpg') {

			  $temp1 = explode(".", $_FILES["image"]["name"]);
			  $newname1 = $username. '-profile' . '.' . end($temp1);

			  move_uploaded_file($_FILES['image']['tmp_name'], './img/profile/'. $newname1);
			  chmod("./img/profile/".$newname1, 0777);

			} 
			else {
			  echo "<p>Only PNG, GIF, JPEG, JPG files are accepted.</p>";
			  $valid_image = false;
			}

		   if ($valid_image) {
			
			 //update database
			 $image = "./img/profile/".$newname1;
			 $stmt = $dbh->prepare("UPDATE users SET picture=:image WHERE username=:username");
			 $stmt->bindParam(':username', $username, PDO::PARAM_STR);
			 $stmt->bindParam(':image', $image, PDO::PARAM_STR);
			 
			 
			 $stmt->execute();
			
		   } 
   
   
			//close the connection
			$dbh = null;

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
		header("Location: profile.php?uID=".$username);
	}
}
	
function create_post($post_ID, $head, $type, $date, $content, $title, $image, $rating, $username, $groupID, $groupName){
	if ($post_ID > 1) {
		//get the correct post page
		$link = 0;
		$groupN = "";
		if ($head==1){
			$link = $post_ID;
		} else {
			$link = $head;
		}
		//set everyone group to everyone
		if ($groupID==1){
			$groupN = "Public";
		} else {
			$groupN = $groupName;
		}
		//make the string
		return '<div class="panel panel-info panel-post">
				<div class="panel-heading">
				  <h3 class="panel-title"><a href="Posts.php?head='.$link.'">'.$title.'</a></h3>
				</div>
				<div class="panel-body">
				  <p class ="post_date">'.$date.'</p>
				  <p class="post_content">'.$content.'</p>
				  <p class="post_rating">Rating: '.$rating.'</p>
				  <p class="post_group">Group: <a href="Group.php?gID='.$groupID.'">'.$groupN.'</a>
				</div>
				</div>';
	} else {
		return null;
	}
}
		
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}



?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<!--For making posts-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<!--Other-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>BrainStorm</title>

    
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    
    <style>
	
	.error {color: #3366ff;}
	
      .container {
        /*max-width: 940px;*/
        width:100%;
      }
      textarea {
        resize: vertical;
      }
      body {
        width: 1px;
        min-width: 100%;
        *width: 100%;
        font-family:"Open Sans","Helvetica Neue", Helvetica, Arial, sans-serif;
        font-size:14px;
        letter-spacing:0px;
        line-height: 1.6;
        color:#1e3948;
        box-sizing:border-box;
        font-weight: 300;
        padding-left:15px;
        padding-right:15px;

      }
      
      .modal-backdrop {
		  z-index: -1;
		}
	.modal-header, h4, .close {
      background-color: #5cb85c;
      color:white !important;
      text-align: center;
      font-size: 30px;
	}
	.modal-footer {
      background-color: #f9f9f9;
	}
    </style>
  </head>

  <body>
  
  <script>
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });
});
</script>
  
  
  
  

    <?php include('headerLoggedIn.php'); ?>

<div class="container">







<div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <div class="jumbotron">
            <div style="display:inline-block;margin:10px;"></div>
				<!--This will be the follow/unfollow button -->
				<form role="form" method="post">
				<?php if ($username != $uID && $isFollowing == 0) { 
                  	echo '<input type="hidden" name="followClick" value='."$uID".'>';
					echo '<input type="hidden" name="follow" value="follow">';
					echo '<button type="submit" class="btn btn-info btn-warning">Follow</button>'.'<hr>';
                  } 
				  else if ($username != $uID && $isFollowing == 1) { 
					echo '<input type="hidden" name="followClick" value='."$uID".'>';
					echo '<input type="hidden" name="follow" value="unfollow">';
					echo '<button type="submit" class="btn btn-info btn-danger">Unfollow</button>'.'<hr>';
				  }
                  ?>
				</form>
				<!--
				
				<form role="form" method="post">
				
				-->
				<a href="profile.php"><img src=""></a>
				<div>			
                <h3>
                  <?php echo '<img src="'.$displayImg.'" class="profile_img" style="width:256px;height:256px;"/>'; ?> <?php echo $displayName; ?>
                </h3>
            	</div>
            	<div>
                	<p>
                  <?php echo "Gender: " . $displayGender; ?>
                  </p>
                  <p>
                  <?php echo $displayProfile; ?>
                  <?php if ($username == $uID) { 
                  	echo "</p>".
                  		' <!-- Trigger the modal with a button -->
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#imgModal" name="submit_files">Upload new image</button>
						<br /><br />'.
                  		'<button type="button" class="btn btn-info" data-toggle="modal" data-target="#bioModal">Update bio</button>';  
                  } 
                  
                  ?>
                  </p>
                 </div> 
                 

                  
          </div>
		  <?php if ($username == $uID) { 
		  echo '<button type="button" class="btn btn-default btn-lg" id="myBtn">Create Post</button>';
		  }
		  ?>
          <div class="row">
            <h2>Posts</h2>
			
              <?php echo $postsList; ?>
          </div><!--/row-->
        </div><!--/.col-xs-12.col-sm-9-->

      <!-- groups -->
      <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
      	<h4>Member of:</h4>
          <div class="list-group">
            <?php echo $groupList; ?>
          </div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->


	  <!--For Making A Post-->
	  
	  
	  <?php
// define variables and set to empty values



$titleErr = $typeErr = $contentErr =  "";
$title = $type = $content = "";
$val = "1";
$grouplist = '<option value="1" select>Everyone</option>'.
			'<option value="2">Private</option>';


			
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
	
	//get the user's groups
	$stmt = $dbh->prepare("SELECT * FROM in_group JOIN groups ON groups.groupID=in_group.groupID WHERE in_group.username=:uID");
	$stmt->bindParam(':uID', $uID);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			//get all groups and their names
			$groupID = $row["groupID"];
			$groupname = $row["groupname"];
			$grouplist .= '<option value="'.$groupID.'">'.$groupname.'</option>';
					
		}
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modal"]) && test_input($_POST["modal"]) == "make_post") {
		$head = test_input($_POST["replyTo"]);
	   if (empty($_POST["title"])) {
		 $titleErr = "Title is required";
		 $val = "0";
	   } else {
		 $title = test_input($_POST["title"]);
	   }
	 

	   if (empty($_POST["type"])) {
		 $typeErr = "Type is required";
		 $val = "0";
	   } else {
		 $type = test_input($_POST["type"]);
	   }
   
	   if (empty($_POST["content"])) {
		 $contentErr = "Content must not be empty";
		 $val = "0";
	   }  
	   else{
		   $content = test_input($_POST["content"]);
	   }
	   
	   //get the group ID
	   $groupID = $_POST["group"];
	 
	   if ($val=="1"){
			//if everything is good, add group to db
			$stmt = $dbh->prepare("INSERT INTO posts (head, type, content, rating, username, groupID, title)
								VALUES (1, :type, :content, 0, :username, :groupID, :title)");
			$stmt->bindParam(':username', $uID, PDO::PARAM_STR);
			$stmt->bindParam(':groupID', $groupID, PDO::PARAM_INT);
			$stmt->bindParam(':content', $content, PDO::PARAM_STR);
			$stmt->bindParam(':title', $title, PDO::PARAM_STR);
			$stmt->bindParam(':type', $type, PDO::PARAM_STR);
			$stmt->execute();
		}
		else{
			//reopen the post page
			echo '<script> $(document).ready(function(){
				$("#myModal").modal();
				}); </script>';
		}

   
	}
	//follow button was clicked
	if ($_SERVER["REQUEST_METHOD"] == "POST" && test_input($_POST["follow"]) == "follow"){
		
		$stmt = $dbh->prepare("INSERT INTO follows (username, follower)
								VALUES (:username, :uID)");
		$stmt->bindParam(':username', $uID, PDO::PARAM_STR);
		$stmt->bindParam(':uID', $username, PDO::PARAM_STR);
		$stmt->execute();
		echo "<script>location.href = 'profile.php?uID=".$uID."'</script>";
		//header("Location: ".$_SERVER['PHP_SELF']);		
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST" && test_input($_POST["follow"]) == "unfollow"){
		$stmt = $dbh->prepare("DELETE FROM follows WHERE username=:uID AND follower=:username");
		$stmt->bindParam(':username', $username, PDO::PARAM_STR);
		$stmt->bindParam(':uID', $uID, PDO::PARAM_STR);
		$stmt->execute();
		echo "<script>location.href = 'profile.php?uID=".$uID."'</script>";
		//header("Location: ".$_SERVER['PHP_SELF']);
	}

	//close the connection
	$dbh = null;

} catch (PDOException $e) {
	print "Error!: " . $e->getMessage() . "<br/>";
	die();
} 

?>
	  
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-random"></span>&nbsp Create Post</h4>
        </div>
		
        <div class="modal-body" style="padding:40px 50px;">
          <!-- <form role="form"> -->
		  <form role="form" method="post">
		  
		  <input type="hidden" name="modal" value="make_post">
			<div style="" class="form-group">
				<label for="title"><span class="glyphicon glyphicon-tags"></span> Title <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if (empty($_POST["title"])) {echo "<span class='error'>".$titleErr."</span>"; $val = "0"; }}?></label>
				<br>
			    <input class="form-control" type="text" name="title" id="title" placeholder="The title of your post" value="<?php if(isset($title)) echo "$title";?>">
		    </div>
			   
			<div style="" class="form-group">
				<label for="content"><span class="glyphicon glyphicon-pencil"></span> Content <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if (empty($_POST["content"])) {echo "<span class='error'>".$contentErr."</span>"; $val = "0"; }}?></label>
				<br>
				<textarea class="form-control" name="content" id="content" rows="3" cols="40" placeholder="Post Content"><?php if(isset($content)) echo "$content";?></textarea>
			</div>
			   
			   
			   <div id="type" style="">
			   <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if (empty($_POST["type"])) {echo "<span class='error'> <strong>".$typeErr."</strong> </span>"."<br>"; $val = "0";}} ?>
			   <input type="radio" name="type" 
			   <?php if(isset($type) && $type=="opinion") echo "checked";?>
			   value="opinion">Opinion
			   <input type="radio" name="type" 
			   <?php if(isset($type) && $type=="suggestion") echo "checked";?>
			   value="suggestion">Suggestion
			   <input type="radio" name="type" 
			   <?php if(isset($type) && $type=="random") echo "checked";?>
			   value="random">Random
			   <input type="radio" name="type" 
			   <?php if(isset($type) && $type=="business") echo "checked";?>
			   value="business">Business
			   <input type="radio" name="type" 
			   <?php if(isset($type) && $type=="creativity") echo "checked";?>
			   value="creativity">Creativity
			   </div>
			   
			   <br>
			<div class="form-group">
				<label for="group"><span class="glyphicon glyphicon-globe"></span> Group</label>
				<select id="group" class="form-control" name="group">
				<?php echo $grouplist; ?>
				</select>
			</div>
				<br>
				<br>
				<hr>
		<!--Old Stuff
            <div class="form-group">
              <label for="usrname"><span class="glyphicon glyphicon-user"></span> Username</label>
              <input type="text" class="form-control" id="usrname" placeholder="Enter email">
            </div>
            <div class="form-group">
              <label for="psw"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
              <input type="text" class="form-control" id="psw" placeholder="Enter password">
            </div>
            <div class="checkbox">
              <label><input type="checkbox" value="" checked>Remember me</label>
            </div>
		End old stuff-->
			
			
              <button type="submit" class="btn btn-success btn-block"><span class="glyphicon glyphicon-send"></span> Post</button>
          
		  
		  
		  
		  
		  </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
      </div>
    </div>
  </div>
<!-- END Model -->


	  
	  
	  
	  
	  
</div> <!--container end-->




      <div class="mastfoot">
          <div class="inner" style="text-align: center">
          © 2016 BrainStorm Inc.

          <a href="#">About</a>
          <a href="#">Help</a>
          <a href="#">Terms</a>
          <a href="#">Privacy</a>
          <a href="#">Cookies</a>
          <a href="#">Apps</a>
        </div>
      </div>
    

    <script src="jquery/jquery-1.11.2.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="ckeditor/ckeditor.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/chart.js"></script>
    <script src="assets/js/toolkit.js"></script>
    <script src="assets/js/application.js"></script>
    <script>
      // execute/clear BS loaders for docs
      $(function(){
        if (window.BS&&window.BS.loader&&window.BS.loader.length) {
          while(BS.loader.length){(BS.loader.pop())()}
        }
      })
    </script>
    
    
    <?php include "Modal_image.php"; ?>

	<?php include "Modal_bio.php"; ?>

	  
    
  </body>
</html>