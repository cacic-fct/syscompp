<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_shortcourses_model extends CI_Model {

	private $table;
	private $order;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'users_shortcourses';
		$this->order = '';
	}

	function add($user)
	{
		$this->db->insert($this->table, $user);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}

	function count()
	{
		return $this->db->get($this->table)->num_rows();
	}

	function getId($idShortcourseFK)
	{
		$this->db->where('idShortcourseFK', $idShortcourseFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function get()
	{
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function exists($idUserFK, $idShortcourseFK)
	{
		$this->db->where('idShortcourseFK', $idShortcourseFK);
		$this->db->where('idUserFK', $idUserFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? true : false;
	}

	function getApi($idShortcourseFK)
	{
		$this->db->select('details.name AS user_name');
		$this->db->where('idShortcourseFK', $idShortcourseFK);
		$this->db->join('users', 'users.idUser = users_shortcourses.idUserFK', 'inner');
		$this->db->join('details', 'users.idDetailFK = details.idDetail', 'inner');
		$this->db->order_by('user_name');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function remove($idShortcourse)
	{
		$this->db->where('idShortcourseFK', $idShortcourse);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}