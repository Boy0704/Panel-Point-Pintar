<?php 

function total_kat($id,$kategori)
{
	$CI =& get_instance();
	$CI->db->where('id_kategori', $id);
	$total = $CI->db->get($kategori)->num_rows();
	return $total;
}

function time_since($timestamp)
{
	date_default_timezone_set('Asia/Jakarta');
	$selisih = time() - strtotime($timestamp) ;
	$detik = $selisih ;
	$menit = round($selisih / 60 );
	$jam = round($selisih / 3600 );
	$hari = round($selisih / 86400 );
	$minggu = round($selisih / 604800 );
	$bulan = round($selisih / 2419200 );
	$tahun = round($selisih / 29030400 );
	if ($detik <= 60) {
	    $waktu = $detik.' detik yang lalu';
	} else if ($menit <= 60) {
	    $waktu = $menit.' menit yang lalu';
	} else if ($jam <= 24) {
	    $waktu = $jam.' jam yang lalu';
	} else if ($hari <= 7) {
	    $waktu = $hari.' hari yang lalu';
	} else if ($minggu <= 4) {
	    $waktu = $minggu.' minggu yang lalu';
	} else if ($bulan <= 12) {
	    $waktu = $bulan.' bulan yang lalu';
	} else {
	    $waktu = $tahun.' tahun yang lalu';
	}
	return $waktu;
}

function diskon($id_trx)
{
	$CI =& get_instance();
	$sql = "SELECT SUM(subtotal) as subtotal FROM penjualan_detail where kode_transaksi='$id_trx' ";
	$subtotal = $CI->db->query($sql)->row()->subtotal;
	if ($subtotal > 200000 && $subtotal < 500000) {
		$diskon = 0.05 * $subtotal;
	} elseif ($subtotal > 500000) {
		$diskon = 0.1 * $subtotal;
	} else {
		$diskon = 0;
	}
	return $diskon;
}

function total_bayar($id_trx)
{
	$CI =& get_instance();
	$sql = "SELECT SUM(subtotal) as subtotal FROM penjualan_detail where kode_transaksi='$id_trx' ";
	$subtotal = $CI->db->query($sql)->row()->subtotal;
	return $subtotal;
}

function param_get()
{
	$url = parse_url($_SERVER['REQUEST_URI']);
	return $url['query'];
}

function cek_centroid($c,$nip)
{
	$CI =& get_instance();
	$cent = $CI->db->get_where('centroid', array('centroid'=>$c))->row();
	$pgw = $CI->db->get_where('pegawai', array('nip'=>$nip))->row();
	$hasil = sqrt(pow(($pgw->orientasi_pelayanan - $cent->orientasi_pelayanan), 2) + pow(($pgw->integritas - $cent->integritas), 2) + pow(($pgw->komitmen - $cent->komitmen), 2) + pow(($pgw->disiplin - $cent->disiplin), 2) + pow(($pgw->kerja_sama - $cent->kerja_sama), 2));
	return $hasil;
}

function superman()
{
  if (strpos(siteURL(),'://localhost')){
    return true;
  }else {
    return false;
  }
}

function siteURL() {
  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $domainName = $_SERVER['HTTP_HOST'] . '/';
  return $protocol . $domainName;
}

function api($value)
{
	if ($value == 'login_fb') {
		return '255436962206721, 07348b9734248bb5d93b4a4a40c012d8';
	} elseif ($value == 'login_google') {
		return '514260896239-7gsm0vuljlcpf2m1qs1qr308isotqe64.apps.googleusercontent.com, H_JIU-RVp23IyVJ32lUNuqK9';
	}
}

function kirim_email($subject,$pesan,$email_to)
{
	$CI =& get_instance();
	$config = [
        'mailtype'  => 'html',
        'charset'   => 'utf-8',
        'protocol'  => 'smtp',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_user' => get_data('setting','nama','email_pengirim','value'),  // Email gmail
        'smtp_pass'   => get_data('setting','nama','password_pengirim','value'),  // Password gmail
        'smtp_crypto' => 'tls',
        'smtp_port'   => 587,
        'crlf'    => "\r\n",
        'newline' => "\r\n"
    ];

    // Load library email dan konfigurasinya
    $CI->email->initialize($config);  
  
	$CI->email->set_newline("\r\n"); 

    // Email dan nama pengirim
    $CI->email->from('test@dokterarief.com', 'Klinik Dokter');

    // Email penerima
    $CI->email->to($email_to); // Ganti dengan email tujuan

    // Lampiran email, isi dengan url/path file
    // $CI->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');

    // Subject email
    $CI->email->subject($subject);

    // Isi email
    $CI->email->message($pesan);

    // Tampilkan pesan sukses atau error
    if ($CI->email->send()) {
        return 'Sukses! email berhasil dikirim.';
    } else {
    	
    	return $CI->email->print_debugger();
    }
}

