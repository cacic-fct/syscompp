<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_registered_shortcourses_model extends CI_Model {

	private $table;
	private $order;
	private $primarykey;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'users_registered_shortcourses';
		$this->primarykey = 'idUserFK';
		$this->secondkey  = 'idEventFK';
		$this->thirdkey   = 'idShortcourseFK';
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

	function countShortcourse($idShortcourseFK)
	{
		$this->db->where($this->thirdkey, $idShortcourseFK);
		return $this->db->get($this->table)->num_rows();
	}

	function edit($user, $idUser)
	{
		$this->db->where($this->primarykey, $idUser);
		$this->db->update($this->table, $user);

		return ($this->db->affected_rows() == 1) ? true : false;
	}

	function get()
	{
		$this->db->order_by($this->order);
		$this->db->join('shortcourses', 'shortcourses.idShortcourse = users_registered_shortcourses.idShortcourseFK', 'inner');
		$this->db->join('users', 'users.idUser = users_registered_shortcourses.idUserFK', 'inner');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getId($idUserFK)
	{
		$this->db->where($this->primarykey, $idUserFK);
		$this->db->join('shortcourses', 'shortcourses.idShortcourse = users_registered_shortcourses.idShortcourseFK', 'inner');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getEvent($idEventFK)
	{
		$this->db->where($this->secondkey, $idEventFK);
		$this->db->join('events', 'events.idEvent = users_registered_shortcourses.idEventFK', 'inner');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getUserEvent($idUserFK, $idEventFK)
	{
		$this->db->where($this->primarykey, $idUserFK);
		$this->db->where('users_registered_shortcourses.idEventFK', $idEventFK);
		$this->db->join('shortcourses', 'shortcourses.idShortcourse = users_registered_shortcourses.idShortcourseFK', 'inner');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function verify_registered($idUserFK, $idEventFK, $idShortcourseFK)
	{
		$this->db->where($this->thirdkey, $idShortcourseFK);
		$this->db->where($this->secondkey, $idEventFK);
		$this->db->where($this->primarykey, $idUserFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function verify($idUserFK, $idShortcourseFK)
	{
		$this->db->where($this->thirdkey, $idShortcourseFK);
		$this->db->where($this->primarykey, $idUserFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function payment($user, $idUserFK, $idShortcourseFK)
	{
		$this->db->where ($this->primarykey, $idUserFK);
		$this->db->where ($this->thirdkey, $idShortcourseFK);
		$this->db->update($this->table, $user);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}

	function removeShortcourse($idShortcourseFK)
	{
		$this->db->where($this->thirdkey, $idShortcourseFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() >= 0) ? true : false;
	}

	function remove($idUserFK)
	{
		$this->db->where($this->primarykey, $idUserFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}