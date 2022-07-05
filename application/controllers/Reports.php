<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	/* Relatório de Inscritos GERAL */
	public function registered()
	{
		if (!$this->session->userdata('logged') || ($this->session->userdata('role') != 'A'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->view('includes/header');
		$this->load->view('reports/registered');
		$this->load->view('includes/footer');
	}

	public function all()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_model');
		$this->load->model('types_model');

		/** DataTables Eventos **/
		$events = $this->users_registered_model->all();
		$data = array();
		if($events){
			foreach($events as $key => $event):
				$email = $this->users_model->getId($event->idUser)->email;
				$item = array(
					'number'	=> $key+1,
					'idUser'	=> $event->idUser,
					'email'		=> $email,
					'event' 	=> $event->event,
					'user' 		=> $event->name,
					'type'		=> $event->type
					);
				array_push($data, $item);
			endforeach;
			/** Fim DataTables Eventos **/

			echo json_encode(array('data' => $data));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	/* Relatório de Pagantes */
	public function payingUsers()
	{
		if (!$this->session->userdata('logged') || ($this->session->userdata('role') != 'A'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->view('includes/header');
		$this->load->view('reports/payingUsers');
		$this->load->view('includes/footer');
	}

	public function payingEventUsers()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_model');
		$users = $this->users_registered_model->get();

		if($users){
			$array = array();
			foreach($users as $user):
				if($user->status == 'S'){
					$name = $this->users_model->getId($user->idUser)->name;
					$item = array(
						'idUser' 	=> $user->idUser,
						'user' 		=> $name,
						'event' 	=> $user->name,
						'amount'	=> $user->amount
						);
					array_push($array, $item);
				}
			endforeach;

			echo json_encode(array('data' => $array));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	public function payingShortcoursesUsers()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_shortcourses_model');
		$users = $this->users_registered_shortcourses_model->get();

		if($users){
			$array = array();
			foreach($users as $user):
				if($user->status == 'S'){
					$name = $this->users_model->getId($user->idUser)->name;
					$item = array(
						'idUser' 		=> $user->idUser,
						'user' 			=> $name,
						'shortcourse' 	=> $user->name,
						'amount'		=> $user->amount
						);
					array_push($array, $item);
				}
			endforeach;

			echo json_encode(array('data' => $array));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	/* Relatório de NÃO Pagantes */
	public function debtorsUsers()
	{
		if (!$this->session->userdata('logged') || ($this->session->userdata('role') != 'A'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->view('includes/header');
		$this->load->view('reports/debtorsUsers');
		$this->load->view('includes/footer');
	}

	public function debtorsEventUsers()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_model');
		$users = $this->users_registered_model->get();

		if($users){
			$array = array();
			foreach($users as $user):
				if($user->status == 'N'){
					$name = $this->users_model->getId($user->idUser);
					$item = array(
						'idUser' 	=> $user->idUser,
						'user' 		=> $name->name,
						'email'		=> $name->email,
						'event' 	=> $user->name,
						'amount'	=> $user->amount
						);
					array_push($array, $item);
				}
			endforeach;

			echo json_encode(array('data' => $array));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	public function debtorsShortcoursesUsers()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_shortcourses_model');
		$users = $this->users_registered_shortcourses_model->get();

		if($users){
			$array = array();
			foreach($users as $user):
				if($user->status == 'N'){
					$name = $this->users_model->getId($user->idUser);
					$item = array(
						'idUser' 		=> $user->idUser,
						'user' 			=> $name->name,
						'email'			=> $name->email,
						'shortcourse' 	=> $user->name,
						'amount'		=> $user->amount
						);
					array_push($array, $item);
				}
			endforeach;

			echo json_encode(array('data' => $array));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	/* Relatório de Inscritos em Eventos */
	public function registeredUsers()
	{
		if (!$this->session->userdata('logged') || ($this->session->userdata('role') != 'A'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->view('includes/header');
		$this->load->view('reports/registeredUsers');
		$this->load->view('includes/footer');
	}

	public function registeredEvent($id)
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_model');
		$this->load->model('types_model');

		/** DataTables Eventos **/
		$events = $this->users_registered_model->getEvent($id);
		$data = array();
		if($events){
			foreach($events as $event):
				//Faço consulta só pra pegar o nome do usuário.
				$user = $this->users_model->getId($event->idUserFK);
				$type = $this->types_model->getId($user->idTypeFK);
				$item = array(
					'idUser'	=> $event->idUserFK,
					'event' 	=> $event->name,
					'user' 		=> $user->name,
					'email'		=> $user->email,
					'type'		=> $type->name,
					'amount'	=> $event->amount
					);
				array_push($data, $item);
			endforeach;
			/** Fim DataTables Eventos **/

			echo json_encode(array('data' => $data));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	/* Relatório de Inscritos em Minicursos */
	public function registeredShortcourses()
	{
		if (!$this->session->userdata('logged') || ($this->session->userdata('role') != 'A'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->view('includes/header');
		$this->load->view('reports/registeredShortcourses');
		$this->load->view('includes/footer');
	}

	public function registeredShortcourse($id)
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_shortcourses_model');
		$this->load->model('shortcourses_model');

		/** DataTables Eventos **/
		$events = $this->users_registered_shortcourses_model->getEvent($id);
		$data = array();
		if($events){
			foreach($events as $event):
				//Faço consulta só pra pegar o nome do usuário.
				$user 		 = $this->users_model->getId($event->idUserFK);
				$shortcourse = $this->shortcourses_model->getId($event->idShortcourseFK);
				$item = array(
					'idUser'		=> $event->idUserFK,
					'shortcourse' 	=> $shortcourse->name,
					'user' 			=> $user->name,
					'email' => $user->email
					);
				array_push($data, $item);
			endforeach;
			/** Fim DataTables Eventos **/

			echo json_encode(array('data' => $data));
		}else{
			echo json_encode(array('data' => ''));
		}
	}
}