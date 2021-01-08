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


if(isset($_POST['promo']) and preg_match("#^[1-9]\d*$#",$_POST['promo']) 
		and isset($_POST['idMatiere']) and preg_match("#^[1-9]\d*$#",$_POST['idMatiere'])){
	$idPromo=$_POST['promo'];
	$lesusers = $m->user_promo($idPromo);
	$idMatiere=$_POST['idMatiere'];
	//var_dump($idMatiere);
}else{
	$idMatiere=3;
    $idPromo=120211;
	$lesusers = $m->user_promo(120211);
}
$c=$m->recuperer_controle($idPromo, $idMatiere);
$nbEval=$m->nb_eval_matiere_promo($idPromo, $idMatiere);



?>
<div class="body" id="body">
<div class="melbanner">
	<button id="btn-menu1" onclick="show_hide()"><img src="../img/menu.png" id="menu"></button>
    <img src="../img/logo.png" id="logo"/>
    <input type="text" placeholder="Entrez des mots-clés" id="searchbar"><input type="submit" value="Rechercher" id="submitbutton">
    <img src="../img/david.jpg" id="user"/>
</div>
<h2><br/>PROMOTION : DEAU <?= $m->nom_promo($idPromo)?></h2><br/>
			
<h2>Matière : <?= $m->nom_matiere($idMatiere)?></h2><br/>
<h2>Semestre 1 </h2><br/>
<div id="btn_eval_abs">
	<form action="EvalEnseignant" method="post">
		<input name="idMatiere" type="hidden" value="<?=$idMatiere?>">
		<input name="idPromo" type="hidden" value="<?=$idPromo?>">
		<button class="btn_submit" type="submit">Creer une évaluation</button>
	</form>
	<form action="appel_absence" method="post">
		<input name="idMatiere" type="hidden" value="<?=$idMatiere?>">
		<input name="idPromo" type="hidden" value="<?=$idPromo?>">
		<button class="btn_submit" type="submit">Faire l'appel</button>
	</form>
</div>
<br/><br/><br/>
	
<?php
	if(isset($_POST['promo'])){
	$promo=$_POST['promo'];
	//var_dump($promo);
}if(isset($_POST['idMatiere'])){
	$matiere=$_POST['idMatiere'];
	//var_dump($matiere);
}if(isset($_POST['date'])){
	$date=$_POST['date'];
	var_dump($date);
}
?>

<br/><br/><br/>

