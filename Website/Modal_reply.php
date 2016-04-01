 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="padding:35px 50px;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4><span class="glyphicon glyphicon-random"></span>&nbsp; Create Post</h4>
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
          
		  
		  
		  
		  
		  </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
        </div>
      </div>
    </div>
  </div>
<!-- END Model -->