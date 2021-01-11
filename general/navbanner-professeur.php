<?php
if(isset($_POST['promo']) and preg_match("#^[1-9]\d*$#",$_POST['promo']) 
		and isset($_POST['idMatiere']) and preg_match("#^[1-9]\d*$#",$_POST['idMatiere'])){
	$idPromo=$_POST['promo'];
	$lesusers = $m->user_promo($idPromo);
	$idMatiere=$_POST['idMatiere'];
}
?>
<div class="nav_bar" id="navbar">
    <img src="../img/logo-4.png" id="logo">
    <button id="btn-menu" onclick="show_hide()"><img src="../img/menu.png" id="menu"></button>
    <h3><?php if(isset($h3)){echo $h3;} ?></h3>
    <ul>
        <li><a href="../professeur/profAccueil.php"><img src ="../img/home.ico"/>ACCUEIL</a></li>
        <li><a href="../general/recherche"><img src ="../img/search.png"/>RECHERCHER</a></li>
        <li><a href="../professeur/appel_absence"><img src ="../img/attendance.png"/>FAIRE L'APPEL</a></li>
        <li><a href="../professeur/saisienote"><img src ="../img/grades.png"/>SAISIR NOTE</a></li>
        <li><a href="../professeur/gestion_controle"><img src ="../img/report-card.png"/>EVALUATION</a></li>
        <li><a href="../professeur/profAccueil"><img src ="../img/diploma.png"/>PROMOTIONS</a></li>
        <li><a href="../professeur/profAccueil"><img src ="../img/graph.ico"/>MES GRAPHIQUES</a></li>
        <li><a href="../professeur/profAccueil"><img src ="../img/user.png"/>MES INFORMATIONS</a></li>
        <li><a href="../professeur/profAccueil"><img src ="../img/deconnexion.png"/>DECONNEXION</a></li>
    </ul>
</div>