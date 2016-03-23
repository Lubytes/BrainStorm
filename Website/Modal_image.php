
	
	<!-- Update Image Modal -->
	<div id="imgModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Upload A new image</h4>
		  </div>
		  <div class="modal-body">
			<!--Image Form-->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
            
            <!--Sends User ID-->
            	<input type="hidden" name="modal" value="image">	

		  
		  </form>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
		
		</div>
	</div>
	</div>