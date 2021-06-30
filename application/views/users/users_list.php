
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('users/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('users/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('users'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
        <th>Nama</th>
		<th>Email</th>
		<th>Username</th>
		<th>Password</th>
        <th>Level</th>
		<th>Jabatan</th>
		<th>Foto</th>
		<th>Action</th>
            </tr><?php
            foreach ($users_data as $users)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
            <td><?php echo $users->nama ?></td>
			<td><?php echo $users->email ?></td>
			<td><?php echo $users->username ?></td>
			<td><?php echo $users->password ?></td>
            <td><?php echo get_data('level','id_level',$users->id_level,'level') ?></td>
            <td><?php echo $users->jabatan ?></td>
			<td><?php echo ($users->status_login == '2') ? '<span class="label label-success">Sedang Login</span>' : '<span class="label label-info">Tidak Login</span>' ?></td>
			<td><img src="image/user/<?php echo $users->foto ?>" style="width: 50px;"></td>
			<td style="text-align:center" width="200px">
                <a href="users/reset_login/<?php echo $users->id_user ?>" class="label label-warning" onclick="javasciprt: return confirm('Yakin akan reset login akun ini ?')">Reset Login</a>
				<?php 
				echo anchor(site_url('users/update/'.$users->id_user),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('users/delete/'.$users->id_user),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    