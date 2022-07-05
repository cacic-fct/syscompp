<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificates extends CI_Controller {

	public function index()
	{
		if (!$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('events_model');

		$events = $this->events_model->get();
		$data = array(
				'events' => $events
			);

		$this->load->view('includes/header');
		$this->load->view('certificates', $data);
		$this->load->view('includes/footer');
	}

	public function certificate($idEvent = 0)
	{
		if (!$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		$this->load->model('users_model');
		$this->load->model('users_registered_model');
		$this->load->model('presence_lectures_model');
		$this->load->model('presence_shortcourses_model');
		$this->load->model('events_model');

		if($this->users_registered_model->verify_registered($this->session->userdata('id'), $idEvent))
		{
			//palestras nas quais o usuário esteve presente.
			$allLectures 		= $this->presence_lectures_model->getByUser($this->session->userdata('id'));
			$allShortcourses 	= $this->presence_shortcourses_model->getByUser($this->session->userdata('id'));
			$event 				= $this->events_model->getId($idEvent);
			$user 				= $this->users_model->getId($this->session->userdata('id'));

			$lectures = array(); // palestras do evento especifico.
			if($allLectures){
				foreach($allLectures as $item):
					if($item->idEventFK == $idEvent):
						array_push($lectures, $item);
					endif;
				endforeach;
			}

			$shortcourses = array(); // palestras do evento especifico.
			if($allShortcourses){
				foreach($allShortcourses as $item):
					if($item->idEventFK == $idEvent):
						array_push($shortcourses, $item);
					endif;
				endforeach;
			}

			$data = array(
					'lectures' 		=> $lectures,
					'shortcourses'  => $shortcourses,
					'event'			=> $event,
					'user'			=> $user
				);

			//Só gero o certificado se participou de pelo menos 1 palestra ou minicurso.
			if(count($lectures) != 0 || count($shortcourses) != 0){
				//Geração do certificado !
			    require_once(APPPATH.'third_party/mpdf2/mpdf.php');

			    $template_pdf .= $this->load->view('certificates/headers/header'.$idEvent, $data, TRUE);
			    $template_pdf .= $this->load->view('certificates/user', $data, TRUE);
			    $template_pdf .= $this->load->view('certificates/footers/'.$idEvent, $data, TRUE);

			    $mPDF=new mPDF('win-1252','A4','','',20,15,48,25,10,10);

				$mPDF->AddPage
				(
					'L', // L - landscape, P - portrait
		            '', '', '', '',
		            30, // margin_left
		            30, // margin right
		            00, // margin top
		            00, // margin bottom
		            00, // margin header
		            00  // margin footer
				);
				$mPDF->SetTitle("Certificado de Participação");
				$mPDF->SetAuthor("SYSCOMPP");
				$mPDF->SetWatermarkImage(FCPATH.'assets/certificates/watermarks/'.$idEvent.'.png', 1, 'F');
				$mPDF->showWatermarkImage = true;

				$mPDF->SetDisplayMode('fullwidth');

				//load do Conteúdo
				$mPDF->WriteHTML($template_pdf);

			    $mPDF->Output();
				exit;
			}
			else
			{
				echo "Não foi possível gerar o certificado, pois você não participou de nenhuma palestra e nenhum minicurso.";
			}
		}
		else
		{
			echo "Certificado não encontrado.";
		}

	}

	public function certificateLecture($idEvent = 0)
	{
		if (!$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('users_model');
		$this->load->model('users_lectures_model');
		$this->load->model('lectures_model');
		$this->load->model('events_model');

			
		$user 				= $this->users_model->getId($this->session->userdata('id'));
		$allLectures 	= $this->lectures_model->getEvent($idEvent);
		$event 				= $this->events_model->getId($idEvent);

		$lectures = array(); // palestras que foram apresentadas pelo usuário
		if($allLectures){
			foreach($allLectures as $item):
				$exists = $this->users_lectures_model->exists($this->session->userdata('id'), $item->idLecture);
				if($exists):
					array_push($lectures, $item);
				endif;
			endforeach;
		}

		$data = array(
			'lectures' => $lectures,
			'user'		=> $user,
			'event' => $event
		);

		//Só gero o certificado se apresentou pelo menos 1 palestra
		if(count($lectures) != 0){
			//Geração do certificado !
		    require_once(APPPATH.'third_party/mpdf2/mpdf.php');

		    $template_pdf .= $this->load->view('certificates/headers/header'.$idEvent, $data, TRUE);
		    $template_pdf .= $this->load->view('certificates/user_lecture', $data, TRUE);
		    $template_pdf .= $this->load->view('certificates/footers/'.$idEvent, $data, TRUE);

		    $mPDF=new mPDF('win-1252','A4','','',20,15,48,25,10,10);

			$mPDF->AddPage
			(
				'L', // L - landscape, P - portrait
	            '', '', '', '',
	            30, // margin_left
	            30, // margin right
	            00, // margin top
	            00, // margin bottom
	            00, // margin header
	            00  // margin footer
			);
			$mPDF->SetTitle("Certificado de Palestrante");
			$mPDF->SetAuthor("SYSCOMPP");
			$mPDF->SetWatermarkImage(FCPATH.'assets/certificates/watermarks/'.$idEvent.'.png', 1, 'F');
			$mPDF->showWatermarkImage = true;

			$mPDF->SetDisplayMode('fullwidth');

			//load do Conteúdo
			$mPDF->WriteHTML($template_pdf);

		    $mPDF->Output();
			exit;
		}
		else
		{
			echo "Não foi possível gerar o certificado, pois você não palestrou.";
		}

	}

	public function certificateShortcourse($idEvent = 0)
	{
		if (!$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('users_model');
		$this->load->model('users_shortcourses_model');
		$this->load->model('shortcourses_model');
		$this->load->model('events_model');

			
		$user 						= $this->users_model->getId($this->session->userdata('id'));
		$allShortcourses 	= $this->shortcourses_model->getEvent($idEvent);
		$event 						= $this->events_model->getId($idEvent);

		$shortcourses = array(); // palestras que foram apresentadas pelo usuário
		if($allShortcourses){
			foreach($allShortcourses as $item):
				$exists = $this->users_shortcourses_model->exists($this->session->userdata('id'), $item->idShortcourse);
				if($exists):
					array_push($shortcourses, $item);
				endif;
			endforeach;
		}

		$data = array(
			'shortcourses' 	=> $shortcourses,
			'user'					=> $user,
			'event' 				=> $event
		);

		//Só gero o certificado se apresentou pelo menos 1 minicurso
		if(count($shortcourses) != 0){
			//Geração do certificado !
		    require_once(APPPATH.'third_party/mpdf2/mpdf.php');

		    $template_pdf .= $this->load->view('certificates/headers/header'.$idEvent, $data, TRUE);
		    $template_pdf .= $this->load->view('certificates/user_shortcourse', $data, TRUE);
		    $template_pdf .= $this->load->view('certificates/footers/'.$idEvent, $data, TRUE);

		    $mPDF=new mPDF('win-1252','A4','','',20,15,48,25,10,10);

			$mPDF->AddPage
			(
				'L', // L - landscape, P - portrait
	            '', '', '', '',
	            30, // margin_left
	            30, // margin right
	            00, // margin top
	            00, // margin bottom
	            00, // margin header
	            00  // margin footer
			);
			$mPDF->SetTitle("Certificado de Ministrante");
			$mPDF->SetAuthor("SYSCOMPP");
			$mPDF->SetWatermarkImage(FCPATH.'assets/certificates/watermarks/'.$idEvent.'.png', 1, 'F');
			$mPDF->showWatermarkImage = true;

			$mPDF->SetDisplayMode('fullwidth');

			//load do Conteúdo
			$mPDF->WriteHTML($template_pdf);

		    $mPDF->Output();
			exit;
		}
		else
		{
			echo "Não foi possível gerar o certificado, pois você não ministrou.";
		}

	}
}
