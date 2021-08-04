<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notif_model');
    }

    
	
	public function index()
	{
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        
		$data = array(
			'konten' => 'home_admin',
            'judul_page' => 'Dashboard',
		);
		$this->load->view('v_index', $data);
    }

    public function kelas()
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        
        $data = array(
            'konten' => 'app/kelas',
            'judul_page' => 'Kelas Online',
        );
        $this->load->view('v_index', $data);
    }

    public function ebook()
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        
        $data = array(
            'konten' => 'app/ebook',
            'judul_page' => 'Ebook',
        );
        $this->load->view('v_index', $data);
    }

    public function video()
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        
        $data = array(
            'konten' => 'app/video',
            'judul_page' => 'Video',
        );
        $this->load->view('v_index', $data);
    }

    public function ujian_online()
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        
        $data = array(
            'konten' => 'app/ujian_online',
            'judul_page' => 'Ujian Online',
        );
        $this->load->view('v_index', $data);
    }

    public function berlangganan()
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        
        $data = array(
            'konten' => 'app/berlangganan',
            'judul_page' => 'Master Berlangganan',
        );
        $this->load->view('v_index', $data);
    }

    public function transaksi()
    {
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
        
        $data = array(
            'konten' => 'app/transaksi',
            'judul_page' => 'Transaksi',
        );
        $this->load->view('v_index', $data);
    }

    public function status_lunas($id_trx)
    {
        $id_user = get_data('transaksi','id_transaksi',$id_trx,'id_user');
        $this->db->where('id_transaksi', $id_trx);
        $this->db->update('transaksi', ['status_lunas'=>'y','updated_at'=>get_waktu()]);
        $this->db->where('id_user', $id_user);
        $this->db->update('users', ['jenis_akun'=>'premium']);
        ?>
        <script type="text/javascript">
            alert("data berhasil di update !");
            window.location="<?php echo base_url() ?>app/transaksi";
        </script>
        <?php
    }

    public function hapus_trx($id_trx)
    {
        $this->db->where('id_transaksi', $id_trx);
        $this->db->delete('transaksi');
        ?>
        <script type="text/javascript">
            alert("data berhasil di hapus !");
            window.location="<?php echo base_url() ?>app/transaksi";
        </script>
        <?php
    }


    

}
