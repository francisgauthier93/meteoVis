
<?php

//require_once('localisation.php');
require_once('php/connexionMysql.inc.php');
require_once('php/extraction.php');


$lien02_cc = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien02_csv['lien_cc'];
$lien37_cc = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien37_csv['lien_cc'];
$lien02_pa = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien02_csv['lien_pa'];
$lien37_pa = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien37_csv['lien_pa'];
$nom_pa = 'Précipitation';
$lien02_pop = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien02_csv['lien_pop'];
$lien37_pop = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien37_csv['lien_pop'];
$nom_pop = 'Probabilité de Précipitation';
$lien02_ta = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien02_csv['lien_ta'];
$lien37_ta = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien37_csv['lien_ta'];
$nom_ta = 'Température de l"aire ';
$lien02_td = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien02_csv['lien_td'];
$lien37_td = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien37_csv['lien_td'];
$nom_td = 'Point de rosée (° Celsius)';
$lien02_ws = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien02_csv['lien_ws'];
$lien37_ws = 'http://dd.weatheroffice.gc.ca/meteocode/' . $province . '/csv/' . $lien37_csv['lien_ws'];
$nom_ws = 'Vent';
$type = 'CC CSV';
$nom_table = maj_principale($id02, $id37, $code, $province, $lien02_cc,
        $lien37_cc, $type);

