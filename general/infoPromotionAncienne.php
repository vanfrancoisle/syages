<?php
$title='Les promotions anciennes';
require '../debut.php';
echo '<link rel="stylesheet" type="text/css" href="/css/general/InfoPromotionAncienne.css">';
#echo '<link rel="stylesheet" type="text/css" href="/css/general/InfoPromotionAncienne.css">';  /*mettre le css qui vous est particulier pas le css general qui est deja défini dans le début.php*/
require '../debut-2.php';
$h3='Les promotions anciennes';
require '../navbanner-secretaire.php'; ?>

<?php 
session_start();
$_SESSION["role"]="s";
$_SESSION["idUser"]="11111113";
?>


        <div class="body" id="body">
            <div class="melbanner">
                <button id="btn-menu1" onclick="show_hide()"><img src="/img/menu.png" id="menu"></button>
                <img src="/img/logo.png" id="logo"/>
                <input type="text" placeholder="Entrez des mots-clés" id="searchbar"><input type="submit" value="Rechercher" id="submitbutton">
                <img src="/img/david.jpg" id="user"/>
            </div>

            <div class=contenu>
                <h2>Toutes les promotions anciennes :</h2>
                <h3><a href="infoPromotionNew.php"> > Les promotions actives</a></h3>

                    <div class="tab">
                        <table>
                            <tr><th>Date de début</th><th>Date de fin</th><th>Nom de la promotion</th><th>Inscrits</th><th>Validé</th><th>Echec</th><th>Moyenne générale</th></tr>

                            <?php 
                                require '../BDDsyages.php';
                                if($_SESSION["role"]=="p" or $_SESSION["role"]=="s"){
                                    $bd = BDDsyages::getBddsyages(2);

                                    $tabPromo= $bd->lespromoAnciennes();
                                    if (!empty($tabPromo)){
                                        $anneefin = explode("-",$tabPromo[0]["datedebut"]);
                                        $anneedebut = explode("-",$tabPromo[0]["dateFin"]);
                                        echo '<tr class="titre_annee"><td colspan="7">Année '.$anneedebut[0].'-'.$anneefin[0].'</td></tr>';
                                        foreach ($tabPromo as $key => $value) {
                                            $fin = explode("-",$tabPromo[0]["datedebut"]);
                                            $debut = explode("-",$tabPromo[0]["dateFin"]);
                                            if ($anneedebut[0]!=$debut[0] or $anneefin[0]!=$fin[0]){
                                                echo '<tr class="titre_annee"><td colspan="7">Année '.$anneedebut[0].'-'.$anneefin[0].'</td></tr>';
                                            }
                                            echo '<tr><td>'.$value["datedebut"].'</td><td>'.$value["dateFin"].'</td><td><a href="#">'.$value["nomPromo"].'</a></td><td>'.$bd->get_nbInscrit($value["idPromotion"])[0].'</td></td><td>'.$bd->get_nbValide($value["idPromotion"])[0].'</td><td>'.$bd->get_nbEchec($value["idPromotion"])[0].'</td><td>'.$bd->get_moyennePromo($value["idPromotion"])[0].'</td></tr>';
                                        }
                                    } else {
                                    echo '<tr class="titre_annee"><td colspan="7">Aucune promotion ancienne</td></tr>';
                                    }
                                } 
                            ?>

                        </table>
                    </div>


                    

            </div>
            
        




<?php  require '../fin.php' ; ?>