<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Events_model extends CI_Model {

	private $table;
	private $order;
	private $primarykey;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'events';
		$this->primarykey = 'idEvent';
		$this->order = '';
	}

	function add($event)
	{
		$this->db->insert($this->table, $event);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? $this->db->insert_id() : false;
	}

	function count()
	{
		return $this->db->get($this->table)->num_rows();
	}

	function edit($event, $idEvent)
	{
		$this->db->where($this->primarykey, $idEvent);
		$this->db->update($this->table, $event);

		return ($this->db->affected_rows() == 1) ? true : false;
	}

	function get()
	{
		$this->db->order_by($this->order);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getId($idEvent)
	{
		$this->db->where($this->primarykey, $idEvent);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function remove($idEventFK)
	{
		$this->db->where($this->primarykey, $idEventFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}