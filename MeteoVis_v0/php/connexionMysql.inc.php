
<?php

//*******************************************************
// pour se connecter à partir du terminal				*
// ssh mouinemo@frontal.iro.umontreal.ca				*
// mot de passe = ***********							*
// mysql -u mouinemo -p -h mysql						*
// mot de passe : cT3axmbg8EKfG5						*
// use mouinemo_meteo_csv;								*
//*******************************************************
$connexion=mysql_connect( "www-labs.iro.umontreal.ca" ,  "wwwrali"  ,  "Tissu16Epsilon" );
mysql_select_db("wwwrali_meteovis_prod");

?>