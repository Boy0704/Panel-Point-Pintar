<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Video extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Video_model');
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
            $config['base_url'] = base_url() . 'video/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'video/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'video/index.html';
            $config['first_url'] = base_url() . 'video/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Video_model->total_rows($q);
        $video = $this->Video_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'video_data' => $video,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'video/video_list',
            'konten' => 'video/video_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Video_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_video' => $row->id_video,
		'id_kategori' => $row->id_kategori,
		'judul' => $row->judul,
		'link' => $row->link,
	    );
            $this->load->view('video/video_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('video'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'video/video_form',
            'konten' => 'video/video_form',
            'button' => 'Create',
            'action' => site_url('video/create_action'),
	    'id_video' => set_value('id_video'),
	    'id_kategori' => set_value('id_kategori'),
	    'judul' => set_value('judul'),
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
            $file = upload_gambar_biasa('video', 'files/video/', 'mp4', 100000, 'link');
            $data = array(
		'id_kategori' => $this->input->post('id_kategori',TRUE),
		'judul' => $this->input->post('judul',TRUE),
		'link' => $file,
	    );

            $this->Video_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('video').'?'.param_get());
        }
    }
    
    public function update($id) 
    {
        $row = $this->Video_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'video/video_form',
                'konten' => 'video/video_form',
                'button' => 'Update',
                'action' => site_url('video/update_action'),
		'id_video' => set_value('id_video', $row->id_video),
		'id_kategori' => set_value('id_kategori', $row->id_kategori),
		'judul' => set_value('judul', $row->judul),
		'link' => set_value('link', $row->link),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('video').'?'.param_get());
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_video', TRUE));
        } else {
            $data = array(
		'id_kategori' => $this->input->post('id_kategori',TRUE),
		'judul' => $this->input->post('judul',TRUE),
		'link' => $retVal = ($_FILES['link']['name'] == '') ? $_POST['link_old'] : upload_gambar_biasa('video', 'files/video/', 'mp4', 100000, 'link'),
	    );

            $this->Video_model->update($this->input->post('id_video', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('video').'?'.param_get());
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Video_model->get_by_id($id);

        if ($row) {
            $this->Video_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('video').'?'.param_get());
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('video').'?'.param_get());
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_kategori', 'id kategori', 'trim|required');
	$this->form_validation->set_rules('judul', 'judul', 'trim|required');

	$this->form_validation->set_rules('id_video', 'id_video', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Video.php */
/* Location: ./application/controllers/Video.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-06-30 15:53:41 */
/* https://jualkoding.com */