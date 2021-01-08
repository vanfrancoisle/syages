<?php
$title='Absence eleve';
require "../general/debut.php";
echo '<link rel="stylesheet" type="text/css" href="../css/eleve/abs_eleve.css">';
require '../general/debut-2.php';
$h3='Eleve';
require '../general/navbanner-eleve.php';
?>

 <div class="body" id="body">
            <div class="melbanner">
				    <button id="btn-menu1" onclick="show_hide()"><img src="../img/menu.png" id="menu"></button>
                <img src="../img/logo.png" id="logo"/>
                <img src="../img/david.jpg" id="user"/>
 </div>
 <div class="container">
        <h1>Mes Absences</h1>
          <div class="contgen">
            <div class="titre"><h2>Absences constatées</h2></div>
            
        </div>

			<br/>
<?php
require "../general/BDDsyages.php";
$m= BDDsyages::getBddsyages(2);
$tab= $m->absence_eleve(11111116);
//var_dump($tab);
?>
		<div class="tababs">

		  <table id="tab_abs">
				<tr><th>N° Absence </th><th>Date </th><th>Heure(s)</th><th >Etat</th><th>Motif</th></tr>
<?php
         $i=1;
         foreach ($tab as $v) {
            $d=explode(" ",$v["Datetheure"]);
            $h=explode(":",$d[1]);
            if ($v["Justif"]==1) {
                  echo "<tr><td>" .$i."</td><td>".$d[0]."</td><td>".$h[0].":".$h[1]."</td><td>"."absence justifiée"."</td><td>".$v["Data"]."</td></tr>";
            }
            else{
                echo "<tr><td>" .$i."</td><td>".$d[0]."</td><td>".$h[0].":".$h[1]."</td><td>"."absence injustifiée"."</td><td>".$v["Data"]."</td></tr>";
            }
            $i++;
        }
?>
    	   </table>

			</div>
		</div>
 <?php
require "../general/fin.php"; ?>
