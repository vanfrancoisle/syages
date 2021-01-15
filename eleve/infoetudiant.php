<?php
$title='Mes informations - etudiant';
require '../general/debut.php';
echo '<link rel="stylesheet" type="text/css" href="../css/eleve/infoetudiant.css">';
require '../general/debut-2.php';
$h3='Menu élève';
require '../general/navbanner-eleve.php';
?>

<?php
require '../general/BDDSyages-etud.php';
$m= Bddsyages::getBddsyages(2);
$idEtudiant=11111112; // MOT DE PASSE NON CRYPTE : wejdene11
$etudiant = $m->info_etud($idEtudiant);
$ancienmdp = $m->recup_ancien_mdp($idEtudiant);
$mdptest = $ancienmdp["MotDePasse"];
?>

<div class="body" id="body">
            <div class="melbanner">
                <button id="btn-menu1" onclick="show_hide()"><img src="/img/menu.png" id="menu"></button>
                <img src="/img/logo.png" id="logo"/>
                <input type="text" placeholder="Entrez des mots-clés" id="searchbar"><input type="submit" value="Rechercher" id="submitbutton">
                <img src="/img/david.jpg" id="user"/>
            </div>
            <!-- <input name="submit" type="submit" class="submit" value="Creer une évaluation" /> -->
            <!-- <input name="submit" type="submit" id="submit" class="submit" value="Faire l'appel" /> -->
            <br/><br/><br/>
            <br/><br/><br/>


            <div class="container">

              <h1>Mes informations</h1>
              <div class="firstgrid">
                <div class="photoprofil"><img src="/img/david.jpg" id="pp" alt="Ma photo de profil"></div>

                <div class="nompromo">
                  <h2><?php echo $etudiant["Nom"]." ".$etudiant["Prénom"]; ?></h2>
                  <p> Login : <?php echo $etudiant["Login"]; ?> </p>
                  <p>Adresse mail : <?php echo $etudiant["Mail"];?></p>
                  <h4>DEAU <?php echo $etudiant["Option"]. " (". $etudiant["NomPromo"] . ")";?></h4>
                  <p>Redoublant : <?php echo $etudiant["Inforedoublement"]; ?></p>
                </div>
                <div class="uploadpp">
                  <h2>Changer Photo de profil</h2>
                  <form class="" action="infoetudiant.html" method="post">
                    <label for="avatar">Choisir avatar :</label>
                    <input type="file" id="avatar" name="avatar" accept="image/png, image/jpeg">
                    <button id="savepp" type="submit" class="btn btn-dark">Submit</button>
                  </form>
                </div>
              </div>
              <div class="secondgrid">

                <div class="formpswd">
                  <div class="formcenter">


                  <?php
				  // var_dump($_POST["ancienmdp"]);
				  // var_dump($_POST["repnvxmdp"]);
				  // var_dump($_POST["nvxmdp"]);
				  if(isset($_POST["ancienmdp"]) and  isset($_POST["nvxmdp"]) and isset($_POST["repnvxmdp"])){
					  $amdp = $_POST["ancienmdp"];
					  $nmdp = $_POST["nvxmdp"];
					  $repmdp = $_POST["repnvxmdp"];

					  if($nmdp===$repmdp){
						  echo 'Mot de passe changé !';
						  if (password_verify($amdp, $mdptest)) {
                $changmdp = $m->changer_mdp_eleve($idEtudiant, $nmdp, $repmdp);
              }
              else {
                echo "Mot de passe incorrect !";
              }
					  }
            else{
						  echo 'Les mots de passes ne correspondent pas !';
					  }

				}
				echo '<form class="changmdp" action="infoetudiant.php" method="post">
				<h2 class="mdp"> Changer mon mot de passe </h2>
				<div class="form-group">
				  <label for="">Mon ancien mot de passe</label></br>
				  <input style="background-color:black" placeholder="Ancien mot de passe" type="password" name="ancienmdp" value="">
				</div>
				<div class="form-group">
				  <label for="">Nouveau mot de passe</label></br>
				  <input style="background-color:black" placeholder="Nouveau mot de passe" type="password" name="nvxmdp" value="">
				</div>
				<div class="form-group">
				  <label for="">Repeter nouveau mot de passe</label></br>
				  <input style="background-color:black" placeholder="Repeter mot de passe" type="text" name="repnvxmdp" value="">
				</div>
				<button id="savemdp" type="submit" class="btn btn-dark">Changer</button>
			   </form>';
                  ?>

                </div>
              </div>

              <div class="notesperso">
                <h2>Mes notes personnelles</h2>
                <form class="" action="infoetudiant.html" method="post">
                  <textarea id="noteperso" style="background-color:black" placeholder="Mes perso notes ici . . ." name="name" rows="8" cols="80"></textarea>
                  <button id="savenotes" type="submit" class="btn btn-dark">Modifier</button>
                </form>
              </div>



        </div>
        </div>

        <?php  require '../general/fin.php' ; ?>