function list_date() {

	$tgl1 = date('Y-m-d');// pendefinisian tanggal awal
	$tgl2 = date('Y-m-d', strtotime('+7 days', strtotime($tgl1)));

    $start    = new DateTime($tgl1);
	$end      = new DateTime($tgl2);
	$interval = DateInterval::createFromDateString('1 day');
	$period   = new DatePeriod($start, $interval, $end);

	// foreach ($period as $dt)
	// {
	//     echo $dt->format("l Y-m-d");
	//     echo "<br>";
	// }

	return $period;
}

function cek_hari($date)
{
	$daftar_hari = array(
		'Sunday' => 'Minggu',
		'Monday' => 'Senin',
		'Tuesday' => 'Selasa',
		'Wednesday' => 'Rabu',
		'Thursday' => 'Kamis',
		'Friday' => 'Jumat',
		'Saturday' => 'Sabtu'
	);
	$namahari = date('l', strtotime($date));

	return $daftar_hari[$namahari];
}

function kode_asset($inst,$jenis_kode)
{
	$CI =& get_instance();
	$urut = 1;
	$tot = $CI->db->get('asset')->num_rows();
	$urut = $tot+1;
	return $inst."-".$jenis_kode."-".sprintf("%03s", $urut);
}

function kode_urut()
{
	error_reporting(0);
	$CI =& get_instance();
	$CI->db->like('create_at', date('Y-m-d'), 'AFTER');
	$CI->db->order_by('no_antrian', 'desc');
	$no_antrian = $CI->db->get('antrian')->row()->no_antrian;
	$urutan = (int) substr($no_antrian, 3,3);
	$urutan++;

	$huruf = "ANT";
	$kode = $huruf. sprintf("%03s", $urutan);

	return $kode;

}

function hitung_umur($tgl_lahir)
{
	// tanggal lahir
	$tanggal = new DateTime($tgl_lahir);

	// tanggal hari ini
	$today = new DateTime('today');

	// tahun
	$y = $today->diff($tanggal)->y;

	// bulan
	$m = $today->diff($tanggal)->m;

	// hari
	$d = $today->diff($tanggal)->d;
	//echo "Umur: " . $y . " tahun " . $m . " bulan " . $d . " hari";

	return $y . " tahun " . $m . " bulan " . $d . " hari";
}

function total_modal_produk($no_penjualan)
{
	$CI =& get_instance();
	$modal = 0;

	foreach ($CI->db->get('penjualan_detail', array('no_penjualan'=>$no_penjualan))->result() as $rw) {
		$modal = $modal + ( modal_produk($rw->id_produk) * $rw->qty ) ;
	}
	return $modal;
}

function modal_produk($id_produk)
{
	$modal = get_data('produk','id_produk',$id_produk,'harga_beli');
	return $modal;
}

function total_stok($id_subkategori)
{
	$total = stok_display($id_subkategori) + stok_gudang($id_subkategori);
	return $total;
}

function stok_display($id_subkategori)
{
	$CI =& get_instance();
	$sql = "
	SELECT
		((COALESCE(SUM(in_qty),0) - COALESCE(SUM(out_qty),0)) ) AS stok_akhir 
	FROM
		stok_transfer
	WHERE
		id_subkategori='$id_subkategori'
		and milik='display';
	";
	$stok = $CI->db->query($sql)->row()->stok_akhir;
	return $stok;
}

function stok_gudang($id_subkategori)
{
	$CI =& get_instance();
	$sql = "
	SELECT
		((COALESCE(SUM(in_qty),0) - COALESCE(SUM(out_qty),0)) ) AS stok_akhir 
	FROM
		stok_transfer
	WHERE
		id_subkategori='$id_subkategori'
		and milik='gudang';
	";
	$stok = $CI->db->query($sql)->row()->stok_akhir;
	return $stok;
}

function cek_ppn($no_po)
{
	$cek = get_data('po_master','no_po',$no_po,'ppn');
	if ($cek == NULL) {
		$cek = 0;
	}
	return $cek;
}

function cek_return($n,$no)
{
	if ($n == '0') {
		return '<a href="app/ubah_return/'.$no.'" onclick="javasciprt: return confirm(\'Are You Sure ?\')"><label class="label label-info"><i class="fa fa-close"></i></label></a>';
	} else {
		return '<label class="label label-success"><i class="fa fa-check"></i></label>';
	}
}

// function create_random($length)
// {
//     $data = 'ABCDEFGHIJKLMNOPQRSTU1234567890';
//     $string = '';
//     for($i = 0; $i < $length; $i++) {
//         $pos = rand(0, strlen($data)-1);
//         $string .= $data{$pos};
//     }
//     return $string;
// }

function upload_gambar_biasa($nama_gambar, $lokasi_gambar, $tipe_gambar, $ukuran_gambar, $name_file_form)
{
    $CI =& get_instance();
    $nmfile = $nama_gambar."_".time();
    $config['upload_path'] = './'.$lokasi_gambar;
    $config['allowed_types'] = $tipe_gambar;
    $config['max_size'] = $ukuran_gambar;
    $config['file_name'] = $nmfile;
    // load library upload
    $CI->load->library('upload', $config);
    // upload gambar 1
    if ( ! $CI->upload->do_upload($name_file_form)) {
    	return $CI->upload->display_errors();
    } else {
	    $result1 = $CI->upload->data();
	    $result = array('gambar'=>$result1);
	    $dfile = $result['gambar']['file_name'];
	    
	    return $dfile;
	}	
}

