<?php
$title='Information sur la promotion';
require 'debut.php';
echo '<link rel="stylesheet" type="text/css" href="/css/general/InfoPromotionNew.css">';  /*mettre le css qui vous est particulier pas le css general qui est deja défini dans le début.php*/
require 'debut-2.php';
$h3='Information sur la promotion';
require 'navbanner-secretaire.php'; 

?>

<?php 
session_start();
$_SESSION["role"]="s";
$_SESSION["idUser"]="11111113";
$_SESSION["idPromotion"]="120212";
//Logs
$texte = "\n".date("d-m-Y")."|";
file_put_contents('log.txt', $texte."Consulter Promotion actuelle|".$_SESSION["idUser"]."|Page promotion ".$_SESSION["idPromotion"],FILE_APPEND);
?>

        <div class="body" id="body">
            <div class="melbanner">
                <button id="btn-menu1" onclick="show_hide()"><img src="/img/menu.png" id="menu"></button>
                <img src="/img/logo.png" id="logo"/>
                <input type="text" placeholder="Entrez des mots-clés" id="searchbar"><input type="submit" value="Rechercher" id="submitbutton">
                <img src="/img/david.jpg" id="user"/>
            </div>

            <div class=contenu>
                <?php 
                require 'BDDsyages.php';
                if($_SESSION["role"]=="p"){
                    $bd = BDDsyages::getBddsyages(2);
                }
                elseif ($_SESSION["role"]=="s"){
                    $bd = BDDsyages::getBddsyages(3);
                }
                    
                if ($_SESSION["role"]=="p" or $_SESSION["role"]=="s"){
                    echo "<h2>Promotion : ".$bd->get_nomPromo($_SESSION["idPromotion"])[0]."</h2>";
                }
                if($_SESSION["role"]=="p"){

                    $tab= $bd->matiere_enseignee($_SESSION["idUser"],$_SESSION["idPromotion"]);
                    $nbMatiere = count($tab);
                    if ($nbMatiere>=2){
                        echo "<h3>Mes matieres : ";
                    } else {
                        echo '<h3>Ma matière : ';
                    }
                    foreach ($tab as $key => $value) {

                        echo '<form class="form_inline" action="gestion_controle.php" method="POST" ><input type="hidden" name="matiere" value="'.$value.'"/></form>'."<a href='#' onclick='document.getElementById(\"".$value."\").submit()'>$value</a>";
                        if ($key<$nbMatiere-1){
                            echo ", ";
                        }
                        #header("Location: ");
                    } 

                    echo '</h3>';
                }
                ?>
                
                <h3>Disciplines enseignées :</h3>

                    <div class="tab">
               
                        <table>
                            <tr><th>Matière</th><th class=width20>Professeurs</th><th>Inscrits</th><th>Evaluations</th><th>Moyenne générale</th>

                                <?php if (isset($_SESSION["role"])){
                                    if ($_SESSION["role"]=="s"){
                                        echo "<th>Absences totales</th><th>Justifiées</th><th>Non justifiée</th>";
                                    }
                                }
                                ?></tr>

                            <?php
                                if ($_SESSION["role"]=="p" or $_SESSION["role"]=="s"){

                                    $matieres["obligatoire"]=$bd->get_matieresObligatoires($_SESSION["idPromotion"]);
                                    $matieres["optionnelle"]=$bd->get_matieresOptionnelles($_SESSION["idPromotion"]);
                                    
                                    foreach ($matieres as $key => $value) {
                                        if ($key=="obligatoire"){
                                            echo '<tr><td>Obligatoire :</td><td colspan="7"></td></tr>';
                                        } elseif ($key=="optionnelle"){
                                            echo '<tr><td>Optionnel :</td><td colspan="7"></td></tr>';
                                        }
                                        foreach ($value as $key2 => $value2) {
                                            echo '<tr><td><a href="#">'.$value2.'</a></td><td>'.implode(",</br>",$bd->get_professeur_promo($_SESSION["idPromotion"],trim($value2))).'</td><td>'.$bd->get_nbEleveMatiere($_SESSION["idPromotion"],$value2)[0].'</td><td>';

                                            if ($bd->get_evaluation($_SESSION["idPromotion"],$value2)[0]!=false){
                                                echo $bd->get_evaluation($_SESSION["idPromotion"],$value2)[0].' en cours</td><td>';
                                            } else {
                                                echo '</td><td>';
                                            }
                                            echo $bd->get_moyenne($_SESSION["idPromotion"],$value2)[0].'</td>';
                                            if ($_SESSION["role"]=="s"){
                                                echo '<td>'.$bd->get_totalAbs($_SESSION["idPromotion"],$value2)[0].'</td><td>'.$bd->get_absJustif($_SESSION["idPromotion"],$value2)[0].'</td><td>'.$bd->get_absInjustif($_SESSION["idPromotion"],$value2)[0].'</td>';
                                            }
                                            echo '</tr>';
                                        }
                                    }   
                                }
                            ?>
                        </table>
                    </div>

                    <div id=liens>
                        <div id="wrapper2">
                            <div id="container_wrapper2">
                                <h3>Acces aux informations</h3>
                                <p><a href="#">Liste des étudiants</a></p></br>
                                <p><a href="infoPromotionAncienne.html">Liste des anciennes promotions</a></p>
                                <?php
                                    if ($_SESSION["role"]=="s"){
                                        echo '                                <h3>Gerer les absences</h3>
                                <p><a href="absence2.html">Calendrier des absences</a></p></br>
                                <p><a href="absence.html">Liste des élèves absents</a></p>';
                                    }
                                ?>

                            </div>
                            <?php 
                                if ($_SESSION["role"]=="s"){
                                    echo   '                         <div id="chart">
                                <canvas id="myChart"></canvas>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
                                <script>'."
                                var ctx = document.getElementById('myChart').getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: ['Justifié','Injustifié'],
                                        datasets: [{
                                            data: [".$bd->get_absJustifPromo($_SESSION["idPromotion"])[0].",".$bd->get_absInjustifPromo($_SESSION["idPromotion"])[0]."],
                                            backgroundColor: [
                                                'rgba(54, 162, 235, 0.2)','rgba(255, 99, 132, 0.2)'
                                                
                                            ],
                                            borderColor: [
                                                'rgba(54, 162, 235, 1)','rgba(255, 99, 132, 1)'
                                                
                                            ],
                                            borderWidth: 1
                                        }]
                                    }
                                });
                                </script>
                            </div>
                            ";
                                }

                            ?>

                        </div>
                    </div>

            </div>

<?php  require 'fin.php' ; ?>