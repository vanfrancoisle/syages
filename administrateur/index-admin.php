<?php

    $title='Accueil - ADMINISTRATEUR';
    require '../general/debut.php';
    echo '<link rel="stylesheet" type="text/css" href="../css/eleve/acceuil_eleve.css?v=<?=time()?>">';
    require '../general/debut-2.php';
    $h3='Accueil - ADMINISTRATEUR';
<<<<<<< HEAD
    require '../general/navbanner-admin.php';
    require '../general/Syages.php';
    $syages = Syages::getModel('99','caca');
=======
    require 'navbanner-admin.php';
    require 'Syages.php';
    $syages = Syages::getModel('admin','caca');
>>>>>>> 11d502be584d74c14954892ed5cde14f7e226259

    $user = $syages->getInfosUser('99');
    $photo = $user[0]["Photo"];

    require '../general/melbanner.php';
    require '../graphes/indexgraph0.php';
    require_once '../Utils/functions.php';

    if(!(file_exists('../../log/log.txt'))){
        file_put_contents('../../log/log.txt','');
    }
    logger("naturephp","utilisateurphp","logphp");

      $contents  = file_get_contents('../../log/log.txt');
      $fichierLog = explode("\n",$contents);
    /*var_dump(getcwd());
    var_dump(get_current_user());
    $user[0]["idUser"]*/
?>
            <script>
            let label1A = "Mes notes";
            let data1A = [0,5, 10, 150, 450];
            let label1B = "Note moyenne de la classe"
            let data1B = [0, 10, 11, 250, 34];
            let label2A = "Mes absences";
            let data2A = [0, 8, 10, 35, 45];
            let label2B = "Absences de la classe";
            let data2B = [0,7, 9, 21, 34];
            </script>

                <?php require '../graphes/index-graph.php';?>

                <p>Bilan : il y a xxx absences constatées au cours de cette semaine dont xxx justifiées et donc xxx injustifiées. Les élèves devant justifier leurs absences sont : implode("select nom from user join absences on absence.iDEtudiant=user.iD and absence.justifie!=true;" , " ") <em>PHP</em><br/><br/></p>

            <h2><br/>Dernières actions</h2><br/>
            <div class="tababs">
                    <div class="tab">
                        <table>

                        <tr><th>Date requête</th><th>Nature requête</th><th>Auteur</th><th>Description</th></tr>

                        <?php foreach($fichierLog as $value):
                        $tab = explode("|",$value);
                        ?>
                        <tr>
                        <?php foreach($tab as $valeur):
                          if(!($valeur=="")):?>
                        <td><?= e($valeur);?></td>
                      <?php endif;endforeach;?></tr><?php endforeach;?>
                        <tr><td>01/09/20</td><td>Création utilisateur</td><td>Mme Secrétaire</td><td>Nouvel élève : Mr ______________________</td></tr>
                        <tr><td>01/09/20</td><td>Création contrôle</td><td>Mme Professeur</td><td>Nouvel contrôle module M0000 date 20/09/2009 </td></tr>
                        <tr><td>01/09/20</td><td>Création utilisateur</td><td>Mme Secrétaire</td><td>Nouvel élève : Mr ______________________</td></tr>
                        <tr><td>01/09/20</td><td>Supression utilisateur</td><td>Mme Secrétaire</td><td>Descolarisation : Mr ______________________</td></tr>
                        </table>
                </div></div><br>

            <div class='tababs'>
            <div class="mes-infos">
                <h2 style="background-color:orange"> MES INFORMATIONS<br>

              <img src=<?= e($user[0]["Photo"]);?> style="height:80px;"><br><a href="user_update_admin.php?u=<?=e($user[0]["idUser"]);?>"><img src="../img/edit.png" style="height: 22px; margin-left:80%;"></a></h2>

                <div class="infos-text">
                    <table class="table" style="height:100%">
                        <tr id="champs-infos"><th>Prénom</th><td><?= e($user[0]["Prénom"]); ?></td></tr>
                        <tr id="champs-infos"><th>Login</th> <td><?= e($user[0]["idUser"]); ?></td></tr>
                        <tr id="champs-infos"><th>Mot de passe :</th> <td>•••••••• </td></tr>
                    </table>
                </div>
            </div>
          </div>
                <div class="tababs">
                    <div class="tab">
                        <h2>Dernières absences</h2>
                        <input type="text" onkeyup="searchFunction('searchBar2','table-data-absences')" id='searchBar2' style="background-color: black; border:2px solid white;width:100%;margin: 2%; height: 30px" placeholder=" Rechercher des mots clés ...">

                        <table id="table-data-absences">

                        <tr><th>identifiant absence</th><th>Identifiant</th><th>Nom Prénom</th><th>Justifiée</th><th>date requête</th><th>modifier</th></tr>
                        <?php
                       $tab_absence = array_slice($syages->absence_admin(),0,7);
                       foreach($tab_absence as $key):
                            $userX = $syages->getInfosUser($key["idUser"]);
                        ?>

                        <tr><td><?= e($key["idAbs"]);?></td><td><?= e($key["idUser"]);?></td><td><?= e($userX[0]["Nom"]." ".$userX[0]["Prénom"]);?></td><?= print_td_justification(e($key["Justif"])); ?><td><?= e($key["Datetheure"]); ?></td><td><a href="modifer" style="text-decoration: underline" href="modif_absence.php<?=e($key["idAbs"]);?>">modifier</a></td></tr>
                        <?php endforeach;?>


                        </table>
                    </div>

                </div>

            <div class="tab" style="display: flex;flex-direction: column;overflow-x: scroll">
                <h2 style="text-transform: uppercase; margin: 1% 1% 01% 0">Dernièrs contrôles<br></h2>
                <input type="text" onkeyup="searchFunction('searchBar3','table-data-controle')" id='searchBar3' style="background-color: black; border:2px solid white;width:100%;margin-bottom:2%; height: 30px" placeholder=" Rechercher des mots clés ...">
                <table id="table-data-controle">
                    <tr><th>Date contrôle</th><th>Module</th><th>Identifiant</th><th>Auteur</th><th>Coeff</th><th>Modifier</th></tr>

                    <?php
                    $tab_controles = array_slice($syages->controles_admin(),0,7);
                    foreach($tab_controles as $key):
                        $userX = $syages->getProfNomPrenom(e($key["idMatiere"]));                        ?>

                        <tr><td><?= e($key["Date"]);?></td><td><?= e($syages->nomMatiere($key["idMatiere"])[0]["Nom"]." : ".$key["idMatiere"]);?></td><td><?= e($key["idEval"]); ?></td><td><?= e($userX[0]["Nom"]." ".$userX[0]["Prénom"]); ?></td><td><?= e($key["Coef"]); ?></td><td><a href="modifer" style="text-decoration: underline" href="modif_absence.php?id=<?=e($key["idAbs"]);?>">modifier</a></td></tr>
                        <?php endforeach;?>
                </table>

            </div>

<?php  require '../general/fin.php';?>
