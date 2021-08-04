<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fitur extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Fitur_model');
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
            $config['base_url'] = base_url() . 'fitur/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'fitur/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'fitur/index.html';
            $config['first_url'] = base_url() . 'fitur/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Fitur_model->total_rows($q);
        $fitur = $this->Fitur_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'fitur_data' => $fitur,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'fitur/fitur_list',
            'konten' => 'fitur/fitur_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Fitur_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_fitur' => $row->id_fitur,
		'fitur' => $row->fitur,
		'logo' => $row->logo,
		'keterangan' => $row->keterangan,
	    );
            $this->load->view('fitur/fitur_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('fitur'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'fitur/fitur_form',
            'konten' => 'fitur/fitur_form',
            'button' => 'Create',
            'action' => site_url('fitur/create_action'),
	    'id_fitur' => set_value('id_fitur'),
	    'fitur' => set_value('fitur'),
	    'logo' => set_value('logo'),
	    'keterangan' => set_value('keterangan'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $img = upload_gambar_biasa('logo', 'image/logo/', 'jpg|png|jpeg', 10000, 'logo');

            $data = array(
		'fitur' => $this->input->post('fitur',TRUE),
		'logo' => $img,
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Fitur_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('fitur'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Fitur_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'fitur/fitur_form',
                'konten' => 'fitur/fitur_form',
                'button' => 'Update',
                'action' => site_url('fitur/update_action'),
		'id_fitur' => set_value('id_fitur', $row->id_fitur),
		'fitur' => set_value('fitur', $row->fitur),
		'logo' => set_value('logo', $row->logo),
		'keterangan' => set_value('keterangan', $row->keterangan),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('fitur'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_fitur', TRUE));
        } else {
            $data = array(
		'fitur' => $this->input->post('fitur',TRUE),
		'logo' => $retVal = ($_FILES['logo']['name'] == '') ? $_POST['logo_old'] : upload_gambar_biasa('logo', 'image/logo/', 'jpg|png|jpeg', 10000, 'logo'),
		'keterangan' => $this->input->post('keterangan',TRUE),
	    );

            $this->Fitur_model->update($this->input->post('id_fitur', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('fitur'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Fitur_model->get_by_id($id);

        if ($row) {
            $this->Fitur_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('fitur'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('fitur'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('fitur', 'fitur', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

	$this->form_validation->set_rules('id_fitur', 'id_fitur', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Fitur.php */
/* Location: ./application/controllers/Fitur.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-06-29 04:04:29 */
/* https://jualkoding.com */