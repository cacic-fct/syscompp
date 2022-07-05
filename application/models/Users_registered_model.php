<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_registered_model extends CI_Model {

	private $table;
	private $order;
	private $primarykey;
	private $secondkey;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'users_registered';
		$this->primarykey = 'idUserFK';
		$this->secondkey = 'idEventFK';
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

	function edit($user, $idUserFK, $idEventFK)
	{
		$this->db->where($this->primarykey, $idUserFK);
		$this->db->where($this->secondkey, $idEventFK);
		$this->db->update($this->table, $user);

		return ($this->db->affected_rows() == 1) ? true : false;
	}

	function getId($idUserFK)
	{
		$this->db->where($this->primarykey, $idUserFK);
		$this->db->join('events', 'events.idEvent = users_registered.idEventFK', 'inner');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getEvent($idEventFK)
	{
		$this->db->where($this->secondkey, $idEventFK);
		$this->db->join('events', 'events.idEvent = users_registered.idEventFK', 'inner');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function get()
	{
		$this->db->join('events', 'events.idEvent = users_registered.idEventFK', 'inner');
		$this->db->join('users', 'users.idUser = users_registered.idUserFK', 'inner');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getTickets()
	{
		$this->db->select('users_registered.idEventFK, users_registered.idUserFK, details.name AS user');
		$this->db->join('events', 'events.idEvent = users_registered.idEventFK', 'inner');
		$this->db->join('users', 'users.idUser = users_registered.idUserFK', 'inner');
		$this->db->join('details', 'users.idDetailFK = details.idDetail', 'inner');
		$this->db->order_by('details.name ASC');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function verify_registered($idUserFK, $idEventFK)
	{
		$this->db->where($this->secondkey, $idEventFK);
		$this->db->where($this->primarykey, $idUserFK);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function payment($user, $idUserFK, $idEventFK)
	{
		$this->db->where ($this->primarykey, $idUserFK);
		$this->db->where ($this->secondkey, $idEventFK);
		$this->db->update($this->table, $user);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}

	function removeEvent($idEventFK)
	{
		$this->db->where($this->secondkey, $idEventFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() >= 0) ? true : false;
	}

	function remove($idUserFK)
	{
		$this->db->where($this->primarykey, $idUserFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}

	function all()
	{
		$query = $this->db->query('SELECT DISTINCT d.name, u.idUser, e.name AS event, t.name AS type FROM `users_registered` AS p
									INNER JOIN `events` AS e ON e.`idEvent` = p.`idEventFK`
									INNER JOIN `users` AS u ON p.`idUserFK` = u.`idUser`
									INNER JOIN `details` AS d ON u.`idDetailFK` = d.`idDetail`
									INNER JOIN `types` AS t ON t.`idType` = u.`idTypeFK`

									');
		return ($query->num_rows() > 0) ? $query->result() : false;
	}
}