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

     $modifyUser = $syages->getInfosUser(e($_GET['u']));
     if(isset($modifyUser[0])){
       $modifyUser=$modifyUser[0];
     }
     else{
       echo '<p style="width:100%;background-color:red; margin-bottom:40%;">Mise à jour d\'utilisateur a échoué
       <br>L\' utilisateur demandé n\'existe pas.<br> Vous allez être redirigé vers la page de gestion d\'utilisateur.';
       header("Refresh:3; url=gestion_user-admin.php");
       require 'fin.php';

       die();
     }
 }
 ?>
 <?php
  if(isset($_POST["login"])){
    $updated=$syages->updateUser($_GET["u"],$_POST);

    if($updated){
      echo '<p style="width:100%;background-color:green;">L\'utilisateur a été mis à jour<br>Vous allez être redirigé vers la page de gestion d\'utilisateur</p>';
      $modifyUser = $syages->getInfosUser(e($_GET['u']))[0];
      header("Refresh:5; url=gestion_user-admin.php");
    }
    else{
      echo '<p style="width:100%;background-color:red;">Mise à jour d\'utilisateur a échoué
      <br>Les modifications ont soient été déjà faites ou l\' utilisateur n\'existe pas. Veuillez faire appel à l\'administrateur de votre établissement.<br></p>';
    }

  }
  ?>
            <div class="tababs" style='display: flex;flex-direction: column;'>
                    <div class="tab" style="flex: auto;" >
                      <div class='tababs'>
<div class="form-conteneur" style="width:90%;margin: 0;">
                    <form action="" method="post">
                        <h2>Mise à jour d'un utilisateur</h2>

                          <div class="champ-formulaire">                             
                                  <p>login</p>                             
                                  <input type="text" id="login" name="login" placeholder="login" value="<?=$modifyUser["Login"]?>"/> 
                                  <p>MDP</p>
                                  <input type="password" id="name" name="motdepasse" placeholder="ne pas remplir sauf si changement de mot de passe"/>                       
                          </div>


                          <div class="champ-formulaire">
                              <p>Nom</p>
                              <input type="text" id="name" name="nom" placeholder="nom" value="<?=$modifyUser["Nom"]?>"/>
                              <p>Prénom</p>
                              <input type="text" id="name" name="prenom" placeholder="Prénom" value="<?=$modifyUser["Prénom"]?>"/>

                          </div>

                          <div class="champ-formulaire">                             
                                  <p>Nom Épouse</p>                             
                                  <input type="text" id="nomepouse" name="nomepouse" placeholder="nomepouse" value="<?=$modifyUser["NomEpouse"]?>"/>                         
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
                                <option value="<?=$dossier.$key?>" <?php if($dossier.$key==$modifyUser["Photo"]){echo ' selected';}?>><?=$key;?></option>
                            <?php endif;endforeach;?>
                            </select>
                            <p>Téléphone</p>
                            <input type="text" id="name" name="telephone" placeholder="01.02.03.04.05" value="<?=$modifyUser["Téléphone"]?>"/>

                        </div>

                        <div class="champ-formulaire">                             
                                <p>mail</p>                             
                                <input type="text" id="mail" name="mail" placeholder="mail" value="<?=$modifyUser["Mail"]?>"/>                         
                                <p>idEtablissement</p>                             
                                <input type="text" id="idEtablissement" name="idetablissement" placeholder="idEtablissement" value="<?=$modifyUser["idEtablissement"]?>"/>                         

                        </div>

                        <div class="champ-formulaire">
                            <p>Rôle</p>

                            <select id="sel" name="role">
                              <?php
                              $listOption=["e","p","s","a"];
                              $listAffichage = ["Élève","Professeur","Secrétaire","Administrateur"];
                              $key1 = array_search($modifyUser["Role"],$listOption);
                              foreach ($listOption as $key => $value) {
                                if($key==$key1){
                                  echo '<option value="'.$listOption[$key].'" selected>'.$listAffichage[$key].'</option>';
                                }
                                else{
                                  echo '<option value="'.$listOption[$key].'">'.$listAffichage[$key].'</option>';
                                }
                              }
                              ?>

                            </select>
                        </div>


                        <div class="champ-formulaire">
                            <p>Promo</p>
                            <select id="sel" name="promo">
                            <?php
                                $promo_actives = $syages->getPromoActivesOuPas('1');
                                foreach ($promo_actives as $key):
                            ?>
                                <option value="<?=e($key["idPromotion"])?>"
                                  <?php if(e($modifyUser["promo"])==e($key["idPromotion"])){echo 'selected';}?>
                                ><?= e($key["idPromotion"]);?></option>
                           <?php endforeach;
                           ?>
                          <option value="">Je ne suis pas un élève</option>
                            </select>
                        </div>

                        <div class="champ-formulaire">                             
                                <p>Inscription</p>                             
                                <input type="text" id="Inscription" name="inscriptionmatiere" placeholder="Inscription" value="<?=$modifyUser["InscriptionMatiere"]?>"/>                         
                        </div>

                        <div class="champ-formulaire">                             
                                <p>Peda</p>                             
                                <input type="text" id="Peda" name="inscriptionpeda" placeholder="InscriptionPeda" value="<?=$modifyUser["InscriptionPeda"]?>"/>                         
                                <p>Privé</p>                             
                                <input type="text" id="InfoPrivee" name="infoprivee" placeholder="Info privée" value="<?=$modifyUser["InfoPrivee"]?>" />                         

                        </div>

                        <div class="champ-formulaire">                             
                                <p>Redoublement (n-1)</p>                             
                                <select id="sel" name="inforedoublement">
                                    <?php
                                    $listOption=["oui","non"];
                                    $key1 = array_search($modifyUser["Redoublement"],$listOption);
                                    foreach ($listOption as $key => $value) {
                                      if($key==$key1){
                                        echo '<option value="'.$listOption[$key].'" selected>'.$listOption[$key].'</option>';
                                      }
                                      else{
                                        echo '<option value="'.$listOption[$key].'">'.$listOption[$key].'</option>';
                                      }
                                    }
                                    ?>

                                </select>
                                <p>Personnalisation</p>                             
                                <input type="text" id="perqonnalisation" name="perqonnalisation" placeholder="Personnalisation" value="<?=$modifyUser["Perqonnalisation"]?>"/>                         

                        </div>

                        <div class="champ-formulaire">                             
                                <p>Data</p>                             
                                <input type="text" id="Data" name="data" placeholder="Data" value="<?=$modifyUser["Data"]?>"/>                         
                                <p>Historique</p>                             
                                <input type="text" id="Historique" name="historique" placeholder="Historique" value="<?=$modifyUser["Historique"]?>"/>                         

                        </div>

                        <input type="submit" value="Mettre à jour" id="btn"/>
                    </form>
</div></div>  <br><br>
<?php
    require 'fin.php';
?>
