<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paket_soal extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Paket_soal_model');
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
            $config['base_url'] = base_url() . 'paket_soal/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'paket_soal/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'paket_soal/index.html';
            $config['first_url'] = base_url() . 'paket_soal/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Paket_soal_model->total_rows($q);
        $paket_soal = $this->Paket_soal_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'paket_soal_data' => $paket_soal,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'Paket Soal',
            'konten' => 'paket_soal/paket_soal_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Paket_soal_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_paket_soal' => $row->id_paket_soal,
		'nama_soal' => $row->nama_soal,
		'waktu' => $row->waktu,
		'keterangan' => $row->keterangan,
		'jenis_soal' => $row->jenis_soal,
		'id_fitur' => $row->id_fitur,
	    );
            $this->load->view('paket_soal/paket_soal_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_soal'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Tambah Paket Soal',
            'konten' => 'paket_soal/paket_soal_form',
            'button' => 'Create',
            'action' => site_url('paket_soal/create_action'),
	    'id_paket_soal' => set_value('id_paket_soal'),
        'nama_soal' => set_value('nama_soal'),
	    'type_soal' => set_value('type_soal'),
        'waktu' => set_value('waktu'),
        'point_salah' => set_value('point_salah'),
        'point_benar' => set_value('point_benar'),
	    'target_point' => set_value('target_point'),
	    'keterangan' => set_value('keterangan'),
	    'jenis_soal' => set_value('jenis_soal'),
	    'id_fitur' => $this->input->get('id_fitur'),
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
        'nama_soal' => $this->input->post('nama_soal',TRUE),
		'type_soal' => $this->input->post('type_soal',TRUE),
        'waktu' => $this->input->post('waktu',TRUE),
        'point_benar' => $this->input->post('point_benar',TRUE),
        'point_salah' => $this->input->post('point_salah',TRUE),
		'target_point' => $this->input->post('target_point',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'jenis_soal' => $this->input->post('jenis_soal',TRUE),
		'id_fitur' => $this->input->post('id_fitur',TRUE),
	    );

            $this->Paket_soal_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('paket_soal?'.param_get()));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Paket_soal_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Ubah Paket Soal',
                'konten' => 'paket_soal/paket_soal_form',
                'button' => 'Update',
                'action' => site_url('paket_soal/update_action'),
		'id_paket_soal' => set_value('id_paket_soal', $row->id_paket_soal),
        'nama_soal' => set_value('nama_soal', $row->nama_soal),
		'type_soal' => set_value('type_soal', $row->type_soal),
        'waktu' => set_value('waktu', $row->waktu),
        'point_salah' => set_value('point_salah', $row->point_salah),
        'point_benar' => set_value('point_benar', $row->point_benar),
		'target_point' => set_value('target_point', $row->target_point),
		'keterangan' => set_value('keterangan', $row->keterangan),
		'jenis_soal' => set_value('jenis_soal', $row->jenis_soal),
		'id_fitur' => set_value('id_fitur', $row->id_fitur),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_soal'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_paket_soal', TRUE));
        } else {
            $data = array(
        'nama_soal' => $this->input->post('nama_soal',TRUE),
		'type_soal' => $this->input->post('type_soal',TRUE),
        'waktu' => $this->input->post('waktu',TRUE),
        'point_salah' => $this->input->post('point_salah',TRUE),
        'point_benar' => $this->input->post('point_benar',TRUE),
		'target_point' => $this->input->post('target_point',TRUE),
		'keterangan' => $this->input->post('keterangan',TRUE),
		'jenis_soal' => $this->input->post('jenis_soal',TRUE),
		'id_fitur' => $this->input->post('id_fitur',TRUE),
	    );

            $this->Paket_soal_model->update($this->input->post('id_paket_soal', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('paket_soal?'.param_get()));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Paket_soal_model->get_by_id($id);

        if ($row) {
            $this->Paket_soal_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('paket_soal?'.param_get()));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket_soal'));
        }
    }

    public function _rules() 
    {
    $this->form_validation->set_rules('nama_soal', 'nama soal', 'trim|required');
	$this->form_validation->set_rules('type_soal', 'type soal', 'trim|required');
	$this->form_validation->set_rules('waktu', 'waktu', 'trim|required');
	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');
	$this->form_validation->set_rules('jenis_soal', 'jenis soal', 'trim|required');
	$this->form_validation->set_rules('id_fitur', 'id fitur', 'trim|required');

	$this->form_validation->set_rules('id_paket_soal', 'id_paket_soal', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Paket_soal.php */
/* Location: ./application/controllers/Paket_soal.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-07-17 09:11:49 */
/* https://jualkoding.com */