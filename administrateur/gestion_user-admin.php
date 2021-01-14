<?php
    $title='Utilisateurs - ADMINISTRATEUR';
    require '../general/debut.php';
    require '../general/Syages.php';
    require '../general/debut-2.php';
    $h3='Gestion des utilisateurs - ADMINISTRATEUR';
    require '../general/navbanner-admin.php';
<<<<<<< HEAD
    $syages = Syages::getModel('99','caca');
    $user = $syages->getInfosUser('99');
    $photo = $user[0]["Photo"];
    require '../general/melbanner.php';
    require_once '../Utils/functions.php';
=======
    $syages = Syages::getModel('admin','caca');
    $user = $syages->getInfosUser('99');
    $photo = $user[0]["Photo"];
    require '../general/melbanner.php';
    require_once 'Utils/functions.php';
>>>>>>> 11d502be584d74c14954892ed5cde14f7e226259

 ?>

 <?php
 if(isset($_POST["login"])){

       $boolmaamaa=$syages->addUser(e($_POST["Prénom"]),e($_POST["Nom"]),e($_POST["idUser"]),e(password_hash($_POST["password"],PASSWORD_DEFAULT)),e($_POST["role"]),e($_POST["selection"]),e($_POST["photo"]),e($_POST["phone"]),
     e($_POST["login"]),e($_POST["nomepouse"]),e($_POST["mail"]),e($_POST["idEtablissement"]),e($_POST["Peda"]),e($_POST["InfoPrivee"]),e($_POST["redoublement"]),e($_POST["Perqonnalisation"]),e($_POST["Data"]),
     e($_POST["Historique"]),e($_POST["Drapeau"]));

     if($boolmaamaa){
       echo '<p style="width:100%;background-color:green;">L\'utilisateur a été ajouté</p>';
     }
     else{
       echo '<p style="width:100%;background-color:red;">Ajout d\'utilisateur a échoué</p>';
     }
 }
 ?>
            <div class="tababs" style='display: flex;flex-direction: column;'>
                    <div class="tab" style="flex: auto;" >
                      <div class='tababs'>
<div class="form-conteneur" style="width:70%;margin: 0;">
                    <form action="" method="post">
                        <h2>Créer des utilisateurs</h2>
                        <div class="champ-formulaire">
                            <p>Prénom</p>
                            <input type="text" id="name" name="Prénom" placeholder="Prénom"/>
                            <p>Nom</p>
                            <input type="text" id="name" name="Nom" placeholder="Nom"/>
                        </div>



                        <div class="champ-formulaire">
                            <p>Identifiant</p>
                            <input type="text" id="name" name="idUser" placeholder="Identifiant"/>
                            <p>Téléphone</p>
                            <input type="text" id="name" name="phone" placeholder="01 02 03 04 05"/>
                        </div>

                        <div class="champ-formulaire">
                            <p>MDP</p>
                            <input type="password" id="name" name="password" placeholder="••••••••"/>
                            <p>Promo</p>
                            <select id="sel" name="selection">
                            <?php
                                $promo_actives = $syages->getPromoActivesOuPas('1');
                                foreach ($promo_actives as $key):
                            ?>
                                <option value="<?=$key["idPromotion"]?>"><?= $key["idPromotion"]?></option>

                           <?php endforeach;?>
                           <option value="">Je ne suis pas un élève</option>
                            </select>
                        </div>
                        <div class="champ-formulaire">                             
                                <p>login</p>                             
                                <input type="text" id="login" name="login" placeholder="login"/>                         
                                <p>Mail</p>                             
                                <input type="text" id="mail" name="mail" placeholder="mail"/>
                        </div>

                        <div class="champ-formulaire">                             
                          <p>Etablissement</p> 
                          <select id="sel" name="idEtablissement">                           
                          <?php
                              $etablissements = $syages->getEtablissements();
                              foreach ($etablissements as $key):
                          ?>
                              <option value="<?=e($key["idEtablissement"])?>"><?= e($key["NomLong"])?></option>

                         <?php endforeach;?>
                         <select>                       
                        </div>

                        <div class="champ-formulaire">                             
                                 <p>Nom épouse</p>                             
                                 <input type="text" id="nomepouse" name="nomepouse" placeholder="Nom Épouse"/>                      
                                <p>Inscription</p>                             
                                <input type="text" id="Inscription" name="Inscription" placeholder="Inscription"/>                         

                        </div>

                        <div class="champ-formulaire">                             
                                <p>Pédagogie (seulement si professeur)</p>                             
                                <input type="text" id="Peda" name="Peda" placeholder="Peda"/>                         
                        </div>

                        <div class="champ-formulaire">                             
                                <p>Privé</p>                             
                                <input type="text" id="InfoPrivee" name="InfoPrivee" placeholder="Info privée" /> 
                                <p>Redoublement (n-1)</p>                             
                                <select id="sel" name="redoublement">
                                    <option value="oui">Oui</option>
                                    <option value="non">Non</option>
                                </select>                       
                        </div>

                        <div class="champ-formulaire">                             
                                <p>Personnalisation</p>                             
                                <input type="text" id="Perqonnalisation" name="Perqonnalisation" placeholder="Personnalisation"/>                         
                                <p>Data</p>                             
                                <input type="text" id="Data" name="Data" placeholder="Data"/> 
                        </div>

                        <div class="champ-formulaire">                             
                                <p>Historique</p>                             
                                <input type="text" id="Historique" name="Historique" placeholder="Historique"/>                         
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

                            <p>Avatar</p>
                            <select id="sel" name="photo">
                            <?php
                                $dossier = "../img/avatar/";
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



    </div></div>  <br><br>
                        <input type="text" onkeyup="searchFunction('searchBar2','table-data-absences')" id='searchBar2' style="background-color: black; border:2px solid white;width:100%;margin: 2%; height: 30px" placeholder=" Rechercher des mots clés ...">
                        <table style="magin-bottom:12px;" id="table-data-absences">
                        <h2>Utilisateurs</h2>
                        <tr><th>Nom</th><th>Prénom</th><th>Identifiant</th><th>Role</th><th>Promo</th><th>Avatar</th><th>Mail</th></tr>
                        <?php
                             $users = $syages->getUsersActive();
                             foreach ($users as $key):
                        ?>
                        <tr><td><?=e($key["Nom"]);?></td><td><?=e($key["Prénom"])?></td><td><?=e($key["idUser"]);?></td><?=print_role(e($key["Role"]));?><td><?=e($key["promo"]);?></td>
                          <td><img style="height:70px" src="<?=e($key["Photo"]);?>" style="height: 40%"></td><td><?=e($key["Mail"]);?></td>
                          <td><a href="user_update_admin.php?u=<?=e($key["idUser"])?>"><img src="../img/edit.png" alt="modifier" style="height:15px;padding:1px;"></a></td>
                          <td><a href="user_delete.php?u=<?=e($key["idUser"]);?>"><img src="../img/delete.png" alt="supprimer" style="height:15px;padding:1px;"></a></td>
                          </tr>
                        <?php
                        endforeach;
                        ?>

                        </table><br><br>
                </div>

            </div><br>


<?php
    require '../general/fin.php';
?>
