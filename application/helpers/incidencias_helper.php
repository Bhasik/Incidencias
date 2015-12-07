<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if(!function_exists('incidenciasNoResueltas')){

    function incidenciasNoResueltas(){


        $CI = & get_instance();

        $sql = "SELECT COUNT(*) AS NUM FROM incidencias WHERE estado <> 'CERRADA'";

        $query = $CI->db->query($sql);

        $fila  = $query->row();

        return $fila->NUM;



    }

}