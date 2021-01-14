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
	
	public function recuperer_infoProf($id){
        $req = $this->bd->prepare("SELECT InscriptionMatiere, Mail, Téléphone from users where idUser= :id and Drapeau = 0;");
        $req->bindValue(':id',$id);
        $req->execute();
        return $req-> fetchALL(PDO:: FETCH_ASSOC);
    }
	
	public function nom_matiere($idm){
        $requeteMatiere = $this->bd->prepare("SELECT `Nom` FROM matiere where idMatiere=:idm and Drapeau = 0;");
		$requeteMatiere->bindValue(":idm",$idm);
		$requeteMatiere->execute();
        return $requeteMatiere->fetch(PDO::FETCH_ASSOC)["Nom"];
    }

    public function id_promo_user($idUser){
        $requeteMatiere = $this->bd->prepare("SELECT promo FROM users where idUser=:iduser and Drapeau = 0;");
		$requeteMatiere->bindValue(":iduser",$idUser);
		$requeteMatiere->execute();
        return $requeteMatiere->fetch(PDO::FETCH_ASSOC)["promo"];
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

    //Admin Promotion Van-François 
    public function lespromoActuelles(){
        $req = $this->bd->prepare("SELECT * from promotion where DATEDIFF(dateFin,CURRENT_DATE())<365 and drapeau=0");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_nbElevePromotion($idPromotion){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM users inner join promotion on users.promo = promotion.idPromotion where role = 'e' and idPromotion=:idPromotion and promotion.drapeau=0");
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();

        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }

    public function get_coefMatiere($matiere){
        $req = $this->bd->prepare('SELECT coef from matiere where nom=:matiere and drapeau=0');
        $req->bindValue(":matiere",$matiere);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM);
    }

    public function creer_promo($form){// JE veux un trigger pour que qu'on n'a pas a mettre les matieres obligatoires
        $tab = ["nomPromo","daeu","dateDebut","dateFin","paraDiplome","paraValidation"];
        $req = $this->bd->prepare('INSERT INTO promotion (NomPromo,idEtalissement,promotion.Option,DateDebut,DateFin,paraDiplome,paraValidation) VALUES (:nomPromo,:idEtablissement,:daeu, :dateDebut,:dateFin,:paraDiplome,:paraValidation)');
        foreach ($form as $key => $value) {
            if (in_array($key, $tab)){
                $req->bindValue(":".$key,$value);
            }
        }
        $req->bindValue(":idEtablissement",$_SESSION["idEtablissement"]);
        $req->execute();
        
    }

    public function sup_promo($form){
        $req = $this->bd->prepare('UPDATE promotion set drapeau=1 where idPromotion=:idPromotion');
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->execute();
    }


    public function add_matiere($form){
        $req = $this->bd->prepare('INSERT into matiere (nom,idPromotion,mode,coef) VALUES (:nomMatiere,:idPromotion,:mode,:coef)');
        $req->bindValue(":nomMatiere",$form["nomMatiere"]);
        $req->bindValue(":mode",$form["mode"]);
        $req->bindValue(":coef",$form["coef"]);
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->execute();
        return $this->get_idMatiere($form["nomMatiere"],$form["idPromotion"]);
    }

    public function get_idMatiere($nomMatiere,$idPromotion){
        $req = $this->bd->prepare('SELECT idMatiere from matiere where nom=:nomMatiere and idPromotion=:idPromotion and drapeau=0');
        $req->bindValue(":idPromotion",$idPromotion);
        $req->bindValue(":nomMatiere",$nomMatiere);
        $req->execute();
        $idMatiere = $req->fetchAll(PDO::FETCH_NUM);
        if ($idMatiere!=false){
            return $idMatiere[0][0];
        }
        return $idMatiere;
    }

    public function add_matiereObl($form){
        $req=$this->bd->prepare('SELECT matieres_obligatoires from promotion where idpromotion=:idPromotion and Drapeau=0');
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->execute();
        $matieresObl=$req->fetchAll(PDO::FETCH_NUM)[0][0];
        $req = $this->bd->prepare('UPDATE promotion set matieres_obligatoires=:matieres_obligatoires where idPromotion=:idPromotion');
        if (is_null($matieresObl)){
            $req->bindValue(":matieres_obligatoires",$form["idMatiere"]);
        } else {
            $req->bindValue(":matieres_obligatoires",$matieresObl.",".$form["idMatiere"]);
        }
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->execute();
    }

    public function add_matiereOpt($form){
        $req=$this->bd->prepare('SELECT matieres_facultatives from promotion where idpromotion=:idPromotion and Drapeau=0');
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->execute();
        $matieresOpt=$req->fetchAll(PDO::FETCH_NUM)[0][0];
        $req = $this->bd->prepare('UPDATE promotion set matieres_facultatives=:matieres_facultatives where idPromotion=:idPromotion');
        if (is_null($matieresOpt)){
            $req->bindValue(":matieres_facultatives",$form["idMatiere"]);
        } else {
            $req->bindValue(":matieres_facultatives",$matieresOpt.",".$form["idMatiere"]);
        }
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->execute();
    }

    public function sup_matiere($form){
        $req = $this->bd->prepare('UPDATE matiere set drapeau=1 where idPromotion=:idPromotion and Nom=:nomMatiere');
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->bindValue(":nomMatiere",$form["nomMatiere"]);
        $req->execute();
    }

    public function supp_matiereObl($form){
        $req=$this->bd->prepare('SELECT matieres_obligatoires from promotion where idpromotion=:idPromotion and Drapeau=0');
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->execute();
        $matieresObl=$req->fetchAll(PDO::FETCH_NUM)[0][0];
        $matieresObl=explode(",", $matieresObl);
        $form["idMatiere"]=$this->get_idMatiere($form["nomMatiere"],$form["idPromotion"]);
        foreach ($matieresObl as $key => $value) {
            if ($value==$form["idMatiere"]){
                unset($matieresObl[$key]);
            }
        }
        var_dump($form);
        var_dump($matieresObl);
        $req = $this->bd->prepare('UPDATE promotion set matieres_obligatoires=:matieres_obligatoires where idPromotion=:idPromotion');
        $req->bindValue(":matieres_obligatoires",implode(",",$matieresObl));
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->execute();
    }
    public function search_enseignant($idPromotion, $nom){
        $nomPrenom = explode(" ", $nom);
        $req = $this->bd->prepare('SELECT idUser from users where nom=:nom and prénom=:prenom and role="p" and Drapeau=0');
        $req->bindValue(":nom",$nomPrenom[0]);
        $req->bindValue(":prenom",$nomPrenom[1]);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM);

    }


    public function all_matieresObligatoires($option){
        $req = $this->bd->prepare('SELECT distinct nom from matiere inner join promotion on promotion.idPromotion=matiere.idPromotion where promotion.option=:option and matieres_obligatoires like concat("%",idMatiere,"%") and matiere.drapeau=0');
        $req->bindValue(":option",$option);
        $req->execute();
        $matiere = $req->fetchAll(PDO::FETCH_NUM);
        # regroupe les matieres en un seul tableau
        foreach ($matiere as $key => $value) { 
            $matiere[$key]=$value[0];
        }
        return $matiere;
    }

    public function all_matieresOptionnelles($option){
        $req = $this->bd->prepare('SELECT distinct nom from matiere inner join promotion on promotion.idPromotion=matiere.idPromotion where promotion.option=:option and matieres_facultatives like concat("%",idMatiere,"%") and matiere.drapeau=0');
        $req->bindValue(":option",$option);
        $req->execute();
        $matiere = $req->fetchAll(PDO::FETCH_NUM);
        # regroupe les matieres en un seul tableau
        foreach ($matiere as $key => $value) { 
            $matiere[$key]=$value[0];
        }
        return $matiere;
    }

    public function get_obligatoireDAEU($option){
        $req=$this->bd->prepare('SELECT matieres_obligatoires from promotion where promotion.Option=:option and Drapeau=0');
        $req->bindValue(":option",$option);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM);
    }

    public function get_nomMatiere($idMatiere){
        $req=$this->bd->prepare('SELECT distinct nom,mode,coef from matiere where idMatiere=:idMatiere and Drapeau=0');
        $req->bindValue(":idMatiere",$idMatiere);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }



    public function set_matiereObligatoire($form){ //Ajout la promotion les matières des DAEUs 
        
        $tab = ["nomPromo","daeu","dateDebut","dateFin","paraDiplome","paraValidation"];
        // Get l'id promotion
        $req = $this->bd->prepare('SELECT idPromotion from promotion where NomPromo=:nomPromo and promotion.Option=:daeu and dateDebut=:dateDebut and dateFin=:dateFin and paraDiplome=:paraDiplome and paraValidation=:paraValidation and drapeau=0');
        foreach ($form as $key => $value) {
            if (in_array($key, $tab)){
                $req->bindValue(":".$key,$value);
            }
        }
        $req->execute();
        $form["idPromotion"]=$req->fetchAll(PDO::FETCH_NUM)[0][0];

        // On prend les matieres obligatoires et on les crée
        $tab=explode(",",$form["matiereObligatoire"]);
        foreach ($tab as $key => $value) {
            $newform=$this->get_nomMatiere($value);
            if (!empty($newform)){
                $newform=$newform[0];
                $newform["nomMatiere"]=$newform["nom"];
                $newform["idPromotion"]=$form["idPromotion"];
                $newform["idMatiere"]=$this->add_matiere($newform);
                $this->add_matiereObl($newform);
            }
        }
    }

    public function existDAEU(){
        $req = $this->bd->prepare('SELECT distinct promotion.option FROM `promotion` where DATEDIFF(dateFin,CURRENT_DATE())<365 and drapeau=0');
        $req->execute();
        $tab=$req->fetchAll(PDO::FETCH_NUM);
        $daeu= array();
        for ($i=0; $i < count($tab); $i++) {
            array_push($daeu,$tab[$i][0]);
        }
        return $daeu;
    }

    public function add_prof($form){
        $matiere_enseignee=$this->matiere_enseignee($form["idProf"],$form["idPromotion"]);
        if (!in_array($form["nomMatiere"] , $matiere_enseignee )){
            $req = $this->bd->prepare('UPDATE users SET InscriptionMatiere=:nomMatiere where idUser=:idUser');
            #$matiere_enseignee=$this->matiere_enseignee($form["idProf"])[0].", ".$form["nomMatiere"];
            $req->bindValue(":nomMatiere",implode(", ", $matiere_enseignee).", ".$form["nomMatiere"]);
            $req->bindValue(":idUser",$form["idProf"]);
            $req->execute();
        }
        $promotion_enseignee=$this->promo_enseignee($form["idProf"]);

        if ($promotion_enseignee!=false){
            if (!in_array($form["idPromotion"], explode(",", $promotion_enseignee[0][0]) ) ){
                $req = $this->bd->prepare('UPDATE users SET InscriptionPeda=:idPromotion where idUser=:idUser');
                #$matiere_enseignee=$this->matiere_enseignee($form["idProf"])[0].", ".$form["nomMatiere"];
                $req->bindValue(":idPromotion",implode(",", $promotion_enseignee[0]).",".$form["idPromotion"]);
                $req->bindValue(":idUser",$form["idProf"]);
                $req->execute();
            }
        }
        
    }

    public function sup_prof($form){
        $req = $this->bd->prepare('UPDATE users SET InscriptionMatiere=:nomMatiere where idUser=:idUser');
        $matiere_enseignee=$this->matiere_enseignee($form["idProf"],$form["idPromotion"]);
        unset($matiere_enseignee[array_search($form["nomMatiere"], $matiere_enseignee)]);

        $req->bindValue(":nomMatiere",implode(", ",$matiere_enseignee));
        $req->bindValue(":idUser",$form["idProf"]);
        $req->execute();
    }

    public function promo_enseignee($idUser){
        $req = $this->bd->prepare('SELECT InscriptionPeda from users where idUser=:idUser and drapeau=0');
        $req->bindValue(":idUser",$idUser);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM);
    }


