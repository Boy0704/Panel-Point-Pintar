
        <form action="<?php echo $action.'?'.param_get(); ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nama Soal <?php echo form_error('nama_soal') ?></label>
            <input type="text" class="form-control" name="nama_soal" id="nama_soal" placeholder="Nama Soal" value="<?php echo $nama_soal; ?>" />
        </div>
        <div class="form-group">
            <label for="int">Type Soal <?php echo form_error('type_soal') ?></label>
            <select class="form-control" name="type_soal">
                <option value="<?php echo $type_soal ?>"><?php echo $type_soal ?></option>
                <option value="skd">skd</option>
                <option value="lainnya">lainnya</option>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Waktu <?php echo form_error('waktu') ?></label>
            <input type="text" class="form-control" name="waktu" id="waktu" placeholder="Waktu" value="<?php echo $waktu; ?>" />
        </div>
        <div class="form-group">
            <label for="int">Point Salah</label>
            <input type="text" class="form-control" name="point_salah" id="point_salah" placeholder="Point Salah" value="<?php echo $point_salah; ?>" />
        </div>
        <div class="form-group">
            <label for="int">Point Benar</label>
            <input type="text" class="form-control" name="point_benar" id="point_benar" placeholder="Point Benar" value="<?php echo $point_benar; ?>" />
        </div>
        <div class="form-group">
            <label for="int">Target Point</label>
            <input type="text" class="form-control" name="target_point" id="target_point" placeholder="Target Point" value="<?php echo $target_point; ?>" />
        </div>
	    <div class="form-group">
            <label for="keterangan">Keterangan <?php echo form_error('keterangan') ?></label>
            <textarea class="form-control" rows="3" name="keterangan" id="keterangan" placeholder="Keterangan"><?php echo $keterangan; ?></textarea>
        </div>
	    <div class="form-group">
            <label for="enum">Jenis Soal <?php echo form_error('jenis_soal') ?></label>
            <select class="form-control" name="jenis_soal">
                <option value="<?php echo $jenis_soal ?>"><?php echo $jenis_soal ?></option>
                <option value="free">free</option>
                <option value="latihan">latihan</option>
                <option value="akbar">akbar</option>
            </select>
        </div>
	    <input type="hidden" name="id_fitur" value="<?php echo $id_fitur ?>">
	    <input type="hidden" name="id_paket_soal" value="<?php echo $id_paket_soal; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('paket_soal?'.param_get()) ?>" class="btn btn-default">Cancel</a>
	</form>
   