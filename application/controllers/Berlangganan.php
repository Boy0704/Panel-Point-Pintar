<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Berlangganan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Berlangganan_model');
        $this->load->library('form_validation');
        if ($this->session->userdata('level') == '') {
            redirect('login');
        }
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'berlangganan/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'berlangganan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'berlangganan/index.html';
            $config['first_url'] = base_url() . 'berlangganan/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Berlangganan_model->total_rows($q);
        $berlangganan = $this->Berlangganan_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'berlangganan_data' => $berlangganan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Harga Berlangganan',
            'konten' => 'berlangganan/berlangganan_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Berlangganan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_langganan' => $row->id_langganan,
		'judul' => $row->judul,
		'detail' => $row->detail,
		'harga' => $row->harga,
		'id_fitur' => $row->id_fitur,
	    );
            $this->load->view('berlangganan/berlangganan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('berlangganan'));
        }
    }

    public function create() 
    {
        $detail = "
            <ul>
                <li>100 Paket Try Out</li>
                <li>100 Paket Latihan</li>
              </ul>
        ";
        $data = array(
            'judul_page' => 'Tambah',
            'konten' => 'berlangganan/berlangganan_form',
            'button' => 'Create',
            'action' => site_url('berlangganan/create_action'),
	    'id_langganan' => set_value('id_langganan'),
	    'judul' => set_value('judul'),
	    'detail' => $detail,
        'harga' => set_value('harga'),
	    'periode' => set_value('periode'),
	    'id_fitur' => set_value('id_fitur'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'judul' => $this->input->post('judul',TRUE),
		'detail' => $this->input->post('detail'),
        'harga' => $this->input->post('harga',TRUE),
		'periode' => $this->input->post('periode',TRUE),
		'id_fitur' => $this->input->post('id_fitur',TRUE),
	    );

            $this->Berlangganan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('berlangganan?'.param_get()));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Berlangganan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Ubah',
                'konten' => 'berlangganan/berlangganan_form',
                'button' => 'Update',
                'action' => site_url('berlangganan/update_action'),
		'id_langganan' => set_value('id_langganan', $row->id_langganan),
		'judul' => set_value('judul', $row->judul),
		'detail' => set_value('detail', $row->detail),
        'harga' => set_value('harga', $row->harga),
		'periode' => set_value('periode', $row->periode),
		'id_fitur' => set_value('id_fitur', $row->id_fitur),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('berlangganan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_langganan', TRUE));
        } else {
            $data = array(
		'judul' => $this->input->post('judul',TRUE),
		'detail' => $this->input->post('detail',TRUE),
        'harga' => $this->input->post('harga',TRUE),
		'periode' => $this->input->post('periode',TRUE),
		'id_fitur' => $this->input->post('id_fitur',TRUE),
	    );

            $this->Berlangganan_model->update($this->input->post('id_langganan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('berlangganan?'.param_get()));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Berlangganan_model->get_by_id($id);

        if ($row) {
            $this->Berlangganan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('berlangganan?'.param_get()));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('berlangganan?'.param_get()));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('judul', 'judul', 'trim|required');
	$this->form_validation->set_rules('harga', 'harga', 'trim|required');
	// $this->form_validation->set_rules('id_fitur', 'id fitur', 'trim|required');

	$this->form_validation->set_rules('id_langganan', 'id_langganan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Berlangganan.php */
/* Location: ./application/controllers/Berlangganan.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-08-03 11:17:23 */
/* https://jualkoding.com */