<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        //$this->load->database();
        date_default_timezone_set('Europe/Madrid');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encrypt');
        $this->load->model('User_Model');
        $this->load->model('Email_model');

        $this->load->library('grocery_CRUD');

    }

    public function validarUsuario()
    {

        $user = $this->input->post('user');
        $password = $this->input->post('password');

        if ($this->User_Model->isValidUser($user, $password) == true) {

            $datos = array(

                'user' => $user,
                'output' => "Panel De Control"

            );

        } else {

            $this->index();

        }

        $this->load->view('admin/vista_admin',$datos);

    }

    public function index()
    {
        $this->load->view('admin/index.php');
    }


    public function usuarios()
    {


        $crud = new grocery_CRUD();
        $crud->set_table("usuarios");
        $crud->required_fields('email', 'clave', 'nombre');
        $crud->field_type('clave', 'password');

        $crud->set_relation('idrol', 'roles', 'descripcion');
        $crud->display_as('idrol','Rol');


        $crud->callback_before_insert(array($this->User_Model, 'encrypt_password_callback'));


        $output = $crud->render();

        $this->cargarVista($output);


    }


    public function incidencias()
    {

        $crud = new Grocery_CRUD();
        $crud->set_table('incidencias');

        $crud->set_relation('idtipo', 'tipos_incidencias', 'descripcion');
        $crud->set_relation('idusuario', 'usuarios', 'nombre');

        $crud->columns('numero', 'idtipo', 'descripcion', 'estado', 'fecha_alta', 'idusuario');
        $crud->add_fields('numero', 'idtipo', 'descripcion', 'fecha_alta', 'Idusuario');

        $crud->field_type('numero', 'hidden');
        $crud->field_type('fecha_alta', 'hidden');
        $crud->field_type('Idusuario', 'hidden');

        $crud->edit_fields('id','idtipo', 'descripcion', 'estado', 'Idusuario','fecha_fin');

        $crud->callback_before_insert(array($this->User_Model, 'alta_incidencia_callback'));
        $crud->callback_before_update(array($this->User_Model,'editar_incidencia_callback'));

        $crud->display_as('idtipo', 'Tipo');

        $output = $crud->render();
        $this->cargarVista($output);
    }



    public function roles()
    {
        $crud = new Grocery_CRUD();
        //  $crud->set_table('usuarios');
        $output = $crud->render();
        $this->cargarVista($output);
    }

    public function tipos_incidencias()
    {
        $crud = new Grocery_CRUD();

        //  $crud->set_table('usuarios');
        $crud->set_relation('idusuario', 'usuarios', 'nombre');
        $crud->set_relation('idusuario2', 'usuarios', 'nombre');
        $crud->set_relation('idusuario3', 'usuarios', 'nombre');
        $output = $crud->render();
        $this->cargarVista($output);
    }


    public function historial(){

        $crud = new Grocery_CRUD();
        $crud->set_table('incidencias');

        $crud->columns('numero', 'idtipo', 'descripcion', 'estado', 'fecha_alta', 'idusuario','dias');

        $crud->callback_column("dias", array($this->User_Model, 'dias_callback'));

        $crud->display_as('idtipo', 'Tipo');

        $output = $crud->render();
        $this->cargarVista($output);



    }




    function cargarVista($output)
    {
        $this->load->view('admin/vista_admin.php', $output);
    }



    public function logout(){

        $userData = array(

            'user_id' => '',
            'user_email' => '',
            'user_name' => ''

        );

        $this->session->sess_destroy();
        $this->index();
    }

}