<div class="tababs">
	<div class="tab">
    <table id="tab_eval">
	<thead>
		<?php
		// Formulaire pour modifier un controle
		$chaine = '<form action="saisienote" method="post">
					 <input name="idMatiere" type="hidden" value="'.$idMatiere.'">
					 <input name="idPromo" type="hidden" value="'.$idPromo.'">
					 <input name="numEval" type="hidden" value=":numEval">
					 <p><input class="btn_modif" type="submit" value="Modifier"></p>
				 </form>';
				 
		echo '<tr><th class="btn_titre_col">Numéro</th><th class="btn_titre_col">Prénom </th><th class="btn_titre_col">Nom</th>';
		for($numEval=1; $numEval<=$nbEval;$numEval++){
		    $nomCtrl= $m->recuperer_nom_controle($idPromo,$idMatiere,$numEval);
			$form_modif=str_replace(":numEval", $numEval,$chaine);
			echo '<th class="bt_eval btn_titre_col">'.$nomCtrl.' <br>'.$form_modif.'</th>';
		}
		echo '<th class="btn_titre_col">Moyenne</th></tr>
		</thead>
		<tbody>';
		// Remplissage du tableau pour chaque etudiants et le nombre de controle qu'il a fait
		
		$i=0;
		$moyenneClasse=0;
		$tabMoyenneCtrl=[];
		for($i=1; $i<= $nbEval ;$i++){
			$tabMoyenneCtrl[$i]=0;
		}
		foreach($lesusers as $cle => $lingneUser){
			$controleEtu = $m->recuperer_controle_etud($idMatiere,$lingneUser["idUser"]);
			//var_dump($controleEtu);
			$moyenneEtu=0;
			$etudiant = $m->nom_prenom_user(intval($lingneUser["idUser"]));

			//echo '<tr data-href="visualition_note_elve?id='.(intval($lingneUser["idUser"])).'"><td>'.($cle+1).'</td><td>'.$etudiant["Nom"].'</td><td>'.$etudiant["Prénom"].'</td>';
			echo '<tr><td>'.($cle+1).'</td><td>'.$etudiant["Prénom"].'</td><td>'.$etudiant["Nom"].'</td>';
			$nbCoef=0;
			for($numEval=1; $numEval<=$nbEval;$numEval++){
				$note=$controleEtu[$numEval-1]["Note"];
				if($note==-1){
					$note="NP";
				}elseif($note==-2){
					$note="abs";
					$nbCoef+=$controleEtu[$numEval-1]["Coef"];
					$moyenneEtu+=0;
				    $tabMoyenneCtrl[$numEval]+=0;
				}else{
					$moyenneEtu+=$note*$controleEtu[$numEval-1]["Coef"];
				    $tabMoyenneCtrl[$numEval]+=$note;
					$nbCoef+=$controleEtu[$numEval-1]["Coef"];
				}
				echo '<td>'.$note.'</td>';
			}
			echo '<td>'.(bcdiv($moyenneEtu,$nbCoef ==0 ? 1 : $nbCoef,2)).'</td>
				<td class="sansBordure">
				<form action="visualition_note_elve" method="post">
					<input name="id" type="hidden" value="'.(intval($lingneUser["idUser"])).'">
					<input class="icone" type="image" id="image" title="Regarder les notes de l\'élève" src="../img/eye.png">
				</form>
				</td>
				<td class="sansBordure">
				<form action="visualition_note_elve" method="post">
					<input name="id" type="hidden" value="'.(intval($lingneUser["idUser"])).'">
					<input class="icone" type="image" id="image" title="Modifier les notes" src="../img/edit.png">
				</form>
				</td>
			</tr>';
			$moyenneClasse+=bcdiv($moyenneEtu,$nbCoef ==0 ? 1 : $nbCoef,2);
			$i++;
		}
		?>
	</tbody>
	<tfoot>
	   <tr ><td colspan="3" class="moy_bas">Moyenne</td>
	   <?php
		   for($i=1; $i<= $nbEval ; $i++){
			echo '<td class="moy_eval_bas">'.(bcdiv($tabMoyenneCtrl[$i],count($lesusers),2)).'</td>';
		   }
	   ?>
	   <td class="moy_gen"><strong>  <?= bcdiv($moyenneClasse,count($lesusers),2)?></strong></td></tr>
    </tfoot>
	</table>
<script type="text/javascript">
	document.addEventListener("DOMContentLoaded",() => {
	const rows = document.querySelectorAll("tr[data-href]");
	rows.forEach(row => {
		row.addEventListener("click",() => {
			window.location.href = row.dataset.href;
		});
	});
	//console.load(rows);
	
	});
	const compare = (ids, asc) => (row1, row2) => {
	  const tdValue = (row, ids) => row.children[ids].textContent;
	  const tri = (v1, v2) => v1 !== '' && v2 !== '' && !isNaN(v1) && !isNaN(v2) ? v1 - v2 : v1.toString().localeCompare(v2);
	  return tri(tdValue(asc ? row1 : row2, ids), tdValue(asc ? row2 : row1, ids));
	};

	const tbody = document.querySelector('tbody');
	const thx = document.querySelectorAll('th');
	const trxb = tbody.querySelectorAll('tr');
	thx.forEach(th => th.addEventListener('click', () => {
	  let classe = Array.from(trxb).sort(compare(Array.from(thx).indexOf(th), this.asc = !this.asc));
	  classe.forEach(tr => tbody.appendChild(tr));
	}));
</script>

<br/><br/><br/>
<br/><br/><br/>
</div>
</div>
<?php require "../general/fin.php"; ?>