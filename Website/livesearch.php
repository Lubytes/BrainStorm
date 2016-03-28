<?php

//connnect to database

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
		$a = array();
		$dbh = new PDO($dsn, $dbname, $dbpword);
		$query = $dbh->prepare("SELECT * from users");
		//$query->bindParam(':uID', $uID);
		$query->execute();
		//$row = $result->fetch_array(MYSQLI_NUM);
		while($uids = $query->fetch(PDO::FETCH_ASSOC)){
					array_push($a,$uids["username"]);
					//array_push($a,$uids[0]);
				}
		
} catch (PDOException $e) {
		echo "Error!: " . $e->getMessage() . "<br/>";
		die();
	} 
//get usernames from database and push them into the array
/*$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die ('Your DB connection is misconfigured. Enter the correct values and try again.');
				$lstmt = mysqli_query($link, "SELECT username FROM users");
				while($empids = mysqli_fetch_array($lstmt,MYSQLI_NUM)){
					array_push($a,$empids[0]);
				}
*/
/*
$a[] = "Anna";
$a[] = "Brittany";
$a[] = "Cinderella";
$a[] = "Diana";
$a[] = "Eva";
$a[] = "Fiona";
$a[] = "Gunda";
$a[] = "Hege";
$a[] = "Inga";
$a[] = "Johanna";
$a[] = "Kitty";
$a[] = "Linda";
$a[] = "Nina";
$a[] = "Ophelia";
$a[] = "Petunia";
$a[] = "Amanda";
$a[] = "Raquel";
$a[] = "Cindy";
$a[] = "Doris";
$a[] = "Eve";
$a[] = "Evita";
$a[] = "Sunniva";
$a[] = "Tove";
$a[] = "Unni";
$a[] = "Violet";
$a[] = "Liza";
$a[] = "Elizabeth";
$a[] = "Ellen";
$a[] = "Wenche";
$a[] = "Vicky";
*/

$a[] = "stillWorks";
// get the q parameter from URL
$q = $_GET["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);
    foreach($a as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            if ($hint === "") {
                $hint = $name;
            } else {
                $hint .= ", $name";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values 
echo $hint === "" ? "no suggestion" : $hint;
?>