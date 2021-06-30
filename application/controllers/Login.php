<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	
	public function index() 
	{
		$this->load->view('login');
	}

	public function aksi_login()
	{
			$username = $this->input->post('username');
			$password = md5($this->input->post('password'));

			// $hashed = '$2y$10$LO9IzV0KAbocIBLQdgy.oeNDFSpRidTCjXSQPK45ZLI9890g242SG';

			if ($username == 'admin') {
				$cek_user = $this->db->query("SELECT * FROM a_user WHERE username='$username' and password='$password' ");
			} else {
				$password = $this->input->post('password');
				$cek_user = $this->db->query("SELECT * FROM users WHERE username='$username' and password='$password' ");
			}
			
			// if (password_verify($password, $hashed)) {
			if ($cek_user->num_rows() > 0) {

				if ($username == 'admin') {
					foreach ($cek_user->result() as $row) {
					
	                    $sess_data['id_user'] = $row->id_user;
						$sess_data['nama'] = $row->nama_lengkap;
						$sess_data['username'] = $row->username;
						$sess_data['foto'] = $row->foto;
						$sess_data['level'] = $row->level;
						$this->session->set_userdata($sess_data);
					}
				} else {
					if ($cek_user->row()->id_level == '6' || $cek_user->row()->id_level == '9') {
						foreach ($cek_user->result() as $row) {
					
		                    $sess_data['id_user'] = $row->id_user;
							$sess_data['nama'] = $row->nama;
							$sess_data['username'] = $row->username;
							$sess_data['foto'] = $row->foto;
							$sess_data['level'] = 'user';
							$this->session->set_userdata($sess_data);
						}
					} else {
						$this->session->set_flashdata('message', alert_biasa('kamu tidak memiliki akses','warning'));
						// $this->session->set_flashdata('message', alert_tunggu('Gagal Login!\n username atau password kamu salah','warning'));
						redirect('login','refresh');
					}
				}
				

				// define('FOTO', $this->session->userdata('foto'), TRUE);
				

				// print_r($this->session->userdata());
				// exit;
				// $sess_data['username'] = $username;
				// $this->session->set_userdata($sess_data);
				if ($this->session->userdata('level') == 'admin') {
					redirect('app','refresh');
				// 	echo 'Server TimeOut';
				} elseif ($this->session->userdata('level') == 'user') {
					redirect('app','refresh');
				}

				// redirect('app/index');
			} else {
				$this->session->set_flashdata('message', alert_biasa('Gagal Login!\n username atau password kamu salah','warning'));
				// $this->session->set_flashdata('message', alert_tunggu('Gagal Login!\n username atau password kamu salah','warning'));
				redirect('login','refresh');
			}
	}

	

	function logout()
	{
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('level');
		session_destroy();
		redirect('login','refresh');
	}
}
