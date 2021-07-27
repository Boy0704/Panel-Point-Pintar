
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('paket_soal/create?'.param_get()),'Create', 'class="btn btn-primary"'); ?>
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
        <table class="table table-bordered" style="margin-bottom: 10px" id="example2">
            <thead>
            <tr>
                <th>No</th>
        <th>Nama Soal</th>
		<th>Type Soal</th>
        <th>Waktu</th>
        <th>Point Salah</th>
        <th>Point Benar</th>
		<th>Target Point</th>
		<th>Keterangan</th>
		<th>Jenis Soal</th>
		<th>Action</th>
            </tr>
            </thead>
            <tbody><?php
            $start = 1;
            $paket_soal_data = $this->db->get_where('paket_soal', ['id_fitur'=>$this->input->get('id_fitur')]);
            foreach ($paket_soal_data->result() as $paket_soal)
            {
                ?>
                <tr>
			<td width="80px"><?php echo $start ?></td>
            <td><?php echo $paket_soal->nama_soal ?></td>
			<td><?php echo $paket_soal->type_soal ?></td>
            <td><?php echo $paket_soal->waktu ?></td>
            <td><?php echo $paket_soal->point_salah ?></td>
            <td><?php echo $paket_soal->point_benar ?></td>
			<td><?php echo $paket_soal->target_point ?></td>
			<td><?php echo $paket_soal->keterangan ?></td>
			<td><?php echo $paket_soal->jenis_soal ?></td>
			<td style="text-align:center" width="200px">
                <a href="soal?id_paket_soal=<?php echo $paket_soal->id_paket_soal ?>" class="label label-success">Input Soal</a>
				<?php 
				echo anchor(site_url('paket_soal/update/'.$paket_soal->id_paket_soal.'?'.param_get()),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('paket_soal/delete/'.$paket_soal->id_paket_soal.'?'.param_get()),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
        
    