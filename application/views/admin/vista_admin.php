<!DOCTYPE html>
<?php

$user_id = $this->session->userdata('user_id');

if (empty($user_id)) {

    redirect(base_url()."index.php");


}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">

    <?php

    if (!isset($css_files)) {

        $css_files = array();


    }

   if (!isset($js_files)) {

        $js_files = array();


    }

    foreach ($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>"/>
    <?php endforeach; ?>
    <?php foreach ($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <title>Title</title>
    <style type="text/css">

        body {
            font-family: Arial;
            font-size: 14px;
        }

        a {
            color: blue;
            text-decoration: none;
            font-size: 14px;

        }

        a:hover {

            text-decoration: underline;
        }

    </style>

</head>
<body>
<b>BIENVENIDO AL SISTEMA DE GESTIONN DE INCIDENCIAS</b>
<br>
<a href="<?php echo site_url('Admin/usuarios'); ?>">Usuario</a> |

<a href="<?php echo site_url('Admin/roles'); ?>">Roles</a> |

<a href="<?php echo site_url('Admin/tipos_incidencias'); ?>">Tipo Incidencias</a> |

<a href="<?php echo site_url('Admin/incidencias'); ?>">Incidencias</a> |

<a href="<?php echo site_url('Admin/historial'); ?>">Historial Incidencias</a> |

<a href="<?php echo site_url('Admin/logout'); ?>">Salir</a>

<div><?php echo $output; ?></div>
</body>
</html>