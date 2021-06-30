
        <form action="<?php echo $action.'?'.param_get(); ?>" method="post">
	    <input type="hidden" name="id_kategori" value="<?php echo ($id_kategori != '') ? $id_kategori : $this->input->get('id_kategori') ?>">
	    <div class="form-group">
            <label for="varchar">Judul <?php echo form_error('judul') ?></label>
            <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul" value="<?php echo $judul; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Link <?php echo form_error('link') ?></label>
            <input type="text" class="form-control" name="link" id="link" placeholder="Link" value="<?php echo $link; ?>" />
        </div>
	    <input type="hidden" name="id_video" value="<?php echo $id_video; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('video').'?'.param_get() ?>" class="btn btn-default">Cancel</a>
	</form>
   