function get_ph($no_po,$total_h)
{
	$CI =& get_instance();
	// log_r($total_h);
	// if ($total_h = '') {
	// 	$total_h = 0;
	// }
	$ph = $CI->db->get_where('po_master', array('no_po'=>$no_po))->row()->potongan_harga;
	$d_ph = explode(';', $ph);
	$t_h_now = $total_h;
	foreach ($d_ph as $key => $value) {
		if (strstr($value, '%')) {
			$t_persen = str_replace('%', '', $value) /100;
			$n_persen = $t_persen * $t_h_now;
			$t_h_now = $t_h_now - $n_persen;
		} else {
			$t_h_now = $t_h_now - floatval($value);
			// log_r($t_h_now);
		}
	}
	return $t_h_now;

}

function get_diskon_beli($diskon,$total_h)
{
	$CI =& get_instance();
	// log_r($total_h);
	// if ($total_h = '') {
	// 	$total_h = 0;
	// }
	$ph = $diskon;
	$d_ph = explode(';', $ph);
	$t_h_now = $total_h;
	foreach ($d_ph as $key => $value) {
		if (strstr($value, '%')) {
			$t_persen = str_replace('%', '', $value) /100;
			$n_persen = $t_persen * $t_h_now;
			$t_h_now = $t_h_now - $n_persen;
		} else {
			$t_h_now = $t_h_now - floatval($value);
			// log_r($t_h_now);
		}
	}
	return $t_h_now;

}


function get_waktu()
{
	date_default_timezone_set('Asia/Jakarta');
	return date('Y-m-d H:i:s');
}
function select_option($name, $table, $field, $pk, $selected = null,$class = null, $extra = null, $option_tamabahan = null) {
    $ci = & get_instance();
    $cmb = "<select name='$name' class='form-control $class  ' $extra>";
    $cmb .= $option_tamabahan;
    $data = $ci->db->get($table)->result();
    foreach ($data as $row) {
        $cmb .="<option value='" . $row->$pk . "'";
        $cmb .= $selected == $row->$pk ? 'selected' : '';
        $cmb .=">" . strtoupper($row->$field ). "</option>";
    }
    $cmb .= "</select>";
    return $cmb;
}

function get_setting($select)
{
	return 'Point Pintar';
}

function get_data($tabel,$primary_key,$id,$select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM $tabel where $primary_key='$id' ")->row_array();
	return $data[$select];
}

function get_produk($barcode,$select)
{
	$CI =& get_instance();
	$data = $CI->db->query("SELECT $select FROM produk where barcode1='$barcode' or barcode2='$barcode' ")->row_array();
	return $data[$select];
}



function alert_biasa($pesan,$type)
{
	return 'swal("'.$pesan.'", "You clicked the button!", "'.$type.'");';
}

function alert_tunggu($pesan,$type)
{
	return '
	swal("Silahkan Tunggu!", {
	  button: false,
	  icon: "info",
	});
	';
}

function selisih_waktu($start_date)
{
	date_default_timezone_set('Asia/Jakarta');
	$waktuawal  = date_create($start_date); //waktu di setting

	$waktuakhir = date_create(date('Y-m-d H:i:s')); //2019-02-21 09:35 waktu sekarang

	//Membandingkan
	$date1 = new DateTime($start_date);
	$date2 = new DateTime(date('Y-m-d H:i:s'));
	if ($date2 < $date1) {
	    $diff  = date_diff($waktuawal, $waktuakhir);
		return $diff->d . ' hari '.$diff->h . ' jam lagi ';
	} else {
		return 'berlangsung';
	}

	

	// echo 'Selisih waktu: ';

	// echo $diff->y . ' tahun, ';

	// echo $diff->m . ' bulan, ';

	// echo $diff->d . ' hari, ';

	// echo $diff->h . ' jam, ';

	// echo $diff->i . ' menit, ';

	// echo $diff->s . ' detik, ';
}



function filter_string($n)
{
	$hasil = str_replace('"', "'", $n);
	return $hasil;
}

function cek_nilai_lulus()
{	
	$CI 	=& get_instance();
	$nilai = $CI->db->query("SELECT sum(nilai_lulus) as lulus FROM mapel ")->row()->lulus;
	return $nilai;
}



function log_r($string = null, $var_dump = false)
    {
        if ($var_dump) {
            var_dump($string);
        } else {
            echo "<pre>";
            print_r($string);
        }
        exit;
    }

    function log_data($string = null, $var_dump = false)
    {
        if ($var_dump) {
            var_dump($string);
        } else {
            echo "<pre>";
            print_r($string);
        }
        // exit;
    }