<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System extends CI_Controller {

	public function index()
	{
		$this->load->model('types_model');
		$data['types'] = $this->types_model->get();
		$this->load->view('index', $data);
	}

	public function invoices()
	{
		if (!$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		// PARA O EVENTO ENCARDIO
		$this->load->model('users_registered_model');
		$events = $this->users_registered_model->getId($this->session->userdata('id'));
		$data['amount'] = 0.0;
		$data['encardio'] = false;
		foreach($events as $event):
			if($event->idEventFK == 7){
				$data['amount'] = $event->amount;
				$data['encardio'] = true;
			}
		endforeach;

		$this->load->model('users_registered_shortcourses_model');
		$this->load->model('events_model');
		$shortcoursesArray = array();
		if($shortcourses = $this->users_registered_shortcourses_model->getId($this->session->userdata('id')))
		{
			foreach($shortcourses as $shortcourse):
				if($shortcourse->status == 'N' && $this->events_model->getId($shortcourse->idEventFK)->idEvent == 7){
					$data['amount'] += $shortcourse->amount;
				}
			endforeach;
		}

		$data['amount'] = number_format($data['amount'], 2, ',', '.');

		$this->load->view('includes/header');
		$this->load->view('invoices', $data);
		$this->load->view('includes/footer');
	}

	// temporário
	public function invoice()
	{
		if (!$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}
		// Busca os dados para boleto
		$this->load->model('users_registered_model');
		$this->load->model('users_registered_shortcourses_model');
		$this->load->model('events_model');
		$this->load->model('users_model');

		$data['user'] = $this->users_model->getId($this->session->userdata('id'));

		$eventsArray = array();
		if($events = $this->users_registered_model->getId($this->session->userdata('id')))
		{
			foreach($events as $event):
				if($event->status == 'N' && $this->events_model->getId($event->idEventFK)->year == date("Y")){
					array_push($eventsArray, $event);
				}
			endforeach;
		}

		$data['events'] = $eventsArray;

		$shortcoursesArray = array();
		if($shortcourses = $this->users_registered_shortcourses_model->getId($this->session->userdata('id')))
		{
			foreach($shortcourses as $shortcourse):
				if($shortcourse->status == 'N' && $this->events_model->getId($shortcourse->idEventFK)->year == date("Y")){
					array_push($shortcoursesArray, $shortcourse);
				}
			endforeach;
		}

		$data['shortcourses'] = $shortcoursesArray;

		//Geração do boleto !
	    require_once(APPPATH.'third_party/mpdf2/mpdf.php');

	    $template_pdf = $this->load->view('invoice', $data, TRUE);

	    $mPDF=new mPDF('win-1252','A4','','',20,15,48,25,10,10);
		for ($i=1; $i < 4; $i++)
		{
			$mPDF->AddPage();
			$mPDF->useOnlyCoreFonts = true;    // false is default
			$mPDF->SetProtection(array('print'));
			$mPDF->SetTitle("Boleto Semana da Computação de Presidente Prudente");
			$mPDF->SetAuthor("SYSCOMPP");
			$mPDF->SetWatermarkText($i."ª Via");
			$mPDF->showWatermarkText = true;
			$mPDF->watermark_font = 'DejaVuSansCondensed';
			$mPDF->watermarkTextAlpha = 0.1;
			$mPDF->SetDisplayMode('fullpage');

			//load do Conteúdo
			$mPDF->WriteHTML($template_pdf);
		}

	    $mPDF->Output();
		exit;

	}

	public function home()
	{
		if (!$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		//aviso do WRVA gratuito
		$this->load->model('users_registered_model');
		if($this->users_registered_model->verify_registered($this->session->userdata('id'), 2) && $this->users_registered_model->verify_registered($this->session->userdata('id'), 1) == false )
			$data['free'] = true;
		else $data['free'] = false;

		$this->load->model('events_model');
		$this->load->view('includes/header');
		$this->load->view('home', $data);
		$this->load->view('includes/footer');
	}

	public function register(){
		if (!$this->input->is_ajax_request())
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('users_model');
		$this->load->model('details_model');
		$this->load->model('types_model');

		//Validação
		$name 					= $this->input->post('name');
		$rg 						= $this->input->post('rg');
		$cpf 						= $this->input->post('cpf');
		$email_form 		= $this->input->post('email_form');
		$password_form 	= $this->input->post('password_form');
		$type 					= $this->input->post('type');
		if( empty($name) || empty($rg) || empty($cpf) || empty($email_form) || empty($password_form) || empty($type) ){
			echo json_encode(array('boolean' => false, 'text' => 'Dados inconsistentes ! Tente novamente.'));
			return;
		}

		if($this->users_model->emailExist($this->input->post('email_form'))){
			echo json_encode(array('boolean' => false, 'text' => 'Email já registrado !'));
			return;
		}

		if(strcmp($this->input->post('password_form'), $this->input->post('password_confirmation')) != 0){
			echo json_encode(array('boolean' => false, 'text' => 'As senhas estão diferentes !'));
			return;
		}

		if(strcmp($this->input->post('email_form'), $this->input->post('email_confirmation')) != 0){
			echo json_encode(array('boolean' => false, 'text' => 'Os emails estão diferentes !'));
			return;
		}

		// Salva detalhes do usuário
		$detail = array(
			'name' 			=> strtoupper($this->input->post('name')),
			'rg'			=> $this->input->post('rg'),
			'issuing' 		=> strtoupper($this->input->post('issuing')),
			'cpf'			=> $this->input->post('cpf')
			);
		$detailFK = $this->details_model->add($detail);

		// Por fim salva usuário com os relacionamentos
		$user = array(
			'email' 		=> $this->input->post('email_form'),
			'password' 		=> sha1($this->input->post('password_form')),
			'idTypeFK'		=> $this->input->post('type'),
			'idDetailFK'	=> $detailFK
			);
		if($this->users_model->add($user)){
			echo json_encode(array('boolean' => true, 'text' => 'Seu usuário foi cadastrado com sucesso !'));
		};
	}

	public function login()
	{
		if (!$this->input->is_ajax_request())
		{
			$this->load->view('control_view/error');
			return;
		}

		$user['email'] = $this->input->post('email');
		$user['password'] = sha1($this->input->post('password'));


		$this->load->model('users_model');

		if($idUserFK = $this->users_model->doLogin($user))
		{
			$user['role'] 		= $this->users_model->getEmail($user['email'])->role;
			$user['idTypeFK']	= $this->users_model->getEmail($user['email'])->idTypeFK;
			$data =
				array(
					'id'	 => $idUserFK,
                   	'email'  => $user['email'],
                   	'type'   => $user['idTypeFK'],
                   	'role'	 => $user['role'],
                   	'logged' => TRUE
               	);

			$this->session->set_userdata($data);

			echo json_encode(array('boolean' => true));
			return;
		}

		echo json_encode(array('boolean' => false));
	}

	public function password()
	{
		if (!$this->input->is_ajax_request())
		{
			$this->load->view('control_view/error');
			return;
		}

		//Validação
		$this->load->model('users_model');

		if( $this->users_model->emailExist($this->input->post('email')) == false){
			echo json_encode(array('boolean' => false));
			return;
		}

		$this->load->helper('string');

		$email = $this->input->post('email');
		$password = random_string('alnum', 8);
		$user['password'] = sha1($password);

		$this->load->model('users_model');

		if($this->users_model->editEmail($user, $email))
		{
			$this->load->library('EmailEngine');

			$content = Array
			(
				'email' 	=> $email,
				'subject' 	=> 'SYSCOMPP - Senha de acesso',
				'view' 		=> 'control_view/email_password',
				'data'		=> array('password' => $password)
			);

			if($this->emailengine->send($content))
			{
				echo json_encode(array('boolean' => true));
				return;
			}
		}

		echo json_encode(array('boolean' => false));
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$this->index();
	}

	/** EVENTOS **/
	public function dataTablesEvent(){
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$this->load->model('events_model');
		$events = $this->events_model->get();
		$data = array();

		if($events){
			foreach($events as $event):

				//formata as datas
				$start = date("d/m/Y", strtotime($event->start));
				$end = date("d/m/Y", strtotime($event->end));

				$this->load->model('users_registered_model');

				// defino se foi pago ou não
				$payment = "<i class='fa fa-times' style='color:#D8000C; font-size:26px;'></i>";

				// Defino botão de inscrito
				$registered = "<button class='btn btn-primary' id='subscribe'>Inscrever-se</button>";
				if( $verify = $this->users_registered_model->verify_registered($this->session->userdata('id'), $event->idEvent) ){
					$registered = "<button class='btn btn-success' disabled>Inscrito</button> <a class='btn btn-default' href=\"".$this->config->base_url('index.php/system/invoices')."\">Ficha de Pagamento</a>";
					if($verify->status != 'N') $payment = "<i class='fa fa-check' style='color:#4F8A10; font-size:26px;''></i>";
				}

				$name = '<a href="'.$event->link.'" target="_blank">'.$event->name.'</a>';

				$aux = array(
					'idEvent' 		=> $event->idEvent,
					'name'			=> $name,
					'start' 		=> $start,
					'end' 			=> $end,
					'payment' 		=> $payment,
					'actions'	 	=> $registered
				);
				array_push($data, $aux);
			endforeach;

			echo json_encode(array('data' => $data));
		}else{
			echo json_encode(array('data' => ''));
		}
	}

	public function registerEvent()
	{
		if (!$this->input->is_ajax_request() || !$this->session->userdata('logged'))
		{
			$this->load->view('control_view/error');
			return;
		}

		$idEventFK = $this->input->post('idEvent');
		$idUserFK  = $this->session->userdata('id');
		$idTypeFK  = $this->session->userdata('type');

		//Salvo id do Evento e id do Usuário
		$register['idEventFK'] = $idEventFK;
		$register['idUserFK']  = $idUserFK;

		// Primeira verificação é se as inscrições estão abertas para um determinado evento.
		$this->load->model('events_model');
		if($this->events_model->getId($idEventFK)->enrollments == 'N'){
			echo json_encode(array('boolean' => false, 'text' => 'Não foi possível a inscrição. As inscrições estão fechadas !'));
			return;
		}

		// Se o evento for a SECOMPP 2019 e se o Aluno é da UNESP OU FATEC
		if( $idEventFK == 9 && ($idTypeFK == 1 || $idTypeFK == 2) )
		{
			$this->load->model('users_model');
			$user['creditShortcourses'] = 3;
			$this->users_model->edit($user, $this->session->userdata('id'));
		}

		// Se o evento for SECOMPP 2019 e se for professor ou profissional.
		if( $idEventFK == 9 && $idTypeFK == 3 )
		{
			$this->load->model('users_model');
			$user['creditShortcourses'] = 3;
			$this->users_model->edit($user, $this->session->userdata('id'));
		}

		// Busca o preço filtrando pelo tipo e o evento no qual desejo me inscrever
		$this->load->model('amounts_events_model');
		$register['amount'] = $this->amounts_events_model->amount($idEventFK, $idTypeFK)->amount;

		$this->load->model('users_registered_model');

		//Se já estiver cadastrado na SECOMPP, ganha WRVA
		// if($this->users_registered_model->verify_registered($this->session->userdata('id'), 2) && $idEventFK == 1){
		// 	$register['amount'] = 0.00;
		// 	//$register['status'] = 'S'; - só sera marco como pago quando pagar o SECOMPP, então WRVA será isento.
		// }

		if($this->users_registered_model->add($register)){
			echo json_encode(array('boolean' => true, 'text' => 'Inscrição realizada com sucesso !<br> Também foi liberado a geração do boleto para pagamento !'));
			return;
		}

		echo json_encode(array('boolean' => false, 'text' => 'Algo deu errado. Tente novamente !'));
	}

	/** FIM EVENTOS **/
}
