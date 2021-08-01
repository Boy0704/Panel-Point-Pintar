<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Soal extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Soal_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'soal/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'soal/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'soal/index.html';
            $config['first_url'] = base_url() . 'soal/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Soal_model->total_rows($q);
        $soal = $this->Soal_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'soal_data' => $soal,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'judul_page' => get_data('paket_soal','id_paket_soal',$this->input->get('id_paket_soal'),'nama_soal'),
            'konten' => 'soal/soal_list',
        );
        $this->load->view('v_index', $data);
    }

    public function read($id) 
    {
        $row = $this->Soal_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_soal' => $row->id_soal,
		'id_paket_soal' => $row->id_paket_soal,
		'soal' => $row->soal,
		'a' => $row->a,
		'b' => $row->b,
		'c' => $row->c,
		'd' => $row->d,
		'e' => $row->e,
		'benar' => $row->benar,
		'pembahasan' => $row->pembahasan,
	    );
            $this->load->view('soal/soal_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('soal'));
        }
    }

    public function create() 
    {
        $data = array(
            'judul_page' => 'Tambah Soal',
            'konten' => 'soal/soal_form',
            'button' => 'Create',
            'action' => site_url('soal/create_action'),
	    'id_soal' => set_value('id_soal'),
	    'id_paket_soal' => set_value('id_paket_soal'),
	    'soal' => set_value('soal'),
	    'a' => set_value('a'),
	    'b' => set_value('b'),
	    'c' => set_value('c'),
	    'd' => set_value('d'),
	    'e' => set_value('e'),
        'benar' => set_value('benar'),
	    'type_soal' => set_value('type_soal'),
	    'pembahasan' => set_value('pembahasan'),
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
		'id_paket_soal' => $this->input->post('id_paket_soal',TRUE),
		'soal' => $this->input->post('soal',TRUE),
		'a' => $this->input->post('a',TRUE),
		'b' => $this->input->post('b',TRUE),
		'c' => $this->input->post('c',TRUE),
		'd' => $this->input->post('d',TRUE),
		'e' => $this->input->post('e',TRUE),
        'benar' => $this->input->post('benar',TRUE),
		'type_soal' => $this->input->post('type_soal',TRUE),
		'pembahasan' => $this->input->post('pembahasan',TRUE),
	    );

            $this->Soal_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('soal?'.param_get()));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Soal_model->get_by_id($id);

        if ($row) {
            $data = array(
                'judul_page' => 'Ubah Soal',
                'konten' => 'soal/soal_form',
                'button' => 'Update',
                'action' => site_url('soal/update_action'),
		'id_soal' => set_value('id_soal', $row->id_soal),
		'id_paket_soal' => set_value('id_paket_soal', $row->id_paket_soal),
		'soal' => set_value('soal', $row->soal),
		'a' => set_value('a', $row->a),
		'b' => set_value('b', $row->b),
		'c' => set_value('c', $row->c),
		'd' => set_value('d', $row->d),
		'e' => set_value('e', $row->e),
        'benar' => set_value('benar', $row->benar),
		'type_soal' => set_value('type_soal', $row->type_soal),
		'pembahasan' => set_value('pembahasan', $row->pembahasan),
	    );
            $this->load->view('v_index', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('soal?'.param_get()));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        // log_r($_POST);

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_soal', TRUE));
        } else {
            $data = array(
		'id_paket_soal' => $this->input->post('id_paket_soal',TRUE),
		'soal' => $this->input->post('soal'),
		'a' => $this->input->post('a',TRUE),
		'b' => $this->input->post('b',TRUE),
		'c' => $this->input->post('c',TRUE),
		'd' => $this->input->post('d',TRUE),
		'e' => $this->input->post('e',TRUE),
        'benar' => $this->input->post('benar',TRUE),
		'type_soal' => $this->input->post('type_soal',TRUE),
		'pembahasan' => $this->input->post('pembahasan',TRUE),
	    );

            $this->Soal_model->update($this->input->post('id_soal', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('soal?'.param_get()));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Soal_model->get_by_id($id);

        if ($row) {
            $this->Soal_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('soal?'.param_get()));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('soal?'.param_get()));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_paket_soal', 'id paket soal', 'trim|required');
	$this->form_validation->set_rules('soal', 'soal', 'trim|required');
	$this->form_validation->set_rules('a', 'a', 'trim|required');
	$this->form_validation->set_rules('b', 'b', 'trim|required');
	$this->form_validation->set_rules('c', 'c', 'trim|required');
	$this->form_validation->set_rules('d', 'd', 'trim|required');
	$this->form_validation->set_rules('e', 'e', 'trim|required');
	$this->form_validation->set_rules('benar', 'benar', 'trim|required');
	$this->form_validation->set_rules('pembahasan', 'pembahasan', 'trim|required');

	$this->form_validation->set_rules('id_soal', 'id_soal', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


    public function soal_user($id_user, $id_paket_soal)
    {

        $data = array(
            'id_user' => $id_user,
            'id_paket' => $id_paket_soal,
            'waktu_mulai'=>get_waktu(),
            'status'=>0
        );
        $this->db->insert('skor', $data);
        $id_skor = $this->db->insert_id();

        $data['id_paket_soal'] = $id_paket_soal;
        $data['id_skor'] = $id_skor;
        $data['total_soal'] = $this->db->get_where('soal', ['id_paket_soal'=>$id_paket_soal])->num_rows();
        $this->load->view('soal/soal_user',$data);
    }

    public function get_soal($id_paket_soal)
    {
        $data = array();
        // $this->db->order_by('rand()');
        $this->db->where('id_paket_soal', $id_paket_soal);
        foreach ($this->db->get('soal')->result() as $key => $rw) {
            $data[] = $rw;
        }
        echo json_encode($data);
    }


    public function get_pertanyaan($id_soal)
    {
        $this->db->where('id_soal', $id_soal);
        $soal = $this->db->get('soal')->row();
        echo str_replace("../../", base_url(), $soal->soal);
    }

    public function get_jawaban($id_soal,$id_skor)
    {
        $this->db->where('id_soal', $id_soal);
        $d = $this->db->get('soal')->row();

        $s = 'a';
        while($s != 'f')
        {

            $checked = "";
            $this->db->where('id_soal', $id_soal);
            $this->db->where('id_skor', $id_skor);
            $cek_jawaban = $this->db->get('skor_detail');
            if ($cek_jawaban->num_rows() > 0) {
                if ($cek_jawaban->row()->id_jawaban == $s) {
                    $checked = "checked";
                }
            }
            
        ?>
        <div class="radio" onclick="simpan_jawaban('<?php echo $id_soal ?>','<?php echo $s ?>')">
          <label><input type="radio" name="optradio" <?php echo $checked ?>><?php echo strtoupper($s).'. '.$d->$s ?></label>
        </div>
<!--         <div onclick="simpan_jawaban('<?php echo $id_soal ?>','<?php echo $s ?>')">
          <input type="radio" id="<?php echo $d->$s ?>" name="drone" value="<?php echo $d->$s ?>" <?php echo $checked ?>>
          <label for="<?php echo $d->$s ?>"><?php echo strtoupper($s).'. '.$d->$s ?></label>
        </div> -->
       
        <?php
        $s = chr(ord($s) + 1);
        }
    }

    public function simpan_jawaban($id_soal,$jawaban,$id_skor)
    {

        $d = $jawaban;
        $cek = $this->db->get_where('skor_detail', array('id_soal'=>$id_soal,'id_skor'=>$id_skor));
        $id_paket_soal = get_data('soal','id_soal',$id_soal,'id_paket_soal');
        $benar = get_data('soal','id_soal',$id_soal,'benar');
        $isi_jawaban = get_data('soal','id_soal',$id_soal,$jawaban);

        $point = 0;
        if ($benar == $jawaban) {
            $point = get_data('paket_soal','id_paket_soal',$id_paket_soal,'point_benar');
        } else {
            $point = get_data('paket_soal','id_paket_soal',$id_paket_soal,'point_salah');
        }

        if ($cek->num_rows() > 0) {
            $this->db->where('id_skor', $id_skor);
            $this->db->where('id_soal', $id_soal);
            $this->db->update('skor_detail', array(
                'nilai'=>$point,
                'id_jawaban'=>$jawaban,
                'jawaban'=>$isi_jawaban,
            ));
        } else {
            $this->db->insert('skor_detail', array(
                'id_skor' => $id_skor,
                'id_soal' => $id_soal,
                'id_jawaban'=>$jawaban,
                'nilai' => $point,
                'jawaban' => $isi_jawaban,
                'waktu' => get_waktu(),
            ));
        }
        echo 'berhasil';

    }

    public function tes_soal()
    {
        $this->load->view('soal/tes_soal');
    }

}

/* End of file Soal.php */
/* Location: ./application/controllers/Soal.php */
/* Please DO NOT modify this information : */
/* Generated by Boy Kurniawan 2021-07-27 04:19:25 */
/* https://jualkoding.com */