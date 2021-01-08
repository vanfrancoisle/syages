<?php

function print_td_note($note){
    if($note>15){return '<td class="bonne-note">'.e($note).'</td>';}
    else if($note>9){return '<td style="background-color:grey">'.e($note).'</td>';}
    else{return '<td class="mauvaise-note">'.e($note).'</td>';}
}

function print_td_justification($note){
    if($note==0){return '<td class="mauvaise-note">Non justifiée</td>';}
    else{return '<td class="bonne-note">Justifiée</td>';}
}


function logger($nature,$user,$log){
    if(!(file_exists('../../log/log.txt'))){
        file_put_contents('../../log/log.txt','');
    }
    $ip = $_SERVER['REMOTE_ADDR'];
    $time = date('d/m/y h:iA',time());
    $content = file_get_contents('../../log/log.txt');
    $content.= $time."\t|\t".$nature."\t|\t".$ip.":".$user."\t|\t".$log."\n";
    file_put_contents('../../log/log.txt',$content);
}

function e($message){
    return htmlspecialchars($message, ENT_QUOTES);
}
function print_role($role){
    $role=strToLower($role);
    $returnString = "<td style=\"background-color:";
    if($role=="a"){
        $returnString .= "green\">Administrateur";
    }elseif($role=="p"){
        $returnString .= "blue\">Proffesseur";
    }elseif($role=="e"){
        $returnString .= "purple\">Eleve";
    }elseif($role=="s"){
        $returnString .= "orange\">Secretaire";
    }
    else{
        $returnString .= "red\">VIDE";
    }
    return $returnString."</td>";
}
?>
