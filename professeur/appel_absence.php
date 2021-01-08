<?php
$title='Controles';
require "../general/debut.php";
echo '<link rel="stylesheet" type="text/css" href="../css/professeur/style_gestion_prof.css">';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
echo "<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>";
require '../general/debut-2.php';
$h3='Menu-Professeur';
require "../general/navbanner-professeur.php";

require_once "../general/Bddsyages.php";

$m = Bddsyages::getBddsyages(2);
$lesusers = $m->user_promo(120211);
?>
<div class="body" id="body">
	<div class="melbanner">
		<button id="btn-menu1" onclick="show_hide()"><img src="../img/menu.png" id="menu"></button>
		<img src="../img/logo.png" id="logo"/>
		<input type="text" placeholder="Entrez des mots-clés" id="searchbar"><input type="submit" value="Rechercher" id="submitbutton">
		<img src="../img/david.jpg" id="user"/>
	</div>
	<?php
	if(isset($_POST['liste_abs'])){
		var_dump($_POST['liste_abs']);
	}else{
		var_dump("Pas de liste");
	}
	if(isset($_POST['dataabs'])){
		var_dump($_POST['dataabs']);
	}else{
		var_dump("Pas de date selectionné");
	}
	if(isset($_POST['idMatiere']) and isset($_POST['idPromo'])){
		var_dump($_POST['idMatiere']);
		var_dump($_POST['idPromo']);
		$idMatiere = $_POST['idMatiere'];
		$idPromo = $_POST['idPromo'];
		$nomMatire=$m->nom_matiere($idMatiere);
	    $nomPromo =$m->nom_promo($idPromo);
	}else{
	    $idMatiere = 1;
		$idPromo = 120211;
		$nomMatire='Maths';
		$nomPromo ='A';
		var_dump("Pas de date matiere et promo ....");
	}
	?>
<h2><br/>Gestion des absences</h2><br/>
<form action="appel_absence" method="post">
<h2><br/>PROMOTION : DEAU <?= $m->nom_promo($idPromo)?></h2><br/>
<h2>Matière : <?= $m->nom_matiere($idMatiere)?></h2><br/>
<h2>Semestre 1 </h2><br/>
<label for="start">Choisir la date : </label>
<input type="datetime-local" id="dateheure" name="dataabs" value="2020-11-18T21:03" min="2020-11-18T21:03" max="2050-11-18T21:03">
<input name="idMatiere" type="hidden" value="<?=$idMatiere?>">
<input name="idPromo" type="hidden" value="<?=$idPromo?>">
<br/><br/><br/>
<div class="tababs">
	<div class="tab">
<table id="tab_abs">
	<tr><th>Numéro </th><th>Prénom </th><th>Nom</th><th>Absent(e)</th></tr>
	<?php
	
	forEach($lesusers as $cle => $lingneUser){
		$user = $m->nom_prenom_user(intval($lingneUser["idUser"]));
		echo '<tr><td>'.($cle+1).'</td><td>'.$user["Nom"].'</td><td>'.$user["Prénom"].'</td><td><input type="checkbox" name="liste_abs[]" class="check_abs" value="'.intval($lingneUser["idUser"]).'"></td></tr>';
	}
	?>
</table>
		<button class="btn_submit" type="submit">Enregister les modifications</button>
</form>
<br/>
<div id="btn_eval_abs">

	<form action="gestion_controle">
		<button class="btn_submit" type="submit">Annuler</button>
	</form>

</div>
<br/><br/><br/>
<br/><br/><br/>
<?php require "../general/fin.php"; ?>