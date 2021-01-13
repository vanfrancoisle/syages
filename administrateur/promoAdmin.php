<?php
$title='Informations promotions';
require '../debut.php';
echo '<link rel="stylesheet" type="text/css" href="/css/administrateur/promoAdmin.css">';
require '../debut-2.php';
$h3='title';
require '../navbanner-admin.php'; 

?>

<?php
//A supprimer
$_SESSION["role"]="a";
$_SESSION["idEtablissement"]=1;
$_SESSION["idUser"]=1;
//

require '../BDDsyages.php';
if($_SESSION["role"]=="a"){
    $bd = BDDsyages::getBddsyages(4);
}

?>

    <div class="wrapper">
        <div class="nav_bar" id="navbar">
            <img src="/img/logo-4.png" id="logo">
            <button id="btn-menu" onclick="show_hide()"><img src="/img/menu.png" id="menu"></button>
            <h3>MENU - SECRÉTARIAT</h3>
            <ul>
                <li><a href="#"><img src ="/img/home.ico"/>ACCUEIL</a></li>
                <li><a href="#"><img src ="/img/search.png"/>RECHERCHER</a></li>
                <li><a href="#"><img src ="/img/diploma.png"/>PROMOTIONS</a></li>
                <li><a href="#"><img src ="/img/settings.png"/>GESTION USER</a></li>
                <li><a href="#"><img src ="/img/graph.ico"/>GRAPHIQUES</a></li>
                <li><a href="#"><img src ="/img/user.png"/>MES INFORMATIONS</a></li>
                <li><a href="#"><img src ="/img/deconnexion.png"/>DECONNEXION</a></li>
            </ul>
        </div>
        <div class="body" id="body">
            <div class="melbanner">
                <button id="btn-menu1" onclick="show_hide()"><img src="/img/menu.png" id="menu"></button>
                <img src="/img/logo.png" id="logo"/>
                <input type="text" placeholder="Entrez des mots-clés" id="searchbar"><input type="submit" value="Rechercher" id="submitbutton">
                <img src="/img/david.jpg" id="user"/>
            </div>

	

            <div class="contenu">

<?php
	
