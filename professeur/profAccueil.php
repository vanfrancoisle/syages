<?php
$title='Acceuil';
require "../general/debut.php";
echo '<link rel="stylesheet" type="text/css" href="../css/professeur/accueil_prof.css">';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
echo "<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>";
require '../general/debut-2.php';
$h3='Menu-Professeur';
require "../general/navbanner-professeur.php";
require '../general/BDDsyages.php';
$m = BDDsyages::getBddsyages(2);

?>
<?php 
  	$mat= $m-> pourcentage_UneMatiere("Mathématiques");
  	$ph= $m-> pourcentage_UneMatiere("Physique");
  	$to= $m-> pourcentage();
	

  	$i=0;
  	foreach ($mat as $c => $v) {
  		if( $v[0]>=10)
 			$i++;
  	}
  	if(count($mat)==0)
  		$maths=0;
  	else
  		$maths= $i/count($mat);
  
  	$j=0;
  	foreach ($ph as $c => $v) {
  		if( $v[0]>=10)
 			$j++;
  	}
  	if (count($ph)==0)
  		$phy= 0;
  	else
  		$phy= $j/count($ph);

  	$k=0;
  	foreach ($to as $c => $v) {
  		if($v[0]>=10)
 			$k++;
  	}
  	if (count($to)==0)
  		$total= 0;
  	else
  		$total= $k/count($to);
  	


    ?>
<!-------------------------------------------CODE PAGE ACCUEIL PROF----------------------------------------------------------------->
 <!---------------------------Circle----------------------------------->
  <div>  
    <h2 class="heading"> PROMO ACTIVE </h2>
    <div class="wrapper2">
      
      <div class="card">
        <div class="circle">
          <div class="bar"></div>
          <div class="box"><span></span></div>
        </div>
        <div class="text">MATHS</div>
      </div>


     <div class="card 2">
        <div class="circle">
          <div class="bar"></div>
          <div class="box"><span></span></div>
        </div>
        <div class="text">PHYSIQUE</div>
      </div>


      <div class="card 3">
        <div class="circle">
          <div class="bar"></div>
          <div class="box"><span></span></div>
        </div>
        <div class="text">MOYENNE GENERALE</div>
      </div>


    </div>
  </div>
    <script>
      let options = {
        startAngle: -1.55,
        size: 150,
        value: <?php echo $maths; ?>,

        fill: {gradient: [ '#673dda', '#42b0fa']}
      }
      $(".circle .bar").circleProgress(options).on('circle-animation-progress',
      function(event, progress, stepValue){
        $(this).parent().find("span").text(String(stepValue.toFixed(2).substr(2)) + "%");
      });
      $(".2 .bar").circleProgress({
        value: <?php echo $phy; ?>,
      });
      $(".3 .bar").circleProgress({
        value: <?php echo $total; ?>,
      });

</script>

   <!-----------------MES INFOS------------------->
	<div>
		<h2>MES INFOS</h2>
		<table class="styled-table">
		<thead>
			<tr class="active_row">
				<th>Matière(s) enseignée(s)</th><th>E-mail</th><th>Num Portable</th>
			</tr>
		</thead>
		<tbody>
			<tr class="row">
				<?php 
					$idProf = 11111116;
					$info = $m->recuperer_infoProf($idProf);
					foreach ($info as $if){
						echo '<td>' . $if['InscriptionMatiere'] . '</td><td>' . $if['Mail'] . '</td><td>' . $if['Téléphone'] . '</td>';
					}?>
			</tr>
		</tbody>
	</table>
		<h2>PROMOTION ACTIVE</h2>
	</div>

		<!-------------------------------TAB PROMO ACTIVE------------------------------------>
		<div class="tabpromo">
			<table>
			<tr><th>Date début</th><th>Date fin</th><th>DAEU options</th><th>Nom de la promotion</th><th>Matières</th></tr>
				<?php 
					$newProm= $m->recuperer_infoPromoNew();
					foreach ($newProm as $new){
						echo '<tr><td>' . $new['DateDebut'] . '</td><td>' . $new['DateFin'] . '</td><td>' . $new['Option'] . '</td><td>' . $new['NomPromo'] . '</td><td>' . $new['matieres'] . '</td></tr>';
					}?>
			</table>
		</div>
		<!------------------------------------------------------------------------------------>
	   
		<!--------------------------------TAP ANCIENNE PROMO---------------------------------->
		<h2>ANCIENNE PROMO </h2>
		<div class="tabpromo">
			<div class="scroll">
			<table class="tabB">
			<tr><th>Date début</th><th>Date fin</th><th>Nom de la promotion</th><th>Inscrits</th><th>Moyenne générale</th></tr>
							<?php 
                                    $tabPromo= $m->lespromoAnciennes();
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
											echo '<tr><td>'.$value["datedebut"].'</td><td>'.$value["dateFin"].'</td><td><a href="#">'.$value["nomPromo"].'</a></td><td>'.$bd->get_nbInscrit($value["idPromotion"])[0].'</td></td><td>'.$bd->get_moyennePromo($value["idPromotion"])[0].'</td></tr>';
                                        }
                                    } else {
                                    echo '<tr class="titre_annee"><td colspan="7">Aucune promotion ancienne</td></tr>';
                                    }
                            ?>
			</table>
			</div>
		</div>
		<!------------------------------------------------------------------------------------>
<?php
require "../general/fin.html";
?>
