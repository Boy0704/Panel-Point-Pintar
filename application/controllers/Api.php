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
                'id_level' => $users->id_level,
                'level' => get_data('level','id_level',$users->id_level,'level'),
                'jabatan' => $users->jabatan,
                'foto' => $users->foto,
                'token' => $users->token,
                'status_gps' => $users->status_gps
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

    
    public function proses_absen_post()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header("WWW-Authenticate: Basic realm=\"Private Area\"");
            header("HTTP/1.0 401 Unauthorized");
            return false;
        }

        $data = file_get_contents("php://input");
        $decoded_data = json_decode($data);

        $originlat = $decoded_data->lat;
        $originlng = $decoded_data->lng;

        // hitung jarak
        // disediakan jarak adalah in M. Jika anda perlu Kilometer, menggunakan 6371 bukan 3959.
        $sql = "SELECT
                    (
                        3959 * acos(
                            cos( radians( $originlat ) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians( $originlng ) ) + sin( radians( $originlat ) ) * sin( radians( lat ) ) 
                        ) 
                    ) AS distance 
                FROM
                    setting
                HAVING distance <= 1
                 ";

        $jarak = $this->db->query($sql);
        if ($jarak->num_rows() == 0) {
            $condition = array('data'=>"kosong");
            $message = array(
                'kode' => '404',
                'message' => 'Lokasi anda bukan dikampus !',
                'data' => [$condition]
            );
            echo json_encode($message);
            exit();
        }

        $image = $decoded_data->foto;
        $namafoto = time() . '-' . rand(0, 99999) . ".jpg";
        $path = "image/absensi/" . $namafoto;
        file_put_contents($path, base64_decode($image));

        $simpan = $this->db->insert('absensi', array(
            'id_user' => $decoded_data->id_user,
            'created_at' => get_waktu(),
            'lat' => $decoded_data->lat,
            'lng' => $decoded_data->lng,
            'foto' => $namafoto
        ));

        if ($simpan) {
            $condition = array('status_absen'=>'1');
            $message = array(
                'kode' => '200',
                'message' => 'Anda berhasil absen hari ini.',
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


    public function absensi_get()
    {
        $this->db->order_by('id_absen', 'desc');
        $absen = $this->db->get('absensi');
        $data = array();
        foreach ($absen->result() as $rw) {
            array_push($data, array(
                'nama' => get_data('users','id_user',$rw->id_user,'nama'),
                'jabatan' => get_data('users','id_user',$rw->id_user,'jabatan'),
                'foto' => $rw->foto,
                'waktu' => time_since($rw->created_at)

            ));
        }
        $message = array(
            'data' => $data
        );

        $this->response($message, 200);
    }

    public function absensi_home_get()
    {
        $this->db->order_by('id_absen', 'desc');
        $this->db->like('create_at', date('Y-m-d', 'after');
        $this->db->limit(5);
        $absen = $this->db->get('absensi');
        $data = array();
        foreach ($absen->result() as $rw) {
            array_push($data, array(
                'nama' => get_data('users','id_user',$rw->id_user,'nama'),
                'jabatan' => get_data('users','id_user',$rw->id_user,'jabatan'),
                'foto' => $rw->foto,
                'waktu' => time_since($rw->created_at)

            ));
        }
        $message = array(
            'data' => $data
        );

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