function maj_principale($id02, $id37, $code, $province, 
        $fichier02, $fichier37, $type)
{
    global $lien02_cc, $lien37_cc, $lien02_pa, $lien37_pa, $lien02_pop, $lien37_pop, $lien02_ta, $lien37_ta, $lien02_td, $lien37_td, $lien02_ws, $lien37_ws;
    $nom_table = $id02 . $id37 . str_replace('.', '_', $code);


    $trouve = 'non';

    $requete = "SELECT * FROM principale where (id02='" . $id02 . "' and id37='"
            . $id37 . "'and code='" . $code . "')";
    // trouver l'enregistrement qui correspond a l'emplacement de notre utilisateur
    $resultat = mysql_query($requete);

    while($row = mysql_fetch_array($resultat, MYSQL_ASSOC)) // si trouvé
    {
        $principale[] = array(
            "province" => $row['province'],
            "id02" => $row['id02'],
            "id37" => $row['id37'],
            "code" => $row['code'],
            "fichier02" => $row['fichier02'],
            "fichier37" => $row['fichier37'],
            "nom_table" => $row['nom_table'],
            "info" => $row['info']);


        if($principale[0]['id02'] == $id02
                && $principale[0]['id37'] == $id37
                && $principale[0]['code'] == $code)
        //si l'enregistrement de cette region existe
        {
            if($principale[0]['fichier02'] == $fichier02
                    && $principale[0]['fichier37'] == $fichier37)
            //si cette enregistrement est à jour
            {
                $trouve = 'oui'; // une variable qui indique si c'est un enregistrement existant ou bien qui a été créer
                return($principale[0]['nom_table']);
            }
            else //si l'enregistrement est trouvé mais n'est pas à jour
            {
                $trouve = 'oui';
                $requete0 = "DROP TABLE IF EXISTS like '" . $principale[0]['nom_table'] . "'%;";
                // supprimer les tables correspondants
                $requete1 = "DELETE FROM principale where (id02='" . $id02 . "'and id37='" . $id37 . "'and code='" . $code . "')";
                // supprimer l'ancien enregistrement
                $requete2 = "INSERT INTO principale SET province='" . $province . "', id02='" . $id02 . "', id37='" . $id37 . "', code='" . $code . "', fichier02='" . $fichier02 . "', fichier37='" . $fichier37 . "', nom_table='" . $nom_table . "', info='" . $type . "' ";
                // inserer le nouveau
                $resltat0 = mysql_query($requete0);
                $resultat1 = mysql_query($requete1);
                $resultat2 = mysql_query($requete2);
                $nom_table_cc = $nom_table . 'cc';
                $requete0 = "DROP TABLE IF EXISTS $nom_table_cc;";
                $sql21 = "CREATE TABLE $nom_table_cc (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `valid_time` varchar(30) NOT NULL,
                            `cloudCover` varchar(1)  NOT NULL,
                            PRIMARY KEY (`id`)
                            ) ENGINE=InnoDB;";
                $resltat0 = mysql_query($requete0); // supprimer l'ancienne table si elle existe
                $requete3 = mysql_query($sql21); // creer la nouvelle table
                $nom_table_pa = $nom_table . 'pa';
                $requete0 = "DROP TABLE IF EXISTS $nom_table_pa;";
                $sql31 = "CREATE TABLE $nom_table_pa(
                            `start` VARCHAR(30) NOT NULL,
                            `end` VARCHAR(30) NOT NULL,
                            `acc_tot_min` VARCHAR(10) NOT NULL,
                            `acc_tot_max` VARCHAR(10) NOT NULL, 
                            `acc_hor_min` VARCHAR(10) NOT NULL, 
                            `acc_hor_max` VARCHAR(10) NOT NULL, 
                            `type_prec` VARCHAR(30) NOT NULL, 
                            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY) ENGINE = InnoDB;";
                $resltat0 = mysql_query($requete0);
                $requete3 = mysql_query($sql31);
                $nom_table_pop = $nom_table . 'pop';
                $requete0 = "DROP TABLE IF EXISTS $nom_table_pop;";
                $sql41 = "CREATE TABLE $nom_table_pop (
                                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                                `start` VARCHAR(30) NOT NULL, 
                                `end` VARCHAR(30) NOT NULL, 
                                `probability` VARCHAR(2) NOT NULL) ENGINE = InnoDB;";
                $resltat0 = mysql_query($requete0);
                $requete3 = mysql_query($sql41);
                $nom_table_ta = $nom_table . 'ta';
                $requete0 = "DROP TABLE IF EXISTS $nom_table_ta;";
                $sql51 = "CREATE TABLE $nom_table_ta (
                                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                                `valid_time` VARCHAR(30) NULL, 
                                `air_temp` VARCHAR(10) NULL) ENGINE = InnoDB;";
                $resltat0 = mysql_query($requete0);
                $requete3 = mysql_query($sql51);
                $nom_table_td = $nom_table . 'td';
                $requete0 = "DROP TABLE IF EXISTS $nom_table_td;";
                $sql61 = "CREATE TABLE $nom_table_td (
                                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                                `valid_time` VARCHAR(30) NULL, 
                                `dew_point` VARCHAR(30) NULL) ENGINE = InnoDB;";
                $resltat0 = mysql_query($requete0);
                $requete3 = mysql_query($sql61);
                $nom_table_ws = $nom_table . 'ws';
                $requete0 = "DROP TABLE IF EXISTS $nom_table_ws;";
                $sql71 = "CREATE TABLE $nom_table_ws(
                                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                                `start` VARCHAR(30) NOT NULL, 
                                `end` VARCHAR(30) NOT NULL, 
                                `vitesse_min` VARCHAR(5) NOT NULL, 
                                `vitesse_max` VARCHAR(5) NOT NULL, 
                                `direction` VARCHAR(40) NOT NULL) ENGINE = InnoDB;";
                $resltat0 = mysql_query($requete0);
                $requete3 = mysql_query($sql71);
                insertion_cc($lien02_cc, $nom_table_cc);
                insertion_cc($lien37_cc, $nom_table_cc);
                insertion_pa($lien02_pa, $nom_table_pa);
                insertion_pa($lien37_pa, $nom_table_pa);
                insertion_pop($lien02_pop, $nom_table_pop);
                insertion_pop($lien37_pop, $nom_table_pop);
                insertion_ta($lien02_ta, $nom_table_ta);
                insertion_ta($lien37_ta, $nom_table_ta);
                insertion_td($lien02_td, $nom_table_td);
                insertion_td($lien37_td, $nom_table_td);
                insertion_ws($lien02_ws, $nom_table_ws);
                insertion_ws($lien37_ws, $nom_table_ws);
                return($nom_table);
            }
        }
    }
    if($trouve == 'non')// si l'enregistrement n'est pas trouvé
    {
        $requete2 = "INSERT INTO principale SET province='" . $province . "', id02='" . $id02 . "', id37='" . $id37 . "', code='" . $code . "', fichier02='" . $fichier02 . "', fichier37='" . $fichier37 . "', nom_table='" . $nom_table . "', info='" . $type . "' "; // inserer le nouveau
        $resultat2 = mysql_query($requete2);
        $nom_table_cc = $nom_table . 'cc';
        $requete0 = "DROP TABLE IF EXISTS $nom_table_cc;";
        $sql21 = "CREATE TABLE $nom_table_cc (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `valid_time` varchar(30) NOT NULL,
                        `cloudCover` varchar(1)  NOT NULL,
                        PRIMARY KEY (`id`)
                        ) ENGINE=InnoDB;";
        $resltat0 = mysql_query($requete0); // supprimer l'ancienne table si elle existe
        $requete3 = mysql_query($sql21); // creer la nouvelle table
        $nom_table_pa = $nom_table . 'pa';
        $requete0 = "DROP TABLE IF EXISTS $nom_table_pa;";
        $sql31 = "CREATE TABLE $nom_table_pa(
                        `start` VARCHAR(30) NOT NULL,
                        `end` VARCHAR(30) NOT NULL,
                        `acc_tot_min` VARCHAR(10) NOT NULL,
                        `acc_tot_max` VARCHAR(10) NOT NULL, 
                        `acc_hor_min` VARCHAR(10) NOT NULL, 
                        `acc_hor_max` VARCHAR(10) NOT NULL, 
                        `type_prec` VARCHAR(30) NOT NULL, 
                        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY) ENGINE = InnoDB;";
        $resltat0 = mysql_query($requete0);
        $requete3 = mysql_query($sql31);
        $nom_table_pop = $nom_table . 'pop';
        $requete0 = "DROP TABLE IF EXISTS $nom_table_pop;";
        $sql41 = "CREATE TABLE $nom_table_pop (
                        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                        `start` VARCHAR(30) NOT NULL, 
                        `end` VARCHAR(30) NOT NULL, 
                        `probability` VARCHAR(2) NOT NULL) ENGINE = InnoDB;";
        $resltat0 = mysql_query($requete0);
        $requete3 = mysql_query($sql41);
        $nom_table_ta = $nom_table . 'ta';
        $requete0 = "DROP TABLE IF EXISTS $nom_table_ta;";
        $sql51 = "CREATE TABLE $nom_table_ta (
                        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                        `valid_time` VARCHAR(30) NULL, 
                        `air_temp` VARCHAR(10) NULL) ENGINE = InnoDB;";
        $resltat0 = mysql_query($requete0);
        $requete3 = mysql_query($sql51);
        $nom_table_td = $nom_table . 'td';
        $requete0 = "DROP TABLE IF EXISTS $nom_table_td;";
        $sql61 = "CREATE TABLE $nom_table_td (
                        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                        `valid_time` VARCHAR(30) NULL, 
                        `dew_point` VARCHAR(30) NULL) ENGINE = InnoDB;";
        $resltat0 = mysql_query($requete0);
        $requete3 = mysql_query($sql61);
        $nom_table_ws = $nom_table . 'ws';
        $requete0 = "DROP TABLE IF EXISTS $nom_table_ws;";
        $sql71 = "CREATE TABLE $nom_table_ws(
                        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                        `start` VARCHAR(30) NOT NULL, 
                        `end` VARCHAR(30) NOT NULL, 
                        `vitesse_min` VARCHAR(5) NOT NULL, 
                        `vitesse_max` VARCHAR(5) NOT NULL, 
                        `direction` VARCHAR(40) NOT NULL) ENGINE = InnoDB;";
        $resltat0 = mysql_query($requete0);
        $requete3 = mysql_query($sql71);
        //print("erreurs lors de la création des tables.  Error: ".mysql_error())."<p>";
        //echo 'nouvel enregistrement ajouté';
        insertion_cc($lien02_cc, $nom_table_cc);
        insertion_cc($lien37_cc, $nom_table_cc);
        insertion_pa($lien02_pa, $nom_table_pa);
        insertion_pa($lien37_pa, $nom_table_pa);
        insertion_pop($lien02_pop, $nom_table_pop);
        insertion_pop($lien37_pop, $nom_table_pop);
        insertion_ta($lien02_ta, $nom_table_ta);
        insertion_ta($lien37_ta, $nom_table_ta);
        insertion_td($lien02_td, $nom_table_td);
        insertion_td($lien37_td, $nom_table_td);
        insertion_ws($lien02_ws, $nom_table_ws);
        insertion_ws($lien37_ws, $nom_table_ws);
        //echo 'table creer';

        return($nom_table);
    }
}

