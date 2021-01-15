<?php
class Bddsyages{

    // Attribut qui contient l'objet PDO
    private $bd;

    // Attribut de classe contenant l'unique instance de la classe model
    public static $instance = NULL;

    public static function getBddsyages($entier){
        // Si aucun objet Model a été créé

        if(Bddsyages::$instance == NULL){
            // On le crée et on le stocke dans $instance
            Bddsyages::$instance = new Bddsyages($entier);
        }

        return Bddsyages::$instance;
    }

     // Se connecter à la base de données
	private function __construct($entier){

		if($entier==1){
			$this->bd = new PDO('mysql:host=localhost;dbname=syages', 'root', 'root');
		}

		else if($entier==2){
		  $this->bd = new PDO('mysql:host=localhost;dbname=syages', 'root', 'root');
		}

		else if($entier==3){
			$this->bd = new PDO('mysql:host=localhost;dbname=SYAGES', 'secretaire', 'secretaire');
		}

		else if($entier==4){
			$this->bd = new PDO('mysql:host=localhost;dbname=SYAGES', 'admin', 'admin');
		}

		$this->bd->query("SET NAMES 'utf8'");

		$this->bd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}


 // Page Notes Etudiant :

    public function notes_eleve($eleve){
        $req= $this->bd->prepare( 'SELECT matiere.Nom, Note from eval,matiere where matiere.idMatiere = eval.idMatiere AND eval.idUser= :id');
        $req->bindValue(':id', $eleve);
        $req->execute();
        return $req-> fetchall(PDO:: FETCH_ASSOC);
    }

    // Page Info de l'etudiant :

    public function info_etud($eleve){
        $req= $this->bd->prepare( 'SELECT promotion.Option, promotion.NomPromo, Mail, Photo, Nom, Prénom, Inforedoublement, Login from users, promotion where idPromotion = promo AND idUser= :id');
        $req->bindValue(':id', $eleve);
        $req->execute();
        return $req-> fetch(PDO:: FETCH_ASSOC);
    }

    public function changer_pdp($eleve, $photo){
      $sql = "UPDATE users SET Photo= :photo WHERE idUser= :id'";
      $req= $this->bd->prepare($sql);
      $req->bindValue(':id', $eleve);
      $req->bindValue(':photo', $photo);
      $req->execute();

      }

	public function changer_mdp_eleve($eleve, $mdp, $repmdp){

    if ($mdp == $repmdp) {
      $pswd = password_hash($mdp, PASSWORD_DEFAULT);
      $sql = "UPDATE users SET MotDePasse = :pswd WHERE idUser= :id";
      //$sql = "";
      $req= $this->bd->prepare($sql);
      $req->bindValue(':id', $eleve);
      $req->bindValue(':pswd', $pswd);
      $req->execute();
    }

    }

    public function recup_ancien_mdp($eleve){
        $req= $this->bd->prepare("SELECT MotDePasse FROM users WHERE idUser= :id");
        $req->bindValue(':id', $eleve);
        $req->execute();
        return $req-> fetch();
      }

    public function recuperer_tout_controle_etud($id){
            $req= $this->bd->prepare( 'SELECT *, matiere.Nom from eval,matiere where matiere.idMatiere = eval.idMatiere AND eval.idUser= :id AND Note>=0;');
            $req->bindValue(':id', $id);
            $req->execute();
            return $req-> fetchALL(PDO:: FETCH_ASSOC);
      }

      public function recup_controle_matiere($id, $matiere){
              $req= $this->bd->prepare( 'SELECT *, matiere.Nom, eval.Mode, eval.Coef from eval,matiere where matiere.idMatiere = eval.idMatiere AND eval.idMatiere = :matiere AND eval.idUser= :id;');
              $req->bindValue(':id', $id);
              $req->bindValue(':matiere', $matiere);
              $req->execute();
              return $req-> fetchALL(PDO:: FETCH_ASSOC);
      }
	  public function recuperer_matieres_etud($idp){
        $req= $this->bd->prepare( "SELECT inscriptionMatiere from users where idUser= :idp;");
		$req->bindValue(':idp', $idp);
        $req->execute();
		$lesM = explode('-',$req-> fetch(PDO:: FETCH_ASSOC)['inscriptionMatiere']);
        return $lesM;
    }
	public function matiere_de($id){
        $req= $this->bd->prepare( 'SELECT nom from matiere where idMatiere= :id;');
		$req->bindValue(':id', $id);
        $req->execute();
        return $req-> fetch(PDO:: FETCH_ASSOC)["nom"];
    }

}

?>
