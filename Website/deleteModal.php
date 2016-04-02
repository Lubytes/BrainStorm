	
	<!-- Update Image Modal -->
	<div id="deleteModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Update your Bio</h4>
		  </div>
		  <div class="modal-body">
			<!--Bio Form-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
            
            	<!--Sends User ID-->
            	<input type="hidden" name="modal" value="deleteProfile">
				<h1>Are you sure?</h1>
				<h5>We'll miss you :c</h5>
				
			  	
				
				<div class="form-group">  
				  <div >
					<input type="submit" name="submit_delete" value="Yes, I'm sure" class="btn btn-block">
				  </div>
				</div>

		  
		  </form>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
		
		</div>
	</div>
	</div>