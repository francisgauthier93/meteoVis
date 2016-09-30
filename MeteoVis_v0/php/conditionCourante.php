<?php

function condition_courante($post, $fichier)
{
    if(isset($_POST["prov"]) and $_POST["prov"] != "")
    {
        $province = $_POST["prov"];
    }
    else
    {
        $province = 'QC';
    }

    /* VILLE */
    if(isset($_POST["ville"]) and $_POST["ville"] != "")
    {
        $ville = $_POST["ville"];
    }
    else
    {
        $ville = 's0000635';
    }


    $xml = new DOMDocument();
    $xml->load('http://dd.weatheroffice.gc.ca/citypage_weather/xml/' . $province . '/' . $ville . '_f.xml');
    //echo 'http://dd.weatheroffice.gc.ca/citypage_weather/xml/' . $province . '/' . $ville . '_f.xml';
	
	$oXmlDocument = simplexml_import_dom($xml);
	Date::setLocalTimeZoneFromZoneNameFr(
			(string)$oXmlDocument->currentConditions[0]->dateTime[1]->attributes()->zone);
	
	$xsl = new DOMDocument();
    $xsl->load('xsl/' . $fichier);
    $proc = new XSLTProcessor();
    $proc->importStyleSheet($xsl);
    $fichieren = 'http://dd.weatheroffice.gc.ca/citypage_weather/xml/' . $province . '/' . $ville . '_e.xml';
    $proc->setParameter(null, 'province', $province);
    $proc->setParameter(null, 'fichieren', $fichieren);
    $proc->setParameter(null, 'ville', $ville);
    // $proc->transformToXML($xml); // OUT 201-01-23 : Paul : Doublon
    return $proc->transformToXML($xml);
}

function extraction_xsl()
{
    
}

?>