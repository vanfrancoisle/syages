<?php

$title='Accueil - SECRÉTAIRE';
require 'debut.php';
require 'debut-2.php';
$h3='Accueil - SECRÉTAIRE';
require 'navbanner-secretaire.php';
$photo = "img/david.jpg";
require 'melbanner.php';
require 'indexgraph0.php';
require 'Syages.php';
$syages = Syages::getModel(3);
$user = $syages->getInfosUser('33333333');
$promo_actives = $syages->getPromoActivesOuPas(1);
$absenceStats=[];
foreach ($promo_actives as $key=>$value){
    $absenceStats[$value["idPromotion"]] = $syages->statsAbsencesPromo($value["idPromotion"]);
    $absenceStats[$value["idPromotion"]]["nbEleves"] = $syages->nbEleves($value["idPromotion"])[0];
    $absenceStats[$value["idPromotion"]]["infosPromos"] = $syages->infosPromo($value["idPromotion"])[0];
}
var_dump($absenceStats);
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
            <h2><br/>PROMOTION ACTIVE</h2><br/>
                <div class="tababs">
                    <div class="tab">
                <table>
                	
                    <tr><th>Promotion</th><th>Identifiant</th><th>Nombre d'élèves</th><th>Nombre absences</th><th>Justifiées</th><th>Non justifiée</th></tr>
                    <?php foreach ($absenceStats as $value):
                	$absences_total = $value[0]["count(*)"] ;
                	$absences_justifiees = $value[0]["Justif"] ;
                	$absences_non_justifiees  = $absences_total - $absences_justifiees;
                	$nbEleves = $value["nbEleves"]["count(*)"];
                	$infosPromo = $value["infosPromos"];
                	?>
                    <tr><td><?= $infosPromo["NomPromo"]; ?></td><td><?= $infosPromo["idPromotion"]; ?></td><td><?= $nbEleves; ?></td><td><?= $absences_total;?></td><td><?= $absences_justifiees;?></td><td><?= $absences_non_justifiees;?></td></tr>
                    <?php endforeach;?>
                </table>
                    </div>

<div class="form-conteneur">
                    <form action="" method="post">
                        <h2>GESTION DES ABSENCES</h2>
                        <div class="champ-formulaire">
                            <p>Identifiant</p>
                            <input type="text" id="nom" name="identifiant" placeholder="identifiant"/>
                        </div>
                        <div class="champ-formulaire">
                            <p>Début</p>
                            <input type="date" id="date-debut" name="d_debut" placeholder="dd/mm/yyyy"/>
                            <input type="time" id="temps-debut" name="t_debut" placeholder="hh:mm">
                        </div>

                        <div class="champ-formulaire">
                            <p>Fin </p>
                            <input type="date" id="date-fin" name="d_fin" placeholder="dd/mm/yyyy"/>
                            <input type="time" id="temps-fin" name="t_fin" placeholder="hh:mm">
                        </div>

                        <div class="champ-formulaire">
                            <p>État</p>
                            <select id="sel" name="selection">
                                <option value="justifiee">JUSTIFIÉE</option>
                                <option value="injustifiee">INJUSTIFIÉES</option>
                            </select>
                        </div>

                        <input type="submit" value="déclarer" id="btn"/>
                    </form>
                    </div>

                </div>
            <div class="mes-infos tababs">
                <h2>MES INFORMATIONS</h2>
                <div class="infos-images">
                <img src=<?=$photo;?> style="height:120px;border:3px solid white;"></div>
                <div class="infos-text">
                    <table class="table">
                        <!--CSS NE SE MET PAS A JOUR !!! TODO style height et padding (browser cache)-->
                        <tr id="champs-infos"><th>Nom :</th><td> <?=$user[0]["Nom"];?></td></tr>
                        <tr id="champs-infos"><th>Prénom :</th><td> <?=$user[0]["Prénom"];?></td></tr>
                        <tr id="champs-infos"><th>Identifiant :</th><td> <?=$user[0]["idUser"];?></td></tr>
                        <tr id="champs-infos" ><th>Téléphone :</th><td> <?=$user[0]["Téléphone"];?></td></tr>
                        <tr id="champs-infos"><th>Login : </th><td><?=$user[0]["Login"];?></td></tr>
                        <tr id="champs-infos"><th>Mot de passe :</th><td> •••••••• <a href="/Syages/mes_infos.php"><img src="img/edit.png" style="height: 22px;background-color: white; margin-left:.1%;"></a></td></tr>
                    </table>
                </div>
            </div>
<?php 
$promo_actives = $syages->getPromoActivesOuPas(0);
$absenceStats=[];
foreach ($promo_actives as $key=>$value){
    $absenceStats[$value["idPromotion"]] = $syages->statsAbsencesPromo($value["idPromotion"]);
    $absenceStats[$value["idPromotion"]]["nbEleves"] = $syages->nbEleves($value["idPromotion"])[0];
    $absenceStats[$value["idPromotion"]]["infosPromos"] = $syages->infosPromo($value["idPromotion"])[0];
}?>
            <div class="tab" style="display: flex;flex-direction: column;overflow-x: scroll">
                <h2 style="text-transform: uppercase; margin: 1% 1% 01% 0">Anciennes promotions</h2>
                <table>
                	
                    <tr><th>Promotion</th><th>Identifiant</th><th>Nombre d'élèves</th><th>Nombre absences</th><th>Justifiées</th><th>Non justifiée</th></tr>
                    <?php foreach ($absenceStats as $value):
                	$absences_total = $value[0]["count(*)"] ;
                	$absences_justifiees = $value[0]["Justif"] ;
                	$absences_non_justifiees  = $absences_total - $absences_justifiees;
                	$nbEleves = $value["nbEleves"]["count(*)"];
                	$infosPromo = $value["infosPromos"];
                	?>
                    <tr><td><?= $infosPromo["NomPromo"]; ?></td><td><?= $infosPromo["idPromotion"]; ?></td><td><?= $nbEleves; ?></td><td><?= $absences_total;?></td><td><?= $absences_justifiees;?></td><td><?= $absences_non_justifiees;?></td></tr>
                    <?php endforeach;?>

                 <tr><td>VERT</td><td>BG0001</td><td>25</td><td>19</td><td>9</td><td>42</td></tr>
                
                </table>
            </div>

<?php
 require 'fin.php';
?>
