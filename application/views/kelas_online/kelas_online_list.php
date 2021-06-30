
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('kelas_online/create').'?'.param_get(),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered" id="example2" style="margin-bottom: 10px">
            <thead>
            <tr>
                <th>No</th>
		<th>Fitur</th>
		<th>Nama Kelas</th>
		<th>Materi</th>
		<th>Waktu</th>
		<th>Link</th>
		<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $start = 1;
            $this->db->where('id_fitur', $this->input->get('id_fitur'));
            $this->db->order_by('id_kelas', 'desc');
            foreach ($this->db->get('kelas_online')->result() as $kelas_online)
            {
                ?>
                <tr>
			<td width="80px"><?php echo $start ?></td>
			<td><?php echo get_data('fitur','id_fitur',$kelas_online->id_fitur,'fitur') ?></td>
			<td><?php echo $kelas_online->nama_kelas ?></td>
			<td><?php echo $kelas_online->materi ?></td>
			<td><?php echo $kelas_online->waktu ?></td>
			<td><?php echo $kelas_online->link ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('kelas_online/update/'.$kelas_online->id_kelas).'?'.param_get(),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('kelas_online/delete/'.$kelas_online->id_kelas).'?'.param_get(),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
                $start++;
            }
            ?>
            </tbody>
        </table>
        </div>
        
    