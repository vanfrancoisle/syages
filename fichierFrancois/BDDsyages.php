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
		require "credentials.php";

		if($entier==1){
			$this->bd = new PDO('mysql:host=localhost;dbname=syages', 'eleve',     'eleve');
		}
 
		else if($entier==2){
		  $this->bd = new PDO('mysql:host=localhost;dbname=syages', $login, $mdp);//prof
		}

		else if($entier==3){
			$this->bd = new PDO('mysql:host=localhost;dbname=syages',  $login, $mdp);// secretaire
		}

		else if($entier==4){
			$this->bd = new PDO('mysql:host=localhost;dbname=syages', $login, $mdp);
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
    }

    public function add_matiereObl($form){
        $req=$this->bd->prepare('SELECT matieres from promotion where idpromotion=:idPromotion and Drapeau=0');
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->execute();
        $matieresObl=$req->fetchAll(PDO::FETCH_NUM)[0][0];
        $req = $this->bd->prepare('UPDATE promotion set matieres=:matieres where idPromotion=:idPromotion');
        $req->bindValue(":matieres",$matieresObl."; ".$form["nomMatiere"]);
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
        $req=$this->bd->prepare('SELECT matieres from promotion where idpromotion=:idPromotion and Drapeau=0');
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->execute();
        $matieresObl=$req->fetchAll(PDO::FETCH_NUM)[0][0];
        $matieresObl=explode("; ", $matieresObl);
        foreach ($matieresObl as $key => $value) {
            if ($value==$form["nomMatiere"]){
                unset($matieresObl[$key]);
            }
        }
        $req = $this->bd->prepare('UPDATE promotion set matieres=:matieres where idPromotion=:idPromotion');
        $req->bindValue(":matieres",implode(", ",$matieresObl));
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

    public function all_matiereDAEU($option){
        $req = $this->bd->prepare('SELECT distinct nom from matiere inner join promotion on promotion.idPromotion=matiere.idPromotion where  promotion.option=:option and matiere.drapeau=0');
        $req->bindValue(":option",$option);
        $req->execute();
        $matiere = $req->fetchAll(PDO::FETCH_NUM);
        foreach ($matiere as $key => $value) {
            $matiere[$key]=$value[0];
        }
        return $matiere;
    }

    public function get_obligatoireDAEU($option){
        $req=$this->bd->prepare('SELECT matieres from promotion where promotion.Option=:option and Drapeau=0');
        $req->bindValue(":option",$option);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM);
    }

    public function get_nomMatiere($nom){
        $req=$this->bd->prepare('SELECT distinct nom,mode,coef from matiere where Nom=:nom and Drapeau=0');

        $req->bindValue(":nom",$nom);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }



    public function set_matiereObligatoire($form){ //Ajout la promotion les matières des DAEUs
        $tab = ["matiereObligatoire","nomPromo","daeu","dateDebut","dateFin","paraDiplome","paraValidation"];
        $req = $this->bd->prepare('UPDATE promotion SET matieres=:matiereObligatoire where NomPromo=:nomPromo and promotion.Option=:daeu and dateDebut=:dateDebut and dateFin=:dateFin and paraDiplome=:paraDiplome and paraValidation=:paraValidation');
        
        foreach ($form as $key => $value) {
            if (in_array($key, $tab)){
                $req->bindValue(":".$key,$value);
            }
        }
        $req->execute();
        // Get l'id promotion pour ajouter les matieres obligatoires

        $req = $this->bd->prepare('SELECT idPromotion from promotion where NomPromo=:nomPromo and promotion.Option=:daeu and dateDebut=:dateDebut and dateFin=:dateFin and paraDiplome=:paraDiplome and paraValidation=:paraValidation and matieres=:matiereObligatoire');
        foreach ($form as $key => $value) {
            if (in_array($key, $tab)){
                $req->bindValue(":".$key,$value);
            }
        }
        $req->execute();
        $form["idPromotion"]=$req->fetchAll(PDO::FETCH_NUM)[0][0];
        // On prend les matieres obligatoires et on les crée
        $tab=explode("; ",$form["matiereObligatoire"]);
        foreach ($tab as $key => $value) {
            $newform=$this->get_nomMatiere(ucfirst($value));
            if (!empty($newform)){
                $newform=$newform[0];
                $newform["nomMatiere"]=$newform["nom"];
                $newform["idPromotion"]=$form["idPromotion"];
                $this->add_matiere($newform);
            }
            
        }
        //GET PUIS ADD
        #$this->bd->add_matiere($form);
        /*
            public function add_matiere($form){
        $req = $this->bd->prepare('INSERT into matiere (nom,idPromotion,mode,coef) VALUES (:nomMatiere,:idPromotion,:mode,:coef)');
        $req->bindValue(":nomMatiere",$form["nomMatiere"]);
        $req->bindValue(":mode",$form["mode"]);
        $req->bindValue(":coef",$form["coef"]);
        $req->bindValue(":idPromotion",$form["idPromotion"]);
        $req->execute();
    }
    */
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

    public function obl_matiereDAEU($option){
        $req = $this->bd->prepare('SELECT distinct matieres from promotion where promotion.option=:option and drapeau=0');
        $req->bindValue(":option",$option);
        $req->execute();
        $matiere = $req->fetchAll(PDO::FETCH_NUM);
        foreach ($matiere as $key => $value) {
            $matiere[$key]=$value[0];
        }
        return $matiere;
    }


    public function add_prof($form){ #MANQUE COMMENT DIFFERENCIER Les promotions qu'on met
        $matiere_enseignee=$this->matiere_enseignee($form["idProf"])[0];
        if (!in_array(lcfirst($form["nomMatiere"]),explode(", ", $matiere_enseignee))){
            $req = $this->bd->prepare('UPDATE users SET InscriptionMatiere=:nomMatiere where idUser=:idUser');
            $matiere_enseignee=$this->matiere_enseignee($form["idProf"])[0].", ".$form["nomMatiere"];
            $req->bindValue(":nomMatiere",$matiere_enseignee);
            $req->bindValue(":idUser",$form["idProf"]);
            #$req->bindValue(":idPromotion",$idPromotion);
            $req->execute();
        }
        
    }

    public function sup_prof($form){
        $req = $this->bd->prepare('UPDATE users SET InscriptionMatiere=:nomMatiere where idUser=:idUser');
        $matiere_enseignee=explode(", ",$this->matiere_enseignee($form["idProf"])[0]);
        unset($matiere_enseignee[array_search($form["nomMatiere"], $matiere_enseignee)]);

        $req->bindValue(":nomMatiere",implode(", ",$matiere_enseignee));
        $req->bindValue(":idUser",$form["idProf"]);
        $req->execute();
    }


// Intragith dire de tout remplacer car toutes les requetes ont changé
//PROMOTION ACTIVE 
    public function get_nomPromo($idPromotion){
        $req = $this->bd->prepare('SELECT nomPromo from promotion where idPromotion=:idPromotion and drapeau=0');
        $req->bindValue(":idPromotion",$idPromotion);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }


    public function matiere_enseignee($idUser){
        $req = $this->bd->prepare('SELECT InscriptionMatiere from users where role="p" and idUser=:idUser and drapeau=0');
        $req->bindValue(":idUser",$idUser);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_NUM)[0];
    }

    public function get_matiere($idPromotion){
    	$req = $this->bd->prepare("SELECT matiere.nom from matiere inner join promotion on matiere.idPromotion = promotion.idPromotion where promotion.idPromotion=:idPromotion and matiere.drapeau=0 "); 
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
    	$req = $this->bd->prepare("SELECT nom FROM users inner join promotion on users.promo = promotion.idPromotion where role = 'p' and InscriptionMatiere like concat('%',:matiere,'%') and idPromotion=:idPromotion and promotion.drapeau=0");
    	$req->bindValue(":matiere",$matiere);
    	$req->bindValue(":idPromotion",$idPromotion);
    	$req->execute();
    	$prof = $req->fetchAll(PDO::FETCH_NUM);
    	$tabProf = array();
    	foreach ($prof as $key => $value) {
    		$tabProf[$key]=$value[0];
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