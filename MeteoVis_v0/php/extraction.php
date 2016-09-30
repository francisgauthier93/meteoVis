
<?php

/* * ***************************************************
 * les parametres									 *
 * @id02= le code du meteocodeo2						 *
 * @id37= le code du meteocode37						 *
 * @code = code de la région							 *
 * @province											 *
 * @type= le type que nous voulons utiliser (xml/csv) *
 * **************************************************** */
if(isset($_POST["ville"]))
{
    $ville = $_POST["ville"];
}
else
{
    $ville = "s0000635";
}

if(isset($_POST["id02"]))
{
    $id02 = $_POST['id02']; //'FPVR14';//'FPWG16';//
    $id37 = $_POST['id37']; //'FPVR54';//'FPWG54';//
    $code = $_POST['code']; //'r2';//'r16.6';//
    $province = $_POST['province']; //'pyr';//'pnr';//
}
else
{

    $dom = new DOMDocument();
    $dom->load('xml/siteList.xml');
    $racine = $dom->documentElement;
    $listeRegion = $dom->getElementsByTagName('site');
    foreach($listeRegion as $Region)
    {
        $city = $Region->getElementsByTagName('city')->item(0);
        $meteocode02 = $Region->getElementsByTagName('meteocode02')->item(0);
        $meteocode37 = $Region->getElementsByTagName('meteocode37')->item(0);
        $coderegion = $Region->getElementsByTagName('region')->item(0);
        if($city->getAttribute("code") == $ville)
        {
            $id02 = $meteocode02->getAttribute("id");
            $id37 = $meteocode37->getAttribute("id");
            $code = $coderegion->getAttribute("code");
            $province = $meteocode02->getAttribute("dir");
        }
    }
}
$fichier = 'http://dd.weatheroffice.gc.ca/meteocode/';
$type = 'xml';
if(date("G") < 3)
{
    $date = array(
        "aa" => date("Y", time() - 86400),
        "mm" => date("m", time() - 86400),
        "jj" => date("d", time() - 86400)
    );
}
else
{
    $date = array(
        "aa" => date("Y"),
        "mm" => date("m"),
        "jj" => date("d"),
        'hh' => date("G")
    );
}

$lien37_csv = csv($fichier . '' . $province . '/csv', $id37, $date, $code);
$lien02_csv = csv($fichier . '' . $province . '/csv', $id02, $date, $code);

$lien02_xml = xml($fichier . '/' . $province . '/cmml', $id02, $date, $code);
$lien37_xml = xml($fichier . '/' . $province . '/cmml', $id37, $date, $code);

//echo 'ville= '.$ville;
//echo '<br/>id02='.$id02;
//echo '<br/>id37='.$id37;
//echo '<br/>code='.$code;
//echo '<br/>le lien csv est: ';
//echo '<pre>';
//print_r($lien02_csv);
//print_r($lien37_csv);
//echo '</pre>';
function csv($fichier, $meteocode, $date, $code)
{
    $lines2 = file($fichier);

    $id = $meteocode;
    // Affiche toutes les lignes du tableau comme code HTML, avec les numéros de ligne
    foreach($lines2 as $line_num2 => $line2)
    {
        $chaine2 = htmlspecialchars($line2);

        if(strpos($chaine2, $date['aa'] . '-' . $date['mm'] . '-' . $date['jj']))
        {
            /*             * *************************************************
             * À regler le probleme de .0 dans la ligne suivante *
             * ************************************************** */

            if(strstr($chaine2, $id . '.0_' . $code . '_'))
            {
                $text = strpbrk($chaine2, '2');
                $x = strpos($text, 'v', 32);
                $lien = substr($text, 0, $x + 1);
                $parametre = substr($lien, -6, -4);
                switch($parametre)
                {
                    case 'CC':$lien_cc = $lien;
                        break;
                    case 'PA':$lien_pa = $lien;
                        break;
                    case 'OP':$lien_pop = $lien;
                        break;
                    case 'TA':$lien_ta = $lien;
                        break;
                    case 'TD':$lien_td = $lien;
                        break;
                    case 'WS':$lien_ws = $lien;
                        break;
                }
            }
        }
    }
    $lien_csv = array(
        'lien_cc' => $lien_cc,
        'lien_pa' => $lien_pa,
        'lien_pop' => $lien_pop,
        'lien_ta' => $lien_ta,
        'lien_td' => $lien_td,
        'lien_ws' => $lien_ws,
    );
    return($lien_csv);
}

function xml($fichier, $meteocode, $date, $code)
{
    // Lit une page web dans un tableau.
    $lines = file($fichier);
    $id = $meteocode;
    // Affiche toutes les lignes du tableau comme code HTML, avec les numéros de ligne
    foreach($lines as $line_num => $line)
    {

        $chaine = strpbrk(htmlspecialchars($line), 'T'); //commencer à partir de 'T'

        if(strstr($chaine, $id . '.' . $date['mm'] . '.' . $date['jj']))
        { // si la chaine contient le id.mm.jj
            $x = strpos($chaine, 'x', 0);
            $rest = substr($chaine, 0, $x + 3);  // retourne "abcde"
        }
    }
    return($rest);
}

?>
