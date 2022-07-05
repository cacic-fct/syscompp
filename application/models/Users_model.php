<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

	private $table;
	private $order;
	private $primarykey;

	public function __construct()
	{
		parent::__construct();
		$this->table = 'users';
		$this->primarykey = 'idUser';
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

	function doLogin($user)
	{
		$this->db->select('*')->from($this->table)->where($user);
		$obj = $this->db->get();
		return ($obj->num_rows() == 1) ? $obj->first_row()->idUser : false;
	}

	function edit($user, $idUserFK)
	{
		$this->db->where ($this->primarykey, $idUserFK);
		$this->db->update($this->table, $user);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}

	function editEmail($user, $email)
	{
		$this->db->where ('email', $email);
		$this->db->update($this->table, $user);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}

	function get()
	{
		$this->db->select('users.idUser AS id, details.name AS text');
		$this->db->order_by($this->order);
		$this->db->join('details', 'details.idDetail = users.idDetailFK', 'inner');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() > 0) ? $obj->result() : false;
	}

	function getId($id)
	{
		$this->db->where($this->primarykey, $id);
		$this->db->join('details', 'details.idDetail = users.idDetailFK');
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function getEmail($email)
	{
		$this->db->where('email', $email);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? $obj->first_row() : false;
	}

	function emailExist($email)
	{
		$this->db->where('email', $email);
		$obj = $this->db->get($this->table);

		return ($obj->num_rows() == 1) ? true : false;
	}

	function isUser($idUserFK)
	{
		$this->db->where($this->primarykey, $idUserFK);
		$this->db->select('*')->from($this->table);

		return ($this->db->get()->num_rows() == 1) ? true : false;
	}

	function remove($idUserFK)
	{
		$this->db->where($this->primarykey, $idUserFK);
		$this->db->delete($this->table);

		return ($this->db->affected_rows() == 1 || $this->db->affected_rows() == 0) ? true : false;
	}
}

/* End of file users.php */
/* Location: ./application/models/users_model.php */