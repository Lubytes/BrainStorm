 
 <!-- Displaying the correct post: This is going to be messy -->
 <?php 
 	//get the group ID
	$groupID = 1;
	$full_post = "";
	$delete_button = "";
	$full_title = "";
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
	
	//get head post
	$stmt = $dbh->prepare("SELECT * FROM posts JOIN users ON posts.username = users.username WHERE post_ID=:replyTo");
	$stmt->bindParam(':replyTo', $replyTo, PDO::PARAM_INT);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while($info=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			//Make the post pretty okay
			$full_title = $info["title"];
			$pc = $info["content"];
			$pr = $info["rating"];
			$pu = $info["username"];
			$ui = $info["picture"];
			$groupID = $info["groupID"];
			//fill empty images
			if (empty($ui)){
				//blank profile image here
				$ui = "img/profile/blank.png";
			}
			$full_post .= "<div>
								<p>$pc</p>
								<p><a href='profile.php?uID=$pu'><img src='$ui' width=70 /> $pu</a></p>
								<p>Rating: $pr</p>
						   </div>";	
			
			//set the delete button if it's the correct user
			if ($uID == $pu){
				$delete_button = '<h3>Delete This Post:</h3><button type="submit" class="btn btn-danger btn-block" name="deletepost" value="deletepost">Delete Post</button>';
			}		
		}
	}
	
	post_all_posts($latest_post);
	
	$post_styles.= "</style>";

	//get the user's groups
	$stmt = $dbh->prepare("SELECT * FROM in_group JOIN groups ON groups.groupID=in_group.groupID WHERE in_group.username=:uID");
	$stmt->bindParam(':uID', $uID, PDO::PARAM_STR);
	$stmt->execute();
	if ($stmt->rowCount() > 0) {
		while($info=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			//These are the groups the user is in
			
		}
	}
	
	//make a reply
	if ($_SERVER["REQUEST_METHOD"] == "POST" && test_input($_POST["modal"]) == "make_post" && !isset($_POST["deletepost"])) {
		
		echo $replyTo;
			
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
	   
	   
	 
	   if ($val=="1"){
			//if everything is good, add group to db
			$stmt = $dbh->prepare("INSERT INTO posts (head, content, rating, username, groupID, title)
								VALUES (:head, :content, 0, :username, :groupID, :title)");
			$stmt->bindParam(':head', $replyTo, PDO::PARAM_INT);
			$stmt->bindParam(':username', $uID, PDO::PARAM_STR);
			$stmt->bindParam(':groupID', $groupID, PDO::PARAM_INT);
			$stmt->bindParam(':content', $content, PDO::PARAM_STR);
			$stmt->bindParam(':title', $title, PDO::PARAM_STR);
			$stmt->execute();
			if (!$stmt) {
				echo "\nPDO::errorInfo():\n";
				print_r($dbh->errorInfo());
			}
			//reload
			echo "<script>location.href = 'Posts.php?head=".$hID."'</script>";
		}
		else{
			//reopen the post page
			echo  '<script> $(document).ready(function(){
				$("#myModal").modal();
				}); </script>';
		}

   
	}
	
	
	//delete post
	if ($_SERVER["REQUEST_METHOD"] == "POST" && test_input($_POST["modal"]) == "make_post" && isset($_POST["deletepost"]) && $_POST["deletepost"] == "deletepost") {
		
		echo $replyTo;
		
		$stmt = $dbh->prepare("DELETE FROM posts WHERE post_ID=:postID");
		$stmt->bindParam(':postID', $replyTo, PDO::PARAM_INT);
		$stmt->execute();
		echo "<script>location.href = 'profile.php?uID=".$uID."'</script>";
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
          <h4><span class="glyphicon glyphicon-random"></span>&nbsp <?php echo $full_title; ?></h4>
        </div>
		
        <div class="modal-body" style="padding:40px 50px;">
        
        	<?php echo $full_post; ?>
        	
        	
        	<hr>
        	<h3>Reply:</h3>
        	
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
			<!--<div class="form-group">
				<label for="group"><span class="glyphicon glyphicon-globe"></span> Group</label>
				<select id="group" class="form-control" name="group">
				<?php echo $grouplist; ?>
				</select>
			</div>-->
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
          
		  	
		  	<hr>
		  	<?php echo $delete_button; ?>
		  
		  
		  </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
      </div>
    </div>
  </div>
<!-- END Model -->