/**
 * Insert Multi Row 
 * @param type $tableName a string
 * @param array $columns size >= 1
 * @param array $datas size >= 1
 */
function insertMultiRow($tableName, array $columns, array $datas)
{  
    $maxNbRowPerQuery = 150;
    $i = 0;
    foreach($datas as $row)
    {
        if($i % $maxNbRowPerQuery == 0)
        {
            if($i > 0)
            {
                $query .= ';';
                $result = mysql_query($query);
//                var_dump($query);
            }
            $query = 'INSERT INTO ' . $tableName . ' ';
            $query .= '(' . implode(',', $columns) . ') VALUES ';
        }
        else
        {
            $query .= ',';
        }
        $query .= '("' . implode('","', $row) . '")';
        $i++;
    }
    $query .= ';';
    $result = mysql_query($query);
//    var_dump($query);
    
    return $result;
}

/* * ************************************
 * insertion dans la table Cloud Cover *
 * ************************************* */

function insertion_cc($lien, $table)
{
    $row = 1;
    if(($handle = fopen($lien, "r")) !== FALSE)
    {
        $datas = array();
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if($row > 1) // on retire les entetes
            {
                $datas[] = array($data[0], $data[1]);
            }
            $row++;
        }
        fclose($handle);
        
        $resultat = insertMultiRow(
                $table, 
                array('valid_time','cloudCover'), 
                $datas);
    }
}

