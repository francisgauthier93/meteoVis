<?php

function dessiner_vent($vent, $nbrjour)
{
    $marge = 40;
    $marge2 = 80;
    $marge3 = 20;
    $h = -93;
    $y = 100;
    $largeur = 100 + ($nbrjour + 1) * 150;
    $premiere_heur = strftime('%H', strtotime($vent[0]['start']));
    foreach($vent as $key => $value)
    {
        $marge_debut_fin = (strtotime($vent[$key]['end']) - strtotime($vent[$key]['start'])) / 3600;
        $limit = ((strtotime(substr(($vent[$key]['start']), 0, 10)) - strtotime(substr(($vent[1]['start']),
                                0, 10))) / 3600) / 24;
        if($limit < $nbrjour)
        {
            $marge_0 = (strtotime($vent[$key]['end']) - strtotime($vent[1]['start'])) / 3600 + $premiere_heur;
            setlocale(LC_TIME, 'fr_FR', 'fra');
            $debutfr = strftime('%A %k', strtotime($vent[$key]['start']));
            $finfr = strftime('%A %k', strtotime($vent[$key]['end']));
            setlocale(LC_ALL, "en_US.UTF-8");
            $debuten = strftime('%A %k', strtotime($vent[$key]['start']));
            $finen = strftime('%A %k', strtotime($vent[$key]['end']));
            $direction_vent = $vent[$key]['direction'];
            $vmin = $vent[$key]['vitesse_min'];
            $vmax = $vent[$key]['vitesse_max'];
            $x_rot = ($marge_0 * 6.25) + $vent[$key]['vitesse_max'];
            $y_rot = 80;
            $direction = array("north" => "",
                "south" => 'rotate(180,' . $x_rot . ',' . $y_rot . ')',
                "northeast" => 'rotate(45,' . $x_rot . ',' . $y_rot . ')',
                "northwest" => 'rotate(-45,' . $x_rot . ',' . $y_rot . ')',
                "west" => 'rotate(-90,' . $x_rot . ',' . $y_rot . ')',
                "east" => 'rotate(90,' . $x_rot . ',' . $y_rot . ')',
                "southwest" => 'rotate(-135,' . $x_rot . ',' . $y_rot . ')',
                "southeast" => 'rotate(135,' . $x_rot . ',' . $y_rot . ')');
            $directionfr = array("north" => "nord",
                "south" => 'sud',
                "northeast" => 'nord-est',
                "northwest" => 'nord-ouest',
                "west" => 'ouest',
                "east" => 'est',
                "southwest" => 'sud-ouest',
                "southeast" => 'sud-est');
            if(strftime('%A', strtotime($vent[$key]['start'])) == strftime('%A',
                            strtotime($vent[$key]['end'])))
            {
                setlocale(LC_TIME, 'fr_FR', 'fra');
                $debutfr = strftime('%A %k', strtotime($vent[$key]['start']));
                $finfr = strftime('%k', strtotime($vent[$key]['end']));
                setlocale(LC_ALL, "en_US.UTF-8");
                $debuten = strftime('%A %k', strtotime($vent[$key]['start']));
                $finen = strftime('%k', strtotime($vent[$key]['end']));
            }
            else
            {
                setlocale(LC_TIME, 'fr_FR', 'fra');
                $debutfr = strftime('%A %k', strtotime($vent[$key]['start']));
                $finfr = strftime('%A %k', strtotime($vent[$key]['end']));
                setlocale(LC_ALL, "en_US.UTF-8");
                $debuten = strftime('%A %k', strtotime($vent[$key]['start']));
                $finen = strftime('%A %k', strtotime($vent[$key]['end']));
            }
            if($vmin == $vmax)
            {
                $datatitlefr = ucfirst($debutfr) . "h - " . $finfr . "h <br/>" 
                        . ((!is_null($direction_vent) && isset($directionfr[$direction_vent])) ? $directionfr[$direction_vent] : '') 
                        . " " . $vmin . " Km/h";
                $datatitleen = ucfirst($debuten) . "h - " . $finen . "h <br/>" . $direction_vent . " " . $vmin . " Km/h";
            }
            else
            {
                $datatitleen = ucfirst($debuten) . "h - " . $finen . "h <br/>" . $direction_vent . " " . $vmin . " to " . $vmax . " Km/h";
                $datatitlefr = ucfirst($debutfr) . "h - " . $finfr . "h <br/>" 
                        . ((!is_null($direction_vent) && isset($directionfr[$direction_vent])) ? $directionfr[$direction_vent] : '') 
                        . " " . $vmin . " à " . $vmax . " km/h";
            }


            $arg = array(
                "data-title" => $datatitlefr,
                "class" => "fr windCond",
                "x" => ($marge_0 * 6.25),
                "y" => 65,
                "width" => ($vent[$key]['vitesse_max'] * 2),
                "height" => "30",
                "xlink:href" => "img/svg/fleche_h.jpg",
                "opacity" => "0.3",
                "transform" => ((!is_null($direction_vent) && isset($direction[$direction_vent])) ? $direction[$direction_vent] : '')
                );
            image($arg);
            $arg["data-title"] = $datatitleen;
            $arg["class"] = "en windCond";
            image($arg);
        }
    }
}

?>