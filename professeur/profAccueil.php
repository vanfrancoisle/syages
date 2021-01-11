<?php
$title='Acceuil';
require "../general/debut.php";
echo '<link rel="stylesheet" type="text/css" href="../css/professeur/accueil_prof.css">';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
echo "<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>";
echo '  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.2.2/circle-progress.min.js"></script>';
require '../general/debut-2.php';
$h3='Menu-Professeur';
require "../general/navbanner-professeur.php";
require '../general/BDDsyages.php';
$m = BDDsyages::getBddsyages(2);

?>

<div class="body" id="body">
<div class="melbanner">
    <button id="btn-menu1" onclick="show_hide()"><img src="../img/menu.png" id="menu"></button>
    <img src="../img/logo.png" id="logo"/>
    <input type="text" placeholder="Entrez des mots-clés" id="searchbar"><input type="submit" value="Rechercher" id="submitbutton">
    <img src="../img/david.jpg" id="user"/>
</div>
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
      
      <div class="card 1">
        <div class="circle">
          <div class="bar"></div>
          <div class="box"><span></span></div>
        </div>
        <div class="text">Taux de réussite en Maths</div>
      </div>


     <div class="card 2">
        <div class="circle">
          <div class="bar"></div>
          <div class="box"><span></span></div>
        </div>
        <div class="text">Taux de réussite en Physique</div>
      </div>


      <div class="card 3">
        <div class="circle">
          <div class="bar"></div>
          <div class="box"><span></span></div>
        </div>
        <div class="text">Moyenne générale</div>
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
	  
	  $(".1 .bar").circleProgress({
        value: <?php echo $maths; ?>,
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
			<tr><th>Date début</th><th>Date fin</th><th>DAEUOptions</th><th>Nom de la promotion</th><th>Matières</th></tr>
							<?php 
									$oldProm= $m->lespromoAnciennes();
									foreach ($oldProm as $new){
										echo '<tr><td>' . $new['DateDebut'] . '</td><td>' . $new['DateFin'] . '</td><td>' . $new['Option'] . '</td><td>' . $new['NomPromo'] . '</td><td>' . $new['matieres'] . '</td></tr>';
									}?>
			</table>
			</div>
		</div>
		<!------------------------------------------------------------------------------------>
<?php
require "../general/fin.php";
?>
