
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('berlangganan/create?'.param_get()),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('berlangganan/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('berlangganan'); ?>" class="btn btn-default">Reset</a>
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
		<th>Judul</th>
		<th>Detail</th>
		<th>Harga</th>
        <th>Fitur</th>
		<th>Periode Batas</th>
		<th>Action</th>
            </tr><?php
            foreach ($berlangganan_data as $berlangganan)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $berlangganan->judul ?></td>
			<td><?php echo $berlangganan->detail ?></td>
			<td><?php echo $berlangganan->harga ?></td>
			<td><?php echo get_data('fitur','id_fitur',$berlangganan->id_fitur,'fitur') ?></td>
            <td><?php echo $retVal = ($berlangganan->periode =='') ? "" : $berlangganan->periode.' Tahun'; ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('berlangganan/update/'.$berlangganan->id_berlangganan.'?'.param_get()),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('berlangganan/delete/'.$berlangganan->id_berlangganan.'?'.param_get()),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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
    