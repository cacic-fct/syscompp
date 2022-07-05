<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shortcourses_model extends CI_Model {

	private $table;
	private $order;
	private $primarykey;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'shortcourses';
		$this->primarykey = 'idShortcourse';
		$this->order = '';
	}

	function add($shortcourse)
	{
		$this->db->insert($this->table, $shortcourse);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? $this->db->insert_id() : false;
	}

	function count()
	{
		return $this->db->get($this->table)->num_rows();
	}

	function edit($shortcourse, $idShortcourse)
	{
		$this->db->where($this->primarykey, $idShortcourse);
		$this->db->update($this->table, $shortcourse);

		return ($this->db->affected_rows() == 1) ? true : false;
	}

	function get()
	{
		$query = "SELECT s.*, e.name AS event FROM shortcourses AS s INNER JOIN events AS e ON s.idEventFK = e.idEvent ORDER BY s.name ASC";
		$obj = $this->db->query($query);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getId($idShortcourse)
	{
		$this->db->where($this->primarykey, $idShortcourse);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function getEvent($idEventFK)
	{
		$this->db->where('idEventFK', $idEventFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getApi($idEventFK)
	{
		$this->db->select('shortcourses.idShortcourse, shortcourses.name AS shortcourse_name, description');
		$this->db->where('idEventFK', $idEventFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function remove($idShortcourseFK)
	{
		$this->db->where($this->primarykey, $idShortcourseFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}