<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paket_soal_model extends CI_Model
{

    public $table = 'paket_soal';
    public $id = 'id_paket_soal';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_paket_soal', $q);
	$this->db->or_like('nama_soal', $q);
	$this->db->or_like('waktu', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->or_like('jenis_soal', $q);
	$this->db->or_like('id_fitur', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_paket_soal', $q);
	$this->db->or_like('nama_soal', $q);
	$this->db->or_like('waktu', $q);
	$this->db->or_like('keterangan', $q);
	$this->db->or_like('jenis_soal', $q);
	$this->db->or_like('id_fitur', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Paket_soal_model.php */
/* Location: ./application/models/Paket_soal_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2021-07-17 09:11:49 */
/* http://harviacode.com */