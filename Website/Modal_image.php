
	<!-- Update Image Modal -->
	<div id="imgModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Upload your image</h4>
		  </div>
		  <div class="modal-body">
			<!--Image Form-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype='multipart/form-data'>
            
            <!--Sends User ID-->
            	<input type="hidden" name="modal" value="image">


			  	<!--Image-->
				<div class="form-group">
				  <label for="comment">Image (.GIF , .JPG , .JPEG , .PNG ):</label>
				  <input type="file" name="image" id="image" placeholder="image" ></input>
				</div>
				
				<div class="form-group">  
				  <div >
					<input type="submit" name="submit_image" value="Submit" class="btn btn-default">
				  </div>
				</div>

		  </form>


<!-- 
<?php 
  
 //************************Upload image**********************
     // if (isset($_POST['submit_image'])) {
// 
// 	      if ($_FILES['image']['type'] == 'image/png' ) {
// 
// 	      $temp1 = explode(".", $_FILES["image"]["name"]);
// 	      $newname1 = "image" . '.' . end($temp1);
// 
// 	      move_uploaded_file($_FILES['image']['tmp_name'], './img/profile/'. $newname1);
// 	      chmod("./img/profile/image.png", 0777);
// 
// 
// 	    } 
// 	    else if ($_FILES['image']['type'] == 'image/gif') {
// 
// 	      $temp1 = explode(".", $_FILES["image"]["name"]);
// 	      $newname1 = "image" . '.' . end($temp1);
// 
// 	      move_uploaded_file($_FILES['image']['tmp_name'], './img/profile/'. $newname1);
// 	      chmod("./img/profile/image.gif", 0777);
// 
// 
// 	    } 
// 	    else if ( $_FILES['image']['type'] == 'image/jpeg' ) {
// 
// 	      $temp1 = explode(".", $_FILES["image"]["name"]);
// 	      $newname1 = "image" . '.' . end($temp1);
// 
// 	      move_uploaded_file($_FILES['image']['tmp_name'], './img/profile/'. $newname1);
// 	      chmod("./img/profile/image.jpeg", 0777);
// 
// 
// 	    } 
// 	    else if ( $_FILES['image']['type'] == 'image/jpg') {
// 
// 	      $temp1 = explode(".", $_FILES["image"]["name"]);
// 	      $newname1 = "image" . '.' . end($temp1);
// 
// 	      move_uploaded_file($_FILES['image']['tmp_name'], './img/profile/'. $newname1);
// 	      chmod("./img/profile/image.jpg", 0777);
// 
// 	    } 
// 	    else {
// 	      echo "<p>Only PNG, GIF, JPEG, JPG files are accepted.</p>";
// 	    }
// 
// 
// 	}


?>
 -->
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
		
		</div>
	</div>
	</div>