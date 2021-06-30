<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'users/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'users/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'users/index.html';
            $config['first_url'] = base_url() . 'users/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Users_model->total_rows($q);
        $users = $this->Users_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'users_data' => $users,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => 'users/users_list',
            'konten' => 'users/users_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Users_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_user' => $row->id_user,
        'nama' => $row->nama,
		'email' => $row->email,
		'username' => $row->username,
		'password' => $row->password,
		'id_jabatan' => $row->id_jabatan,
		'foto' => $row->foto,
		'token' => $row->token,
	    );
            $this->load->view('users/users_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'users/users_form',
            'konten' => 'users/users_form',
            'button' => 'Create',
            'action' => site_url('users/create_action'),
	    'id_user' => set_value('id_user'),
        'nama' => set_value('nama'),
	    'email' => set_value('email'),
	    'username' => set_value('username'),
	    'password' => set_value('password'),
        'id_level' => set_value('id_level'),
	    'jabatan' => set_value('jabatan'),
        'foto' => set_value('foto'),
	    'token' => set_value('token'),
	);
        $this->load->view('v_index', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        $img = upload_gambar_biasa('user', 'image/user/', 'jpg|png|jpeg', 10000, 'foto');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
        'nama' => $this->input->post('nama',TRUE),
		'email' => $this->input->post('email',TRUE),
		'username' => $this->input->post('username',TRUE),
		'password' => $this->input->post('password',TRUE),
        'id_level' => $this->input->post('id_level',TRUE),
		'jabatan' => $this->input->post('jabatan',TRUE),
		'foto' => $retVal = ($_FILES['foto']['name'] == '') ? '' : $img,
		'token' => $this->input->post('token',TRUE),
	    );

            $this->Users_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('users'));
        }
    }

    public function reset_login($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->update('users', array('status_login'=>'1'));

        $this->session->set_flashdata('message', 'Berhasil di reset');
            redirect(site_url('users'));
    }
    
    public function update($id) 
    {
        $row = $this->Users_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'users/users_form',
                'konten' => 'users/users_form',
                'button' => 'Update',
                'action' => site_url('users/update_action'),
		'id_user' => set_value('id_user', $row->id_user),
        'nama' => set_value('nama', $row->nama),
		'email' => set_value('email', $row->email),
		'username' => set_value('username', $row->username),
		'password' => set_value('password', $row->password),
        'id_level' => set_value('id_level', $row->id_level),
		'jabatan' => set_value('jabatan', $row->jabatan),
        'foto' => set_value('foto', $row->foto),
		'token' => set_value('token', $row->token),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_user', TRUE));
        } else {
        if ($_FILES == NULL) {
            $foto = $this->input->post('foto_old');
        } else {
            $foto = $img = upload_gambar_biasa('user', 'image/user/', 'jpg|png|jpeg', 10000, 'foto');
        }
            $data = array(
        'nama' => $this->input->post('nama',TRUE),
		'email' => $this->input->post('email',TRUE),
		'username' => $this->input->post('username',TRUE),
		'password' => $this->input->post('password',TRUE),
        'id_level' => $this->input->post('id_level',TRUE),
		'jabatan' => $this->input->post('jabatan',TRUE),
		'foto' => $foto,
		'token' => $this->input->post('token',TRUE),
	    );

            $this->Users_model->update($this->input->post('id_user', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('users'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Users_model->get_by_id($id);

        if ($row) {
            $this->Users_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('users'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
        }
    }

    public function _rules() 
    {
    $this->form_validation->set_rules('nama', 'nama', 'trim|required');
	$this->form_validation->set_rules('email', 'email', 'trim|required');
	$this->form_validation->set_rules('username', 'username', 'trim|required');
	$this->form_validation->set_rules('password', 'password', 'trim|required');
    $this->form_validation->set_rules('id_level', 'Level', 'trim|required');
	$this->form_validation->set_rules('jabatan', 'jabatan', 'trim|required');

	$this->form_validation->set_rules('id_user', 'id_user', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-05-09 15:38:12 */
/* https://jualkoding.com */