
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('kategori_video/create').'?'.param_get(),'Create', 'class="btn btn-primary"'); ?>
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
		<th>Nama Kategori</th>
		<th>Fitur</th>
		<th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $start = 1;
            $this->db->where('id_fitur', $this->input->get('id_fitur'));
            $this->db->order_by('id_kategori', 'desc');
            $kategori_video_data = $this->db->get('kategori_video')->result();
            foreach ($kategori_video_data as $kategori_video)
            {
                ?>
                <tr>
			<td width="80px"><?php echo $start ?></td>
			<td><?php echo $kategori_video->nama_kategori ?></td>
			<td><?php echo get_data('fitur','id_fitur',$kategori_video->id_fitur,'fitur') ?></td>
			<td style="text-align:center" width="200px">
                <a href="video?id_kategori=<?php echo $kategori_video->id_kategori ?>" class="label label-success">Input Video</a>
				<?php 
				echo anchor(site_url('kategori_video/update/'.$kategori_video->id_kategori).'?'.param_get(),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('kategori_video/delete/'.$kategori_video->id_kategori).'?'.param_get(),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
        
    