<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presences extends CI_Controller {
	public function index(){
		if (!$this->session->userdata('logged') || ($this->session->userdata('role') == 'U'))
		{
			$this->load->view('control_view/error');
			return;
		}

		// codigo de barras
		$this->load->model('shortcourses_model');
		$this->load->model('lectures_model');
		$data['shortcourses_select'] = $this->shortcourses_model->get();
		$data['lectures_select'] = $this->lectures_model->get();

		$this->load->view('includes/header');
		$this->load->view('presences', $data);
		$this->load->view('includes/footer');
	}

	public function shortcourses()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') == 'U'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_shortcourses_model');
		$this->load->model('presence_shortcourses_model');

		/** DataTables Minicursos **/
		$shortcourses = $this->users_registered_shortcourses_model->get();
		$data = array();

		if($shortcourses){
			foreach($shortcourses as $shortcourse):
				//Verifico se o usuário já tem presença
				if($this->presence_shortcourses_model->exists($shortcourse->idUserFK, $shortcourse->idShortcourseFK))
				$presence = "<button class='btn btn-danger' id='addPresence' idShortcourse='".$shortcourse->idShortcourseFK."'>Cancelar Presença</button>";
				else $presence = "<button class='btn btn-primary' id='addPresence' idShortcourse='".$shortcourse->idShortcourseFK."'>Dar Presença</button>";
				//Faço consulta só pra pegar o nome do usuário.
				$user = $this->users_model->getId($shortcourse->idUserFK);
				$item = array(
					'idUser'		=> $shortcourse->idUserFK,
					'user' 			=> $user->name,
					'shortcourse' 	=> $shortcourse->name,
					'actions' 		=> $presence
					);
				array_push($data, $item);
			endforeach;
			/** Fim DataTables Minicursos **/

			echo json_encode(array('data' => $data));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	public function presenceShortcourse()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') == 'U'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$idUserFK 		 = $this->input->post('idUser');
		$idShortcourseFK = $this->input->post('idShortcourse');

		$presence = array(
			'idUserFK' => $idUserFK,
			'idShortcourseFK' => $idShortcourseFK
			);

		$this->load->model('presence_shortcourses_model');

		$this->load->model('presence_lectures_model');
		$this->load->model('users_registered_shortcourses_model');
		$this->load->model('shortcourses_model');

		// se o usuário não estiver inscrito
		$idEventFK = $this->shortcourses_model->getId($idShortcourseFK)->idEventFK;
		if( $this->users_registered_shortcourses_model->verify_registered($idUserFK, $idEventFK, $idShortcourseFK) == false ){
			echo json_encode(array('boolean' => false, 'text' => 'Usuário não inscrito !!'));
			return;
		}

		if($this->presence_shortcourses_model->exists($idUserFK, $idShortcourseFK)){
			// ja existe então deleto
			if($this->presence_shortcourses_model->remove($idUserFK, $idShortcourseFK)){
				echo json_encode(array('boolean' => true, 'text' => 'Presença RETIRADA com sucesso !', 'button' => 'N'));
				return;
			}
		}else{
			if($this->presence_shortcourses_model->add($presence)){
				echo json_encode(array('boolean' => true, 'text' => 'Presença ADICIONADA com sucesso !', 'button' => 'S'));
				return;
			}
		}

		echo json_encode(array('boolean' => false, 'text' => 'Algo deu errado ! Tente novamente.'));
	}

	public function lectures()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') == 'U'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_model');
		$this->load->model('presence_lectures_model');

		$this->load->model('lectures_model');

		/** DataTables Palestras **/
		$events = $this->users_registered_model->get();
		$data = array();

		$lectures = $this->lectures_model->get();
		//var_dump($lectures);die;

		if($events && $lectures){
			foreach($events as $event):

				//Faço consulta só pra pegar o nome do usuário.
				$user = $this->users_model->getId($event->idUser);

				foreach($lectures as $lecture):

					if($this->presence_lectures_model->exists($event->idUserFK, $lecture->idLecture))
					$presence = "<button class='btn btn-danger' id='addPresence' idLecture='".$lecture->idLecture."'>Cancelar Presença</button>";
					else $presence = "<button class='btn btn-primary' id='addPresence' idLecture='".$lecture->idLecture."'>Dar Presença</button>";

					//verifico se a palestra é do evento atual.
					if($this->lectures_model->verifyEvent($lecture->idLecture, $event->idEventFK)){
						$item = array(
							'idUser'	=> $event->idUser,
							'user' 		=> $user->name,
							'lecture' 	=> $lecture->name,
							'actions' 	=> $presence
							);
						array_push($data, $item);
					}
				endforeach;
			endforeach;
			/** Fim DataTables Eventos **/

			echo json_encode(array('data' => $data));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	public function presenceLecture()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged') || ($this->session->userdata('role') == 'U'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$idUserFK    = $this->input->post('idUser');
		$idLectureFK = $this->input->post('idLecture');

		$presence = array(
			'idUserFK' => $idUserFK,
			'idLectureFK' => $idLectureFK
			);

		$this->load->model('presence_lectures_model');
		$this->load->model('users_registered_model');
		$this->load->model('lectures_model');

		// se o usuário não estiver inscrito
		if( $this->users_registered_model->verify_registered($idUserFK, $this->lectures_model->getId($idLectureFK)->idEventFK) == false ){
			echo json_encode(array('boolean' => false, 'text' => 'Usuário não inscrito !!'));
			return;
		}

		if($this->presence_lectures_model->exists($idUserFK, $idLectureFK)){
			// ja existe então deleto
			if($this->presence_lectures_model->remove($idUserFK, $idLectureFK)){
				echo json_encode(array('boolean' => true, 'text' => 'Presença RETIRADA com sucesso !', 'button' => 'N'));
				return;
			}
		}else{
			if($this->presence_lectures_model->add($presence)){
				echo json_encode(array('boolean' => true, 'text' => 'Presença ADICIONADA com sucesso !', 'button' => 'S'));
				return;
			}
		}

		echo json_encode(array('boolean' => false, 'text' => 'Algo deu errado ! Tente novamente.'));
	}
}