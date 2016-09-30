<?php

function dessiner_temp($temperature, $nbrjour, $min, $max, $min_key, $max_key)
{
    $espace = 5;
    $marge3 = -6.25;
    $premiere_heur = strftime('%H', strtotime($temperature[1]['heure']));
    $ligne = 150;
    $diviseur = 1;
    $total_temp = 0;
    foreach($temperature as $key => $value)
    {
        $total_temp = $total_temp + $temperature[$key]['temperature_air'];
        $diviseur = $diviseur + 1;
        $DataTitle = strftime('%A', strtotime($temperature[$key]['heure'])) . " " .
                strftime('%H', strtotime($temperature[$key]['heure'])) .
                "h</br><span class=\"celsius\">" . round($temperature[$key]['temperature_air'],
                        1) . "</span>";
        circle(array(
            "cx" => ($marge3 + $premiere_heur * 6.25),
            "cy" => ($ligne - $espace * $temperature[$key]['temperature_air']),
            "r" => "3",
            "style" => "fill:rgb(200, 208, 70)",
            "stroke-width" => '0',
            "class" => "en temperature",
            'data-title' => $DataTitle)
        );

        $marge3 = $marge3 + 6.25;
    }
    $marge3 = -6.25;
    setlocale(LC_TIME, 'fr_FR', 'fra');
    foreach($temperature as $key => $value)
    {        
        $DataTitle = strftime('%A', strtotime($temperature[$key]['heure'])) . " " .
                strftime('%H', strtotime($temperature[$key]['heure'])) .
                "h</br><span class=\"celsius\">" . round($temperature[$key]['temperature_air'],
                        1) . "</span>";
        circle(array(
            "cx" => ($marge3 + $premiere_heur * 6.25),
            "cy" => ($ligne - $espace * $temperature[$key]['temperature_air']),
            "r" => "3",
            "style" => "fill:rgb(200, 208, 70)",
            "stroke-width" => '0',
            "class" => "fr temperature",
            'data-title' => $DataTitle)
        );

        $marge3 = $marge3 + 6.25;
    }

    // la ligne montrant le maximum de la température 
    $y = ($ligne - $espace * ($total_temp / $diviseur));
    $fin = (($nbrjour + 1) * 150);
    $DataTitle = "La température maximum prévue pour cette periode est: <span class=\"celsius\">" . round($max) . "</span>. Cette température est prévue pour le " . strftime('%A',
                    strtotime($temperature[$max_key]['heure'])) . " à " . strftime('%H',
                    strtotime($temperature[$max_key]['heure'])) . 'h';
    setlocale(LC_ALL, "en_US.UTF-8");
    $DataTitleen = "The maximum temperature on your chosen dates is: <span class=\"celsius\">" . round($max) . "</span> for " . strftime('%A',
                    strtotime($temperature[$max_key]['heure'])) . " at " . strftime('%H',
                    strtotime($temperature[$max_key]['heure'])) . 'h';

    $arg = array("class" => "fr temperature",
        'data-title' => $DataTitle,
        "x1" => "0",
        "y1" => $ligne - $espace * $max,
        "x2" => $fin,
        "y2" => ($ligne - $espace * $max),
        "stroke" => 'red',
        "stroke-width" => "0.5");
    line($arg);
    $argtxt = array(
        "class" => $arg['class'],
        "data-title" => $arg['data-title'],
        "x" => 0,
        "y" => $ligne - $espace * $max - 3,
        "stroke-width" => '0',
        "fill" => "red");
    text("<tspan class='svgcelsius'>" . round($max, 1) . "°C</tspan>", $argtxt);
    text('max',
            array("x" => (($nbrjour + 1) * 150 - 50), "y" => ($ligne - $espace * $max),
        "fill" => "red"));
    //************ tool tip en anglais
    $arg["class"] = "en temperature";
    $arg['data-title'] = $DataTitleen;

    line($arg);
    $argtxt = array(
        "class" => $arg['class'],
        "data-title" => $arg['data-title'],
        "x" => 0,
        "y" => $ligne - $espace * $max - 3,
        "stroke-width" => '0',
        "fill" => "red");
    text("<tspan class='svgcelsius'>" . round($max, 1) . "°C</tspan>", $argtxt);
    text('max',
            array("x" => (($nbrjour + 1) * 150 - 50), "y" => ($ligne - $espace * $max),
        "fill" => "red"));


    // la ligne montrant le minimum de la température
    setlocale(LC_TIME, 'fr_FR', 'fra');
    $DataTitle = "La température minimum prévue est: <span class=\"celsius\">" . round($min) . "</span>. Cette température est prévue pour le " . strftime('%A',
                    strtotime($temperature[$min_key]['heure'])) . " à " . strftime('%H',
                    strtotime($temperature[$min_key]['heure'])) . 'h';
    setlocale(LC_ALL, "en_US.UTF-8");
    $DataTitleen = "The minimum temperature  is: <span class=\"celsius\">" . round($max) . "</span> for " . strftime('%A',
                    strtotime($temperature[$max_key]['heure'])) . " at " . strftime('%H',
                    strtotime($temperature[$max_key]['heure'])) . 'h';
    $arg = array("class" => "fr temperature",
        'data-title' => $DataTitle,
        "x1" => 0,
        "y1" => $ligne - $espace * $min,
        "x2" => $fin,
        "y2" => $ligne - $espace * $min,
        "stroke" => "blue",
        "stroke-width" => "0.5");
    line($arg);
    $argtxt = array(
        "class" => $arg['class'],
        "data-title" => $arg['data-title'],
        "x" => 0,
        "y" => $ligne - $espace * $min - 3,
        "stroke-width" => '0',
        "fill" => "blue");
    text("<tspan class='svgcelsius'>" . round($min) . "°C</tspan>", $argtxt);
    text('min',
            array("x" => (($nbrjour + 1) * 150 - 50), "y" => ($ligne - $espace * $min),
        "stroke-width" => '0', "fill" => "blue"));
    //************ tool tip en anglais
    $arg["class"] = "en temperature";
    $arg['data-title'] = $DataTitleen;

    line($arg);
    $argtxt = array(
        "class" => $arg['class'],
        "data-title" => $arg['data-title'],
        "x" => 0,
        "y" => $ligne - $espace * $min - 3,
        "stroke-width" => '0',
        "fill" => "blue");
    text("<tspan class='svgcelsius'>" . round($min, 1) . "°C</tspan>", $argtxt);
    text('min',
            array("x" => (($nbrjour + 1) * 150 - 50), "y" => ($ligne - $espace * $min),
        "stroke-width" => '0', "fill" => "blue"));

    // la ligne montrant la moyenne de la température 
    line(array("x1" => 0, "y1" => $y, "x2" => $fin, "y2" => $y, "stroke" => "green",
        "stroke-width" => "0.2", "class" => "fr en temperature"));
    $arg = array("x" => 0, "y" => $y - 3, "stroke-width" => '0', "fill" => "green",
        "class" => "fr en temperature");
    $tempMoy = round(($total_temp / $diviseur), 1);
    text("<tspan class='svgcelsius'>" . $tempMoy . "°C</tspan>", $arg);
    $arg["x"] = $fin - 50;
    text('Température moyenne', $arg);
}

?>
