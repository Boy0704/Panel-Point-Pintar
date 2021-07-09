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

    public function menu_home_get()
    {
        $this->db->order_by('id_fitur', 'desc');
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