/* * **************************************
 * insertion dans la table precipitation *
 * *************************************** */

function insertion_pa($lien, $table)
{
//    $row = 1;
//    if(($handle = fopen($lien, "r")) !== FALSE)
//    {
//        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
//        {
//            // sauter les entetes
//            if($row == 1)
//            {
//                $row++;
//            }
//            // Afficher le contenu
//            else
//            {
//                $requete = "INSERT INTO $table SET 
//                start='" . $data[0] . "', end='" . $data[1] . "', 
//                acc_tot_min='" . $data[2] . "', acc_tot_max='" . $data[3] . "', 
//                acc_hor_min='" . $data[4] . "', acc_hor_max='" . $data[5] . "', 
//                type_prec='" . $data[6] . "' ";
//                $resultat = mysql_query($requete);
//                $row++;
//            }
//        }
//        fclose($handle);
//    }
    $row = 1;
    if(($handle = fopen($lien, "r")) !== FALSE)
    {
        $datas = array();
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if($row > 1) // on retire les entetes
            {
                $datas[] = array($data[0], $data[1], $data[2], $data[3], 
                    $data[4], $data[5], $data[6]);
            }
            $row++;
        }
        fclose($handle);
        
        $resultat = insertMultiRow(
                $table, 
                array('start','end', 'acc_tot_min', 'acc_tot_max', 
                    'acc_hor_min', 'acc_hor_max', 'type_prec'), 
                $datas);
    }
}

/* * **************************************
 * insertion dans la table pop		*
 * *************************************** */

