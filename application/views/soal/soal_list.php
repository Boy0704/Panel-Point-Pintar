
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('soal/create?'.param_get()),'Create', 'class="btn btn-primary"'); ?>
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
		<th>Soal</th>
		<th>A</th>
		<th>B</th>
		<th>C</th>
		<th>D</th>
		<th>E</th>
		<th>Benar</th>
		<th>Pembahasan</th>
		<th>Action</th>
            </tr>
            </thead>
            <tbody><?php
            $start = 1;
            $soal_data = $this->db->get_where('soal', ['id_paket_soal'=>$this->input->get('id_paket_soal')]);
            foreach ($soal_data->result() as $soal)
            {
                ?>
                <tr>
			<td width="80px"><?php echo $start ?></td>
			<td><?php echo $soal->soal ?></td>
			<td><?php echo $soal->a ?></td>
			<td><?php echo $soal->b ?></td>
			<td><?php echo $soal->c ?></td>
			<td><?php echo $soal->d ?></td>
			<td><?php echo $soal->e ?></td>
			<td><?php echo $soal->benar ?></td>
			<td><?php echo $soal->pembahasan ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('soal/update/'.$soal->id_soal.'?'.param_get()),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('soal/delete/'.$soal->id_soal.'?'.param_get()),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
        