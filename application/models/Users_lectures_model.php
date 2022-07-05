<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_lectures_model extends CI_Model {

	private $table;
	private $order;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'users_lectures';
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

	function get()
	{
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getId($idLectureFK)
	{
		$this->db->where('idLectureFK', $idLectureFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function exists($idUserFK, $idLectureFK)
	{
		$this->db->where('idLectureFK', $idLectureFK);
		$this->db->where('idUserFK', $idUserFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? true : false;
	}

	function getApi($idLectureFK)
	{
		$this->db->select('details.name AS user_name');
		$this->db->where('idLectureFK', $idLectureFK);
		$this->db->join('users', 'users.idUser = users_lectures.idUserFK', 'inner');
		$this->db->join('details', 'users.idDetailFK = details.idDetail', 'inner');
		$this->db->order_by('user_name');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function remove($idLectureFK)
	{
		$this->db->where('idLectureFK', $idLectureFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}