function insertion_pop($lien, $table)
{
//    $row = 1;
//    if(($handle = fopen($lien, "r")) !== FALSE)
//    {
//        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
//        {
//            // sauter les entetes
//            if($row == 1)
//            {
//                $row++;
//            }
//            // Afficher le contenu
//            else
//            {
//                $requete = "INSERT INTO $table SET "
//                        . "start='" . $data[0] . "', end='" . $data[1] . "', "
//                        . "probability='" . $data[2] . "'";
//                $resultat = mysql_query($requete);
//                $row++;
//            }
//        }
//        fclose($handle);
//    }
    $row = 1;
    if(($handle = fopen($lien, "r")) !== FALSE)
    {
        $datas = array();
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if($row > 1) // on retire les entetes
            {
                $datas[] = array($data[0], $data[1], $data[2]);
            }
            $row++;
        }
        fclose($handle);
        
        $resultat = insertMultiRow(
                $table, 
                array('start','end', 'probability'), 
                $datas);
    }
}

/* * **************************************
 * insertion dans la table temp_air		*
 * *************************************** */

function insertion_ta($lien, $table)
{
//    $row = 1;
//    if(($handle = fopen($lien, "r")) !== FALSE)
//    {
//
//        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
//        {
//            // sauter les entetes
//            if($row == 1)
//            {
//                $row++;
//            }
//            // Afficher le contenu
//            else
//            {
//                $requete = "INSERT INTO $table SET "
//                        . "valid_time='" . $data[0] . "', air_temp='" . $data[1] . "' ";
//                $resultat = mysql_query($requete);
//            }
//            $row++;
//        }
//    }
//    fclose($handle);
    $row = 1;
    if(($handle = fopen($lien, "r")) !== FALSE)
    {
        $datas = array();
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if($row > 1) // on retire les entetes
            {
                $datas[] = array($data[0], $data[1]);
            }
            $row++;
        }
        fclose($handle);
        
        $resultat = insertMultiRow(
                $table, 
                array('valid_time','air_temp'), 
                $datas);
    }
}

/* * **************************************
 * insertion dans la table dew_point *
 * *************************************** */

function insertion_td($lien, $table)
{
//    $row = 1;
//    if(($handle = fopen($lien, "r")) !== FALSE)
//    {
//        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
//        {
//            // sauter les entetes
//            if($row == 1)
//            {
//                $row++;
//            }
//            // Afficher le contenu
//            else
//            {
//                $requete = "INSERT INTO $table SET "
//                        . "valid_time='" . $data[0] . "', dew_point='" . $data[1] . "'";
//                $resultat = mysql_query($requete);
//                $row++;
//            }
//        }
//        fclose($handle);
//    }
    $row = 1;
    if(($handle = fopen($lien, "r")) !== FALSE)
    {
        $datas = array();
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if($row > 1) // on retire les entetes
            {
                $datas[] = array($data[0], $data[1]);
            }
            $row++;
        }
        fclose($handle);
        
        $resultat = insertMultiRow(
                $table, 
                array('valid_time','dew_point'), 
                $datas);
    }
}

/* * **************************************
 * insertion dans la table wind		*
 * *************************************** */

function insertion_ws($lien, $table)
{
//    $row = 1;
//    if(($handle = fopen($lien, "r")) !== FALSE)
//    {
//        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
//        {
//            // sauter les entetes
//            if($row == 1)
//            {
//                $row++;
//            }
//            // Afficher le contenu
//            else
//            {
//                $requete = "INSERT INTO $table SET "
//                        . "start='" . $data[0] . "', end='" . $data[1] . "', "
//                        . "vitesse_min='" . $data[2] . "', vitesse_max='" . $data[3] . "', "
//                        . "direction='" . $data[4] . "' ";
//                $resultat = mysql_query($requete);
//                $row++;
//            }
//        }
//        fclose($handle);
//    }
    $row = 1;
    if(($handle = fopen($lien, "r")) !== FALSE)
    {
        $datas = array();
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            if($row > 1) // on retire les entetes
            {
                $datas[] = array($data[0], $data[1], $data[2], $data[3], $data[4]);
            }
            $row++;
        }
        fclose($handle);
        
        $resultat = insertMultiRow(
                $table, 
                array('start','end','vitesse_min','vitesse_max','direction'), 
                $datas);
    }
}

?>