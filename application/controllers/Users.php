<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function profile()
	{
		if (!$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('types_model');
		$this->load->model('details_model');

		$data['types']  = $this->types_model->get();
		$data['user']   = $this->users_model->getId($this->session->userdata('id'));

		$this->load->view('includes/header');
		$this->load->view('profile', $data);
		$this->load->view('includes/footer');
	}

	public function updateProfile()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('users_model');
		$this->load->model('details_model');
		$this->load->model('types_model');

		//Validação
		if(strcmp($this->input->post('password_form'), $this->input->post('password_confirmation')) != 0){
			echo json_encode(array('boolean' => false, 'text' => 'As senhas estão diferentes !'));
			return;
		}

		// Atualiza detalhes do usuário
		$idDetailFK = $this->users_model->getId($this->session->userdata('id'))->idDetailFK;
		$detail = array(
			'name' 			=> strtoupper($this->input->post('name')),
			'rg'			=> $this->input->post('rg'),
			'issuing' 		=> strtoupper($this->input->post('issuing')),
			'cpf'			=> $this->input->post('cpf')
			);
		$this->details_model->edit($detail, $idDetailFK);

		// Atualiza dados usuário
		$user = array(
			'email' 		=> $this->input->post('email_form'),
			'idTypeFK'		=> $this->input->post('type')
			);

		// Atualizo os preços caso ele já tenha de inscrito em um evento
		$this->load->model('users_registered_model');
		$this->load->model('amounts_events_model');
		$this->load->model('events_model');
		$events = $this->events_model->get();
		foreach($events as $event):
			if($aux = $this->users_registered_model->verify_registered($this->session->userdata('id'), $event->idEvent))
			{
				if($aux->amount != 0){
					$amount = $this->amounts_events_model->getPrice($event->idEvent, $this->input->post('type'))->amount;
					$new['amount'] = $amount;
					$this->users_registered_model->edit($new, $this->session->userdata('id'), $event->idEvent);
				}
			}
		endforeach;

		//Se o usuário preencher a senha, atualizamos no banco !
		if($this->input->post('password_form') != '') $user['password'] = sha1($this->input->post('password_form'));

		//Por fim salva usuários
		if($this->users_model->edit($user, $this->session->userdata('id'))){
			echo json_encode(array('boolean' => true, 'text' => 'Profile atualizado com sucesso !'));
		}
	}
}
