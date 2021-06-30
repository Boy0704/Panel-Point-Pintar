
        <form action="<?php echo $action.'?'.param_get(); ?>" method="post">
	    <input type="hidden" name="id_fitur" value="<?php echo ($id_fitur != '') ? $id_fitur : $this->input->get('id_fitur') ?>">
	    <div class="form-group">
            <label for="varchar">Nama Kelas <?php echo form_error('nama_kelas') ?></label>
            <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" placeholder="Nama Kelas" value="<?php echo $nama_kelas; ?>" />
        </div>
	    <div class="form-group">
            <label for="materi">Materi <?php echo form_error('materi') ?></label>
            <textarea class="form-control" rows="3" name="materi" id="materi" placeholder="Materi"><?php echo $materi; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="datetime">Waktu <?php echo form_error('waktu') ?></label>
            <?php if ($this->uri->segment(2) == 'create'): ?>
            <input type="datetime-local" class="form-control" name="waktu" id="waktu" placeholder="Waktu" value="<?php echo $waktu; ?>" />

            <?php else: ?>
            <input type="text" class="form-control" name="waktu" id="waktu" placeholder="Waktu" value="<?php echo $waktu; ?>" />
            <?php endif ?>
        </div>
	    <div class="form-group">
            <label for="link">Link <?php echo form_error('link') ?></label>
            <textarea class="form-control" rows="3" name="link" id="link" placeholder="Link"><?php echo $link; ?></textarea>
        </div>
	    <input type="hidden" name="id_kelas" value="<?php echo $id_kelas; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('kelas_online').'?'.param_get() ?>" class="btn btn-default">Cancel</a>
	</form>
   