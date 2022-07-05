<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roundtable extends CI_Controller {

	public function index()
	{
		if (!$this->session->userdata('logged') || ($this->session->userdata('role') != 'A'))
		{
			$this->load->view('control_view/error');
			return;
		}
		//eventos pro form do minicurso
		$this->load->model('events_model');
		$data['events'] = $this->events_model->get();

		$this->load->view('includes/header');
		$this->load->view('roundtable', $data);
		$this->load->view('includes/footer');
	}

	public function dataTables(){
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('roundtable_model');
		$roundtables = $this->roundtable_model->get();
		$data = array();
		if($roundtables){
			foreach($roundtables as $roundtable):
				$aux = array(
					'idRoundtable' => $roundtable->idRoundtable,
					'event'		=> $roundtable->name,
					'actions'	 => "<div class='btn-group btn-group-xs' role='group' aria-label='Ações'>
										<button id='editbtn' class='btn btn-warning'><i class='fa fa-pencil'></i> Editar</button>
										<button id='removebtn' class='btn btn-danger'>Deletar <i class='fa fa-trash'></i></button>
								 		</div>"
				);
				array_push($data, $aux);
			endforeach;

			echo json_encode(array('data' => $data));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	public function search()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('roundtable_model');
		$idRoundtable = $this->input->post('idRoundtable');

		$this->session->set_flashdata('idRoundtable', $idRoundtable);

		if($roundtable = $this->roundtable_model->getId($idRoundtable)){
			echo json_encode(array('boolean' => true, 'text'=> 'Informações inseridas no formulário ! <br>Faça as alterações abaixo.', 'obj' => $roundtable));
		}else{
			echo json_encode(array('boolean' => false, 'text' => 'Não foi possível encontrar o evento.'));
		}

	}

	public function submitRoundtable()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') != 'A') )
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('roundtable_model');

		//Validação
		if(!$this->input->post('date') || !$this->input->post('start') || !$this->input->post('location') || !$this->input->post('end') )
		{
			echo json_encode(array('boolean' => false, 'text' => 'Os dados não foram preenchidos corretamente.'));
			return;
		}

		//verifica operação
		$idRoundtable = $this->session->flashdata('idRoundtable');

		//valores via POST
		$roundtable = array(
			'idEventFK' 	=> $this->input->post('event'),
			'start'			=> $this->input->post('start'),
			'end' 			=> $this->input->post('end'),
			'date'			=> $this->input->post('date'),
			'location' 		=> $this->input->post('location'),
			'description' 	=> $this->input->post('description')
		);


		// Se o id não existe, então adiciona novo evento
		if(empty($idRoundtable))
		{
			if($this->roundtable_model->add($roundtable)){
				echo json_encode(array('boolean' => true, 'text' => 'Mesa Redonda adicionado com sucesso !'));
				return;
			}
		}
		else
		{
			//Se existe o id, então edita
			if($this->roundtable_model->edit($roundtable, $idRoundtable)){
				echo json_encode(array('boolean' => true, 'text' => 'Mesa Redonda atualizada com sucesso !'));
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
		$this->load->model('roundtable_model');
		$idRoundtable = $this->input->post('idRoundtable');
		if($this->roundtable_model->remove($idRoundtable))
			echo json_encode(array('boolean'=>true, 'text' => 'Mesa Redonda deletada com sucesso !'));
		else echo json_encode(array('boolean'=>false, 'text' => 'Algo deu errado, tente novamente.'));
	}

}