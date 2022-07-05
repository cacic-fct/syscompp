<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presence_shortcourses_model extends CI_Model {

	private $table;
	private $order;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'presence_shortcourses';
		$this->order = '';
	}

	function add($user)
	{
		$this->db->insert($this->table, $user);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}

	function exists($idUserFK, $idShortcourseFK){
		$this->db->where('idUserFK', $idUserFK);
		$this->db->where('idShortcourseFK', $idShortcourseFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? true : false;
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

	function getByUser($idUserFK)
	{
		$this->db->where('idUserFK', $idUserFK);
		$this->db->join('shortcourses', 'shortcourses.idShortcourse = presence_shortcourses.idShortcourseFK', 'inner');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function remove($idUserFK, $idShortcourseFK)
	{
		$this->db->where('idShortcourseFK', $idShortcourseFK);
		$this->db->where('idUserFK', $idUserFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}