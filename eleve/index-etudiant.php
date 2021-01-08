<?php
/*
@author inthragith
*/
$title = 'Accueil - Étudiant';
require 'debut.php';
echo '<link rel="stylesheet" type="text/css" href="css/eleve/css_acceuil_student.css">';
require 'debut-2.php';
$h3 = 'Accueil - Étudiant';
require 'navbanner-eleve.php';
$photo="img/david.jpg";
require 'melbanner.php';
require 'indexgraph0.php';
require 'Syages.php';
require_once 'Utils/functions.php';


$_SESSION["idUser"]="11111380";



$syages = Syages::getModel(1);
$notes = array_slice($syages->getNotes($_SESSION["idUser"]),0,7);

/* TODO : prendre en compte la sécurité pour contrer les XSS*/


//avoir les infos générale /*TODO : gérer avec les SESSIONS*/

$eleve = $syages->getInfosUser('11111380');
$idPromo = e($eleve[0]["promo"]);

//Séparation id des matieres_obligatoires et facultative
$idMatiere = $syages->getIdMatieres($idPromo);

//séparation id des matieres_obligatoires et facultative
$matieres_obligatoires = $idMatiere[0]["matieres_obligatoires"];
$matieres_facultatives = $idMatiere[0]["matieres_facultatives"];

/*Séparation des moyennes des matières obligatoires et facultatives*/
$note_moyenne_obligatoires = $syages->moyenneMatiere('11111380',$matieres_obligatoires)[0]["AVG(Note)"];
$note_moyenne_facultatives = $syages->moyenneMatiere('11111380',$matieres_facultatives)[0]["AVG(Note)"];
/*TODO : Demander si les moyenne ont des coeffs*/
$note_moyenne = ($note_moyenne_obligatoires+$note_moyenne_facultatives)/2;

$absenceEtudiant = array_slice($syages->absence_eleve('11111380'),0,7);
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
            <p>Votre note est en train </p>
             <div class="tab" style="display: flex;flex-direction: column;overflow-x: scroll">
                <h2 style="text-transform: uppercase; margin: 1% 1% 01% 0">Mes notes</h2>
                <table>

                    <tr><th>Date</th><th>Matière</th><th>Professeur(e)</th><th>Module</th><th>Note</th><th>Coeff</th></tr>
                    <?php foreach ($notes as $value):?>

                    <tr><td><?=$value["Date"]?></td><td><?=e($syages->nomMatiere(e($value["idMatiere"]))[0]["Nom"])?></td><td><?php $proff=$syages->getProfNomPrenom(e($value["idMatiere"]));echo e($proff[0]["Nom"])." ".e($proff[0]["Prénom"]);?></td>
                        <td><?=$value["idMatiere"];?></td><?= print_td_note($value["Note"]);?><td><?=e($value["Coef"]);?></td></tr>
                    <?php endforeach; ?>
                    <tr><th>Moy matière obligatoire</th><?= print_td_note($note_moyenne_obligatoires);?></tr>
                    <tr><th>Moy matière facultative</th><?= print_td_note($note_moyenne_facultatives);?></tr>
                    <tr><th>Moyenne actuelle</th><?= print_td_note($note_moyenne);?></tr>

                </table>
            </div>
            <h2 ><br/>MES ABSENCES</h2><br/>
                <div class="tababs">
                    <div class="tab">

                        <table>
                        <tr><th>Absence</th><th>Date début</th><th>Raison</th><th>Justifiées</th></tr>
                        <?php foreach (array_slice($absenceEtudiant,0,5) as $key => $value): ?>
                          <tr><td><?=e($value["idAbs"])?></td><td><?=e($value["Datetheure"])?></td><td><?=e($value["Data"])?></td><?=print_td_justification(e($value["Justif"]))?></tr>
                        <?php endforeach; ?>
                        </table>
                    </div>

<div class="form-conteneur">
                    <form action="soumissionAbsence.php" method="post">
                        <h2>GESTION DES ABSENCES</h2>
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
                            <select id="sel" name="justification">
                                <option value="medical">Certificat médical</option>
                                <option value="religion">Religion</option>
                                <option value="politique">Participation à une manifestation</option>
                                <option value="quarantaine">Test PCR</option>
                            </select>
                        </div>

                        <input type="submit" value="déclarer" id="btn"/>
                    </form>
                    </div>

                </div>
                <h2>MES INFORMATIONS</h2>
            <div class="mes-infos tababs">


                <div class="infos-text">
                    <table class="table">
                        <tr id="champs-infos"><th>Nom :</th><td> <?=e($eleve[0]["Nom"]);?></td></tr>
                        <tr id="champs-infos"><th>Prénom :</th><td> <?=e($eleve[0]["Prénom"]);?></td></tr>
                        <tr id="champs-infos"><th>Numéro Étudiant :</th><td> <?=e($eleve[0]["idUser"])?><img src=<?=e($eleve[0]["Photo"])?> style="height:52px; margin-left:13px;"></td></tr>
                        <tr id="champs-infos"><th>Promo :</th><td> <?=e($eleve[0]["promo"]);?></td></tr>

                        <tr id="champs-infos"><th>Matières obligatoires :</th><td>
                          <?php
                           $tab=explode(",",$matieres_obligatoires);
                           foreach ($tab as $key => $value):
                            echo e($value).': '.e($syages->nomMatiere($value)[0]["Nom"]).'<br>';
                           endforeach; ?></td></tr>


                           <tr id="champs-infos" style="padding:1%;"><th>Matières facultatives :</th><td>
                             <?php foreach (explode(",",$matieres_facultatives) as $key => $value):
                               echo e($value).': '.e($syages->nomMatiere($value)[0]["Nom"]).'<br>';
                              endforeach; ?></td></tr>

                        <tr id="champs-infos" ><th>Téléphone :</th><td> <?=e($eleve[0]["Téléphone"]);?></td></tr>
                        <tr id="champs-infos"><th>Login : </th><td><?=e($eleve[0]["Login"]);?></td></tr>
                        <tr id="champs-infos"><th>Mot de passe :</th><td> •••••••• <a href="mes_infos.php"><img src="img/edit.png" style="height: 22px;background-color: white; margin-left:.1%;"></a></td></tr>
                    </table>
                </div>
            </div>


<?php
    require 'fin.php';
?>
