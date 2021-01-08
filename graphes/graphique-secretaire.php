<?php
    $title='Graphique - SECRÉTAIRE';
    require 'debut.php';
    echo '<link rel="stylesheet" type="text/css" href="css/graphes/style_graphes.css">';

    require 'debut-2.php';

    $h3='Graphique - SECRÉTAIRE';
    require 'navbanner-secretaire.php';
    require 'melbanner.php';
    //inclure les données
    require 'graphiques-toutUser.php';
    require 'graphes-graphiques.php';
    require 'fin.php';
?>
