<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('front/head'); ?>

<body>

  

  <main id="main">

    

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
                if ($_GET) {
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
          if ($_GET) {
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
                <a href="#" class="btn-buy">Pilih</a>
              </div>
            </div>
          </div>

          <?php endforeach ?>

          
        </div>

      </div>
    </section><!-- End Pricing Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <!-- Vendor JS Files -->
  <script src="front/vendor/jquery/jquery.min.js"></script>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $("#fitur").change(function() {
        var id_fitur = $(this).val();
        window.location="<?php echo base_url() ?>web/berlangganan?id_fitur="+id_fitur;
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