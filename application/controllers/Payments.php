<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

	public function index()
	{
		if (!$this->session->userdata('logged') || ($this->session->userdata('role') != 'A'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->view('includes/header');
		$this->load->view('payments');
		$this->load->view('includes/footer');
	}

	public function eventsPayment()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_model');

		/** DataTables Eventos **/
		$events = $this->users_registered_model->get();
		$data = array();

		if($events){
			foreach($events as $event):
				//Verifico se ja foi pago
				if($event->status == 'N')
				$payment = "<button class='btn btn-primary' id='pay' idEvent='".$event->idEvent."'>Dar Baixa</button>";
				else $payment = "<button class='btn btn-danger' id='pay' idEvent='".$event->idEvent."'>Cancelar Pagamento</button>";
				//Faço consulta só pra pegar o nome do usuário.
				$user = $this->users_model->getId($event->idUser);
				$item = array(
					'idUser'	=> $event->idUser,
					'user' 		=> $user->name,
					'event' 	=> $event->name,
					'amount'	=> $event->amount,
					'actions' 	=> $payment
					);
				array_push($data, $item);
			endforeach;
			/** Fim DataTables Eventos **/

			echo json_encode(array('data' => $data));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	public function payEvent()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_registered_model');
		$idUser = $this->input->post('idUser');
		$idEvent = $this->input->post('idEvent');

		if($user = $this->users_registered_model->verify_registered($idUser, $idEvent))
		{
			if($user->status == 'S'){
				$payment['status'] = 'N';
				if($this->users_registered_model->payment($payment, $idUser, $idEvent)){
				echo json_encode(array('boolean' => true, 'text' => 'Pagamento CANCELADO !', 'payment' => 'N'));
				return;
			}
			}else{
				$payment['status'] = 'S';
				if($this->users_registered_model->payment($payment, $idUser, $idEvent)){
				echo json_encode(array('boolean' => true, 'text' => 'Pagamento REALIZADO com sucesso !', 'payment' => 'S'));
				return;
			}
			}
		}

		echo json_encode(array('boolean' => false, 'text' => 'Algo deu errado. Tente novamente.'));
	}

	public function shortcoursesPayment()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_shortcourses_model');

		/** DataTables Minicursos **/
		$shortcourses = $this->users_registered_shortcourses_model->get();
		$data = array();

		if($shortcourses){
			foreach($shortcourses as $shortcourse):
				//Verifico se ja foi pago
				if($shortcourse->status == 'N')
				$payment = "<button class='btn btn-primary' id='pay' idShortcourse='".$shortcourse->idShortcourseFK."'>Dar Baixa</button>";
				else $payment = "<button class='btn btn-danger' id='pay' idShortcourse='".$shortcourse->idShortcourseFK."'>Cancelar Pagamento</button>";
				//Faço consulta só pra pegar o nome do usuário.
				$user = $this->users_model->getId($shortcourse->idUserFK);
				$item = array(
					'idUser'		=> $shortcourse->idUserFK,
					'user' 			=> $user->name,
					'shortcourse' 	=> $shortcourse->name,
					'amount'		=> $shortcourse->amount,
					'actions' 		=> $payment
					);
				array_push($data, $item);
			endforeach;
			/** Fim DataTables Minicursos **/

			echo json_encode(array('data' => $data));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	public function payShortcourse()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_registered_shortcourses_model');
		$idUser = $this->input->post('idUser');
		$idShortcourse = $this->input->post('idShortcourse');

		if($user = $this->users_registered_shortcourses_model->verify($idUser, $idShortcourse))
		{
			if($user->status == 'S'){
				$payment['status'] = 'N';
				if($this->users_registered_shortcourses_model->payment($payment, $idUser, $idShortcourse)){
				echo json_encode(array('boolean' => true, 'text' => 'Pagamento CANCELADO !', 'payment' => 'N'));
				return;
			}
			}else{
				$payment['status'] = 'S';
				if($this->users_registered_shortcourses_model->payment($payment, $idUser, $idShortcourse)){
				echo json_encode(array('boolean' => true, 'text' => 'Pagamento REALIZADO com sucesso !', 'payment' => 'S'));
				return;
			}
			}
		}

		echo json_encode(array('boolean' => false, 'text' => 'Algo deu errado. Tente novamente.'));
	}
}