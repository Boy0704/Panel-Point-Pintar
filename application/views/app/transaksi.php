<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered" id="example2">
			<thead>
				<tr>
					<th>No.</th>
					<th>No Trx</th>
					<th>Nama User</th>
					<th>Paket yg diambil</th>
					<th>Total Bayar</th>
					<th>Status Lunas</th>
					<th>Created</th>
					<th>Updated</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$no = 1;
				$this->db->order_by('id_transaksi', 'desc');
				foreach ($this->db->get('transaksi')->result() as $rw): ?>
				
				<tr>
					<td><?php echo $no ?></td>
					<td><?php echo $rw->no_transaksi ?></td>
					<td><?php echo get_data('users','id_user',$rw->id_user,'nama') ?></td>
					<td><?php 
					$id_fitur = get_data('berlangganan','id_berlangganan',$rw->id_berlangganan,'id_fitur');
					echo get_data('fitur','id_fitur',$id_fitur,'fitur').' '.get_data('berlangganan','id_berlangganan',$rw->id_berlangganan,'judul') ?></td>
					<td><?php echo number_format($rw->total_bayar) ?></td>
					<td>
						<?php if ($rw->status_lunas == 't'): ?>
							<span class="label label-warning">Menunggu Pembayaran</span>
						<?php else: ?>
							<span class="label label-success">Lunas</span>
						<?php endif ?>

					</td>
					<td><?php echo $rw->created_at ?></td>
					<td><?php echo $rw->updated_at ?></td>
					<td>
						<?php if ($rw->status_lunas == 't'): ?>
							<a onclick="javasciprt: return confirm('Yakin akan konfirmasi pembayaran transaksi ini ?')" href="app/status_lunas/<?php echo $rw->id_transaksi ?>" class="label label-info">Konfirmasi</a>
						<?php endif ?>
						
						<a onclick="javasciprt: return confirm('Yakin akan hapus transaksi ini ?')" href="app/hapus_trx/<?php echo $rw->id_transaksi ?>" class="label label-danger">Hapus</a>
					</td>
				</tr>
				<?php $no++; endforeach ?>
			</tbody>
		</table>
	</div>
</div>