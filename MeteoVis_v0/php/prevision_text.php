<?php

function prevision_text($temperature, $vent, $pa, $cc, $nbrjour)
{
    $max = -1200;
    $min = 1200;
    $i = 0;
    foreach($temperature as $key => $value)
    {
        if($key == 0)
        {
            $key = 1;
        }

        if(substr($temperature[$key]['heure'], 0, 10) == substr($temperature[$key - 1]['heure'], 0, 10))
        {
            $limit = ((strtotime($temperature[$key]['heure']) - strtotime($temperature[1]['heure'])) / 3600) / 24;
            if($limit < $nbrjour)
            {
                if($temperature[$key]['temperature_air'] > $max)
                {
                    $max = $temperature[$key]['temperature_air'];
//                    $max_key = $key;
                }

                if($temperature[$key]['temperature_air'] < $min)
                {
                    $min = $temperature[$key]['temperature_air'];
//                    $min_key = $key;
                }
            }
        }
        else
        {
//            $jouuuur = substr($temperature[$key - 1]['heure'], 0, 10);
            $tab_temp[$i]['max'] = ($max > -1200) ? $max : null;
            $tab_temp[$i]['min'] = ($min < 1200) ? $min : null;
            $max = -1200;
            $min = 1200;
            $i++;
        }
    }
    /*     * ********************************************************************* */
    /* 						vent (text)										*
      /*********************************************************************** */
    $tab_vent = array();
    foreach($vent as $key => $value)
    {
        if(substr($vent[$key]['start'], 0, 10) == substr($vent[$key]['end'], 0, 10))
        {
            if(array_key_exists(strftime("%A", strtotime(substr($vent[$key]['start'], 0, 10))), $tab_vent))
            {
                if($tab_vent[strftime("%A", strtotime(substr($vent[$key]['start'], 0, 10)))]['vitesse'] < $vent[$key]['vitesse_max'])
                {
                    $tab_vent[strftime("%A", strtotime(substr($vent[$key]['start'], 0, 10)))]['vitesse'] = $vent[$key]['vitesse_max'];
                    $tab_vent[strftime("%A", strtotime(substr($vent[$key]['start'], 0, 10)))]['direction'] = $vent[$key]['direction'];
                }
            }
            else
            {
                $tab_vent[strftime("%A", strtotime(substr($vent[$key]['start'], 0, 10)))]['vitesse'] = $vent[$key]['vitesse_max'];
                $tab_vent[strftime("%A", strtotime(substr($vent[$key]['start'], 0, 10)))]['direction'] = $vent[$key]['direction'];
            }
        }
    }
    /*     * ********************************************************************* */
    /* 						tableau (text)									*
      /*********************************************************************** */
    $commence_old = 'Null';
    $commence = 'NULL';
    for($i = 0; $i < $nbrjour; $i++)
    {
        echo'<tr>';
        if($i == 0)
        {
            echo '<td><span class="fr">Aujourd\'hui</span><span class="en">Today</span></td>';
        }
        else
        {
            setlocale(LC_TIME, 'fr_FR', 'fra');
            echo'<td><span class="fr">' . strftime("%A", time() + ($i) * 86400) . '</span>';
            setlocale(LC_ALL, "en_US.UTF-8");
            echo'<span class="en">' . strftime("%A", time() + ($i) * 86400) . '</span></td>';
        }
        echo'<!-- Affiche le résumé de la prévision -->';
        // Température
//        echo'<td class="celsius">' . round($tab_temp[$i]['min']) 
//                . '</td><td class="celsius">' . round($tab_temp[$i]['max']) . '</td>';
        echo is_null($tab_temp[$i]['min']) ? '<td><span class="fr">Inconnue</span><span class="en">Unknown</span></td>' 
                : '<td class="celsius">' . round($tab_temp[$i]['min']) . '</td>';
        echo is_null($tab_temp[$i]['max']) ? '<td><span class="fr">Inconnue</span><span class="en">Unknown</span></td>' 
                : '<td class="celsius">' . round($tab_temp[$i]['max']) . '</td>';
        //description
        echo'<td>';
        // vent 
        if(array_key_exists(strftime("%A", time() + ($i) * 86400), $tab_vent))
        {
            $vitesse = $tab_vent[strftime("%A", time() + ($i) * 86400)]['vitesse'];
            $direction = $tab_vent[strftime("%A", time() + ($i) * 86400)]['direction'];
            if($tab_vent[strftime("%A", time() + ($i) * 86400)]['vitesse'] > 39)
            {
                echo vent_text($vitesse, $direction, "vent_tfort");
            }
            else
            {
                if($tab_vent[strftime("%A", time() + ($i) * 86400)]['vitesse'] > 29)
                {
                    echo vent_text($vitesse, $direction, "vent_fort");
                }
                else
                {
                    if($tab_vent[strftime("%A", time() + ($i) * 86400)]['vitesse'] > 19)
                    {
                        echo vent_text($vitesse, $direction, "vent_pfort");
                    }
                }
            }
        }
        //ACCUMULATION

        $snow = 0;
        $rain = 0;

        for($j = 0; $j < count($pa); $j++)
        {
            // si le jour= au jour dans le tableau et (c'est le premier dans la bd ou le jour n'est pas le meme que le dernier traité)
            if(strftime("%d", strtotime(substr($pa[$j]['start'], 0, 10))) == strftime("%d", time() + ($i) * 86400))
            {
                if($pa[$j]['type_prec'] == 'snow')
                {
                    $snow = $snow + $pa[$j]["acc_hor_max"];
                }
                if($pa[$j]['type_prec'] == 'rain')
                {
                    $rain = $rain + $pa[$j]["acc_hor_max"];
                }
            }
        }

        if($snow > 0 and $rain > 0)
        {
            echo'<span class="fr">Alternance neige et pluie</span>';
            echo'<span class="en">Alternating snow and rain</span>';
        }
        else
        {
            if($snow > 0)
            {
                //fr
                echo ' <span class="fr">Une accumulation totale de <highlite id="qteneige">' . round($snow / 10) . '</highlite> cm de <highlite id="neige" >neige</highlite> est prévue.</span>';
                //en
                echo ' <span class="en">A total of <highlite id="qteneige">' . round($snow / 10) . '</highlite> cm of accumulation of <highlite id="neige" >snow</highlite> is expected.</span>';
            }
            if($rain > 0)
            {
                //fr
                echo ' <span class="fr">Une accumulation totale de <highlite id="qtepluie">' . round($rain) . '</highlite> mm de <highlite id="pluie" >pluie</highlite> est prévue.</span>';
                //en
                echo ' <span class="en">A total accumulation of <highlite id="qtepluie">' . round($rain) . '</highlite> mm of <highlite id="pluie" >rain</highlite> is expected.</span>';
            }
        }
        //CLOUD COVER
        $cc_somme = 0;
        $cont = 0;
        for($j = 0; $j < count($cc); $j++)
        {
            // si le jour= au jour dans le tableau et (c'est le premier dans la bd ou le jour n'est pas le meme que le dernier traité)
            if(strftime("%d", strtotime(substr($cc[$j]['valid_time'], 0, 10))) == strftime("%d", time() + ($i) * 86400))
            {
                $cc_somme = $cc_somme + $cc[$j]['cloudCover'];
                $cont++;
            }
        }
        if($cc_somme / $cont > 7)
        {
            echo '<span class="fr"> Nuageux.</span> ';
            echo '<span class="en"> Cloudy.</span> ';
        }
        else
        {
            if($cc_somme / $cont > 5)
            {
                echo '<span class="fr"> Globalement nuageux. </span>';
                echo '<span class="en"> Cloudy.</span> ';
            }
            else
            {
                if($cc_somme / $cont > 3)
                {
                    echo '<span class="fr"> Partiellement nuageux.</span> ';
                    echo '<span class="en"> Partly cloudy.</span> ';
                }
                else
                {
                    if($cc_somme / $cont > 1)
                    {
                        echo '<span class="fr"> Ciel dégagé. </span>';
                        echo '<span class="en"> Clear. </span>';
                    }
                    else
                    {
                        echo '<span class="fr"> Ensoleillé.</span> ';
                        echo '<span class="en"> Sunny.</span> ';
                    }
                }
            }
        }
        echo '</td>                
    </tr>';
    }
}

function vent_text($vitesse, $direction, $type)
{
    return <<<ACC

        <span class="fr">Vent d'une vitesse maximum pouvant atteindre <highlite id="$type" >$vitesse</highlite> Km/h ($direction).</span>
        <span class="en">Wind speeds up to a maximum <highlite id="$type" >$vitesse</highlite> Km/h ($direction).</span>
ACC;
}

?>
