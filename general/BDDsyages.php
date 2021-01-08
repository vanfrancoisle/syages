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
			$this->bd = new PDO('mysql:host=localhost;dbname=SYAGES', 'eleve',     'eleve');
		}
 
		else if($entier==2){
		  $this->bd = new PDO('mysql:host=localhost;dbname=bddsyages', 'root', '');
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
	
	public function update($id){
    	$req = $this->bd->prepare("UPDATE `users` SET `Drapeau` = '1' WHERE `users`.`idUser` = :id ;");
    	$req->bindValue(":id",$id);
    	$req->execute();
    }

    public function majNote2($data){
    	$req = $this->bd->prepare('UPDATE eval SET 
        Note = :note,
        modifie = 1,
        historique= :historique
        WHERE idUser= :idEtu and idpromo= :idpromo and idMatiere= :idmatiere and NumEval= :numEval and Drapeau = 0;');
        foreach($data as $cle => $val){
            $req->bindValue($cle,$val);
        }
    	$req->execute();
    }
    
	public function updateMatiere($id){
    	$req = $this->bd->prepare("UPDATE `users` SET `InscriptionMatiere` = '1-2-3-4' WHERE `users`.`idUser` = :id;");
    	$req->bindValue(":id",$id);
    	$req->execute();
    }
   
    //// PAGE AYMANE
    public function absence_eleve($eleve){
          $req= $this->bd->prepare( 'SELECT iduser, idAbs, Datetheure, Data, Justif from absenceretard where idUser= :id and Drapeau = 0');
          $req->bindValue(':id', $eleve);
          $req->execute();
          return $req-> fetchAll(PDO:: FETCH_ASSOC);
      }

      public function absence_admin(){
        $req= $this->bd->prepare('SELECT u.Nom, u.Prénom, a.Datetheure, a.Justif, a.Data, a.Historique from  users u, absenceretard a where u.idUser = a.idUser and Drapeau = 0');
        $req->execute();
        return $req-> fetchAll(PDO:: FETCH_ASSOC);

    }

    public function get_absJustifTotal(){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM absenceretard  where absenceretard.Justif = 1 and Drapeau = 0 ");
       
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];    
    }

    public function get_absInjustifTotal(){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM absenceretard where absenceretard.Justif = 0 and Drapeau = 0 ");
       
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }

    //Page prof accueil

  
    public function pourcentage_UneMatiere($nomMatiere){ //pourcentage de reussite par matiere
        $req= $this->bd->prepare('SELECT mo.Note, mo.idMatiere, m.Nom FROM moyenne mo, matiere m where m.idMatiere=mo.idMatiere and m.Nom= :nom and mo.Drapeau = 0 ');
        $req->bindValue(':nom', $nomMatiere);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM);
    } 
     public function pourcentage(){ //pourcentage de reussite total
        $req= $this->bd->prepare('SELECT mo.Note, mo.idMatiere, m.Nom FROM moyenne mo, matiere m where m.idMatiere=mo.idMatiere and mo.Drapeau = 0 ');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM);
    } 

    ////
	
    public function nom_prenom_user($id){
        $req= $this->bd->prepare( 'SELECT Nom, Prénom from users where idUser= :id and Drapeau = 0');
        $req->bindValue(':id', $id);
        $req->execute();
        return $req-> fetch(PDO:: FETCH_ASSOC);
    }
	public function user_promo($idpromo){
        $req= $this->bd->prepare( 'SELECT idUser, Nom from users where promo= :id and Drapeau = 0 ORDER BY nom ASC');
        $req->bindValue(':id', $idpromo);
        $req->execute();
        return $req-> fetchALL(PDO:: FETCH_ASSOC);
    }
    public function nb_eval_matiere_promo($idpromo, $idMatiere){
        $req= $this->bd->prepare( 'SELECT max(NumEval) nb from eval where idpromo= :idpromo and idMatiere= :idmatiere and Drapeau = 0;');
        $req->bindValue(':idpromo', $idpromo);
        $req->bindValue(':idmatiere', $idMatiere);
        $req->execute();
        return intval($req-> fetch(PDO:: FETCH_ASSOC)['nb']);
    }
	public function recuperer_controle($idpromo, $idMatiere){
        $req= $this->bd->prepare( 'SELECT * from eval where idpromo= :idpromo and idMatiere= :idmatiere and Drapeau = 0;');
        $req->bindValue(':idpromo', $idpromo);
        $req->bindValue(':idmatiere', $idMatiere);
        $req->execute();
        return $req-> fetchALL(PDO:: FETCH_ASSOC);
    }
    public function recuperer_nom_controle($idpromo, $idMatiere,$numEval){
        $req= $this->bd->prepare( 'SELECT Mode from eval where idpromo= :idpromo and idMatiere= :idmatiere and NumEval= :numEval and Drapeau = 0;');
        $req->bindValue(':idpromo', $idpromo);
        $req->bindValue(':idmatiere', $idMatiere);
        $req->bindValue(':numEval', $numEval);
        $req->execute();
        return $req-> fetch(PDO:: FETCH_ASSOC)['Mode'];
    }
    public function info_controle($idpromo, $idMatiere,$numEval){
        $req= $this->bd->prepare( 'SELECT * from eval where idpromo= :idpromo and idMatiere= :idmatiere and NumEval= :numEval and Drapeau = 0;');
        $req->bindValue(':idpromo', $idpromo);
        $req->bindValue(':idmatiere', $idMatiere);
        $req->bindValue(':numEval', $numEval);
        $req->execute();
        return $req-> fetch(PDO:: FETCH_ASSOC);
    }
    public function controle_promo_matiere_num($idpromo, $idMatiere,$numEval){
        $req= $this->bd->prepare( 'SELECT users.idUser, Nom, Prénom, Note, users.Drapeau du, eval.Drapeau de, eval.historique, eval.modifie from users, eval where users.idUser= eval.idUser and idpromo= :idpromo and idMatiere= :idmatiere and NumEval= :numEval and eval.Drapeau = 0 and users.Drapeau = 0;');
        $req->bindValue(':idpromo', $idpromo);
        $req->bindValue(':idmatiere', $idMatiere);
        $req->bindValue(':numEval', $numEval);
        $req->execute();
        return $req-> fetchALL(PDO:: FETCH_ASSOC);
    }
	public function recuperer_controle_etud($idMatiere, $id){
        $req= $this->bd->prepare( 'SELECT * from eval where idUser= :id and idMatiere= :idmatiere and Drapeau = 0 ORDER BY NumEval ASC;');
        $req->bindValue(':idmatiere', $idMatiere);
		$req->bindValue(':id', $id);
        $req->execute();
        return $req-> fetchALL(PDO:: FETCH_ASSOC);
    }
	public function recuperer_tout_controle_etud($id){
        $req= $this->bd->prepare( 'SELECT * from eval where idUser= :id and Drapeau = 0;');
		$req->bindValue(':id', $id);
        $req->execute();
        return $req-> fetchALL(PDO:: FETCH_ASSOC);
    }
	public function recuperer_matieres_prof($idp){
        $req= $this->bd->prepare( "SELECT inscriptionMatiere from users where idUser= :idp and Drapeau = 0;");
		$req->bindValue(':idp', $idp);
        $req->execute();
		$lesM = explode('-',$req-> fetch(PDO:: FETCH_ASSOC)['inscriptionMatiere']);
        return $lesM;
    }
	public function matiere_de($id){
        $req= $this->bd->prepare( 'SELECT nom from matiere where idMatiere= :id and Drapeau = 0;');
		$req->bindValue(':id', $id);
        $req->execute();
        return $req-> fetch(PDO:: FETCH_ASSOC);
    }
	
	public function creer_eval_deau($eleves, $idpromo, $idProf, $coef, $numEval){
		// $eleves= $this->bd->prepare( 'SELECT iduser from users where promo= :idpromo');
        // $eleves->bindValue(':idpromo', $idpromo);
        // $eleves->execute();
		// while($ligne = $eleves->fetch(PDO::FETCH_ASSOC)) {
			// var_dump($ligne);
			// $req = $this->bd->prepare( "INSERT into eval(idPromo, idUser, Note, Date, Coef, Mode, Drapeau, modifie, historique, NumEval, idMatiere) VALUES(:idpromo, :idEtud, 15, '2021-01-10', 6, 'Exam Espagnol', 0, 0, '', 3, 6);");
			// $req->bindValue(':idpromo', $idpromo);
			// $req->bindValue(':idEtud', $ligne["iduser"]);
			// $req->execute();
				
		// }
    }
	
	public function nom_matiere($idm){
        $requeteMatiere = $this->bd->prepare("SELECT `Nom` FROM matiere where idMatiere=:idm");
		$requeteMatiere->bindValue(":idm",$idm);
		$requeteMatiere->execute();
        return $requeteMatiere->fetch(PDO::FETCH_ASSOC)["Nom"];
    }
	
	public function nom_promo($idp){
        $requetePromo = $this->bd->prepare("SELECT `Option` FROM promotion where idPromotion=:idp");
		$requetePromo->bindValue(":idp",$idp);
		$requetePromo->execute();
        return $requetePromo->fetch(PDO::FETCH_ASSOC)['Option'];
    }
	public function les_absences(){
        $requeteAbs = $this->bd->prepare("SELECT * FROM absenceretard;");
		$requeteAbs->execute();
        return $requeteAbs->fetchALL(PDO::FETCH_ASSOC);
    }
	
	public function les_absences_par_personnes(){
        $requeteAbs = $this->bd->prepare("SELECT idUser, count(*) as nbAbs FROM absenceretard GROUP BY idUser;");
		// c'est GROUP BY idUser qui te donne le nbAbs par personne ok ! ok !
		$requeteAbs->execute();
        return $requeteAbs->fetchALL(PDO::FETCH_ASSOC);
    }
	public function les_nbAbs_justif_par_personnes(){
        $requeteAbs = $this->bd->prepare("SELECT idUser, count(*) as nbAbsJustif FROM absenceretard WHERE justif=1 GROUP BY idUser;");
		// c'est GROUP BY idUser qui te donne le nbAbs par personne ok !
		$requeteAbs->execute();
        return $requeteAbs->fetchALL(PDO::FETCH_ASSOC);
    }
	// on fait une jointure des deux tables ok !! les NbAbs et les Justifieés ok !!!!!!!
	
	public function les_abs_par_perso_JNJ(){
		// SELECT table1111.id,table111.aval1,table113.cval1 FROM table111 INNER JOIN table113 ON table111.id=table113.id;
        $requeteAbs = $this->bd->prepare("SELECT idUser, nbAbsJustif, nbAbs FROM ((SELECT idUser, count(*) as nbAbsJustif FROM absenceretard WHERE justif=1 GROUP BY idUser) NATURAL JOIN (SELECT idUser, count(*) as nbAbs FROM absenceretard GROUP BY idUser)) ;");
		// c'est GROUP BY idUser qui te donne le nbAbs par personne ok !
		$requeteAbs->execute();
        return $requeteAbs->fetchALL(PDO::FETCH_ASSOC);
    }
	
	public function recuperer_tout_controle_etuds($id){
		$req= $this->bd->prepare( 'SELECT *, matiere.Nom from eval,matiere where matiere.idMatiere = eval.idMatiere AND eval.idUser= :id AND Note>=0;');
		$req->bindValue(':id', $id);
		$req->execute();
		return $req-> fetchALL(PDO:: FETCH_ASSOC);
    }
    public function les_derniers_eval_du_prof($idPromo, $idMatieres){
        $rq="SELECT distinct idMatiere, idPromo, Coef, Date, Mode FROM eval where idpromo = :idpromo and idMatiere in ( _idMatieres ) and Drapeau = 0 ORDER BY Date limit 10";
        $rq = str_replace("_idMatieres",$idMatieres,$rq);
        $req = $this->bd->prepare($rq);
        $req->bindValue(':idpromo', $idPromo);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
    public function creer_eval($idPromo,$promo_users, $Date, $Coef, $eval, $numEval,$idMatiere){
        foreach($promo_users as $etudiant){
            $req = $this->bd->prepare(
            "INSERT INTO eval (idPromo, idUser, Date, Coef, Mode,NumEval,idMatiere,historique)
                      VALUES (:idPromo, :idUser, :Date, :Coef, :Mode, :NumEval,:idMatiere,'')");
            $req->bindValue(':idPromo', $idPromo);
            $req->bindValue(':idUser', $etudiant['idUser']);
            $req->bindValue(':Date', $Date);
            $req->bindValue(':Coef', $Coef);
            $req->bindValue(':Mode', $eval);
            $req->bindValue(':NumEval', $numEval);
            $req->bindValue(':idMatiere', $idMatiere);
            $req->execute();
        }
    }
}
?>