<?php

class Incidencias_Model extends CI_Model
{

        function __construct()
        {
            parent::__construct();
            date_default_timezone_set("Europe/Madrid");
            $this->load->database();
            $this->load->helper('date');
            $this->load->helper("url");
            $this->load->library('pagination');
        }

        function getAllIncidencias($pagina)
        {
            $sql = "SELECT COUNT(id) as num FROM incidencias";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $config['base_url'] = site_url("front/index/");
                $config['total_rows'] = $query->result()[0]->num;
                $config['per_page'] = 16;
                $config['num_links'] = 5;
                //para configurar el estilo del paginador
                $config['full_tag_open'] = '<div class="pagination">';
                $config['full_tag_close'] = '</div>';
                $config['num_tag_open'] = '<span class="page">';
                $config['num_tag_close'] = '</span>';
                $config['cur_tag_open'] = '<span class="page active">';
                $config['cur_tag_close'] = '</span>';
                $config['prev_tag_open'] = '<span class="page">';
                $config['prev_tag_close'] = '</span>';
                $config['next_tag_open'] = '<span class="page">';
                $config['next_tag_close'] = '</span>';
                $config['last_tag_open'] = '<span class="page">';
                $config['last_tag_close'] = '</span>';
                $config['first_tag_open'] = '<span class="page">';
                $config['first_tag_close'] = '</span>';
                $this->pagination->initialize($config);
                $pagination = $this->pagination->create_links();
                //ahora creamos la añadimos a la consulta lo que se mostrara
                $sql = "SELECT numero, descripcion, estado FROM incidencias ORDER BY fecha_alta DESC LIMIT ";
                if ($pagina) $sql .= $pagina . ",";
                $sql .= $config['per_page'];
                $query = $this->db->query($sql);
                $datos = $query->result();
                $return = array(
                    'datos' => $datos,
                    'pagination' => $pagination
                );
                return (object)$return;
            }
        }
}

?>