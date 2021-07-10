
        <form action="<?php echo $action.'?'.param_get(); ?>" method="post" enctype="multipart/form-data">
	    <input type="hidden" name="id_kategori" value="<?php echo ($id_kategori != '') ? $id_kategori : $this->input->get('id_kategori') ?>">
	    <div class="form-group">
            <label for="varchar">Judul <?php echo form_error('judul') ?></label>
            <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul" value="<?php echo $judul; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Upload Video </label>
            <input type="file" class="form-control" name="link" id="link"/>
            <div>
            	<?php if ($link !=''): ?>
            	*) File sebelumnya <br>
            	<a href="files/video/<?php echo $link ?>"><?php echo $link ?></a>
            	<input type="hidden" name="link_old" value="<?php echo $link ?>">
            	<?php endif ?>
            </div>
        </div>
	    <input type="hidden" name="id_video" value="<?php echo $id_video; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('video').'?'.param_get() ?>" class="btn btn-default">Cancel</a>
	</form>
   