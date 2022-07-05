<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Types_model extends CI_Model {

	private $table;
	private $order;
	private $primarykey;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'types';
		$this->primarykey = 'idType';
		$this->order = 'types.idType asc';
	}

	function add($type)
	{
		$this->db->insert($this->table, $type);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? $this->db->insert_id() : false;
	}

	function count()
	{
		return $this->db->get($this->table)->num_rows();
	}

	function edit($type, $idTypeFK)
	{
		$this->db->where ($this->primarykey, $idTypeFK);
		$this->db->update($this->table, $type);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}

	function getId($idTypeFK)
	{
		$this->db->where($this->primarykey, $idTypeFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function get()
	{
		$this->db->order_by($this->order);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function remove($idTypeFK)
	{
		$this->db->where($this->primarykey, $idTypeFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}
