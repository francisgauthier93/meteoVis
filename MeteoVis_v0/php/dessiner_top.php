<?php

function dessiner_top($principale, $nbrjour)
{
    $nom_table_pa = $principale[0]['nom_table'] . 'pa';
    $requete = "SELECT * FROM $nom_table_pa"; // trouver l'enregistrement qui correspond a l'emplacement de notre utilisateur
    $resultat = mysql_query($requete);

    while($row = mysql_fetch_array($resultat, MYSQL_ASSOC)) // si trouvé
    {
        $pa[] = array(
            "start" => $row['start'],
            "end" => $row['end'],
            "acc_tot_min" => $row['acc_tot_min'],
            "acc_tot_max" => $row['acc_tot_max'],
            "acc_hor_min" => $row['acc_hor_min'],
            "acc_hor_max" => $row['acc_hor_max'],
            "type_prec" => $row['type_prec']);
    }
    $premiere_heur = strftime('%H', strtotime($pa[0]['start']));
    foreach($pa as $key => $value)
    {
        if($pa[$key]['type_prec'] <> 'N/A')
        {
            $marge_debut_fin = (strtotime($pa[$key]['end']) - strtotime($pa[$key]['start'])) / 3600;
            //nombre d'heures entre le debut et la fin
            $limit = ((strtotime(substr(($pa[$key]['start']), 0, 10)) - strtotime(substr(($pa[1]['start']),
                                    0, 10))) / 3600) / 24;
            //nombre de jour (pour savoir l'afficher ou non)
            if($limit < $nbrjour - 1)
            {//nbrjour: est le nombre de jour que l'utilisateur a demander
                $marge_0 = (strtotime($pa[$key]['end']) - strtotime($pa[0]['start'])) / 3600 + $premiere_heur;
                //$debut= strftime('%A %H',strtotime($pa[$key]['start']));
                //$fin=strftime('%A %H',strtotime($pa[$key]['end'])); 

                if($pa[$key]['type_prec'] == 'snow')
                {
                    $image = 'snow_flake_icon_2.jpg';
                }
                if($pa[$key]['type_prec'] == 'rain')
                {
                    $image = 'rain.jpg';
                }

                for($i = 0; $i <= $pa[$key]['acc_hor_max']; $i++)
                {
                    $x = $marge_0 * 6.25;
                    $y = rand(40, 200);
                    $from = rand(40, 200);
                    $dur = rand(5, 15);
                    echo precipitation($x, $y, $from, $dur, $image);
                }
            }
        }
    }
}

?>