<?php
$title='Detail de l\'absence';
require "../general/debut.php";
echo '<link rel="stylesheet" type="text/css" href="/css/secretaire/style_absence2.css/">';  /*mettre le css qui vous est particulier pas le css general qui est deja défini dans le début.php*/
require "../general/debut-2.php";
$h3='Menu secretaire';
require "../general/navbanner-secretaire.php"; 

require_once "../general/Bddsyages.php";

$m = Bddsyages::getBddsyages(2);
?> 
        <div class="body" id="body">
            <div class="melbanner">
        <button id="btn-menu1" onclick="show_hide()"><img src="/img/menu.png" id="menu"></button>
                <img src="/img/logo.png" id="logo"/>
                <input type="text" placeholder="Entrez des mots-clés" id="searchbar"><input type="submit" value="Rechercher" id="submitbutton">
                <img src="/img/david.jpg" id="user"/>
            </div>


<center><h1>Detail de l'absence </h1><br/></center>
<?php
$eleve = 11111116;
$nomPremonIdUser = $m->nom_prenom_user($eleve);



// je fais ici avec lesabsdeId !!
$nbabsj=0;
$lesabsdeId=$m->absence_eleve($eleve);
foreach($lesabsdeId as $abs){
	if($abs['Justif']=="1") $nbabsj++;
}
//var_dump($nomPromeIdUser);// pas correct !!
echo '<p> Prénom : '.$nomPremonIdUser["Prénom"]; 
echo '<p> Nom : '.$nomPremonIdUser["Nom"];
echo '<p> Promo : '.$nomPromeIdUser;
echo '<p> Nombre d\'absence total : '.count($lesabsdeId);
echo '<p> Nombre d\'absence Justifiée : '.$nbabsj;
?>
       <div class="tababs">
           <div class="tab">
                        
            <table>
			<tr class ="bg"><th class ="bg">Date Debut</th><th class ="bg">Heure</th><th class ="bg">Cours Manque</th><th class ="bg">Etat</th> <th class ="bg"> Motif de l'absence</th></tr>

             <?php
			 // je fais un test avec le user 11111116 !! ok !
			 // parcontre cours manqué on l'a pas dans la bdd
			 // sur ta page on sait pas c'est qui donc ont mets nom et prénom 
			foreach($lesabsdeId as $abs){
				$dateHeure=explode(' ',$abs['Datetheure']);
				$date= $dateHeure[0];
				$heure=explode(":",$dateHeure[1])[0];
				$justif=$abs['Justif']== 1 ? "Justifiée" : " non Justifiée";
				//var_dump($justif);
				echo '<tr class ="bg"><td><B>'.$date.'</B></td><td><B>'.$heure.'h</B></td><<td> <B>Gestion</td><td><B>'.$justif.'</td></B> <td> '.$abs['Data'].'</td></td> </tr>';
			}
			?>
                </table>


                  </div>
                  </div>

<?php  require '../general/fin.php' ; ?>