//Logs
	$texte = "\n".date("d-m-Y")."|";
	file_put_contents('log.txt', $texte."Consulter promotion admin|".$_SESSION["idUser"]."|Page promotion admin",FILE_APPEND);
	#var_dump($_POST);

	foreach ($_POST as $key => $value) { // On fait passer tous les valeurs par htmlspecialchars pour éviter d'entrer des infos malicieuses
		$_POST[$key]=htmlspecialchars($value, ENT_QUOTES);
	}

	if (isset($_POST["formulaire"])){
		if ($_POST["formulaire"]=="creerPromotion"){
			if (    !empty($_POST["nomPromo"]) and !empty($_POST["dateDebut"]) and !empty($_POST["dateFin"]) and 
					!empty($_POST["paraDiplome"]) and !empty($_POST["paraValidation"]) ){
				$_POST["nomPromo"]=ucwords($_POST["nomPromo"]);
				$bd->creer_promo($_POST);
				$matiereObl = $bd->get_obligatoireDAEU($_POST["daeu"])[0]; // TU recois soit A soit B
				if (!empty($matiereObl[0])){
					$_POST["matiereObligatoire"]=$matiereObl[0]; 
					$bd->set_matiereObligatoire($_POST);    // ICI on met les matieres obligatoires à la promo
				}
				file_put_contents('log.txt', $texte."Création d'une promotion|".$_SESSION["idUser"]."|Promotion : ".$_POST["nomPromo"]." en daeu ".$_POST["daeu"],FILE_APPEND);
				echo "<h1>Vous avez ajouté une promotion.</h1>";
			} else {
				echo "<h1>Ajout d'une promotion échoué.</h1>";
			}

		} elseif ($_POST["formulaire"]=="ajouterMatiere") {
			if  ( !empty($_POST["nomMatiere"]) ){
				$_POST["nomMatiere"]=ucfirst($_POST["nomMatiere"]);//majuscule
				if ($_POST["choixMatiere"]=="ajout" and !empty($_POST["coef"])){
					$_POST["idMatiere"]=$bd->add_matiere($_POST);
					if ($_POST["choixObligatoireOption"]=="obligatoire"){
						$bd->add_matiereObl($_POST);
						$texte.="Obligatoire :";
					} else {
						$bd->add_matiereOpt($_POST);
						$texte.="Optionnelle :";
					}
					echo "<p>Vous avez ajouté une matière.</p>";
					file_put_contents('log.txt', $texte."Ajout d'une matière|".$_SESSION["idUser"]."|Promotion : ".$bd->get_nomPromo($_POST["idPromotion"])[0].", matiere : ".$_POST["nomMatiere"],FILE_APPEND);
				} elseif ($_POST["choixMatiere"]=="supprimer"){
					if ($_POST["choixObligatoireOption"]=="obligatoire"){
						$bd->supp_matiereObl($_POST);
						$texte.="Obligatoire :";
					}
					$bd->sup_matiere($_POST);
					echo "<h1>Vous avez supprimé une matière.</h1>";
					file_put_contents('log.txt', $texte."Supression d'une matière|".$_SESSION["idUser"]."|Promotion : ".$bd->get_nomPromo($_POST["idPromotion"])[0].", matiere : ".$_POST["nomMatiere"],FILE_APPEND);
				}
			} else {
				echo "<h1>Erreur lors de l'ajout/suppression d'une matiere</h1>";
			}

		} elseif ($_POST["formulaire"]=="ajouterProf" and !empty($_POST["nomProf"]) and !empty($_POST["nomMatiere"])) {
			$_POST["nomProf"]=ucwords($_POST["nomProf"]);//majuscule
			$idProf=$bd->search_enseignant($_POST["idPromotion"], $_POST["nomProf"])[0];
			if (!empty($idProf)){
				$_POST["idProf"]=$idProf[0];
				if ($_POST["choixProf"]=="ajout"){
					var_dump($_POST);
					$bd->add_prof($_POST);

					echo "<h1>Vous avez ajouté un prof.</h1>";
					file_put_contents('log.txt', $texte."Ajout d'un prof|".$_SESSION["idUser"]."|Promotion : ".$bd->get_nomPromo($_POST["idPromotion"])[0].", prof : ".$_POST["nomProf"].", matiere : ".$_POST["nomMatiere"],FILE_APPEND);
				} elseif ($_POST["choixProf"]=="supprimer"){
					$bd->sup_prof($_POST);
					echo "<h1>Vous avez supprimé un prof.</h1>";
					file_put_contents('log.txt', $texte."Supression d'un prof|".$_SESSION["idUser"]."|Promotion : ".$bd->get_nomPromo($_POST["idPromotion"])[0].", prof : ".$_POST["nomProf"].", matiere : ".$_POST["nomMatiere"],FILE_APPEND);
				}
			} else {
				echo "<h1>Nom du prof invalide</h1>";
			}
		}
		elseif ($_POST["formulaire"]=="supPromotion"){
			$bd->sup_promo($_POST);
			file_put_contents('log.txt', $texte."Supression d'une promotion|".$_SESSION["idUser"]."|Promotion : ".$_POST["nomPromo"],FILE_APPEND);
		} else {
			echo "<h1>Erreur lors de l'ajout/suppression d'un prof</h1>";
		}
	}
