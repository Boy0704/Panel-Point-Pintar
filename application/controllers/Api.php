<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Api extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notif_model');
    }

	public function index_get()
	{
		$id = $this->get('id');
        $kontak = array(
        	"nama" => "By dsf",
        	"jk" => "sdff"
        );
        $this->response($kontak, 502);
	}

    public function slide_get()
    {
        $this->db->order_by('id_slide', 'desc');
        $slide = $this->db->get('slide');
        $data = array();
        foreach ($slide->result() as $rw) {
            array_push($data, array(
                'id_slide' => $rw->id_slide,
                'slide' => $rw->slide,
            ));
        }
        $message = array(
            'data' => $data
        );

        $this->response($message, 200);
    }

    public function menu_home_get()
    {
        $this->db->order_by('id_fitur', 'asc');
        $fitur = $this->db->get('fitur');
        $data = array();
        foreach ($fitur->result() as $rw) {
            array_push($data, array(
                'id_menu' => $rw->id_fitur,
                'menu' => $rw->fitur,
                'icon_menu' => $rw->logo,
                'keterangan_menu' => $rw->keterangan,

            ));
        }
        $message = array(
            'data' => $data
        );

        $this->response($message, 200);
    }

	public function login_post()
	{
		if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $this->db->where('username', $decoded_data->username);
        $this->db->where('password', $decoded_data->password);
        $user = $this->db->get('users');
        if ($user->num_rows() > 0) {
            $users = $user->row(); 

            $this->db->where('token', $decoded_data->token);
            $cek_token = $this->db->get('users');
            if ($cek_token->num_rows() > 0) {
                $this->db->where('token', $decoded_data->token);
                $this->db->update('users', array('token' => ''));
            }

            $this->db->where('id_user', $users->id_user);
            $this->db->update('users', array('token'=>$decoded_data->token));
            $condition = array(
                'id_user' => $users->id_user,
                'nama' => $users->nama,
                'username' => $users->username,
                'password' => $users->password,
                'jenis_akun' => $users->jenis_akun,
                'foto' => $users->foto,
                'token' => $users->token
            );
            if ($users->status_login == '1') {
                $this->db->where('id_user', $users->id_user);
                $this->db->update('users', array('status_login'=>'2'));
                $message = array(
                    'kode' => '200',
                    'message' => 'berhasil',
                    'data' => [$condition]
                );
            } else {
                $condition = array('data'=>"kosong");
                $message = array(
                    'kode' => '404',
                    'message' => 'Akun anda sedang login diperangkat lain',
                    'data' => [$condition]
                );
            }
            
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'Akun login tidak di temukan !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
		
	}

    public function register_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);
        $data = array(
            'nama' => $decoded_data->nama,
            'username' => $decoded_data->username,
            'password' => $decoded_data->password,
        );
        $user = $this->db->insert('users', $data);
        $condition = array('daftar'=>'berhasil');
        $message = array(
            'kode' => '200',
            'message' => 'Pendaftaran Berhasil Silahkan Login !',
            'data' => [$condition]
        );

        $this->response($message, 200);
        
    }

    public function logout_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $this->db->where('id_user', $decoded_data->id_user);
        $update = $this->db->update('users', array('status_login'=>'1'));
        if ($update) {
            $condition = array('status_login'=>'1');
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => [$condition]
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }

    
    


    public function kelas_online_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $this->db->where('id_fitur', $decoded_data->id_menu);
        $kelas_online = $this->db->get('kelas_online');
        $data = array();
        foreach ($kelas_online->result() as $rw) {
            array_push($data, array(
                'nama_kelas' => $rw->nama_kelas,
                'materi' => $rw->materi,
                'waktu' => $rw->waktu,
                'link' => $rw->link,
                'akses' => $rw->akses,

            ));
        }

        if ($kelas_online) {
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => $data
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }

    public function kat_ebook_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $this->db->where('id_fitur', $decoded_data->id_menu);
        $ebook = $this->db->get('kategori_ebook');
        $data = array();
        foreach ($ebook->result() as $rw) {
            array_push($data, array(
                'id_kategori' => $rw->id_kategori,
                'nama_kategori' => $rw->nama_kategori,
                'total' => total_kat($rw->id_kategori,'ebook'),
            ));
        }

        if ($ebook) {
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => $data
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }

    public function kat_video_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $this->db->where('id_fitur', $decoded_data->id_menu);
        $video = $this->db->get('kategori_video');
        $data = array();
        foreach ($video->result() as $rw) {
            array_push($data, array(
                'id_kategori' => $rw->id_kategori,
                'nama_kategori' => $rw->nama_kategori,
                'total' => total_kat($rw->id_kategori,'video'),
            ));
        }

        if ($video) {
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => $data
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }

    public function ebook_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $id_fitur = get_data('kategori_ebook','id_kategori',$decoded_data->id_kategori,'id_fitur');

        $this->db->where('id_user', $decoded_data->id_user);
        $this->db->where('id_fitur', $id_fitur);
        $akses_user = $this->db->get('transaksi');
        if ($akses_user->num_rows() > 0) {
            if ( strtotime($akses_user->row()->batas_waktu) > strtotime(date('Y-m-d')) ) {
                $user_akses = 'y';
            } else {
                $user_akses = 't';
            }
        } else {
            $user_akses = 't';
        }

        $this->db->where('id_kategori', $decoded_data->id_kategori);
        $video = $this->db->get('ebook');
        $data = array();
        foreach ($video->result() as $rw) {
            array_push($data, array(
                'judul' => $rw->judul,
                'link' => $rw->link,
                'akses' => $rw->akses,
                'user_akses' => $user_akses
            ));
        }

        if ($video) {
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => $data
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }

    public function video_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $this->db->where('id_kategori', $decoded_data->id_kategori);
        $video = $this->db->get('video');
        $data = array();
        foreach ($video->result() as $rw) {
            array_push($data, array(
                'judul' => $rw->judul,
                'link' => $rw->link,
                'akses' => $rw->akses,
            ));
        }

        if ($video) {
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => $data
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }

    public function paket_soal_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);


        $this->db->where('id_user', $decoded_data->id_user);
        $this->db->where('id_fitur', $decoded_data->id_fitur);
        $akses_user = $this->db->get('transaksi');
        if ($akses_user->num_rows() > 0) {
            if ( strtotime($akses_user->row()->batas_waktu) > strtotime(date('Y-m-d')) ) {
                $user_akses = 'y';
            } else {
                $user_akses = 't';
            }
        } else {
            $user_akses = 't';
        }

        $this->db->where('id_fitur', $decoded_data->id_fitur);
        $this->db->where('jenis_soal', $decoded_data->jenis_soal);
        $paket_soal = $this->db->get('paket_soal');
        $data = array();
        foreach ($paket_soal->result() as $rw) {
            array_push($data, array(
                'id_paket_soal' => $rw->id_paket_soal,
                'nama_soal' => $rw->nama_soal,
                'type_soal' => $rw->type_soal,
                'waktu' => $rw->waktu,
                'keterangan' => $rw->keterangan,
                'jenis_soal' => $rw->jenis_soal,
                'point_salah' => $rw->point_salah,
                'point_benar' => $rw->point_benar,
                'target_point' => $rw->target_point,
                'user_akses' => $user_akses
            ));
        }

        if ($paket_soal) {
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => $data
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }

    public function pembahasan_soal_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $this->db->where('id_user', $decoded_data->id_user);
        $this->db->where('id_paket', $decoded_data->id_paket);
        $this->db->where('status', '1');
        $skor = $this->db->get('skor');
        $data = array();
        foreach ($skor->result() as $rw) {
            $total_point = $this->db->query("SELECT sum(nilai) as total from skor_detail where id_skor='$rw->id_skor' ")->row()->total;
            array_push($data, array(
                'id_skor' => $rw->id_skor,
                'nama_soal' => get_data('paket_soal','id_paket_soal',$rw->id_paket,'nama_soal'),
                'waktu_selesai' => $rw->waktu_selesai,
                'total_point' => $total_point,
            ));
        }

        if ($skor) {
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => $data
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }

    public function selesai_soal_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $this->db->where('id_user', $decoded_data->id_user);
        $this->db->where('id_paket', $decoded_data->id_paket);
        $this->db->order_by('id_skor', 'desc');
        $skor = $this->db->get('skor')->row();
        $this->db->where('id_skor', $skor->id_skor);
        $update = $this->db->update('skor', array('waktu_selesai'=>get_waktu(), 'status'=>'1'));
        if ($update) {
            $condition = array('status_selesai'=>'1');
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => [$condition]
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }



    public function edit_profil_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $image = $decoded_data->foto;
        $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
        $path = "image/user/" . $namafoto;
        file_put_contents($path, base64_decode($image));

        $this->db->where('id_user', $decoded_data->id_user);
        $update =  $this->db->update('users', array(
            'nama' => $decoded_data->nama,
            'username' => $decoded_data->username,
            'password' => ($decoded_data->password == '') ? $decoded_data->password_old : $decoded_data->password,
            'foto' => ($decoded_data->foto == '') ? $decoded_data->foto_old : $namafoto,
        ));
        if ($update) {
            $condition = array('id_user'=>$decoded_data->id_user);
            $message = array(
                'kode' => '200',
                'message' => 'berhasil',
                'data' => [$condition]
            );
        } else {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'gagal !',
                'data' => [$condition]
            );
        }

        $this->response($message, 200);
    }

    

   




}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */