<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Notif_model extends CI_Model {

public function send_notif_topup($title, $id, $message, $method, $token)
{

	$data = array(
	  'title' => $title,
	  'id' => $id,
	  'message' => $message,
	  'method' => $method,
	  'type' => 3
	);
	$senderdata = array(
	  'data' => $data,
	  'to' => $token

	);

	$headers = array(
	  'Content-Type : application/json',
	  'Authorization: key=' . keyfcm
	);
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => json_encode($senderdata),
	  CURLOPT_HTTPHEADER => $headers,
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);
	return "1"; //$response;
}

	public function send_notif($title, $message, $topic)
	{

		$data = array(
		  'title' => $title,
		  'message' => $message,
		  'type' => 4
		);
		$senderdata = array(
		  'data' => $data,
		  'to' => '/topics/' . $topic
		);

		$headers = array(
		  'Content-Type : application/json',
		  'Authorization: key=' . keyfcm
		);
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($senderdata),
		  CURLOPT_HTTPHEADER => $headers,
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);
		return $response;
		// return "1";//$response;
	}

}

/* End of file Notif_model.php */
/* Location: ./application/models/Notif_model.php */