<?php

function dessiner_acc($pa, $nbrjour)
{
    $couleurH = 'rgb(0,247,238)';

    $premiere_heur = strftime('%H', strtotime($pa[0]['start']));
    foreach($pa as $key => $value)
    {
        if($pa[$key]['type_prec'] != 'N/A')
        {
            $marge_debut_fin = (strtotime($pa[$key]['end']) 
                    - strtotime($pa[$key]['start'])) / 3600; 
            //nombre d'heures entre le debut et la fin
            
            $limit = ((strtotime(substr(($pa[$key]['start']), 0, 10)) 
                    - strtotime(substr(($pa[1]['start']), 0, 10))) / 3600) / 24; 
            //nombre de jour (pour savoir l'afficher ou non)
            
            if($limit < $nbrjour - 1)
            {
                $top = $pa[$key]['type_prec'];
                if($top == 'snow')
                {//accumulation totale en cm (neige)
                    $Tmax = round(($pa[$key]['acc_tot_max'] / 10), 1);
                    $Hmax = round(($pa[$key]['acc_hor_max'] / 10), 1);
                    $couleur = 'rgb(233,242,241)';
                    $unit = 'cm';
                    $h = 0.4;
                    $Hhor = 0.5;
                    $topfr = 'neige';
                }
                if($pa[$key]['type_prec'] == 'rain')
                {//accumulation totale en mm (pluie)
                    $Tmax = round($pa[$key]['acc_tot_max'], 1);
                    $Hmax = round($pa[$key]['acc_hor_max'], 1);
                    $couleur = 'rgb(51,102,238)';
                    $unit = "mm";
                    $h = 1;
                    $Hhor = 2;
                    $topfr = 'pluie';
                }

                $marge_0 = (strtotime($pa[$key]['end']) - strtotime($pa[0]['start'])) / 3600 + $premiere_heur;
                setlocale(LC_TIME, 'fr_FR', 'fra');
                $debut = strftime('%A %H', strtotime($pa[$key]['start']));
                setlocale(LC_ALL, "en_US.UTF-8");
                $debuten = strftime('%A %H', strtotime($pa[$key]['start']));
                $fin = strftime('- %H', strtotime($pa[$key]['end']));
                $Mx = $marge_0 * 6.25;
                $L1x = $marge_0 * 6.25 + $marge_debut_fin * 6.25;
                $L2x = $marge_0 * 6.25 + $marge_debut_fin * 6.25;
                $L2y = 300 - $pa[$key]['acc_tot_max'] * $h;
                $L2yH = 300 - $pa[$key]['acc_hor_max'] * $Hhor;
//                $L3x = ($marge3 + $marge_0 * 6.25); // OUT PAUL : undefined marge3 : 2015-01-26
                $L3x = $marge_0 * 6.25;
                $L3y = 300 - $pa[$key]['acc_tot_max'] * $h;
                $L3yH = 300 - $pa[$key]['acc_hor_max'] * $Hhor;


                $DataTitlefr = <<<DATA
						$debut h <br/>$topfr: $Hmax $unit<br/>Total: $Tmax $unit
DATA;
                $DataTitleen = <<<DATA
						$debuten h <br/>$top: $Hmax $unit<br/>Total: $Tmax $unit
DATA;

                echo acc($Mx, $L1x, $L2x, $L2y, $L3x, $L3y, $couleur,
                        $DataTitlefr, $DataTitleen);
                echo acc($Mx, $L1x, $L2x, $L2yH, $L3x, $L3yH, $couleurH,
                        $DataTitlefr, $DataTitleen);
            }
        }
    }
}

?>