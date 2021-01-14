<?php
$title='Absence General';
require '../general/debut.php';
echo '<link rel="stylesheet" type="text/css" href="/css/secretaire/style_absence">';  /*mettre le css qui vous est particulier pas le css general qui est deja défini dans le début.php*/
require '../general/debut-2.php';
$h3='Menu secrétaire';

require "../general/navbanner-secretaire.php"; 
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
// CONNECXION A LA BDD
try{
   $bdd = new PDO('mysql:host=localhost; dbname=bddsyages;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(Exception $e){
            die("Message". $e.getMessage());
        }

// NOM ET PRENOM 
    
$req1 = $bdd->query('SELECT Nom, Prénom, idUser FROM users');

       while ($donnees = $req1->fetch()){
        echo '<tr class ="bg"><td><B>'. $donnees['Nom']. '</B></td>  <td><B>' . $donnees['Prénom'] . '</B></td><td>';
        
        
// ABSENCE TOTAL 

        $req2=$bdd->prepare('SELECT COUNT(*) FROM absenceretard WHERE idUser LIKE :idutilisateur ');

        $req2->execute(array('idutilisateur'=>strval($donnees['idUser'])));
       
       while ($donnees2 = $req2->fetch()){
        echo  $donnees2['COUNT(*)'] ;
        
        $abs_Total = $donnees2['COUNT(*)'];
       }


// ABSENCE JUSTIFIER 

$req3=$bdd->prepare('SELECT COUNT(*) FROM absenceretard WHERE idUser LIKE :idutilisateur AND Justif=1 ');
      
        $req3->execute(array('idutilisateur'=>strval($donnees['idUser'])));
       
       while ($donnees3 = $req3->fetch()){
        echo  '<td><B>'. $donnees3['COUNT(*)'];
        
        $abs_Jutify = $donnees3['COUNT(*)'];
       }
       $abs_No_justify = $abs_Total - $abs_Jutify;
       echo  '<td><B>' .$abs_No_justify . '<td>  <a href="/syages/secretaire/absence2.html"> <B> Cliquez ici</B> </a></button>'  ;


        echo '<br/>';
        echo '<br/>';
            
            }
            ?>




        </table>
            
            </center>
              </div>
              </div>

    


    <?php require '../general/fin.php' ; ?>
    