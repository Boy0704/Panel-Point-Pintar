
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Nama <?php echo form_error('nama') ?></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
        <div class="form-group">
            <label for="varchar">Email <?php echo form_error('email') ?></label>
            <input type="email" class="form-control" name="email" id="nama" placeholder="Email Aktif" value="<?php echo $email; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Username <?php echo form_error('username') ?></label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Password <?php echo form_error('password') ?></label>
            <input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Level <?php echo form_error('id_level') ?></label>
            <select name="id_level" class="form-control">
                <option value="<?php echo $id_level ?>"><?php echo get_data('level','id_level',$id_level,'level') ?></option>
                <?php foreach ($this->db->get('level')->result() as $br): ?>
                    <option value="<?php echo $br->id_level ?>"><?php echo $br->level ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label for="varchar">Jabatan <?php echo form_error('jabatan') ?></label>
            <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan" value="<?php echo $jabatan; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Foto </label>
            <input type="hidden" name="foto_old" value="<?php echo $foto ?>">
            <input type="file" class="form-control" name="foto" id="foto" placeholder="Foto" <?php //echo ($this->uri->segment(2) == 'create') ? 'required' : '' ?>/>
        </div>
	    <input type="hidden" name="id_user" value="<?php echo $id_user; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('users') ?>" class="btn btn-default">Cancel</a>
	</form>
   