<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

  function __construct() {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "OPTIONS") {
        die();
    }
    parent::__construct();
  }
  
  // Pega toda informação de 1 evento por id
  public function getEvent($idEvent){
    // if (!$this->input->is_ajax_request() || empty($idEvent))
    // {
    //   $this->load->view('control_view/error');
    //   return;
    // }

    $this->load->model('events_model');
    $event = $this->events_model->getId($idEvent);

    if($event)
      echo json_encode($event);
    else
      echo json_encode(array());
  }

  // pega todos os minicursos de um evento especifico.
  public function getShortcourses($idEvent){
    // if (!$this->input->is_ajax_request() || empty($idEvent))
    // {
    //   $this->load->view('control_view/error');
    //   return;
    // }

    $this->load->model('shortcourses_model');
    $this->load->model('users_shortcourses_model');
    $shortcourses = $this->shortcourses_model->getApi($idEvent);

    foreach($shortcourses as $shortcourse):
      $users_shortcourses = $this->users_shortcourses_model->getApi($shortcourse->idShortcourse);
      $shortcourse->users = $users_shortcourses;
    endforeach;

    if($shortcourses)
      echo json_encode($shortcourses);
    else
      echo json_encode(array());
  }

  public function getShortcourse($idShortcourse){
    $this->load->model('shortcourses_model');
    $shortcourse = $this->shortcourses_model->getId($idShortcourse);

    if($shortcourse)
      echo json_encode($shortcourse);
    else
      echo json_encode(array());
  } 

  // pega todos as palestras de um evento especifico.
  public function getLectures($idEvent){
    // if (!$this->input->is_ajax_request() || empty($idEvent))
    // {
    //   $this->load->view('control_view/error');
    //   return;
    // }

    $this->load->model('lectures_model');
    $lectures = $this->lectures_model->getApi($idEvent);
    $this->load->model('users_lectures_model');

    foreach($lectures as $lecture):
      $users_lectures = $this->users_lectures_model->getApi($lecture->idLecture);
      $lecture->users = $users_lectures;
    endforeach;
    
    if($lectures)
      echo json_encode($lectures);
    else
      echo json_encode(array());
  } 

  public function getLecture($idLecture){
    $this->load->model('lectures_model');
    $lecture = $this->lectures_model->getId($idLecture);

    if($lecture)
      echo json_encode($lecture);
    else
      echo json_encode(array());
  } 


  // pega informações da mesa redonda de um evento especifico.
  public function getRoundTable($idEvent){
    // if (!$this->input->is_ajax_request() || empty($idEvent))
    // {
    //   $this->load->view('control_view/error');
    //   return;
    // }

    $this->load->model('roundtable_model');
    $roundtable = $this->roundtable_model->getEvent($idEvent);

    if($roundtable)
      echo json_encode($roundtable);
    else
      echo json_encode(array());
  } 


  /** TICKETS **/
  public function tickets()
  {
    // if (!$this->session->userdata('logged'))
    // {
    //   $this->load->view('control_view/error');
    //   return;
    // }
    $this->load->model('users_registered_model');
    $this->load->model('users_registered_shortcourses_model');
    $this->load->model('users_model');

    $eventsArray = array();
    if($events = $this->users_registered_model->getTickets())
    {
      foreach($events as $event):
        if($event->idEventFK == 9):
          $user         = $event->user;
          $shortcourses = $this->users_registered_shortcourses_model->getUserEvent($event->idUserFK, $event->idEventFK);
          $array = array(
            'idUser' => $event->idUserFK,
            'name' => $event->user,
            'shortcourses' => $shortcourses
          );
          array_push($eventsArray, $array);
        endif;
      endforeach;
    }

    //var_dump($eventsArray[0]['shortcourses'][0]->code);die;

    $data['users'] = $eventsArray;
    $data['url'] = APPPATH.'third_party/barcode/barcode.php';

    require_once(APPPATH.'third_party/mpdf2/mpdf.php');

    $template_pdf = $this->load->view('tickets', $data, TRUE);
    //$this->load->view('tickets', $data);
    $mPDF = new mPDF('win-1252','A4','','');

    $mPDF->SetProtection(array('print'));
    $mPDF->SetTitle("Tickets");
    $mPDF->SetAuthor("SYSCOMPP");
    $mPDF->SetDisplayMode('fullpage');

    //load do Conteúdo
    $mPDF->WriteHTML($template_pdf);

    $mPDF->Output();
    exit;

  }
}
