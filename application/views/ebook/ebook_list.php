
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('ebook/create').'?'.param_get(),'Create', 'class="btn btn-primary"'); ?>
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
		<th>Kategori</th>
		<th>Judul</th>
		<th>Link</th>
		<th>Action</th>
            </tr>
            </thead>
            <tbody><?php
            $start = 1;
            $this->db->where('id_kategori', $this->input->get('id_kategori'));
            $this->db->order_by('id_kategori', 'desc');
            $ebook_data = $this->db->get('ebook')->result();
            foreach ($ebook_data as $ebook)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo get_data('kategori_video','id_kategori',$ebook->id_kategori,'nama_kategori') ?></td>
			<td><?php echo $ebook->judul ?></td>
			<td><?php echo $ebook->link ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('ebook/update/'.$ebook->id_ebook).'?'.param_get(),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('ebook/delete/'.$ebook->id_ebook).'?'.param_get(),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
        
    