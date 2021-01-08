<?php 
class Bddsyages{

    // Attribut qui contient l'objet PDO --
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
			$this->bd = new PDO('mysql:host=localhost;dbname=SYAGES', 'eleve',     'eleve');
		}
 
		else if($entier==2){
		  $this->bd = new PDO('mysql:host=localhost;dbname=bddsyages', 'root', 'root');
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
	
    public function absence_eleve($eleve){
        $req= $this->bd->prepare( 'SELECT idAbs, Datetheure, Data from absenceretard where idUser= :id');
        $req->bindValue(':id', $eleve);
        $req->execute();
        return $req-> fetch(PDO:: FETCH_ASSOC);
    }
	
	public function etudiant_deau($idpromo){
        $req= $this->bd->prepare( 'SELECT iduser, nom, prénom, promo from users where promo= :idpromo');
        $req->bindValue(':idpromo', $idpromo);
        $req->execute();
        return $req-> fetchALL(PDO:: FETCH_ASSOC);
    }
	
	public function creer_eval_deau($idpromo, $idProf, $coef, $numEval){
		
    }
    public function fonction_test($idpromo){
		
    }
}

?>