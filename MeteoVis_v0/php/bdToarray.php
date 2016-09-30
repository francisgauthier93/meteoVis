<?php

function import_cc($principale)
{
    $nom_table_cc = $principale[0]['nom_table'] . 'cc';
    $requete = "SELECT * FROM $nom_table_cc ";
    $resultat = mysql_query($requete);
    while($row = mysql_fetch_array($resultat, MYSQL_ASSOC))
    {
        $cc[] = array(
            "valid_time" => $row['valid_time'],
            "cloudCover" => $row['cloudCover']);
    }
    return($cc);
}

function endKey($array)
{
    end($array);
    return key($array);
}

function import_temp($principale)
{
    $nom_table_ta = $principale[0]['nom_table'] . 'ta';
    $requete = "SELECT * FROM $nom_table_ta where air_temp <> '-9999.00'";
    $resultat = mysql_query($requete);
    $temperature = array();
    while($row = mysql_fetch_array($resultat, MYSQL_ASSOC))
    {
        $dernier = endKey($temperature);
        if($row['valid_time'] > $temperature[$dernier]['heure'])
        {
            $temperature[] = array(
                "heure" => $row['valid_time'],
                "temperature_air" => $row['air_temp']);
        }
    }

    return($temperature);
}

function import_pop($principale)
{
    $nom_table_pop = $principale[0]['nom_table'] . 'pop';
    $requete = "SELECT * FROM $nom_table_pop where probability <> 0";
    $resultat = mysql_query($requete);
    while($row = mysql_fetch_array($resultat, MYSQL_ASSOC))
    {
        $pop[] = array(
            "start" => $row['start'],
            "end" => $row['end'],
            "probability" => $row['probability']
        );
    }
    return($pop);
}

function import_vent($principale)
{
    $nom_table_ws = $principale[0]['nom_table'] . 'ws';
    $requete = "SELECT * FROM $nom_table_ws ";
    $resultat = mysql_query($requete);
    while($row = mysql_fetch_array($resultat, MYSQL_ASSOC))
    {
        $vent[] = array(
            "start" => $row['start'],
            "end" => $row['end'],
            "vitesse_min" => $row['vitesse_min'],
            "vitesse_max" => $row['vitesse_max'],
            "direction" => $row['direction']);
    }
    return($vent);
}

function import_pa($principale)
{
    $nom_table_pa = $principale[0]['nom_table'] . 'pa';
    $requete = "SELECT * FROM $nom_table_pa";
    $resultat = mysql_query($requete);
    while($row = mysql_fetch_array($resultat, MYSQL_ASSOC))
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
    return($pa);
}

function min_max($temperature, $nbrjour)
{
    $max = -1200;
    $min = 1200;
    foreach($temperature as $key => $value)
    {
        $limit = 0;
        $limit = ((strtotime($temperature[$key]['heure']) - strtotime($temperature[1]['heure'])) / 3600) / 24;
        if($limit < $nbrjour)
        {
            if($temperature[$key]['temperature_air'] < $min)
            {
                $min = $temperature[$key]['temperature_air'];
                $min_key = $key;
            }
            if($temperature[$key]['temperature_air'] > $max)
            {
                $max = $temperature[$key]['temperature_air'];
                $max_key = $key;
            }
        }
    }
    $resultat = array('min' => $min, 'max' => $max, 'min_key' => $min_key, 'max_key' => $max_key);
    return($resultat);
}

?>