//PROMOTION ACTIVE  Van-François
    public function get_nomPromo($idPromotion){
        $req = $this->bd->prepare('SELECT nomPromo from promotion where idPromotion=:idPromotion and drapeau=0');
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }

    public function matiere_enseignee($idUser,$idPromotion){
        $req = $this->bd->prepare('SELECT matiere.nom from users inner join matiere on idPromotion=:idPromotion where role="p" and users.idUser=:idUser and InscriptionMatiere like concat("%",matiere.nom,"%") and matiere.drapeau=0');
        $req->bindValue(":idUser",$idUser);
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        $tab = $req->fetchAll(PDO::FETCH_NUM);
        foreach ($tab as $key => $value) {
            $tab[$key]=$value[0];
        }
        return $tab;
    }

    public function get_matieresObligatoires($idPromotion){
        $req = $this->bd->prepare('SELECT matiere.nom from matiere inner join promotion on matiere.idPromotion = promotion.idPromotion where promotion.idPromotion=:idPromotion and matieres_obligatoires like concat("%",idMatiere,"%") and matiere.drapeau=0');
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        $matiere = $req->fetchAll(PDO::FETCH_NUM);
        $tabMatiere=array();
        foreach ($matiere as $key => $value) { // Pour n'avoir qu'un tableau d'une clé -> valeur et pas clé -> valeur/clé ->valeur
            $tabMatiere[$key]=$value[0];
        }
        return $tabMatiere;
    }

    public function get_matieresOptionnelles($idPromotion){
        $req = $this->bd->prepare('SELECT matiere.nom from matiere inner join promotion on matiere.idPromotion = promotion.idPromotion where promotion.idPromotion=:idPromotion and matieres_facultatives like concat("%",idMatiere,"%") and matiere.drapeau=0');
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        $matiere = $req->fetchAll(PDO::FETCH_NUM);
        $tabMatiere=array();
        foreach ($matiere as $key => $value) { // Pour n'avoir qu'un tableau d'une clé -> valeur et pas clé -> valeur/clé ->valeur
            $tabMatiere[$key]=$value[0];
        }
        return $tabMatiere;
    }

    public function get_professeur_promo($idPromotion,$matiere){
        $req = $this->bd->prepare("SELECT distinct nom, prénom FROM users natural join promotion where role = 'p' and InscriptionMatiere like concat('%',:matiere,'%') and InscriptionPeda like concat('%',:idPromotion,'%') and promotion.drapeau=0");
        $req->bindValue(":matiere",$matiere);
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        $prof = $req->fetchAll(PDO::FETCH_NUM);
        $tabProf = array();
        foreach ($prof as $key => $value) {
            $tabProf[$key]=$value[0]." ".$value[1];
        }
        return $tabProf;


    }

    public function get_nbEleveMatiere($idPromotion,$matiere){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM users inner join promotion on users.promo = promotion.idPromotion where role = 'e' and InscriptionMatiere like concat('%',:matiere,'%') and idPromotion=:idPromotion and promotion.drapeau=0");
        $req->bindValue(":matiere",$matiere);
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();

        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }

    public function get_evaluation($idPromotion,$matiere){
        $req = $this->bd->prepare("SELECT count(*) FROM eval inner join matiere on eval.idMatiere = matiere.idMatiere where Date > CURRENT_DATE() and matiere.nom=:matiere and idPromotion=:idPromotion and matiere.drapeau=0");
        $req->bindValue(":matiere",$matiere);
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }

    public function get_moyenne($idPromotion,$matiere){
        $req = $this->bd->prepare("SELECT avg(note) FROM moyenne inner join matiere on moyenne.idMatiere = matiere.idMatiere where nom=:matiere and matiere.idPromotion=:idPromotion and matiere.drapeau=0");
        $req->bindValue(":matiere",$matiere);
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }

    public function get_totalAbs($idPromotion,$matiere){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM absenceretard inner join users on users.idUser = absenceretard.idUser where users.InscriptionMatiere like concat('%',:matiere,'%') and promo=:idPromotion and absenceretard.drapeau=0");
        $req->bindValue(":matiere",$matiere);
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }

    public function get_absJustif($idPromotion,$matiere){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM absenceretard inner join users on users.idUser = absenceretard.idUser where users.InscriptionMatiere like concat('%',:matiere,'%') and absenceretard.Justif = 1 and promo=:idPromotion and absenceretard.drapeau=0");
        $req->bindValue(":matiere",$matiere);
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];   
    }

    public function get_absInjustif($idPromotion,$matiere){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM absenceretard inner join users on users.idUser = absenceretard.idUser where users.InscriptionMatiere like concat('%',:matiere,'%') and absenceretard.Justif = 0 and promo=:idPromotion and absenceretard.drapeau=0");
        $req->bindValue(":matiere",$matiere);
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }

        public function get_absJustifPromo($idPromotion){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM absenceretard inner join users on users.idUser = absenceretard.idUser where absenceretard.Justif = 1 and promo=:idPromotion and absenceretard.drapeau=0");
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];   
    }

    public function get_absInjustifPromo($idPromotion){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM absenceretard inner join users on users.idUser = absenceretard.idUser where absenceretard.Justif = 0 and promo=:idPromotion and absenceretard.drapeau=0");
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }


