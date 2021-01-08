<?php
    $title='Mes informations';
    require 'debut.php';
    require 'debut-2.php';
    $h3='Mes informations';
    require 'navbanner-admin.php';
    $photo =  "img/david.jpg";//$_SESSION[""]; TODO : import photo
    require 'melbanner.php';
    require "Syages.php";
    $syages = Syages::getModel(1);
    $infosUser = $syages->getInfosUser("11111111");
    $infosEtablissement = $syages->getEtablissementUser($infosUser[0]["idEtablissement"]);

?>

<h2><br/>Mes informations<br></h2><br/>
            <div class="tababs" style='display: flex;flex-direction: column;'>
                    <div class="tab" style="flex: auto;" >

                        <table style="magin-bottom:12px;"><tr>
                        <?php
                        $tabAutorisation=["Nom","Prénom","idUser","Photo","Téléphone","Mail","InscriptionMatiere"];
                         foreach ($infosUser[0] as $key => $value):
                           if(in_array($key,$tabAutorisation,false)):?>
                          <th><?=''.$key; ?></th>
                        <?php endif;endforeach;?></tr><tr>

                      <?php foreach ($infosUser[0] as $key => $value):
                        if(in_array($key,$tabAutorisation,false)):
                          if($key==="Photo"):
                            echo '<td><img src="'.$value.'" style="width:100px;"></td>';
                            ?>
                        <?php else:?>
                        <td><?= ' '.$value;?></td>
                      <?php endif;endif;endforeach;?></tr></table>
                </div>
                <h2><br>Informations établissement<br></h2><br>
                <div class="tab" >

                        <table style="height: 20%;"><tr>
                          <?php
                          $tabAutorisationEtab=["NomLong","Adresse","NomResponsable"	,"PrenomResponsable"	,"TelResponsable"	,"MailResponsable"	,"NomSecretaire"	,"PrenomSecretaire"	,"TelSecretaire","MailSecretaire"];
                          foreach ($infosEtablissement[0] as $key => $value):
                              if(in_array($key,$tabAutorisationEtab,false)):?>
                            <tr><th><?=''.$key; ?></th><td><?= ' '.$value;?></td></tr>
                          <?php endif;endforeach;?></tr><tr>
                          </table>
                </div>
<div class="form-conteneur" style='width:40%;padding:2.5%'><br><br>
                    <form action="changementmdp.php" method="post">
                        <h2>Changement de mot de passe<br></h2>
                        <div class="champ-formulaire">
                            <p>Ancien mot de passe</p>
                            <input type="password" id="oldmdp" name="oldmdp" placeholder="Ancien mot de passe"/>

                        </div>

                        <div class="champ-formulaire">
                            <p>Nouveau mot de passe </p>
                            <input type="newmdp" id="newmdp" name="newmdp" placeholder="Nouveau mot de passe"/>

                        </div>

                        <div class="champ-formulaire">
                            <p>Nouveau mot de passe </p>
                            <input type="newmdp" id="newmdp" name="newmdp" placeholder="Nouveau mot de passe"/>

                        </div>

                        <input type="submit" value="Changer" id="btn"/>
                    </form>
                    </div>
            </div><br>


<?php
    require 'fin.php';
?>
