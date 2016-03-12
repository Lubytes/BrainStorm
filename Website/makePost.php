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
// define variables and set to empty values
$titleErr = $typeErr = $contentErr =  "";
$title = $type = $content = "";
$val = "1";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   if (empty($_POST["title"])) {
     $titleErr = "Title is required";
   } else {
     $title = test_input($_POST["title"]);
   }
     

   if (empty($_POST["type"])) {
     $typeErr = "Type is required";
   } else {
     $type = test_input($_POST["type"]);
   }
   
   if (empty($_POST["content"])) {
     $contentErr = "Content must not be empty";
   }  
   else{
	   $content = test_input($_POST["content"]);
   }
     
   

   
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
		  <option >Followers</option>
		  <option >??</option>
		  <option >??</option>
		  <option >??</option>
		</select>
   
   
   
   <input type="submit" name="submit" value="Post"> 
</form>
</div>
</div>
</div>
</div>