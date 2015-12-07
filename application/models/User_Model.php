<?php
/**
 * Created by PhpStorm.
 * User: Alberto
 * Date: 26/11/2015
 * Time: 20:22
 */

class User_Model extends CI_model {

    public function __construct(){
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        $this->load->library('encrypt');
        //$this->load->helper('url');
        $this->load->library('session');

    }

    public function isValidUser($user,$pass){

        $sql ="SELECT * FROM usuarios WHERE email = ?";


        $query = $this->db->query($sql,array($user));

        if($query->num_rows() == 1) {


            $fila = $query->row();
            $clave_cifrado = $fila->clave;

            $clave_descodificada = $this->encrypt->decode($clave_cifrado);

            if ($clave_descodificada == $pass) {

                $userData = array(

                    'user_id' => $fila->id,
                    'user_email' => $fila->email,
                    'user_name' => $fila->nombre,

                );

                $this->session->set_userdata($userData);

                return true;
            }

            } else {

                return false;

            }

        }


    public function encryptPassword($crud,$usuario){

        //$crud = new grocery_CRUD();

        $crud->callback_before_insert(array($usuario, 'encrypt_password_callback'));

        return true;




    }

    public function getMailByTipoIncidencia($idIncidencia){

        $sql ="SELECT u.id, u.email, i.idusuario FROM usuarios AS u , tipos_incidencias AS i WHERE i.idtipo = ? AND i.idusuario = u.id";

        $query = $this->db->query($sql,$idIncidencia);
        $fila = $query->row();

        return $fila->email;


    }

    public function getMailUsuarioCerrarSesion($idIncidencia){

        $sql ="SELECT u.id, u.email, i.idusuario FROM usuarios AS u , incidencia AS i WHERE i.id = ? AND i.idusuario = u.id";

        $query = $this->db->query($sql,$idIncidencia);
        $fila = $query->row();

        return $fila->email;


    }

    public function alta_incidencia_callback($post_array)
    {

        $idIncidencia = date('YmdHis');
        $fechaAlta = date('Y-m-d H:i:s');

        $idUsuario = $this->session->userdata('user_id');

        $post_array['numero'] = $idIncidencia;
        $post_array['fecha_alta'] = $fechaAlta;
        $post_array['Idusuario'] = $idUsuario;

        //Partiendo del tipo de incidencia averiguar que usuario es y mandarle un email

        $id_tipo_incidencias = $post_array['idtipo'];
        $email_to = $this->getMailByTipoIncidencia($id_tipo_incidencias);
        $this->Email_model->sendEmail('daw@iesmariaenriquez.es',$email_to,'Incidencias',$post_array['descripcion']);

        return $post_array;


    }


    public function editar_incidencia_callback($post_array)
    {

        $sql = 'SELECT idusuario,numero,estado FROM incidencias WHERE id=?';
        $query = $this->db->query($sql, $post_array['id']);
        $fila = $query->row();

        $numero_incidencia = $fila->numero;
        $estado_antes = $fila->estado;

        $estado = $post_array['estado'];


        if($estado == 'CERRADA' && $estado_antes!=$estado){

            $post_array['fecha_fin'] = date('Y-d-m H:i:s');
            //al cerrarse la incidencia se envia un email a quien creo la incidencia, usaremos los mismos datos que antes para el cuerpo del email
            $subject = "Se ha cerrado la incidencia ".$numero_incidencia;
            //montamos el mensaje en html
            $message = "<div>Numero de inidencia: ".$numero_incidencia."</div>";
            $message .= "<div>Descripcion:</div>";
            $message .= $post_array['descripcion'];
            //$message .= "<div>Ubicacion: ".$post_array['ubicacion']."</div>";
            //añadimos al usuario que ha dado parte de la incidencia
            $sql = 'SELECT email FROM usuarios u, incidencias i WHERE i.id=? AND u.id=i.idusuario';
            $query = $this->db->query($sql, $post_array['id']);
            $results = $query->result();
            $emails[] = $results[0]->email;

            $this->Email_model->sendEmail('daw@iesmariaenriquez.es',$emails,$subject,$post_array['descripcion']);

        }

        return $post_array;



    }

    public function encrypt_password_callback($post_array){

        $clave = $post_array['clave'];

        $clave_cifrado = $this->encrypt->encode($clave);

        $post_array['clave']=$clave_cifrado;

        return $post_array;


    }


    public function dias_callback($value,$row) {

        $fin = new DateTime($row->fecha_fin);
        $inico = new DateTime($row->fecha_alta);
        $resultado = $fin->diff($inico)->days;
        /*
        echo "<script>"
        . "console.log('" . $row->numero . " = " . $fin->format('Y-m-d H:i:s') . " - " . $inico->format('Y-m-d H:i:s') . "');"
        . "console.log('" . $resultado . "');"
        . "</script>";
         */
        return $resultado;
    }

}