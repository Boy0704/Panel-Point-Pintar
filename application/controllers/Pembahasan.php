<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembahasan extends CI_Controller {

	public function index()
	{
		
	}

	public function getdata($id_skor)
	{

		$this->db->where('id_skor', $id_skor);
		$skor = $this->db->get('skor')->row();

        $data['id_paket_soal'] = $skor->id_paket;
		$data['type_soal'] = get_data('paket_soal','id_paket_soal',$skor->id_paket,'type_soal');
        $data['id_skor'] = $skor->id_skor;
        $data['id_user'] = $skor->id_user;
        $data['total_soal'] = $this->db->get_where('soal', ['id_paket_soal'=>$skor->id_paket])->num_rows();
        $this->load->view('pembahasan/soal_user',$data);
	}

	public function get_soal($id_paket_soal, $id_skor)
    {
        $data = array();
        // $this->db->order_by('rand()');
        // $this->db->select('a.*,c.id_soal');
        // $this->db->where('id_paket_soal', $id_paket_soal);

        $sql = "
        	SELECT
				c.*, b.id_soal as id_soal_skor, b.id_jawaban, b.jawaban
			FROM
				skor a
				INNER JOIN skor_detail b ON a.id_skor = b.id_skor
				RIGHT JOIN soal c ON c.id_soal=b.id_soal
				WHERE c.id_paket_soal = '$id_paket_soal' and a.id_skor='$id_skor'

        ";

        foreach ($this->db->query($sql)->result() as $key => $rw) {
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

    public function get_pembahasan($id_soal)
    {
        echo get_data('soal','id_soal',$id_soal,'pembahasan');
    }

    public function get_benar($id_soal)
    {
        echo get_data('soal','id_soal',$id_soal,'benar');
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
        <div class="radio">
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

}

/* End of file Pembahasan.php */
/* Location: ./application/controllers/Pembahasan.php */