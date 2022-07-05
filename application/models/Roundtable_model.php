<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roundtable_model extends CI_Model {

	private $table;
	private $order;
	private $primarykey;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'roundtable';
		$this->primarykey = 'idRoundtable';
		$this->order = '';
	}

	function add($roundtable)
	{
		$this->db->insert($this->table, $roundtable);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? $this->db->insert_id() : false;
	}

	function count()
	{
		return $this->db->get($this->table)->num_rows();
	}

	function edit($roundtable, $idRoundtable)
	{
		$this->db->where($this->primarykey, $idRoundtable);
		$this->db->update($this->table, $roundtable);

		return ($this->db->affected_rows() == 1) ? true : false;
	}

	function get()
	{
		$this->db->join('events', 'events.idEvent = roundtable.idEventFK', 'inner');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getId($idRoundtable)
	{
		$this->db->where($this->primarykey, $idRoundtable);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function getEvent($idEventFK)
	{
		$this->db->where('idEventFK', $idEventFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function remove($idRoundtableFK)
	{
		$this->db->where($this->primarykey, $idRoundtableFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}