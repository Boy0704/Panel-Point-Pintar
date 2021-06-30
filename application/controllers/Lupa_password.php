<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Lupa_password extends CI_Controller {

	public function index()
	{
		$data['view'] = 'form';
		$this->load->view('lupa_password', $data);
	}

	public function aksi()
	{
		$email = $this->input->post('email');

		$this->db->where('email', $email);
		$cek = $this->db->get('users');
		if ($cek->num_rows() > 0) {

			$password = $cek->row()->password;

			$content = "<p>Silahkan login dengan password berikut.</p>
						<br>
						<center><h4>$password</h4></center>";

			require APPPATH . '/libraries/class.phpmailer.php';
			$mail = new PHPMailer;
			$mail->IsSMTP();
			$mail->SMTPSecure = 'ssl';
			$mail->Host = 'mail.lsisptpn3.com'; //host masing2 provider email
			$mail->SMTPDebug = 0;
			$mail->Port = '465';
			$mail->SMTPAuth = true;
			$mail->Username = 'admin@lsisptpn3.com'; //user email
			$mail->Password = '123456'; //password email 
			$mail->SetFrom('admin@lsisptpn3.com', 'LSIS APPS'); //set email pengirim
			$mail->Subject = "Permintaan Resend Password"; //subyek email
			$mail->AddAddress($email, "User");  //tujuan email
			$mail->MsgHTML($content); //pesan dapat berupa html
			$mail->Send();

			?>
			<script type="text/javascript">
				WebAppInterface.showToast("Password sudah dikirim ke email anda !");
				window.location="<?php echo base_url() ?>lupa_password/berhasil";
			</script>
			<?php
		} else {
			?>
			<script type="text/javascript">
				WebAppInterface.showToast("Email kamu tidak ditemukan !");
				WebAppInterface.vibrate(1000);
				window.location="<?php echo base_url() ?>lupa_password";
			</script>
			<?php
		}
	}

	public function berhasil()
	{
		$data['view'] = 'berhasil';
		$this->load->view('lupa_password', $data);
	}

}

/* End of file Lupa_password.php */
/* Location: ./application/controllers/Lupa_password.php */