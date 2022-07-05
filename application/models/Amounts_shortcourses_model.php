<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Amounts_shortcourses_model extends CI_Model {

	private $table;
	private $order;
	private $primarykey;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'amounts_shortcourses';
		$this->primarykey = 'idAmount';
		$this->order = '';
	}

	function amount($idShortcourseFK, $idTypeFK)
	{
		$this->db->where('idShortcourseFK', $idShortcourseFK);
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

	function get($idShortcourseFK)
	{
		$this->db->order_by($this->order);
		$this->db->join('types', 'types.idType = amounts_shortcourses.idTypeFK', 'inner');
		$this->db->where('idShortcourseFK', $idShortcourseFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function verifyType($idTypeFK, $idShortcourseFK)
	{
		$this->db->where('idTypeFK', $idTypeFK);
		$this->db->where('idShortcourseFK', $idShortcourseFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? true : false;
	}

	function getId($amount)
	{
		$this->db->where($this->primarykey, $amount);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function removeShortcourse($idShortcourseFK)
	{
		$this->db->where('idShortcourseFK', $idShortcourseFK);
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