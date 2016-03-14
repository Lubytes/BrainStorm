
	
	<!-- Update Image Modal -->
	<div id="bioModal" class="modal fade" role="dialog">
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
            	<input type="hidden" name="modal" value="bio">

				<!--Display Name-->
			
				<div class="form-group">        
				  <div >
					<input type="text" name="dname" id="dname" class="form-control" placeholder="Display Name" autofocus autocomplete="off" value="<?php if(isset($dname)) echo "$dname";?>">
				  </div>
				</div>
			  
			  	<!--Bio-->
				<div class="form-group">
				  <label for="comment">Comment:</label>
				  <textarea class="form-control" rows="5" name="bio" id="bio" placeholder="Bio" autocomplete="off" value="<?php if(isset($bio)) echo "$bio";?>"></textarea>
				</div>
				
				<div class="form-group">  
				  <div >
					<input type="submit" name="submit_bio" value="Submit" class="btn btn-default">
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