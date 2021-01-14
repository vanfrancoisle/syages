<?php
$title='Absence General';
require '../debut.php';
echo '<link rel="stylesheet" type="text/css" href="/css/secretaire/style_absence">';  /*mettre le css qui vous est particulier pas le css general qui est deja défini dans le début.php*/
require '../debut-2.php';
$h3='Menu secrétaire';

require "../navbanner-secretaire.php";  

require_once "../Bddsyages.php";

$m = Bddsyages::getBddsyages(2);

?>



        <div class="body" id="body">
            <div class="melbanner">
        <button id="btn-menu1" onclick="show_hide()"><img src="/img/menu.png" id="menu"></button>
                <img src="/img/logo.png" id="logo"/>
                <input type="text" placeholder="Entrez des mots-clés" id="searchbar"><input type="submit" value="Rechercher" id="submitbutton">
                <img src="/img/david.jpg" id="user"/>
            </div>

<center class="titre"> <h1>
ABSENCES PROMOTION DAEU 2020/2021</h1>
</br>
<h2> Groupe : n°1 
</br>Trimestre 1</h2> </center> <br/>
       
       <div class="tababs">
           <div class="tab">
            
            <center>            
             
            <table>
			<tr><th>Nom Etudiant</th><th>Prenom Etudiant</th><th>Nombres absences deélèves</th><th>Nombres Absences Justifiées</th><th>Nombres Absences Non justifiée</th> <th> Détails</th></tr>

            <?php
			$tab = $m->les_absences();

			$les_personnes_abs = $m->les_absences_par_personnes();
			$les_personnes_absJustif = $m->les_nbAbs_justif_par_personnes();
			$les_absJNJ = $m->les_abs_par_perso_JNJ();
			//echo 'nbAbsJ = '.count($les_personnes_absJustif).' et nbAbsG = '.count($les_personnes_abs; // parfait sont == on peut faire la jointure !! ok!!!!!
			//var_dump($les_personnes_abs);
			//var_dump($les_personnes_abs);
			//var_dump($les_absJNJ);

			//echo 'les nombre d\'abs dans la bdd au total est : '.count($tab);
			//echo 'les personnes \'abs sont au nombre de : '.count($les_personnes_abs );
			//TEST

			foreach($les_personnes_absJustif as $cle => $abs){
				$nomPremonIdUser = $m->nom_prenom_user(intval($abs["idUser"]));
				//var_dump($abs);
				echo '<tr class ="bg"><td><B>'.$nomPremonIdUser["Nom"].'</B></td><td><B>'.$nomPremonIdUser["Prénom"].'</B></td><td> <B>'.intval($abs["nbAbsJustif"]).'</td><td><B>'.intval($abs["nbAbsJustif"]).'</B></td><td><B>1</td></B> <td> <button> <a href="absence2.html"> Cliquez ici !</a></button> </td></td> </tr>';
			}
			
			?>
			
  
            </table>
            
            </center>
              </div>
              </div>

<?php  require '../fin.php' ; ?>
