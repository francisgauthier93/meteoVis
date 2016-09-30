<?php

function dessiner_cc($nbrjour, $cc)
{
    $premiere_heur = strftime('%H', strtotime($cc[0]['valid_time'])); // premiere heure de la prévision (pour decaller)
    $indice = 0;
    $image = '987.png';
    $dist = 0; // une variable pour dessiner les nuage de chaque trois heures (pour ne pas dessiner une seul pour toute la periode)
    foreach($cc as $key => $value)
    {
        $limit = ((strtotime($cc[$key]['valid_time']) - strtotime($cc[0]['valid_time'])) / 3600) / 24;
        $image = '987.png';
        if($limit < $nbrjour - 1)
        {
            $dist++;
            $indice = $key + 1;
            if(($cc[$key]['cloudCover'] != $cc[$key + 1]['cloudCover']) || ( $dist == 4))
            {
                if($cc[$key]['cloudCover'] == 9 
                        || $cc[$key]['cloudCover'] == 8 
                        || $cc[$key]['cloudCover'] == 7)
                {
                    $image = '987.png';
                    $dist = 0;
                }
                if($cc[$key]['cloudCover'] == 6 || $cc[$key]['cloudCover'] == 5)
                {
                    $image = '56.png';
                    $dist = 0;
                }

                if($cc[$key]['cloudCover'] == 4 || $cc[$key]['cloudCover'] == 3)
                {
                    $image = '34.png';
                    $dist = 0;
                }

                if($cc[$key]['cloudCover'] == 2 || $cc[$key]['cloudCover'] == 1)
                {
                    $image = '12.png';
                    $dist = 0;
                }
                if($cc[$key]['cloudCover'] == 0)
                {
                    $image = '0.png';
                    $dist = 0;
                }
                $x = ($indice + $premiere_heur) * 6.25;
                echo cc($x, $image);
                //echo'<image x="'.(($indice+$premiere_heur)*6.25).'" y="'.($h + 320).'" width="25" height="'.$height.'" xlink:href="img/svg/'.$image.'"></image>';
            }
        }
    }
}

?>