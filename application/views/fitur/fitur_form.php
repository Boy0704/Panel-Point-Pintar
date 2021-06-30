
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
	    <div class="form-group">
            <label for="varchar">Fitur <?php echo form_error('fitur') ?></label>
            <input type="text" class="form-control" name="fitur" id="fitur" placeholder="Fitur" value="<?php echo $fitur; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Logo <?php echo form_error('logo') ?></label>
            <input type="file" class="form-control" name="logo" id="logo" placeholder="Logo" value="<?php echo $logo; ?>" />
            <input type="hidden" name="logo_old" value="<?php echo $logo ?>">
            <div>
                <?php if ($logo != ''): ?>
                    <b>*) Logo Sebelumnya : </b><br>
                    <img src="image/logo/<?php echo $logo ?>" style="width: 100px;">
                <?php endif ?>
            </div>
        </div>
	    <div class="form-group">
            <label for="keterangan">Keterangan <?php echo form_error('keterangan') ?></label>
            <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
        </div>
	    <input type="hidden" name="id_fitur" value="<?php echo $id_fitur; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('fitur') ?>" class="btn btn-default">Cancel</a>
	</form>
   