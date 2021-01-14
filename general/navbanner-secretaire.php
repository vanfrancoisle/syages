<div class="nav_bar" id="navbar">
            <img src="../img/logo-4.png" id="logo">
            <button id="btn-menu" onclick="show_hide()"><img src="../img/menu.png" id="menu"></button>
            <h3><?php if(isset($h3)){echo $h3;} ?></h3>
            <ul>
                <li><a href="../professeur/profAccueil.php"><img src ="../img/home.ico"/>ACCUEIL</a></li>
                <li><a href="../general/recherche"><img src ="../img/search.png"/>RECHERCHER</a></li>
                <li><a href="../professeur/profAccueil"><img src ="../img/diploma.png"/>PROMOTIONS</a></li>
                <li><a href="../professeur/profAccueil"><img src ="../img/graph.ico"/>MES GRAPHIQUES</a></li>
                <li><a href="../professeur/profAccueil"><img src ="../img/user.png"/>MES INFORMATIONS</a></li>
                <li><a href="../professeur/profAccueil"><img src ="../img/deconnexion.png"/>DECONNEXION</a></li>
            </ul>
        </div>
<!--TODO modifier les '#' afin qu'il redirige vers les pages concernées-->
