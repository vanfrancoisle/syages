<?php

    $title='Accueil - ADMINISTRATEUR';
    require 'debut.php';
    require 'debut-2.php';
    $h3='Accueil - ADMINISTRATEUR';
    require 'navbanner-admin.php';
    require 'Syages.php';
    $syages = Syages::getModel(4);

    $user = $syages->getInfosUser('99');
    $photo = $user[0]["Photo"];

    require 'melbanner.php';
    require 'indexgraph0.php';
    require_once 'Utils/functions.php';

    // get contents of a file into a string
    logger("naturephp","utilisateurphp","logphp");
    if(!(file_exists('../../log/log.txt'))){
        file_put_contents('../../log/log.txt','');
    }
    $contents  = file_get_contents('../../log/log.txt');
    $fichierLog = explode("\n",$contents);
    var_dump(getcwd());
    var_dump(get_current_user());
    /*$user[0]["idUser"]*/
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

                <?php require 'index-graph.php';?>

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
                <h2>MES INFORMATIONS</h2>
                <div class="infos-images">
                <img src=<?= e($user[0]["Photo"]);?> style="height:80px;border:3px solid white;margin-top: auto;margin-bottom: auto;"></div>
                <div class="infos-text">
                    <table class="table" style="height:100%">
                        <tr id="champs-infos"><th>Prénom</th><td><?= e($user[0]["Prénom"]); ?></td></tr>
                        <tr id="champs-infos"><th>Login</th> <td><?= e($user[0]["idUser"]); ?></td></tr>
                        <tr id="champs-infos"><th>Mot de passe :</th> <td>•••••••• <a href="user_update_admin.php?u=<?=e($user[0]["idUser"]);?>"><img src="img/edit.png" style="height: 22px;background-color: white; margin-left:.1%;"></a></td></tr>
                    </table>
                </div>
            </div>
            <div class="form-conteneur" style="margin: 0px;">
              <form action="" method="post">
                  <h2>Créer des utilisateurs</h2>
                  <div class="champ-formulaire">
                      <p>Prénom</p>
                      <input type="text" id="name" name="Prénom" placeholder="Prénom"/>
                  </div>

                  <div class="champ-formulaire">
                      <p>Nom</p>
                      <input type="text" id="name" name="Nom" placeholder="Nom"/>
                  </div>

                  <div class="champ-formulaire">
                      <p>Identifiant</p>
                      <input type="text" id="name" name="idUser" placeholder="Identifiant"/>
                  </div>

                  <div class="champ-formulaire">
                      <p>Numéro de téléphone</p>
                      <input type="text" id="name" name="phone" placeholder="01.02.03.04.05"/>
                  </div>

                  <div class="champ-formulaire">
                      <p>MDP</p>
                      <input type="password" id="name" name="password" placeholder="••••••••"/>
                  </div>

                  <div class="champ-formulaire">
                      <p>Promo</p>
                      <select id="sel" name="selection">
                      <?php
                          $promo_actives = $syages->getPromoActivesOuPas('1');
                          foreach ($promo_actives as $key):
                      ?>
                          <option value="<?=$key["idPromotion"]?>"><?= $key["idPromotion"]?></option>
                     <?php endforeach;
                     ?>

                      </select>
                  </div>
                  <div class="champ-formulaire">                             
                          <p>login</p>                             
                          <input type="text" id="login" name="login" placeholder="login"/>                         
                  </div>

                  <div class="champ-formulaire">                             
                          <p>nomepouse</p>                             
                          <input type="text" id="nomepouse" name="nomepouse" placeholder="nomepouse"/>                         
                  </div>

                  <div class="champ-formulaire">                             
                          <p>mail</p>                             
                          <input type="text" id="mail" name="mail" placeholder="mail"/>                         
                  </div>

                  <div class="champ-formulaire">                             
                          <p>idEtablissement</p>                             
                          <input type="text" id="idEtablissement" name="idEtablissement" placeholder="idEtablissement"/>                         
                  </div>

                  <div class="champ-formulaire">                             
                          <p>Inscription</p>                             
                          <input type="text" id="Inscription" name="Inscription" placeholder="Inscription"/>                         
                  </div>

                  <div class="champ-formulaire">                             
                          <p>Peda</p>                             
                          <input type="text" id="Peda" name="Peda" placeholder="Peda"/>                         
                  </div>

                  <div class="champ-formulaire">                             
                          <p>Privé</p>                             
                          <input type="text" id="InfoPrivee" name="InfoPrivee" placeholder="Info privée" />                         
                  </div>

                  <div class="champ-formulaire">                             
                          <p>Redoublement (n-1)</p>                             
                          <select id="sel" name="redoublement">
                              <option value="oui">Oui</option>
                              <option value="non">Non</option>

                          </select>
                  </div>

                  <div class="champ-formulaire">                             
                          <p>Personnalisation</p>                             
                          <input type="text" id="Perqonnalisation" name="Perqonnalisation" placeholder="Personnalisation"/>                         
                  </div>

                  <div class="champ-formulaire">                             
                          <p>Data</p>                             
                          <input type="text" id="Data" name="Data" placeholder="Data"/>                         
                  </div>

                  <div class="champ-formulaire">                             
                          <p>Historique</p>                             
                          <input type="text" id="Historique" name="Historique" placeholder="Historique"/>                         
                  </div>

                  <div class="champ-formulaire">                             
                          <p>Drapeau</p>                             
                          <input type="text" id="Drapeau" name="Drapeau" placeholder="Drapeau"/>                         
                  </div>
                  <div class="champ-formulaire">
                      <p>Rôle</p>
                      <select id="sel" name="role">
                          <option value="e">Eleve</option>
                          <option value="p">Professeur</option>
                          <option value="s">Secrétaire</option>
                          <option value="a">Admin</option>

                      </select>
                  </div>
                  <div class="champ-formulaire">
                      <p>Avatar</p>
                      <select id="sel" name="photo">
                      <?php
                          $dossier = "img/avatar/";
                          $ls_dossier = scandir($dossier);
                          foreach ($ls_dossier as $key):
                          if(!($key[0]==='.')):
                      ?>
                          <option value="<?=$dossier.$key?>"><?=$key;?></option>
                      <?php endif;endforeach;?>
                      </select>
                  </div>
                  <input type="submit" value="Créer" id="btn"/>
              </form>

              <?php
              if(isset($_POST["login"])){

                    $boolmaamaa=$syages->addUser(e($_POST["Prénom"]),e($_POST["Nom"]),e($_POST["idUser"]),e(password_hash($_POST["password"],PASSWORD_DEFAULT)),e($_POST["role"]),e($_POST["selection"]),e($_POST["photo"]),e($_POST["phone"]),
                  e($_POST["login"]),e($_POST["nomepouse"]),e($_POST["mail"]),e($_POST["idEtablissement"]),e($_POST["Peda"]),e($_POST["InfoPrivee"]),e($_POST["redoublement"]),e($_POST["Perqonnalisation"]),e($_POST["Data"]),
                  e($_POST["Historique"]),e($_POST["Drapeau"]));

                  if($boolmaamaa){
                    echo '<p style="width:100%;background-color:green;">L\'utilisateur a été ajouté</p>';
                  }
                  else{
                    echo '<p style="width:100%;background-color:red;">Ajout d\'utilisateur a échoué peut-être que quelqu\'un avec le même identifiant utilisateur existe déjà</p>';
                  }
              }
              ?>
            </div></div>
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

<?php  require 'fin.php';?>
