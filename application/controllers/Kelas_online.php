<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kelas_online extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Kelas_online_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kelas_online/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kelas_online/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kelas_online/index.html';
            $config['first_url'] = base_url() . 'kelas_online/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kelas_online_model->total_rows($q);
        $kelas_online = $this->Kelas_online_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kelas_online_data' => $kelas_online,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => "Kelas Online",
            'konten' => 'kelas_online/kelas_online_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Kelas_online_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_kelas' => $row->id_kelas,
		'id_fitur' => $row->id_fitur,
		'nama_kelas' => $row->nama_kelas,
		'materi' => $row->materi,
		'waktu' => $row->waktu,
		'link' => $row->link,
	    );
            $this->load->view('kelas_online/kelas_online_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelas_online'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'kelas_online/kelas_online_form',
            'konten' => 'kelas_online/kelas_online_form',
            'button' => 'Create',
            'action' => site_url('kelas_online/create_action'),
	    'id_kelas' => set_value('id_kelas'),
	    'id_fitur' => set_value('id_fitur'),
	    'nama_kelas' => set_value('nama_kelas'),
	    'materi' => set_value('materi'),
	    'waktu' => set_value('waktu'),
	    'link' => set_value('link'),
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
		'id_fitur' => $this->input->post('id_fitur',TRUE),
		'nama_kelas' => $this->input->post('nama_kelas',TRUE),
		'materi' => $this->input->post('materi',TRUE),
		'waktu' => $this->input->post('waktu',TRUE),
		'link' => $this->input->post('link',TRUE),
	    );

            $this->Kelas_online_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kelas_online').'?'.param_get());
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kelas_online_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'kelas_online/kelas_online_form',
                'konten' => 'kelas_online/kelas_online_form',
                'button' => 'Update',
                'action' => site_url('kelas_online/update_action'),
		'id_kelas' => set_value('id_kelas', $row->id_kelas),
		'id_fitur' => set_value('id_fitur', $row->id_fitur),
		'nama_kelas' => set_value('nama_kelas', $row->nama_kelas),
		'materi' => set_value('materi', $row->materi),
		'waktu' => set_value('waktu', $row->waktu),
		'link' => set_value('link', $row->link),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelas_online').'?'.param_get());
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kelas', TRUE));
        } else {
            $data = array(
		'id_fitur' => $this->input->post('id_fitur',TRUE),
		'nama_kelas' => $this->input->post('nama_kelas',TRUE),
		'materi' => $this->input->post('materi',TRUE),
		'waktu' => $this->input->post('waktu',TRUE),
		'link' => $this->input->post('link',TRUE),
	    );

            $this->Kelas_online_model->update($this->input->post('id_kelas', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kelas_online').'?'.param_get());
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kelas_online_model->get_by_id($id);

        if ($row) {
            $this->Kelas_online_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kelas_online').'?'.param_get());
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kelas_online').'?'.param_get());
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_fitur', 'id fitur', 'trim|required');
	$this->form_validation->set_rules('nama_kelas', 'nama kelas', 'trim|required');
	$this->form_validation->set_rules('materi', 'materi', 'trim|required');
	$this->form_validation->set_rules('waktu', 'waktu', 'trim|required');
	$this->form_validation->set_rules('link', 'link', 'trim|required');

	$this->form_validation->set_rules('id_kelas', 'id_kelas', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Kelas_online.php */
/* Location: ./application/controllers/Kelas_online.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-06-30 10:41:24 */
/* https://jualkoding.com */