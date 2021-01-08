<?php
$title='Controles';
require "../general/debut.php";
echo '<link rel="stylesheet" type="text/css" href="../css/professeur/ProfEval.css">';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
echo "<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>";
require '../general/debut-2.php';
$h3='Menu-Professeur';
require "../general/navbanner-professeur.php";

require_once "../general/Bddsyages.php";


$m = Bddsyages::getBddsyages(2);

?>
<div class="body" id="body">
	<div class="melbanner">
		<button id="btn-menu1" onclick="show_hide()"><img src="../img/menu.png" id="menu"></button>
		<img src="../img/logo.png" id="logo"/>
		<input type="text" placeholder="Entrez des mots-clés" id="searchbar"><input type="submit" value="Rechercher" id="submitbutton">
		<img src="../img/david.jpg" id="user"/>
    </div>
	<?php
		if(isset($_POST['promo']) and preg_match("#^[1-9]\d*$#",$_POST['promo']) 
		and isset($_POST['idMatiere']) and preg_match("#^[1-9]\d*$#",$_POST['idMatiere'])
		and isset($_POST['date']) and $_POST['date']!=""
		and isset($_POST['eval']) and $_POST['eval']!=""
		and isset($_POST['coef'])){
			$idPromo=$_POST['promo'];
			$lesusers = $m->user_promo($idPromo);
			$idMatiere=$_POST['idMatiere'];
			$nbEval=$m->nb_eval_matiere_promo($idPromo, $idMatiere);
            $date=$_POST['date'];
            $Coef = $_POST['coef'];
            $eval = $_POST['eval'];
            $numEval = $nbEval+1;
			//var_dump($idPromo);var_dump($idMatiere); var_dump($date);var_dump($Coef);var_dump($eval);var_dump("Possible de creer un ctrl");
			$m->creer_eval($idPromo,$lesusers, $date, $Coef, $eval, $numEval,$idMatiere);
			$nomPromo=$m->nom_promo($idPromo);
			echo '<h2>L\'évaluation : '.$eval.'  a été bien créée pour la promo DEAU '.$nomPromo.'</h2>';
		}else{
			$idPromo=120211;
			$idMatiere=1;
			//var_dump("Pas de Controles créé !!");
		}
	?>
        <h2><br/>ÉVALUATION </h2><br/>  
        <div id="tab_fomulaire" class="tabeval">
            <div class="tab">
                <table>
                <tr><th>Matières</th><th>Promo concernée</th><th>Date</th><th>Coefficient</th><th>Type d'évaluation</th></tr>
					
					<?php
						$les_matieresProf="1,4";
						$ctrl= $m->les_derniers_eval_du_prof($idPromo,$les_matieresProf);
						//var_dump($ctrl);
                       /*foreach ($lesEval as $ligne){
						$nomMatiere=$m->nom_matiere($ligne['idMatiere']);
						
                        $nomPromo=$m->nom_promo($ligne['idPromo']);
                        echo '<tr><td>'. $nomMatiere. '</td><td>' . $nomPromo[0]['Option'].'</td><td>'.$ligne['Date'].'</td><td>'.$ligne['Coef'].'</td><td> '.$ligne['Mode'] .'</td></tr>';
                        }*/
                        /**foreach ($liste_eval as $ev){
                            echo '<tr><td>' . $ev['idMatiere'] . '</td><td>' . $ev['idPromotion'] . '</td><td>' .  $ev['Coef'] . '</td><td>' .  $ev['Date'] . '</td><td>' .  $ev['Mode'] . '</td></tr>';
						}**/
						foreach	($ctrl as $ev){
							$nomMatiere=$m->nom_matiere($ev['idMatiere']);
							$nomPromo=$m->nom_promo($ev['idPromo']);
							echo '<tr><td>'. $nomMatiere. '</td><td> DEAU ' . $nomPromo.'</td><td>'.$ev['Date'].'</td><td>'.$ev['Coef'].'</td><td> '.$ev['Mode'] .'</td></tr>';
						}
                    ?>
                </table>
            </div>
            
            <div class="eval">
                <h4>Evalution et gestion des promos</h4>
			
                <form action="" method="post">
                    <p>Date : <input type="date" value="" name="date"/></p>
					<p>DAEU : 
					<select name="promo">
						<option name="promo" value="120211">DAEU option A</option>
						<option name="promo" value="120212">DAEU option B</option>
						<option name="promo" value="240423">DAEU A et B</option>
					</select></p>
				<p>Matières : 
					<select name="idMatiere">
						<option></option>
						<?php
						$lesMatieres =$m->recuperer_matieres_prof(11111113);

						foreach($lesMatieres as $idMatiere){
							$nomMatiere=$m->nom_matiere(intval($idMatiere));
							//var_dump($nomMatiere);
							echo '<option name="idMatiere" value="'.$idMatiere.'">'.$nomMatiere.'</option>';
						}
						?>
					</select></p>
					<p><label>Type d'évaluation:<input text="text" name="eval"/></label></p> 
                    <p><label>Coefficient:<input type="number" name="coef" required step="any"></label></p>
					<button class="btn_submit" type="submit">Créer l'évaluation</button>
                </form>
				<form action="gestion_controle" method="post">
					<p>DAEU : 
					<select name="promo">
						<option name="promo" value="120211">DAEU option A</option>
						<option name="promo" value="120212">DAEU option B</option>
						<option name="promo" value="240423">DAEU A et B</option>
					</select></p>
				<p>Matières : 
					<select name="idMatiere">
						<option></option>
						<?php
						$lesMatieres =$m->recuperer_matieres_prof(11111113);
						foreach($lesMatieres as $idMatiere){
							$nomMatiere=$m->nom_matiere(intval($idMatiere));
							//var_dump($nomMatiere);
							echo '<option name="idMatiere" value="'.$idMatiere.'">'.$nomMatiere.'</option>';
						}
						?>
					</select></p>
					<button class="btn_submit" type="submit">Gérer la promo</button>
                </form>
            </div>
        </div>
        
<?php require "../general/fin.php"; ?>

