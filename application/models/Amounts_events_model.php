<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Amounts_events_model extends CI_Model {

	private $table;
	private $order;
	private $primarykey;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'amounts_events';
		$this->primarykey = 'idAmount';
		$this->order = '';
	}

	function amount($idEventFK, $idTypeFK)
	{
		$this->db->where('idEventFK', $idEventFK);
		$this->db->where('idTypeFK', $idTypeFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function add($amount)
	{
		$this->db->insert($this->table, $amount);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? $this->db->insert_id() : false;
	}

	function count()
	{
		return $this->db->get($this->table)->num_rows();
	}

	function edit($amount, $idAmount)
	{
		$this->db->where($this->primarykey, $idAmount);
		$this->db->update($this->table, $amount);

		return ($this->db->affected_rows() == 1) ? true : false;
	}

	function get($idEventFK)
	{
		$this->db->order_by($this->order);
		$this->db->join('types', 'types.idType = amounts_events.idTypeFK', 'inner');
		$this->db->where('idEventFK', $idEventFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getPrice($idEventFK, $idTypeFK){
		$this->db->where('idTypeFK', $idTypeFK);
		$this->db->where('idEventFK', $idEventFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function verifyType($idTypeFK, $idEventFK)
	{
		$this->db->where('idTypeFK', $idTypeFK);
		$this->db->where('idEventFK', $idEventFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? true : false;
	}

	function getId($amount)
	{
		$this->db->where($this->primarykey, $amount);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function getEvent($idEventFK)
	{
		$this->db->where('idEventFK', $idEventFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function removeEvent($idEventFK)
	{
		$this->db->where('idEventFK', $idEventFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}

	function remove($idAmountFK)
	{
		$this->db->where($this->primarykey, $idAmountFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}