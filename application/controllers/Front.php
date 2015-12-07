<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Front_Controlador extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->model('Incidencias_Model');

    }

    public function index(){

        $datos['incidencias']= $this->Incidencias_Model->getAllIncidencias(1);

        $this->load->view('front/index.php',$datos);


    }

}
