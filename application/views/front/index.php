<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Incidencias</title>
    <link href="<?php echo base_url() ?>assets/frontoffice/css/tabla.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/frontoffice/css/paginador.css" rel="stylesheet">
</head>
<body>
<div class="linees">
    <a href="<?php echo site_url("admin/index.php");?>">Panel de control</a>
</div>
<div style="clear: both;"></div>
<div id="tabla"><table border="1">
        <thead>
        <tr>
            <th>Numero</th>
            <th>Descripcion</th>
            <th>Estado</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($incidencias->datos as $incidencia) {
            echo "<tr>";
            echo "<td>" . $incidencia->numero . "</td>";
            echo "<td>" . $incidencia->descripcion . "</td>";
            echo "<td><div";
            if($incidencia->estado=="CERRADA"){
               echo " class='label label-success'";
            }else if($incidencia->estado=="ABIERTA"){
                echo " class='label label-danger'";
            }else if($incidencia->estado=="EN PROCESO"){
                echo " class='label label-warning'";
            }
            echo ">".$incidencia->estado;
            echo "</div></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <?php echo $incidencias->pagination; ?>
</div>

</body>
</html>