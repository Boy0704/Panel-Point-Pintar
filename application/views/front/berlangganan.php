<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('front/head'); ?>

<body>

  

  <main id="main">

    <div class="accordion" id="accordionExample">
      <?php 
      $this->db->where('id_user', $this->uri->segment(3));
      foreach ($this->db->get('transaksi')->result() as $br): ?>
        
      
      <div class="card">
        <div class="card-header" id="headingOne">
            <a data-toggle="collapse" data-target="#collapseOne<?php echo $br->id_transaksi ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $br->id_transaksi ?>">
               #<?php echo strtolower($br->no_transaksi) ?> (tanggal : <?php echo strtolower($br->created_at) ?>) <br>
               <?php if ($br->status_lunas == 'y'): ?>
                 <span class="badge badge-success">success</span>
               <?php else: ?>
                <span class="badge badge-warning">menunggu pembayaran</span>
               <?php endif ?>
            </a>
        </div>

        <div id="collapseOne<?php echo $br-> id_transaksi ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
          <div class="card-body">
            <div class="col-md-12">
              <table class="table">
                <tr>
                  <td>No Transaksi</td>
                  <td>: <?php echo $br->no_transaksi ?></td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td>: <?php echo get_data('users','id_user',$br->id_user,'nama') ?></td>
                </tr>
                <tr>
                  <td>Paket yang dipilih</td>
                  <td>: <?php 
                  $id_fitur = get_data('berlangganan','id_berlangganan',$br->id_berlangganan,'id_fitur');

                  $nama_paket = get_data('fitur','id_fitur',$id_fitur,'fitur')." ".get_data('berlangganan','id_berlangganan',$br->id_berlangganan,'judul');
                  echo $nama_paket;
                   ?></td>
                </tr>
                <tr>
                  <td>Total Bayar</td>
                  <td>: <?php echo number_format($br->total_bayar) ?></td>
                </tr>
                <tr>
                  <td>Periode Aktif</td>
                  <td>: <?php 
                  $periode = get_data('berlangganan','id_berlangganan',$br->id_berlangganan,'periode');
                  echo $periode.' Tahun'; ?></td>
                </tr>
              </table>

              <?php if ($br->status_lunas == 't'): 
                  $total_bayar = number_format($br->total_bayar);
                  ?>
              <p>
                Lakukan pembayaran sesuai dengan total tagihan agar memudahkan pengecekan pembayaran. Pembayaran hari ini akan di proses hari ini juga, setelah melakukan pembayaran lakukan konfirmasi pembayaran ke admin dengan mengklik tombol di bawah ini.
              </p>

              <div>
                
                  <button class="btn btn-info" onclick="konfirmasi_pembayaran('6285161480960','<?php echo "Halo Admin, saya ingin konfirmasi pembelian paket $nama_paket dengan total bayar: Rp. $total_bayar" ?>')">Konfirmasi Pembayaran</button>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php endforeach ?>
      
    </div>

    <!-- ======= Pricing Section ======= -->
    <section id="pricing" class="pricing section-bg">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Berlangganan</h2>
          <p>Silahkan pilih jenis langganan yang kamu minati.</p>
          <br>
          <p>
            <select class="form-control" id="fitur">
              <?php foreach ($this->db->get('fitur')->result() as $rw):
              $selected = ""; 
                if ($_GET['id_fitur']) {
                  if ($rw->id_fitur == $this->input->get('id_fitur')) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
                } else {
                  $selected = "";
                }
              ?>
                <option value="<?php echo $rw->id_fitur ?>" <?php echo $selected ?>><?php echo $rw->fitur ?></option>
              <?php endforeach ?>
              
            </select>
          </p>
        </div>

        <div class="row">
          <?php 
          if (isset($_GET['id_fitur'])) {
            $this->db->where('id_fitur', $this->input->get('id_fitur'));
          } else {
            $this->db->where('id_fitur','1');
          }
          
          foreach ($this->db->get('berlangganan')->result() as $rw): ?>
            
          
          <div class="col-lg-3 col-md-6">
            <div class="box" data-aos="zoom-in">
              <h3><?php echo $rw->judul ?></h3>
              <h4><sup>Rp </sup><?php echo number_format($rw->harga) ?></h4>
              <?php echo $rw->detail ?>
              <div class="btn-wrap">
                <a href="web/transaksi/<?php echo $this->uri->segment(3) ?>/<?php echo $rw->id_berlangganan ?>" class="btn-buy">Pilih</a>
              </div>
            </div>
          </div>

          <?php endforeach ?>

          
        </div>

      </div>
    </section><!-- End Pricing Section -->

  </main><!-- End #main -->

  <script type="text/javascript">
    function konfirmasi_pembayaran(noWa, pesan) {
      WebAppInterface.waManual(noWa, pesan);
    }
  </script>

  <!-- ======= Footer ======= -->
  <!-- Vendor JS Files -->
  <script src="front/vendor/jquery/jquery.min.js"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $("#fitur").change(function() {
        var id_fitur = $(this).val();
        window.location="<?php echo base_url() ?>web/berlangganan/<?php echo $this->uri->segment(3) ?>?id_fitur="+id_fitur;
      });
    });
  </script>
  <script src="front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="front/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="front/vendor/php-email-form/validate.js"></script>
  <script src="front/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="front/vendor/venobox/venobox.min.js"></script>
  <script src="front/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="front/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="front/js/main.js"></script>

</body>

</html>