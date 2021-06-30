<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No.</th>
					<th>Icon</th>
					<th>Fitur</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				foreach ($this->db->get('fitur')->result() as $rw): ?>
				
				<tr>
					<td><?php echo $no ?></td>
					<td><img src="image/logo/<?php echo $rw->logo ?>" style="width: 50px;"></td>
					<td><?php echo $rw->fitur."<br>".$rw->keterangan ?></td>
					<td>
						<a href="kategori_ebook?id_fitur=<?php echo $rw->id_fitur ?>" class="btn btn-xs btn-info">Pilih</a>
					</td>
				</tr>
				<?php $no++; endforeach ?>
			</tbody>
		</table>
	</div>
</div>