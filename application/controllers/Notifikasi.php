<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Notif_model');
	}

	public function index()
	{
		echo $this->Notif_model->send_notif("Hallo tes", "Hallo ini tes aja !", "customer");
		// $this->send_notif_topup("Hallo Boy", "1", "in saya tes aja boy", "1", "f8B8GFVlSd6BnzqvrcqPvF:APA91bF5WWUMkhNhQJiGwNZlZgWcTWnmCBR99Adxmo_WRWfxrb0qOChRnvJOcQndbTa6mhIHfAhZS3wOhzgyAYpyDZS4MfQ6pxvsd3Afj0oFRZJNInShqrbefDLYDRe-nU82ish8FJt2");
	}

	

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */
 ?>