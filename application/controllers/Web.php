<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller {

	public function index()
	{
		$this->load->view('front/index');
	}

	public function berlangganan()
	{
		$this->load->view('front/berlangganan');
	}

	public function transaksi($id_user,$id_berlangganan)
	{
		$this->db->where('id_berlangganan', $id_berlangganan);
		$berlangganan = $this->db->get('berlangganan')->row();
		$total_bayar = $berlangganan->harga + kode_unik();

		$data = array(
			'no_transaksi' => kode_urut(),
			'id_user' => $id_user,
			'id_berlangganan' => $id_berlangganan,
			'id_fitur' =>  $berlangganan->id_fitur,
			'total_bayar' => $total_bayar,
			'created_at' =>get_waktu()
		);
		$this->db->insert('transaksi', $data);
		redirect("web/berlangganan/".$id_user);
	}

}

/* End of file Web.php */
/* Location: ./application/controllers/Web.php */