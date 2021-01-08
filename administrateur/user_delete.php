<?php
    $title='Utilisateurs - ADMINISTRATEUR';
    require 'debut.php';
    require 'Syages.php';
    require 'debut-2.php';
    $h3='Gestion des utilisateurs - ADMINISTRATEUR';
    require 'navbanner-admin.php';
    $syages = Syages::getModel(4);
    $user = $syages->getInfosUser('99');
    $photo = $user[0]["Photo"];
    require 'melbanner.php';
    require_once 'Utils/functions.php';

 ?>

 <?php
 if(isset($_GET["u"])){
     $deleteUser = $syages->getInfosUser(e($_GET['u']));
     if(isset($deleteUser[0])){
       $deleteUser=$deleteUser[0];
     }
     else{
       echo '<p style="width:100%;background-color:red; margin-bottom:40%;">Supression d\'utilisateur a échoué
       <br>L\' utilisateur demandé n\'existe pas.<br> Vous allez être redirigé vers la page de gestion d\'utilisateur.';
       header("Refresh:2.5; url=gestion_user-admin.php");
       require 'fin.php';
       die();
     }

     /*garder si on doit vérifier des trucs avant de supprimer*/
     $deleted = $syages->deleteUser(e($_GET['u']));

     if($deleted){
       echo '<p style="width:100%;background-color:green;">L\'utilisateur a été supprimé</p><br><br>';
     }
     else{
       echo '<p style="width:100%;background-color:red;">Supression de l\'utilisateur a échoué</p><br><br>';
     }
 }
 ?>

 <?php
      echo '<br><br>';
     require 'fin.php';
 ?>
