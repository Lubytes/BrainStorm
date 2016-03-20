<!DOCTYPE HTML> 
<html>
<head>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style>
.error {color: #3366ff;}
</style>
</head>
<body> 

<?php
session_name('project');  
session_start();
$uID = $_SESSION["username"];
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

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	   if (empty($_POST["title"])) {
		 $titleErr = "Title is required";
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
			$stmt->bindParam(':username', $uID);
			$stmt->bindParam(':groupID', $groupID);
			$stmt->bindParam(':content', $content);
			$stmt->bindParam(':title', $title);
			$stmt->bindParam(':type', $type);
			$stmt->execute();
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
<div class="container">
<div>
<div class="panel panel-default">

<div class="panel-heading">
<div class="panel-title">Post Creation</div>
</div>
<div class="panel-body">

<!-- Validation -->
<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if (empty($_POST["title"])) {echo $titleErr."<br><br>"; $val = "0"; }}?></span>
<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if (empty($_POST["content"])) {echo $contentErr."<br><br>"; $val = "0"; }}?></span>
<span class="error"> <?php if ($_SERVER["REQUEST_METHOD"] == "POST") { if (empty($_POST["type"])) {echo $typeErr."<br><br>"; $val = "0";}} ?></span>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   
   <div id="nname" style="">
   <input type="text" name="title" placeholder="The title of your post" value="<?php if(isset($title)) echo "$title";?>">
   </div>
   
   <div id="content" style="">
   <textarea name="content" rows="3" cols="40" placeholder="Post Content"><?php if(isset($content)) echo "$content";?></textarea>
   </div>
   
   <div id="type" style="">
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
   
   <br><br>
		<select name="group">
		  <?php echo $grouplist; ?>
		</select>
   
   
   
   <input type="submit" name="submit" value="Post"> 
</form>
</div>
</div>
</div>
</div>