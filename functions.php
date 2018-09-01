<?php

namespace Functions {

    function getFic($g_id, $g_unique = "\r\n\r\n@#@#@#@#@#\r\n\r\n")
    { // $g_id : ID de la fic - $g_unique : S�parateur unique - $g_log : Handle du log
        $g_raw = ''; // Contenu brut du fichier texte de la fic
        $g_fic = array(); // Le tableau qui contiendra toutes les donn�es de la fic
        /*
        $g_fic[0] : Tableau avec donn�es g�n�rales de la fic
        $g_fic[0]["id"] : ID de la fic
        $g_fic[0]["titre"] : Titre de la fic
        $g_fic[0]["chapitres"] : Nombre de chapitres de la fic
        $g_fic[0]["auteur"] : Auteur de la fic
        $g_fic[0]["genre"] : Genre de la fic
        $g_fic[0]["statut"] : Statut de la fic

        $g_fic[1] : Tableau avec donn�es du chapitre 1
        $g_fic[1]["titre"] : Titre du chapitre (cha�ne vide si pas de titre)
        $g_fic[1]["date"] : Date de cr�ation du chapitre
        $g_fic[1]["heure"] : Heure de cr�ation du chapitre
        $g_fic[1]["auteur"] : Auteur du chapitre
        $g_fic[1]["contenu"] : Contenu du chapitre

        $g_fic[2] : Tableau avec donn�es du chapitre 2 si existant, etc
        */
        $g_array = array();
        $g_array2 = array();
        $g_array3 = array(); // Tableaux temporaires pour manipulation des donn�es
//        if (($g_raw = file_get_contents("Fics/Fic-" . $g_id . ".txt")) === false) {
//            return false;
//        }
        $g_raw = $g_id;
        $g_fic[0] = array();
        $g_fic[0]['id'] = null; // On dispose d�j� de l'ID de la fic
        $g_array = explode($g_unique, $g_raw);
        $g_array2 = explode("\r\n", $g_array[0]); // $g_array[0] : Donn�es g�n�rales de la fic (sauf nombre de chapitres)
        if (preg_match('|^TITRE : (.+)$|', $g_array2[1], $g_array3) !== 1) {
            return false;
        }
        $g_fic[0]['titre'] = $g_array3[1];
        $g_array3 = array(); // Titre de la fic r�cup�r�
        if (preg_match('|^AUTEUR : (.+)$|', $g_array2[2], $g_array3) !== 1) {
            return false;
        }
        $g_fic[0]['auteur'] = $g_array3[1];
        $g_array3 = array(); // Auteur de la fic r�cup�r�
        if (preg_match('|^GENRE : (.+)$|', $g_array2[3], $g_array3) !== 1) {
            return false;
        }
        $g_fic[0]['genre'] = $g_array3[1];
        $g_array3 = array(); // Genre de la fic r�cup�r�
        if (preg_match('|^STATUT : (.+)$|', $g_array2[4], $g_array3) !== 1) {
            return false;
        }
        $g_fic[0]['statut'] = $g_array3[1]; // Statut de la fic r�cup�r�
        $g_fic[0]['chapitres'] = 1; // On ne conna�t pas encore le nombre de chapitres donc �a sera 1 en attendant
        for ($i = 1; $i <= $g_fic[0]['chapitres']; $i++) { // On r�cup�re les donn�es chapitre par chapitre
            $g_array2 = array();
            $g_array3 = array(); // Remise � z�ro des tableaux 2 et 3 de manipulation de donn�es
            $g_fic[$i] = array();
            if (!isset($g_array[$i])) {
                return false;
            }
            $g_array2 = explode("\r\n", $g_array[$i]); // $g_array[$i] : Donn�es du chapitre $i
            if ($i == 1) { // Premier chapitre, on va r�cup�rer le nombre total de chapitres de la fic
                if (preg_match('|^CHAPITRE : ' . $i . "/(\d+)$|", $g_array2[0], $g_array3) !== 1) {
                    return false;
                }
                $g_fic[0]['chapitres'] = $g_array3[1];
                $g_array3 = array(); // Nombre total de chapitres de la fic r�cup�r�
            }
            if (preg_match('|^TITRE : (.+)$|', $g_array2[1], $g_array3) !== 1) {
                return false;
            }
            if ($g_array3[1] !== '(@#aucun#@)') $g_fic[$i]['titre'] = $g_array3[1]; else $g_fic[$i]['titre'] = '';
            $g_array3 = array(); // Titre du chapitre $i de la fic r�cup�r� (s'il existe)
            if (preg_match('|^DATE : (.+)$|', $g_array2[2], $g_array3) !== 1) {
                return false;
            }
            $g_fic[$i]['date'] = $g_array3[1];
            $g_array3 = array(); // Date du chapitre $i de la fic r�cup�r�e
            if (preg_match('|^HEURE : (.+)$|', $g_array2[3], $g_array3) !== 1) {
                return false;
            }
            $g_fic[$i]['heure'] = $g_array3[1];
            $g_array3 = array(); // Heure du chapitre $i de la fic r�cup�r�e
            if (preg_match('|^AUTEUR : (.+)$|', $g_array2[4], $g_array3) !== 1) {
                return false;
            }
            $g_fic[$i]['auteur'] = $g_array3[1];
            $g_array3 = array(); // Auteur du chapitre $i de la fic r�cup�r�e
            if (preg_match('|^CONTENU : (.+)$|', $g_array2[6], $g_array3) !== 1) {
                return false;
            }
            $g_fic[$i]['contenu'] = $g_array3[1];
            $g_array3 = array(); // Contenu du chapitre $i de la fic r�cup�r�e
        }
        return $g_fic;
    }

}

