<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
  <style type="text/css">
      .dijawab{
        color: white;
        background: green;
      }
  </style>
</head>
<body>

<div class="row" style="margin: 10px;">

    <div class="col-md-12">
        <div>
            <span>Soal No. <b id="no_soal"></b> </span> <div id="pertanyaan">
                
            </div>
            <hr style="background-color: #93c8ed;">
            <div id="jawaban"></div>

            <hr style="background-color: #93c8ed;">
            <h4>Jawaban Benar</h4>
            <div id="benar"></div>
            <h4>Pembahasan</h4>
            <div id="pembahasan"></div>
        </div>
        <div style="margin-top: 30px;">
            <div class="col-md-2">
                <button href="#" id="sebelumnya" data-id-soal="0" class="btn btn-warning">Sebelumnya</button>
            </div>
            <div class="col-md-8"></div>
            <div class="col-md-2">
                <button id="selanjutnya" data-id-soal="0" class="btn btn-primary">Selanjutnya</button>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <h5>Navigasi Soal</h5>
        <div style="margin-top:10px; " id="nav_soal"></div>
    </div>
</div>

<div class="row" style="margin: 10px;">
    <hr style="background-color: #93c8ed;">
    <div class="col-md-12">
        <h5>Nilai</h5>
        <?php if ($type_soal == 'skd'): ?>
            <p><b>Total Nilai TIU : <?php echo $this->db->query("SELECT sum(a.nilai) as nilai FROM skor_detail a INNER JOIN soal b ON a.id_soal = b.id_soal WHERE a.id_skor='$id_skor' and b.type_soal='tiu'")->row()->nilai; ?></b></p>

            <p><b>Total Nilai TKP : <?php echo $this->db->query("SELECT sum(a.nilai) as nilai FROM skor_detail a INNER JOIN soal b ON a.id_soal = b.id_soal WHERE a.id_skor='$id_skor' and b.type_soal='tkp'")->row()->nilai; ?></b></p>

            <p><b>Total Nilai TWK : <?php echo $this->db->query("SELECT sum(a.nilai) as nilai FROM skor_detail a INNER JOIN soal b ON a.id_soal = b.id_soal WHERE a.id_skor='$id_skor' and b.type_soal='twk'")->row()->nilai; ?></b></p>
        <?php else: ?>
            <p><b>Total Nilai : <?php echo $this->db->query("SELECT sum(a.nilai) as nilai FROM skor_detail a INNER JOIN soal b ON a.id_soal = b.id_soal WHERE a.id_skor='$id_skor'")->row()->nilai; ?></b></p>
        <?php endif ?>
    </div>
</div>

<script src="<?php echo base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">

function get_soal(id_butir_soal,no) {
    $.get('<?php echo base_url() ?>pembahasan/get_pertanyaan/'+id_butir_soal, function(pertanyaan) {
        $('#no_soal').text(no);
        $('#pertanyaan').html(pertanyaan);
    });

    $.get('<?php echo base_url() ?>pembahasan/get_pembahasan/'+id_butir_soal, function(pembahasan) {
        $('#pembahasan').html(pembahasan);
    });

    $.get('<?php echo base_url() ?>pembahasan/get_benar/'+id_butir_soal, function(benar) {
        var j_benar = benar;
        $('#benar').html("("+j_benar.toUpperCase()+")");
    });

    $.get('<?php echo base_url() ?>pembahasan/get_jawaban/'+id_butir_soal+'/<?php echo $id_skor ?>', function(jawaban) {
        $('#jawaban').html(jawaban);
    });

    total_soal = '<?php echo $total_soal ?>';
    no_lanjut = parseInt(no)+1;
    no_sblm = parseInt(no)-1;
    if (no == 1) {
        var x_id_soal = $('[data-no-soal='+no_lanjut+']').attr('data-id-butir');
        $('#sebelumnya').hide();
        $('#selanjutnya').attr('onclick', "get_soal_selanjutnya('"+x_id_soal+"','"+no_lanjut+"')");
    } else if (no == total_soal) {
        var x_id_soal0 = $('[data-no-soal='+no_sblm+']').attr('data-id-butir');
        $('#selanjutnya').hide();
        $('#sebelumnya').show();
        $('#sebelumnya').attr('onclick', "get_soal_sebelumnya('"+x_id_soal0+"','"+no_sblm+"')");
    } else {
         var x_id_soal0 = $('[data-no-soal='+no_sblm+']').attr('data-id-butir');
        $('#sebelumnya').show();
        $('#selanjutnya').show();
        $('#sebelumnya').attr('onclick', "get_soal_sebelumnya('"+x_id_soal0+"','"+no_sblm+"')");

        var x_id_soal1 = $('[data-no-soal='+no_lanjut+']').attr('data-id-butir');
        $('#selanjutnya').attr('onclick', "get_soal_selanjutnya('"+x_id_soal1+"','"+no_lanjut+"')");
    }
}

function get_soal_sebelumnya(valfn,no_soal) {

    get_soal(valfn,no_soal);
}

function get_soal_selanjutnya(valfn,no_soal) {
    get_soal(valfn,no_soal);
}

function simpan_jawaban(id_butir_soal,id_jwb) {
    $.ajax({
        url: '<?php echo base_url() ?>pembahasan/simpan_jawaban/'+id_butir_soal+'/'+id_jwb+'/'+'<?php echo $id_skor ?>',
        type: 'GET'
    })
    .done(function(data) {
        console.log("success");
        if (data == 'berhasil') {
            $('#no_'+id_butir_soal).attr('class', 'btn btn-success');
        }
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });

}

$(document).ready(function() {
    // load navigasi soal
    $.getJSON('<?php echo base_url() ?>pembahasan/get_soal/<?php echo $id_paket_soal ?>', function(data){

        var soal_pertama = data[0].soal;
        soal_pertama = soal_pertama.replace("../../", "<?php echo base_url() ?>");
        $('#no_soal').text('1');
        $('#pertanyaan').html(soal_pertama);
        var j_benar = data[0].benar;
        $('#benar').html("("+j_benar.toUpperCase()+")");
        $("#pembahasan").html(data[0].pembahasan);
        
        $.get('<?php echo base_url() ?>pembahasan/get_jawaban/'+data[0].id_soal+'/<?php echo $id_skor ?>', function(jawaban) {
            $('#jawaban').html(jawaban);
        });

        var no=1;
        var btn_class = "";
        $.each(data, function(i, order){
            // if (data[i].id_soal_skor != null) {
            //     if (data[i].benar = data[i].id_jawaban ) {
            //         btn_class = "btn_success";
            //     } else {
            //         btn_class = "btn_danger";
            //     }
            // } else {
            //     btn_class = "btn_primary";
            // }

            $("#nav_soal").append('<button type="button" onclick="get_soal('+data[i].id_soal+','+no+')" data-no-soal="'+no+'" data-id-butir="'+data[i].id_soal+'" id="no_'+data[i].id_soal+'" class="btn btn_primary">'+no+'</button>&nbsp;');
            no = no +1;
        });

        var no_soal = 2;
        var x_id_soal = $('#no_'+data[1].id_soal).attr('data-id-butir');
        $('#sebelumnya').hide();
        $('#selanjutnya').attr('onclick', "get_soal_selanjutnya('"+x_id_soal+"','"+no_soal+"')");


    });

});

</script>


</body>
</html>