// PROMOTION NOUVELLE
    public function recuperer_infoPromoNew(){
        $req = $this->bd->prepare("SELECT NomPromo, `Option`, DateDebut, DateFin, matieres from promotion where Drapeau=0");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

// PROMOTION ANCIENNE
    public function lespromoAnciennes(){
        $req = $this->bd->prepare("SELECT idPromotion,nomPromo,datedebut,dateFin from promotion where DATEDIFF(dateFin,CURRENT_DATE())>365 and drapeau=0");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_nbInscrit($idPromotion){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM users inner join promotion on users.promo = promotion.idPromotion where users.promo=:idPromotion and promotion.drapeau=0");
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }

    public function get_nbValide($idPromotion){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM users inner join promotion on users.promo = promotion.idPromotion where users.promo=:idPromotion and data like '%valide%' and promotion.drapeau=0");
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }

        public function get_nbEchec($idPromotion){
        $req = $this->bd->prepare("SELECT COUNT(*) FROM users inner join promotion on users.promo = promotion.idPromotion where users.promo=:idPromotion and data like '%echec%' and promotion.drapeau=0");
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }
    public function get_moyennePromo($idPromotion){
        $req = $this->bd->prepare("SELECT avg(note) FROM moyenne inner join matiere on moyenne.idMatiere = matiere.idMatiere where matiere.idPromotion=:idPromotion and moyenne.drapeau=0");
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }
}

?>

