<?php

function condition($id02, $id37, $code)
{

    $requete = "SELECT * FROM principale where (id02='" . $id02 . "' and id37='" . $id37 . "'and code='" . $code . "')"; // trouver l'enregistrement qui correspond a l'emplacement de notre utilisateur
    $resultat = mysql_query($requete);

    while($row = mysql_fetch_array($resultat, MYSQL_ASSOC)) // si trouvé
    {
        $principale[] = array(
            "province" => $row['province'],
            "id02" => $row['id02'],
            "id37" => $row['id37'],
            "code" => $row['code'],
            "fichier02" => $row['fichier02'],
            "fichier37" => $row['fichier37'],
            "nom_table" => $row['nom_table'],
            "info" => $row['info']);
    }

    //Température	

    $nom_table_ta = $principale[0]['nom_table'] . 'ta';
    $requete = "SELECT * FROM $nom_table_ta where air_temp <> '-9999.00'"; // trouver l'enregistrement qui correspond a l'emplacement de notre utilisateur.
    $resultat = mysql_query($requete);

    while($row = mysql_fetch_array($resultat, MYSQL_ASSOC)) // si trouvé
    {
        $temperature[] = array(
            "heure" => $row['valid_time'],
            "temperature_air" => $row['air_temp']);
    }

    $nbr = 0;
    for($i = 0; $i <= 10; $i++)
    {
        if(($nbr < 3)and ( strtotime($temperature[$i]['heure']) > strtotime(strftime("%Y-%m-%dT%H:%M:%S"))))
        {
            $nbr++;
            echo'<tr><th>';
            //heure
            echo strftime("%H", strtotime($temperature[$i]['heure'])) . 'h00</th>';
            //temperature
            echo '<td class="celsius">' . $temperature[$i]['temperature_air'] . '</td></tr>';
        }
    }

    return($principale);
}

?>