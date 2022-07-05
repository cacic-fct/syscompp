<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shortcourses extends CI_Controller {

	public function index()
	{
		if (!$this->session->userdata('logged') || ($this->session->userdata('role') != 'A') )
		{
			$this->load->view('control_view/error');
			return;
		}
		//eventos pro form do minicurso
		$this->load->model('events_model');
		$data['events'] = $this->events_model->get();

		//tipos pro form do preço
		$this->load->model('types_model');
		$data['types'] = $this->types_model->get();

		//usuários que serão ministrantes
		$this->load->model('users_model');
		$data['users'] = str_replace("'","\'",json_encode($this->users_model->get()));


		$this->load->view('includes/header');
		$this->load->view('shortcourses', $data);
		$this->load->view('includes/footer');
	}

	public function search()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('shortcourses_model');
		$idShortcourse = $this->input->post('idShortcourse');

		$this->session->set_flashdata('idShortcourse', $idShortcourse);

		// busco os ministrantes
		$this->load->model('users_shortcourses_model');
		$this->load->model('users_model');
		$users = $this->users_shortcourses_model->getId($idShortcourse);
		$names = array();
		foreach ($users as $id)
		{
			array_push($names, $id->idUserFK);
		}

		if($shortcourse = $this->shortcourses_model->getId($idShortcourse)){
			$shortcourse->panelists = $names;
			echo json_encode(array('boolean' => true, 'text'=> 'Informações inseridas no formulário ! <br>Faça as alterações abaixo.', 'obj' => $shortcourse));
		}else{
			echo json_encode(array('boolean' => false, 'text' => 'Não foi possível encontrar o minicurso.'));
		}
	}

	public function dataTables(){
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('shortcourses_model');
		$shortcourses = $this->shortcourses_model->get();
		$data = array();
		if($shortcourses){
			foreach($shortcourses as $shortcourse):
				$aux = array(
					'idShortcourse' => $shortcourse->idShortcourse,
					'name'			=> $shortcourse->name,
					'event'			=> $shortcourse->event,
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

	public function submitShortcourse()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') != 'A') )
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('shortcourses_model');

		//Validação
		$name 				= $this->input->post('name');
		$description 	= $this->input->post('description');
		$panelist 	 	= $this->input->post('panelist');
		if( empty($name) || empty($description) || empty($panelist) )
		{
			echo json_encode(array('boolean' => false, 'text' => 'Os dados não foram preenchidos corretamente.'));
			return;
		}

		//verifica operação
		$idShortcourse = $this->session->flashdata('idShortcourse');

		//valores via POST
		$shortcourse = array(
			'idEventFK'		=> $this->input->post('event'),
			'name' 				=> $this->input->post('name'),
			'vacancies' 	=> $this->input->post('vacancies'),
			'description'	=> $this->input->post('description'),
			'workload'		=> $this->input->post('workload'),
			'code'				=> $this->input->post('code'),
		);

		// Se o id não existe, então adiciona novo Minicurso
		if(empty($idShortcourse))
		{
			if($idShortcourseFK = $this->shortcourses_model->add($shortcourse)){

				//rollback ministrantes
				$this->load->model('users_shortcourses_model');
				$panelists = explode(',',$this->input->post('panelist'));
				$this->users_shortcourses_model->remove($idShortcourseFK);

				foreach ($panelists as $panelist)
				{
					$this->users_shortcourses_model->add(array('idUserFK' => $panelist, 'idShortcourseFK' => $idShortcourseFK));
				}

				echo json_encode(array('boolean' => true, 'text' => 'Minicurso adicionado com sucesso ! <br> NÃO ESQUEÇA DE ADICIONAR OS PREÇOS !!'));
				return;
			}
		}
		else
		{
			//Se existe o id, então edita
			$this->shortcourses_model->edit($shortcourse, $idShortcourse);

			//rollback ministrantes
			$this->load->model('users_shortcourses_model');
			$panelists = explode(',',$this->input->post('panelist'));
			$this->users_shortcourses_model->remove($idShortcourse);

			foreach ($panelists as $panelist)
			{
				$this->users_shortcourses_model->add(array('idUserFK' => $panelist, 'idShortcourseFK' => $idShortcourse));
			}

			echo json_encode(array('boolean' => true, 'text' => 'Minicurso atualizado com sucesso !'));
			return;
		}



		echo json_encode(array('boolean' => false, 'text' => 'Ocorreu algum erro durante a operação. Tente novamente.'));
	}

	public function remove()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') != 'A'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('shortcourses_model');
		$idShortcourse = $this->input->post('idShortcourse');

		//rollback ministrantes
		$this->load->model('users_shortcourses_model');
		$this->users_shortcourses_model->remove($idShortcourse);

		//deleta preços
		$this->load->model('amounts_shortcourses_model');
		$this->amounts_shortcourses_model->removeShortcourse($idShortcourse);

		//deleta usuários vinculados ao minicurso
		$this->load->model('users_registered_shortcourses_model');
		$this->users_registered_shortcourses_model->removeShortcourse($idShortcourse);

		if($this->shortcourses_model->remove($idShortcourse))
			echo json_encode(array('boolean'=>true, 'text' => 'Minicurso deletado com sucesso !'));
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

		$this->load->model('amounts_shortcourses_model');

		//Validação
		$type  = $this->input->post('type');
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
			'idShortcourseFK' 	=> $this->input->post('idShortcourseFK'),
			'amount' 			=> $this->input->post('price')
		);

		// Se o id não existe, então adiciona novo preço
		if(empty($idAmount))
		{
			// Antes de adicionar, verifico se ja existe esse preço pro TIPO
			if($this->amounts_shortcourses_model->verifyType($this->input->post('type'), $this->input->post('idShortcourseFK'))){
				echo json_encode(array('boolean' => false, 'text' => 'O preço para esse tipo já existe. Edite o existente !'));
				return;
			}
			if($this->amounts_shortcourses_model->add($amount)){
				echo json_encode(array('boolean' => true, 'text' => 'Preço adicionado com sucesso !'));
				return;
			}
		}
		else
		{
			//Se existe o id, então edita
			if($this->amounts_shortcourses_model->edit($amount, $idAmount)){
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

		$this->load->model('amounts_shortcourses_model');
		$prices = $this->amounts_shortcourses_model->get($this->input->post('idShortcourseFK'));
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

		$this->load->model('amounts_shortcourses_model');
		$idAmount = $this->input->post('idAmount');
		if($this->amounts_shortcourses_model->remove($idAmount))
			echo json_encode(array('boolean'=>true, 'text' => 'Preço deletado com sucesso !'));
		else echo json_encode(array('boolean'=>false, 'text' => 'Algo deu errado, tente novamente.'));
	}

	public function searchPrice()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('amounts_shortcourses_model');
		$idAmount = $this->input->post('idAmount');

		$this->session->set_flashdata('idAmount', $idAmount);

		if($amount = $this->amounts_shortcourses_model->getId($idAmount)){
			echo json_encode(array('boolean' => true, 'text'=> 'Informações inseridas no formulário ! <br>Faça as alterações abaixo.', 'obj' => $amount));
		}else{
			echo json_encode(array('boolean' => false, 'text' => 'Não foi possível encontrar o preço.'));
		}
	}

	/** REGISTRO DE MINICURSOS **/
	public function register()
	{
		if (!$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		//loads models
		$this->load->model('events_model');
		$this->load->model('users_registered_model');
		$this->load->model('shortcourses_model');
		$this->load->model('users_registered_shortcourses_model');
		$this->load->model('users_model');
		$this->load->model('users_shortcourses_model');


		$events = $this->events_model->get();

		$allData = array();
		foreach($events as $event):
			//verifico se está registrado no evento
			if($this->users_registered_model->verify_registered($this->session->userdata('id'), $event->idEvent) && $event->enrollments == 'S'){

				$shortcourses = array();
				$tempShortcourses = $this->shortcourses_model->getEvent($event->idEvent);

				if(!empty($tempShortcourses)):
					foreach($tempShortcourses as $shortcourse):
						if($this->users_registered_shortcourses_model->verify_registered($this->session->userdata('id'), $event->idEvent, $shortcourse->idShortcourse)){
							$shortcourse->isRegistered = true;
						}else{
							$shortcourse->isRegistered = false;
						}
						array_push($shortcourses, $shortcourse);

						//busco ministrantes e armazeno no array do minicurso
						$panelists = array();
						$usersFK = $this->users_shortcourses_model->getId($shortcourse->idShortcourse);
						foreach($usersFK as $id):
							array_push($panelists, $this->users_model->getId($id->idUserFK)->name);
						endforeach;
						$shortcourse->panelists = $panelists;

					endforeach;
				endif;

				$item = array
				(
					'idEvent'		=> $event->idEvent,
					'event' 		=> $event->name,
					'shortcourses'  => $shortcourses
				);

				array_push($allData, $item);
			}
		endforeach;

		$data['events'] = $allData;

		$this->load->view('includes/header');
		$this->load->view('shortcourses_register', $data);
		$this->load->view('includes/footer');
	}

	public function registerShortcourse()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$idEventFK 		 = $this->input->post('idEvent');
		$idShortcourseFK = $this->input->post('idShortcourse');
		$idUserFK  		 = $this->session->userdata('id');
		$idTypeFK  		 = $this->session->userdata('type');

		//Salvo id's
		$register['idEventFK'] 		 = $idEventFK;
		$register['idUserFK']  		 = $idUserFK;
		$register['idShortcourseFK'] = $idShortcourseFK;

		$this->load->model('shortcourses_model');
		$this->load->model('users_registered_shortcourses_model');

		// Se o minicurso estiver lotado, já retorno e não deixo registrar.
		$vacancies = $this->shortcourses_model->getId($idShortcourseFK)->vacancies; //qtd de vagas de cada minicurso
		if($this->users_registered_shortcourses_model->countShortcourse($idShortcourseFK) >= $vacancies)
		{
			echo json_encode(array('boolean' => false, 'text' => 'Infelizmente não foi possível a inscrição. O Minicurso está LOTADO.'));
			return;
		}

		// Busca o preço filtrando pelo tipo e o evento no qual desejo me inscrever
		$this->load->model('amounts_shortcourses_model');
		$register['amount'] = $this->amounts_shortcourses_model->amount($idShortcourseFK, $idTypeFK)->amount;

		// Se ele tiver os créditos, deixo o preço 0 e tiro o credito
		$this->load->model('users_model');
		$tempUser = $this->users_model->getId($idUserFK);
		$credits = $tempUser->creditShortcourses;

		$this->load->model('users_registered_model');
		if($credits > 0)
		{
			$user['creditShortcourses'] = $credits - 1;
			$this->users_model->edit($user, $idUserFK);
			$register['amount'] = 0.00;
			//$register['status'] = 'S';
		}

		if($this->users_registered_shortcourses_model->add($register)){
			echo json_encode(array('boolean' => true, 'text' => 'Inscrição realizada com sucesso !'));
			return;
		}

		echo json_encode(array('boolean' => false, 'text' => 'Algo deu errado. Tente novamente !'));
	}

	/** FIM REGISTRO DE MINICURSOS **/
}