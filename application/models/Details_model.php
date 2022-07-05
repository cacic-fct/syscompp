<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Details_model extends CI_Model {

	private $table;
	private $order;
	private $primarykey;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'details';
		$this->primarykey = 'idDetail';
		$this->order = '';
	}

	function add($detail)
	{
		$this->db->insert($this->table, $detail);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? $this->db->insert_id() : false;
	}

	function count()
	{
		return $this->db->get($this->table)->num_rows();
	}

	function edit($detail, $idDetail)
	{
		$this->db->where($this->primarykey, $idDetail);
		$this->db->update($this->table, $detail);

		return ($this->db->affected_rows() == 1) ? true : false;
	}

	function get()
	{
		$this->db->order_by($this->order);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getId($detail)
	{
		$this->db->where($this->primarykey, $detail);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function remove($idDetailFK)
	{
		$this->db->where($this->primarykey, $idDetailFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}