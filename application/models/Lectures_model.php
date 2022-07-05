<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lectures_model extends CI_Model {

	private $table;
	private $order;
	private $primarykey;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'lectures';
		$this->primarykey = 'idLecture';
		$this->order = '';
	}

	function add($lecture)
	{
		$this->db->insert($this->table, $lecture);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? $this->db->insert_id() : false;
	}

	function count()
	{
		return $this->db->get($this->table)->num_rows();
	}

	function edit($lecture, $idLecture)
	{
		$this->db->where($this->primarykey, $idLecture);
		$this->db->update($this->table, $lecture);

		return ($this->db->affected_rows() == 1) ? true : false;
	}

	function get()
	{
		$query = "SELECT s.*, e.name AS event FROM lectures AS s INNER JOIN events AS e ON s.idEventFK = e.idEvent ORDER BY s.name ASC";
		$obj = $this->db->query($query);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function verifyEvent($idLecture, $idEventFK)
	{
		$this->db->where($this->primarykey, $idLecture);
		$this->db->where('idEventFK', $idEventFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? true : false;
	}

	function getId($idLecture)
	{
		$this->db->where($this->primarykey, $idLecture);
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
		$this->db->select('lectures.idLecture, lectures.name AS lecture_name, description');
		$this->db->where('idEventFK', $idEventFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function remove($idLectureFK)
	{
		$this->db->where($this->primarykey, $idLectureFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}