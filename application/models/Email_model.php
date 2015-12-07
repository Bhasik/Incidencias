<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Email_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('email'); //llibreria funcions email
    }

    public function sendEmail($from, $to, $asunto, $mensaje, $ficheroAdjunto = NULL) {
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($asunto);
        $this->email->message($mensaje);
        $this->email->cc(''); //enviar copies
        if($ficheroAdjunto!=NULL){
            
        $this->email->attach($ficheroAdjunto);
        
        }
        if(!$this->email->send()){
            echo "Error en el envio del mensaje".$this->email->print_debugger();
        }
    }

}
