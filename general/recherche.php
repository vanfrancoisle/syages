<?php
$title='Controles';
require "../general/debut.php";
echo '<link rel="stylesheet" type="text/css" href="../css/general/filtersearch .css">';
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

<form name="searching_tabel" id="searching_tabel">
	<div class="container">
		<!----------------------------------------
		-	SEARCH Compartement with Search Bar  -
		------------------------------------------>
		<div class="front">
			<h2> Qui cherchez-vous ? </h2>
			<input type="text" id="myInput" onkeyup="searchFunction()" class="search_input">
		</div>
				
		<!----------------------------------------
		-	TABLE With Data in pure html   -
		------------------------------------------>

		<div class="scrollable">
		<table class="table table-bordered my_tabel" id="myTable" >
			<thead>
			<tr>
				<th>#</th>
				<th>Nom</th>
				<th>Numéro Etudiant</th>
				<th>E-mail</th>
				<th>Groupe</th>
			
			</tr>
			</thead>
			<tbody>
			<tr>
				<th scope="row">1</th>
				<td>Ross Geller</td>
				<td>11924456</td>
				<td>blablabla@uspn.fr</td>
				<td>DEAU-A </td>
					
			</tr>
			<tr>
				<th scope="row">2</th>
				<td>Hannah Baker</td>
				<td>143462462HF</td>
				<td>blablabla@uspn.fr</td>
				<td>DEAU-B </td>
					  
			</tr>
			<tr>
				<th scope="row">3</th>
				<td>Jhon Doe </td>
				<td>030c8493</td>
				<td>blablabla@uspn.fr</td>
				<td>DEAU-A </td>
					  
			</tr>
			<tr>
				<th scope="row">4</th>
				<td>Jane Doe</td>
				<td>10987654</td>
				<td>blablabla@uspn.fr</td>
				<td>DEAU-B </td>
					 
			</tr>
			<tr>
				<th scope="row">5</th>
				<td>Paul Sean</td>
				<td>67923567</td>
				<td>blablabla@uspn.fr</td>
				<td>DEAU-A </td>
					  				
			</tr>
			<tr>
				<th scope="row">6</th>
				<td>Paul Doyle</td>
				<td>003011bb</td>
				<td>blablabla@uspn.fr</td>
				<td>DEAU-B </td>
					  					
			</tr>
			<tr>
				<th scope="row">7</th>
				<td>Barney Stinson</td>
				<td>123011bb</td>
				<td>blablabla@uspn.fr</td>
				<td>DEAU-A </td>				
					  
			</tr>

			<tr>
				<th scope="row">8</th>
				<td>Charles Dickens</td>
				<td>112345KL</td>
				<td>blablabla@uspn.fr</td>
				<td>DEAU-A </td>
											
				</tr>

				<tr>
				<th scope="row">9</th>
				<td>Corleone Micky</td>
				<td>10224567</td>
				<td>blablabla@uspn.fr</td>
				<td>DEAU-B </td>
											
				</tr>

				<tr>
				<th scope="row">10</th>
				<td>El Che</td>
				<td>132568IL</td>
				<td>blablabla@uspn.fr</td>
				<td>DEAU-B </td>
											
				</tr>

			</tbody>
		</table>

		</div>
	</div>	
	<!----------------------------------------
	-	TABLE With Data in pure html   -
	------------------------------------------>

</form>

<!----------------------------------------
-	JAVASCRIPT To Filter the TABLE above  -
------------------------------------------>

<script> 
function searchFunction() {
    let tabel, filter, input, tr, td, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    tabel = document.getElementById("myTable");
    tr = document.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
        if (tr[i].textContent.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
			//document.write(" person n'existe pas "); tried to show a message incase the entered student is not in the list but didn't work ;(
	
        }
    }
}
</script>

<br/><br/><br/>
<br/><br/><br/>
<br/><br/><br/>
<br/><br/><br/>
</div>
</div>
<?php require "../general/fin.php"; ?>