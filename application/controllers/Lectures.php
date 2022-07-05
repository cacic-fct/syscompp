<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lectures extends CI_Controller {

	public function index()
	{
		if (!$this->session->userdata('logged') || ($this->session->userdata('role') != 'A'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('events_model');
		$data['events'] = $this->events_model->get();

		//usuários que serão ministrantes
		$this->load->model('users_model');
		$data['users'] = str_replace("'","\'",json_encode($this->users_model->get()));

		$this->load->view('includes/header');
		$this->load->view('lectures', $data);
		$this->load->view('includes/footer');
	}

	public function search()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('lectures_model');
		$idLecture = $this->input->post('idLecture');

		$this->session->set_flashdata('idLecture', $idLecture);

		// busco os ministrantes
		$this->load->model('users_lectures_model');
		$this->load->model('users_model');
		$users = $this->users_lectures_model->getId($idLecture);
		$names = array();
		foreach ($users as $id)
		{
			array_push($names, $id->idUserFK);
		}

		if($lecture = $this->lectures_model->getId($idLecture)){
			$lecture->panelists = $names;
			echo json_encode(array('boolean' => true, 'text'=> 'Informações inseridas no formulário ! <br>Faça as alterações abaixo.', 'obj' => $lecture));
		}else{
			echo json_encode(array('boolean' => false, 'text' => 'Não foi possível encontrar o lectureo.'));
		}

	}

	public function dataTables(){
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('lectures_model');
		$lectures = $this->lectures_model->get();
		$data = array();
		if($lectures){
			foreach($lectures as $lecture):
				$aux = array(
					'idLecture' => $lecture->idLecture,
					'name'		=> $lecture->name,
					'event'		=> $lecture->event,
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

	public function submitlecture()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') != 'A') )
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('lectures_model');

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
		$idLecture = $this->session->flashdata('idLecture');

		//valores via POST
		$lecture = array(
			'idEventFK'		=> $this->input->post('event'),
			'name' 			=> $this->input->post('name'),
			'description'	=> $this->input->post('description')
		);

		// Se o id não existe, então adiciona novo Palestra
		if(empty($idLecture))
		{
			if($idLectureFK = $this->lectures_model->add($lecture)){
				//rollback ministrantes
				$this->load->model('users_lectures_model');
				$panelists = explode(',',$this->input->post('panelist'));
				$this->users_lectures_model->remove($idLectureFK);

				foreach ($panelists as $panelist)
				{
					$this->users_lectures_model->add(array('idUserFK' => $panelist, 'idLectureFK' => $idLectureFK));
				}

				echo json_encode(array('boolean' => true, 'text' => 'Palestra adicionada com sucesso !'));
				return;
			}
		}
		else
		{
			//Se existe o id, então edita
			$this->lectures_model->edit($lecture, $idLecture);
			//rollback ministrantes
			$this->load->model('users_lectures_model');
			$panelists = explode(',',$this->input->post('panelist'));
			$this->users_lectures_model->remove($idLecture);

			foreach ($panelists as $panelist)
			{
				$this->users_lectures_model->add(array('idUserFK' => $panelist, 'idLectureFK' => $idLecture));
			}

			echo json_encode(array('boolean' => true, 'text' => 'Palestra atualizada com sucesso !'));
			return;
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

		$idLecture = $this->input->post('idLecture');

		//rollback ministrantes
		$this->load->model('users_lectures_model');
		$this->users_lectures_model->remove($idLecture);

		$this->load->model('lectures_model');
		if($this->lectures_model->remove($idLecture))
			echo json_encode(array('boolean'=>true, 'text' => 'Palestra deletada com sucesso !'));
		else echo json_encode(array('boolean'=>false, 'text' => 'Algo deu errado, tente novamente.'));
	}
}