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

}

/* End of file Web.php */
/* Location: ./application/controllers/Web.php */