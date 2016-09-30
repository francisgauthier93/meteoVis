<?php


header('Content-Type: text/html; charset=UTF-8');

ob_start();

// Display errors
error_reporting(-1);
ini_set('display_errors', 'On');

define('REAL_PATH_ROOT', realpath('../../../') . '/');

require_once REAL_PATH_ROOT . 'autoloader.php';

$sDmFile = Config::get('path.real.root')
                . Config::get('path.relative.root_to_api')
                . Config::get('path.relative.api_to_api_data') . 
                Config::get('jsreal.lexicon.dm.file.' . 'fr');

$oDmParser = new DmParser($sDmFile, '(n79 um           (um masc sing) (a femi sing) (a masc plur) (a femi plur)) ; maximum  ', '(n81 eu           (eu masc sing) (ei masc plur)) ; leu');
$aDmLexicon = $oDmParser->run();

$oDmFormatter = new DmFormatter($aDmLexicon);
$aSimplifiedDmLexicon = $oDmFormatter->getDeclensionTable();

Util::var_dump($aSimplifiedDmLexicon); die;