?>

            	<h1>Gestion des promotions</h1>

				<h3>Récapitulatif des matieres des DAEU</h3>
				
	                <div class="tababs marginauto">
	                    <table>
	                        <tr><th>DAEU</th><th>Matières obligatoires</th><th>Matières optionnelles</th></tr>
	                        <?php
                    		$tabPromo = $bd->lespromoActuelles();
                    		$daeu = ["A","B"];
                    		$daeu=$bd->existDAEU();
                    		foreach ($daeu as $value) {
                    			echo "<tr><td>".$value."</td>";
                    			$matieres["obligatoire"]=$bd->all_matieresObligatoires($value);
                    			$matieres["optionnelle"]=$bd->all_matieresOptionnelles($value);
                                echo "<td>".implode("</br>",$matieres["obligatoire"])."</td><td>".implode("</br>",$matieres["optionnelle"])."</td></tr>";
                    		}
                    		?>

	                    </table>
	                </div>

<script language="JavaScript">
function verif(){
	if(confirm("Voulez vous vraiment supprimer cette promotion ?")){
		return true;
	} else {
		return false;
	}
}
</script>

                <h1> Les promotions en cours<br></h1>
                <div class="tababs">
                    <table class="promotionEnCours">

                        <tr><th class="width5"></th><th class="width10">Nom de la promotion</th><th class="width15">Date de début</th><th class="width15">Date de fin</th><th class="width5">Nombre d'élèves</th><th class="width15">Liens</th>
                        </tr>

                    	<?php

                    		foreach ($tabPromo as $key => $value) {	
                    			echo '<tr id="rouge">

                    			<td><form action="" method="POST" onsubmit="return verif();">

                    				<input name="formulaire" type="hidden" value="supPromotion">
                    				<input name="idPromotion" type="hidden" value='.$value["idPromotion"].'>
                    				<input name="nomPromo" type="hidden" value='.$value["NomPromo"].'>
                    				<input type="image" id="cross" alt="supprimer" src="/img/remove-icon.png"></form></td>


                    			<td><a href="infoPromotionNew.html">'.$value["NomPromo"].'</a></td>
                            <td>'.$value["DateDebut"].'</td><td>'.$value["DateFin"].'</td><td>'.$bd->get_nbElevePromotion($value["idPromotion"])[0].'</td><td><a>voir absences</a></td></tr>';

                            	echo '<tr><th></th><th>Matieres</th><th>Professeurs</th><th>Moyenne</th><th>Coefficient</th><th></th></tr>';

                            	$matieres=array();
								$matieres["obligatoire"]=$bd->get_matieresObligatoires($value["idPromotion"]);
                                $matieres["optionnelle"]=$bd->get_matieresOptionnelles($value["idPromotion"]);
                                if (empty($matieres["obligatoire"])){ // si on remarque que pas de matiere obligatoire
                                	unset($matieres["obligatoire"]);
                                }
                                if (empty($matieres["optionnelle"])){ // si on remarque que pas de matiere optionnelle
                                	unset($matieres["optionnelle"]);
                                }
								foreach ($matieres as $key2 => $tabMatiere) {
									if ($key2=="obligatoire"){
                                            echo '<tr><td rowspan='.count($tabMatiere).'>Obligatoire</td>';
                                    } elseif ($key2=="optionnelle"){
                                            echo '<tr><td rowspan='.count($tabMatiere).'>Optionnel</td>';
                                    }

                                    foreach ($tabMatiere as $key3 => $value2) {

                                    	echo '<td><a>'.$value2.'</a></td><td>'.implode("</br>",$bd->get_professeur_promo($value["idPromotion"],trim($value2))).'</td><td>'.$bd->get_moyenne($value["idPromotion"],$value2)[0].'</td><td>';
                                    	$coef = $bd->get_coefMatiere($value2);

                                    	if (!empty($coef)){
                                    		echo $coef[0][0];
                                    	} else {
                                    		echo 1; // Gerer l'erreur rare coef non saisi
                                    	}
                                    	echo '</td><td><a href="EnseignantEval.html">voir évaluation</a></td></tr>';
                                	}
                                }
                    		}
                    	?>
                    </table>

                </div>
                
                <div class="flex">
	    			<div class="tababs">
						<div class="form-conteneur">
		                    <form action="" method="POST">
		                        <h3>Créer une promotion :</h3>
		                        <input name="formulaire" type="hidden" value="creerPromotion">
		                        <select type="select" name="daeu" class="daeu">
		                            <option value="A">DAEU A</option>
		                            <option value="B">DAEU B</option>
		                        </select>
		                        <input type="text" name="nomPromo" id="nomPromo" placeholder="Nom de la promotion">
		                    <br>
		                        <label>Date de début :
		                        <input type="date" name="dateDebut" id="dateDebut" style="height:auto;"></label>

		                        <label>Date de fin :
		                        <input type="date" name="dateFin" id="dateFin" style="height:auto;"></label>
		                        
		                        <input type="text" name="paraDiplome" id="paraDiplome" placeholder="Parametre du diplome">

		                        <input type="number" name="paraValidation" id="paraValidation" placeholder="Parametre de validation">

		                        <input type="submit" name="valider" value="valider" style="height:auto;">
		                    </form>
		                </div>
		            </div>

					<div class="tababs">
						<div class="form-conteneur marginauto" >
	                    <form action="" method="POST">
		                        <h2>Ajouter / Supprimer une matière</h2>
		                        <input name="formulaire" type="hidden" value="ajouterMatiere">
		                        <select type="select" name="idPromotion" class="idPromotion">
		                            <?php foreach ($tabPromo as $key => $value): ?>
		                            <option value="<?=$value["idPromotion"]?>"><?=$value["NomPromo"]?></option>
		                        	<?php endforeach ?>
		                        </select>

		                        <select type="select" name="choixMatiere" id="choixMatiere">
		                            <option value="ajout">Ajouter une matière</option>
		                            <option value="supprimer">Supprimer une matière</option>
		                        </select>

		                        <select type="select" name="choixObligatoireOption" id="choixObligatoireOption">
		                            <option value="obligatoire">Obligatoire</option>
		                            <option value="optionnel">Optionnelle</option>
		                        </select>

		                        <select type="select" name="mode" id="mode">
		                            <option value="pour jury">Pour jury</option>
		                            <option value="autre">Autre</option>
		                        </select>

		                        <input type="text" name="nomMatiere" id="nomMatiere" placeholder="Nom de la matière">

		                        <input type="number" name="coef" id="coef" placeholder="Coefficient">

		                        <input type="submit" name="valider" value="valider" style="height:auto;">
		                    </form>
		                </div>
		            </div>

					<div class="tababs">
		    			<div class="form-conteneur">  <!-- esthetique pour formulaire -->
		    				<form action="" method="POST">
		            			<h3>Ajouter / Supprimer une matière à un professeur</h3>
		            			<input name="formulaire" type="hidden" value="ajouterProf">
		                        <select type="select" name="idPromotion" class="idPromotion">
		                        	<?php foreach ($tabPromo as $key => $value): ?>
		                            <option value="<?=$value["idPromotion"]?>"><?=$value["NomPromo"]?></option>
		                        	<?php endforeach ?>
		                        </select>

		                        <select type="select" name="choixProf" id="choixProf">
		                            <option value="ajout">Ajouter un prof</option>
		                            <option value="supprimer">Supprimer un prof</option>
		                        </select>
<!--
		                        <select type="select" name="choixObligatoireOption" id="choixObligatoireOption">
		                            <option value="obligatoire">Matiere obligatoire</option>
		                            <option value="optionnel">Matiere optionnelle</option>
		                        </select>

		                        <select type="select" name="nomMatiere" id="nomMatiere">
		                            <option value="">Nom de la matiere</option>
		                            <option value="francais">Francais</option>
		                            <option value="maths">Maths</option>
		                        </select>
!-->
								<input type="text" name="nomMatiere" id="nomMatiere" placeholder="Nom de la matière">
		                        <input type="text" name="nomProf" id="nomProf" placeholder="Nom de l'enseignant">
		                        <input type="submit" name="valider" value="valider" style="height:auto;">
		                    </form>
		                </div>
					</div>
		        </div>
			</div>
            <footer></footer>

<?php  require '../fin.php' ; ?>