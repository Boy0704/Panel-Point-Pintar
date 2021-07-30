
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	    <div class="form-group">
            <label for="varchar">Slide <?php echo form_error('slide') ?></label>
            <input type="file" class="form-control" name="slide" id="slide" placeholder="Slide"  />
        </div>
	    <input type="hidden" name="id_slide" value="<?php echo $id_slide; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('slide') ?>" class="btn btn-default">Cancel</a>
	</form>
   