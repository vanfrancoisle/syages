<?php
/*
@author : inthragith, aymane
*/
require 'Utils/functions.php';
class Syages{

  private static $instance =null;
  private $bd;

  private function __construct($entier){
    if(!((bool)entier)){
      $this->bd = new PDO('mysql:host=192.168.64.2;dbname=SYAGES', 'juste',     'pourlaconnecxtion');
    }

     else if($entier==1){
          $this->bd = new PDO('mysql:host=192.168.64.2;dbname=SYAGES', 'eleve',     'eleve');
      }

    else if($entier==2){
        $this->bd = new PDO('mysql:host=192.168.64.2;dbname=SYAGES', 'professeur', 'professeur');
    }

    else if($entier==3){
        $this->bd = new PDO('mysql:host=192.168.64.2;dbname=SYAGES', 'secretaire', 'secretaire');
    }

    else if($entier==4){
        $this->bd = new PDO('mysql:host=192.168.64.2;dbname=SYAGES', 'administrateur', 'administrateur');
  }

    $this->bd->query("SET NAMES 'utf8'");

    $this->bd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  }


  public function getInfosUser($login){
      $req = $this->bd->prepare('SELECT * from users where idUser= :login');
      $req->bindValue(':login', $login);
      $req->execute();
      return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getUsersActive(){
      $req = $this->bd->prepare('SELECT * from users where Drapeau=1');
      $req->execute();
      return $req->fetchAll(PDO::FETCH_ASSOC);
  }



  public function getEtablissementUser($idEtablissement){
    $req = $this->bd->prepare('SELECT * from etablissement where idEtablissement= :idEtablissement');
    $req->bindValue(':idEtablissement', $idEtablissement);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  public function getNotes($idUser){
    $req = $this->bd->prepare('SELECT * from eval where idUser= :idUser');
    $req->bindValue(':idUser', $idUser);
    $req->execute();

    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  public function nomMatiere($idMatiere){
      $req = $this->bd->prepare('SELECT Nom from matiere where idMatiere= :idMatiere');
      $req->bindValue(':idMatiere', $idMatiere);
      $req->execute();

      return $req->fetchAll(PDO::FETCH_ASSOC);
  }

  public function nbEleves($idPromo){
      $req = $this->bd->prepare('SELECT count(*) from users where promo=:idPromo');
      $req->bindValue(':idPromo', $idPromo);
      $req->execute();

      return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  public function getProfNomPrenom($idMatiere){
    $req = $this->bd->prepare('SELECT idUser from matiere where idMatiere= :idMatiere');
    $req->bindValue(':idMatiere', $idMatiere);
    $req->execute();
    $tab = $req->fetchAll(PDO::FETCH_ASSOC);
    $req = $this->bd->prepare('SELECT Nom,Prénom from users where idUser=:idUser');
    $req->bindValue(':idUser', ''.$tab[0]["idUser"]);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  public function promoEleve($idEleve){
    $req = $this->bd->prepare('select promo from moyenne where idUser=:idUser');
    $req->bindValue(':idUser', ''.$idEleve);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  public function getIdMatieres($idPromo){
    $req = $this->bd->prepare('select matieres_obligatoires,matieres_facultatives from promotion where idPromotion=:idPromo');
    $req->bindValue(':idPromo', $idPromo);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  public function moyenneMatiere($idUser,$tabIdMatiere){
    $req = $this->bd->prepare('select AVG(Note) from moyenne where idUser=:idUser and idMatiere in (:matieres)');
    $req->bindValue(':idUser', ''.$idUser);
    $tab = $tabIdMatiere;
    $req->bindValue(':matieres', $tab);
    $req->execute();
    return $req->fetchAll(PDO::FETCH_ASSOC);
  }


  public function absence_eleve($eleve){
         $req= $this->bd->prepare( 'SELECT idAbs, Datetheure, Data, Justif from absenceretard where idUser= :id order by Datetheure desc;');
         $req->bindValue(':id', $eleve);
         $req->execute();
         return $req-> fetchAll(PDO:: FETCH_ASSOC);
     }


     public function absence_admin(){
         $req= $this->bd->prepare( 'SELECT *,u.Nom, u.Prénom, a.Datetheure, a.Justif, a.Data, a.Historique from  users u, absenceretard a where u.idUser = a.idUser order by Datetheure desc;');
         $req->execute();
         return $req-> fetchAll(PDO:: FETCH_ASSOC);

     }

     public function controles_admin(){
         $req= $this->bd->prepare( 'SELECT * from eval order by Date desc ;');
         $req->execute();
         return $req-> fetchAll(PDO:: FETCH_ASSOC);

     }

     public function getPromoActivesOuPas($bool){
         $req= $this->bd->prepare( 'SELECT idPromotion from promotion where Drapeau=:bool');
         $req->bindValue(':bool', $bool);
         $req->execute();
         return $req-> fetchAll(PDO:: FETCH_ASSOC);
     }

     public function statsAbsencesPromo($promo){
         $req= $this->bd->prepare( 'SELECT count(*),Justif from absenceretard where absenceretard.idUser in (SELECT users.idUser from users where users.promo=:idPromo)');
         $req->bindValue(':idPromo',$promo);
         $req->execute();
         return $req-> fetchAll(PDO:: FETCH_ASSOC);
     }
     public function infosPromo($idPromo){
         $req = $this->bd->prepare( 'SELECT * from promotion where idPromotion=:idPromo');
         $req->bindValue(':idPromo',$idPromo);
         $req->execute();
         return $req-> fetchAll(PDO:: FETCH_ASSOC);
     }

     /*Methode débile on aurait pu faire un liste avec un foreach qui bind les value de cettte liste avec $POST[key]*/
     public function addUser($prenom,$nom,$idUser,$password,$role,$promo,$photo,$telephone,$login,$nomepouse,$mail,$idEtablissement,$inscriptionPeda,$infoPrivee,$infoRedoublement,$perqonnalisation,$data,$historique,$drapeau){
         $req = $this->bd->prepare('INSERT INTO users (idUser, Login, MotDePasse, Nom, NomEpouse, Prénom, Photo, Téléphone, Mail,
           idEtablissement, Role, promo, InscriptionMatiere, InscriptionPeda, InfoPrivee, InfoRedoublement, Perqonnalisation,
           Data, Historique, Drapeau) VALUES (:idUser, :login, :password, :nom, :nomEpouse, :prenom, :photo, :telephone, :mail, :idEtablissement,
             :role, :promo, \'ok\' , :inscriptionPeda, :infoPrivee, :infoRedoublement, :perqonnalisation, :data, :historique,:drapeau)');

         $req->bindValue(':idUser',$idUser);
         $req->bindValue(':login',$login);
         $req->bindValue(':password',$password);
         $req->bindValue(':nom',$nom);
         $req->bindValue(':nomEpouse',$nomepouse);
         $req->bindValue(':prenom',$prenom);
         $req->bindValue(':photo',$photo);
         $req->bindValue(':telephone',$telephone);
         $req->bindValue(':mail',$mail);
         $req->bindValue(':idEtablissement',$idEtablissement);
         $req->bindValue(':role',$role);
         $req->bindValue(':promo',$promo);
         $req->bindValue(':inscriptionPeda',$inscriptionPeda);
         $req->bindValue(':infoPrivee',$infoPrivee);
         $req->bindValue(':infoRedoublement',$infoRedoublement);
         $req->bindValue(':perqonnalisation',$perqonnalisation);
         $req->bindValue(':data',$data);
         $req->bindValue(':historique',$historique);
         $req->bindValue(':drapeau',$drapeau);

         $req->execute();
         return $req->rowCount();
     }

     public function updateUser($user,$post){

    if($post["motdepasse"]==""){
        $query = "UPDATE users SET Login = :login, Nom = :nom, NomEpouse = :nomepouse, Prénom = :prenom, Photo = :photo, Téléphone = :telephone, Mail = :mail, idEtablissement = :idetablissement, Role = :role, promo = :promo, InscriptionMatiere = :inscriptionmatiere, InscriptionPeda = :inscriptionpeda, InfoPrivee = :infoprivee, InfoRedoublement = :inforedoublement, Perqonnalisation = :perqonnalisation, Data = :data, Historique = :historique WHERE idUser = :iduser";
        unset($post["motdepasse"]);


    } else {
        $post["motdepasse"]=e(password_hash($post["motdepasse"],PASSWORD_DEFAULT));
        /*htmlspecialchars et password hash se sentiraient mieux ailleurs*/
        $query = 'UPDATE users SET Login = :login, MotDePasse = :motdepasse, Nom = :nom, NomEpouse = :nomepouse, Prénom = :prenom, Photo = :photo, Téléphone = :telephone, Mail = :mail, idEtablissement = :idetablissement, Role = :role, promo = :promo, InscriptionMatiere = :inscriptionmatiere, InscriptionPeda = :inscriptionpeda, InfoPrivee = :infoprivee, InfoRedoublement = :inforedoublement, Perqonnalisation = :perqonnalisation, Data = :data, Historique = :historique WHERE idUser = :iduser';

     }
    $req = $this->bd->prepare($query);
    $copiepost=[];
    $copiepost[":iduser"]=$user;
    foreach ($post as $key => $value) {
      $copiepost[':'.$key]=e($value);
    }
    $req->execute($copiepost);
    return $req->rowCount();
}


public function deleteUser($idUser){
  $query = "UPDATE users SET Historique = :historique, Drapeau = 0 WHERE idUser = :iduser";

  $req = $this->bd->prepare($query);
  $req->bindValue(':iduser',$idUser);
  $req->bindValue(':historique','DELETED BY ADMIN');

  $req->execute();

  return $req->rowCount();
}

public function getEtablissements(){
  $req = $this->bd->prepare('SELECT * from etablissement');
  $req->execute();
  return $req->fetchAll(PDO::FETCH_ASSOC);
}

  /**
    * Méthode permettant de récupérer l'instance de la classe Model
  */
  public static function getModel($int) {
      //Si la classe n'a pas encore été instanciée
  if (self::$instance === null) {
  self::$instance = new self($int); //On l'instancie
  }
  return self::$instance; //On retourne l'instance

}
}
?>
