<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kategori_ebook extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_ebook_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kategori_ebook/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kategori_ebook/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kategori_ebook/index.html';
            $config['first_url'] = base_url() . 'kategori_ebook/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kategori_ebook_model->total_rows($q);
        $kategori_ebook = $this->Kategori_ebook_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kategori_ebook_data' => $kategori_ebook,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'kategori_ebook/kategori_ebook_list',
            'konten' => 'kategori_ebook/kategori_ebook_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Kategori_ebook_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_kategori' => $row->id_kategori,
		'nama_kategori' => $row->nama_kategori,
		'id_fitur' => $row->id_fitur,
	    );
            $this->load->view('kategori_ebook/kategori_ebook_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kategori_ebook'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'kategori_ebook/kategori_ebook_form',
            'konten' => 'kategori_ebook/kategori_ebook_form',
            'button' => 'Create',
            'action' => site_url('kategori_ebook/create_action'),
	    'id_kategori' => set_value('id_kategori'),
	    'nama_kategori' => set_value('nama_kategori'),
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
		'nama_kategori' => $this->input->post('nama_kategori',TRUE),
		'id_fitur' => $this->input->post('id_fitur',TRUE),
	    );

            $this->Kategori_ebook_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kategori_ebook').'?'.param_get());
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kategori_ebook_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'kategori_ebook/kategori_ebook_form',
                'konten' => 'kategori_ebook/kategori_ebook_form',
                'button' => 'Update',
                'action' => site_url('kategori_ebook/update_action'),
		'id_kategori' => set_value('id_kategori', $row->id_kategori),
		'nama_kategori' => set_value('nama_kategori', $row->nama_kategori),
		'id_fitur' => set_value('id_fitur', $row->id_fitur),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kategori_ebook').'?'.param_get());
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kategori', TRUE));
        } else {
            $data = array(
		'nama_kategori' => $this->input->post('nama_kategori',TRUE),
		'id_fitur' => $this->input->post('id_fitur',TRUE),
	    );

            $this->Kategori_ebook_model->update($this->input->post('id_kategori', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kategori_ebook').'?'.param_get());
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kategori_ebook_model->get_by_id($id);

        if ($row) {
            $this->Kategori_ebook_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kategori_ebook').'?'.param_get());
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kategori_ebook').'?'.param_get());
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nama_kategori', 'nama kategori', 'trim|required');
	$this->form_validation->set_rules('id_fitur', 'id fitur', 'trim|required');

	$this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Kategori_ebook.php */
/* Location: ./application/controllers/Kategori_ebook.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-06-30 15:53:48 */
/* https://jualkoding.com */