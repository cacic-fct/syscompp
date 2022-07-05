<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller {

	public function index()
	{
		if (!$this->session->userdata('logged') || ($this->session->userdata('role') != 'A'))
		{
			$this->load->view('control_view/error');
			return;
		}

		//tipos pro form do preço
		$this->load->model('types_model');
		$data['types'] = $this->types_model->get();

		$this->load->view('includes/header');
		$this->load->view('events', $data);
		$this->load->view('includes/footer');
	}

	public function search()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('events_model');
		$idEvent = $this->input->post('idEvent');

		$this->session->set_flashdata('idEvent', $idEvent);

		if($event = $this->events_model->getId($idEvent)){
			echo json_encode(array('boolean' => true, 'text'=> 'Informações inseridas no formulário ! <br>Faça as alterações abaixo.', 'obj' => $event));
		}else{
			echo json_encode(array('boolean' => false, 'text' => 'Não foi possível encontrar o evento.'));
		}

	}

	public function dataTables(){
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('events_model');
		$events = $this->events_model->get();
		$data = array();

		if($events){
			foreach($events as $row => $event):

				if($event->enrollments == 'S') $enrollments = "<b style='color:green'>abertas</b>";
				else $enrollments = "<b style='color:red'>fechadas</b>";

				//formata as datas
				$start = date("d/m/Y", strtotime($event->start));
				$end = date("d/m/Y", strtotime($event->end));

				$aux = array(
					'idEvent' 		=> $event->idEvent,
					'name'			=> $event->name,
					'start' 		=> $start,
					'end' 			=> $end,
					'enrollments' 	=> $enrollments,
					'actions'	 	=> "<div class='btn-group btn-group-xs' role='group' aria-label='Ações'>
										<button id='pricebtn' class='btn btn-primary'><i class='fa fa-dollar'></i> Preços</button>
										<button id='editbtn' class='btn btn-warning'><i class='fa fa-pencil'></i> Editar</button>
										<button id='removebtn' class='btn btn-danger'><i class='fa fa-trash'></i> Deletar</button>
								 		</div>"
				);
				array_push($data, $aux);
			endforeach;

			echo json_encode(array('data' => $data));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	public function submitEvent()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') != 'A') )
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('events_model');

		//Validação
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$location = $this->input->post('location');
		$year = $this->input->post('year');
		if(empty($name) || empty($link) || empty($location) || empty($year) )
		{
			echo json_encode(array('boolean' => false, 'text' => 'Os dados não foram preenchidos corretamente.'));
			return;
		}

		//verifica operação
		$idEvent = $this->session->flashdata('idEvent');

		//valores via POST
		$event = array(
			'name' 		=> $this->input->post('name'),
			'start'		=> $this->input->post('start'),
			'end' 		=> $this->input->post('end'),
			'link'		=> $this->input->post('link'),
			'location' 	=> $this->input->post('location'),
			'year' 		=> $this->input->post('year')
		);
		if(isset($_POST['enrollments']))
			$event['enrollments'] = 'S';
		else $event['enrollments'] = 'N';

		// Se o id não existe, então adiciona novo evento
		if(empty($idEvent))
		{
			if($this->events_model->add($event)){
				echo json_encode(array('boolean' => true, 'text' => 'Evento adicionado com sucesso !<br> NÃO ESQUEÇA DE ADICIONAR OS PREÇOS !!'));
				return;
			}
		}
		else
		{
			//Se existe o id, então edita
			if($this->events_model->edit($event, $idEvent)){
				echo json_encode(array('boolean' => true, 'text' => 'Evento atualizado com sucesso !'));
				return;
			}
		}

		echo json_encode(array('boolean' => false, 'text' => 'Ocorreu algum erro durante a operação. Tente novamente.'));
	}

	public function remove()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') != 'A') )
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('events_model');
		$idEvent = $this->input->post('idEvent');

		//deleta preços
		$this->load->model('amounts_events_model');
		$this->amounts_events_model->removeEvent($idEvent);

		//deleta usuários vinculados ao evento
		$this->load->model('users_registered_model');
		$this->users_registered_model->removeEvent($idEvent);


		if($this->events_model->remove($idEvent))
			echo json_encode(array('boolean'=>true, 'text' => 'Evento deletado com sucesso !'));
		else echo json_encode(array('boolean'=>false, 'text' => 'Algo deu errado, tente novamente.'));
	}

	/* PRICES */
	public function submitPrice()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') != 'A') )
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('amounts_events_model');

		//Validação
		$type = $this->input->post('type');
		$price = $this->input->post('price');
		if( empty($type) || empty($price) )
		{
			echo json_encode(array('boolean' => false, 'text' => 'Os dados não foram preenchidos corretamente.'));
			return;
		}

		//verifica operação
		$idAmount = $this->session->flashdata('idAmount');

		//valores via POST
		$amount = array(
			'idTypeFK'			=> $this->input->post('type'),
			'idEventFK' 	=> $this->input->post('idEventFK'),
			'amount' 			=> $this->input->post('price')
		);

		// Se o id não existe, então adiciona novo preço
		if(empty($idAmount))
		{
			// Antes de adicionar, verifico se ja existe esse preço pro TIPO
			if($this->amounts_events_model->verifyType($this->input->post('type'), $this->input->post('idEventFK'))){
				echo json_encode(array('boolean' => false, 'text' => 'O preço para esse tipo já existe. Edite o existente !'));
				return;
			}
			if($this->amounts_events_model->add($amount)){
				echo json_encode(array('boolean' => true, 'text' => 'Preço adicionado com sucesso !'));
				return;
			}
		}
		else
		{
			//Se existe o id, então edita
			if($this->amounts_events_model->edit($amount, $idAmount)){
				echo json_encode(array('boolean' => true, 'text' => 'Preço atualizado com sucesso !'));
				return;
			}
		}

		echo json_encode(array('boolean' => false, 'text' => 'Ocorreu algum erro durante a operação. Tente novamente.'));
	}

	public function pricesDataTables(){
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('amounts_events_model');
		$prices = $this->amounts_events_model->get($this->input->post('idEventFK'));
		$data = array();
		if($prices){
			foreach($prices as $price):
				$aux = array(
					'idAmount' 	=> $price->idAmount,
					'type'		=> $price->name,
					'amount'	=> $price->amount,
					'actions'	=> "<div class='btn-group btn-group-xs' role='group' aria-label='Ações'>
										<button id='editPricebtn' class='btn btn-warning'><i class='fa fa-pencil'></i> Editar</button>
										<button id='removePricebtn' class='btn btn-danger'>Deletar <i class='fa fa-trash'></i></button>
								 	</div>"
				);
				array_push($data, $aux);
			endforeach;

			echo json_encode(array('data' => $data));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	public function removePrice()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') != 'A') )
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('amounts_events_model');
		$idAmount = $this->input->post('idAmount');
		if($this->amounts_events_model->remove($idAmount))
			echo json_encode(array('boolean'=>true, 'text' => 'Preço deletado com sucesso !'));
		else echo json_encode(array('boolean'=>false, 'text' => 'Algo deu errado, tente novamente.'));
	}

	public function searchPrice()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') != 'A') )
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('amounts_events_model');
		$idAmount = $this->input->post('idAmount');

		$this->session->set_flashdata('idAmount', $idAmount);

		if($amount = $this->amounts_events_model->getId($idAmount)){
			echo json_encode(array('boolean' => true, 'text'=> 'Informações inseridas no formulário ! <br>Faça as alterações abaixo.', 'obj' => $amount));
		}else{
			echo json_encode(array('boolean' => false, 'text' => 'Não foi possível encontrar o preço.'));
		}
	}
}