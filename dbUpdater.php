<?php

header('Content-Type: text/html; charset=UTF-8');

error_reporting(-1);
ini_set('display_errors', 'On');
ini_set('max_execution_time', 1200);
set_time_limit(1200);

//echo file_get_contents('http://www-etud.iro.umontreal.ca/~molinspa/MeteoVis_dev/api/batch/dbUpdater.php');

$curl_handle=curl_init();
curl_setopt($curl_handle, CURLOPT_URL,'http://www-etud.iro.umontreal.ca/~molinspa/MeteoVis_dev/api/batch/dbUpdater.php');
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_USERAGENT, 'MeteoVis');
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl_handle);
curl_close($curl_handle);

echo $result;

echo '<br />';

$curl_handle=curl_init();
curl_setopt($curl_handle, CURLOPT_URL,'http://www-etud.iro.umontreal.ca/~molinspa/MeteoVis_stage/api/batch/dbUpdater.php');
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_USERAGENT, 'MeteoVis');
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($curl_handle);
curl_close($curl_handle);

echo $result;