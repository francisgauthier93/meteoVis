<?php

header('Content-Type: text/html; charset=utf-8');

//ob_start();

// Display errors
error_reporting(-1);
//ini_set('display_errors', 'On');

require_once('php/connexionMysql.inc.php');

require_once 'php/utility/Constant.php';
require_once 'php/utility/Number.php';
require_once 'php/utility/Date.php';

require_once 'php/model/AirTemperature.php';
require_once 'php/model/Wind.php';
require_once 'php/model/Accumulation.php';
require_once 'php/model/CloudCover.php';
require_once 'php/model/Day.php';
require_once 'php/model/MeteoCode.php';

require_once 'php/factory/MeteoCodeFactory.php';

require_once('php/conditionCourante.php');
require_once('php/condition5heures.php');
require_once('php/dessiner_acc.php');
require_once('php/dessiner_cc.php');
require_once('php/dessiner_temp.php');
require_once('php/dessiner_top.php');
require_once('php/dessiner_vent.php');
require_once('php/fonction.php');
require_once('php/prevision_text.php');
require_once('php/bdToarray.php');
require_once('php/csv_bd.php');
require_once('php/svgFunctions.php');

//ob_end_clean();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xmlns:svg="http://www.w3.org/2000/svg"  
        xmlns:xlink="http://www.w3.org/1999/xlink" lang="en">
<head>
    <title>
        MeteoVis - <?php if (isset($_POST["inVille"])){echo $_POST["inVille"];}else{echo'Montréal';}?>
    </title>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <!-- bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css"/>
    <script type="text/javascript" src="js/jquery-1.11.1.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="js/bootstrap.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="js/typeahead.bundle.js" charset="utf-8"></script>
    <!-- pour le typeahead de bootstrap -->
    
    <!-- spécifique à MeteoVis -->
    <link rel="stylesheet" href="css/MeteoVis.css" type="text/css" media="screen" charset="utf-8">
    <link rel="stylesheet" href="css/MeteoVis-typeahead.css" type="text/css" media="screen" charset="utf-8">
    <!-- javascript -->
    
    <?php 
        $chekbox= array(
        0=>'checked="checked"',
        1=>'',
        2=>'checked="checked"',
        3=>'checked="checked"');
        $param=rand(5,7);
        $ventch=rand(0,1);
        $accch=rand(0,3);
        echo<<<CC
        <script language="javascript" type="text/javascript">
            var currNbJours= $param;
        </script>	
CC;
    ?>
    <script type="text/javascript" charset="utf-8" src="js/regionTable.js"></script>
    <script type="text/javascript" charset="utf-8" src="js/MeteoVis.js"></script>
</head>
<body>
    <div class="container">
    <?php
    if(isset($_POST["province"]) && $_POST["province"]!="")
    {
        $province = $_POST["province"];
        $ville= $_POST["ville"];
        $id02=$_POST["id02"];
        $id37=$_POST["id37"];
        $code=$_POST["code"];
    }
    else
    {
        $province = 'QC';
        $id02="FPCN71";
        $id37="FPUL55";
        $code="r71.1";
    }
    ?>
    
    <?php 
    echo'<div class="row page-header ">';
    print condition_courante($_POST, 'entete.xsl');

    echo' <div class="col-sm-2">
                 <button id="degres" type="button" class="btn btn-inverse btn-small">°F</button>
                 <button id="lang" type="button" class="btn btn-info">en</button>                
             </div>';
         echo'</div>';
    echo '<div class="row">';
    print condition_courante($_POST, 'cond_cour.xsl');
    ?>
  
    <div class="clearfix visible-sm"></div>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <table class="table table-condensed">
                <colgroup>
                    <col style="width:50%"/>
                    <col style="width:50%"/>
                </colgroup>
                <thead>
                    <tr>
                        <th colspan="2" class="fr">Pour les 3 prochaines heures</th>
                        <th colspan="2" class="en">For the next 3 hours</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $principale = condition($id02, $id37, $code); ?>
                </tbody>
            </table>
        </div>
    </div>
 
       <!-- modification d'affichage -->
        <div class="row">
            <form class="form-inline" autocomplete="off" method="post"
            action="#">
                <div class="col-sm-6 col-md-5 col-lg-4  container-fluid">
                    <div class="form-group" id="inputVille">
                        <label class="sr-only" for="inVille">Email</label>
                        <input type="text" class="typeahead tt-query" id="inVille"
                        spellcheck="false" placeholder="Changer de ville" name="inVille">
                        <input type="hidden" id="prov" name="prov" />
                        <input type="hidden" id="province" name="province" />
                        <input type="hidden" id="ville"  name="ville"/>
                        <input type="hidden" id="villeen"  name="villeen"/>
                        <input type="hidden" id="id02" name="id02" />
                        <input type="hidden" id="id37" name="id37" />
                        <input type="hidden" id="code" name="code" />
                    </div>
                    <div class="form-group" id='nbjours'>
                        <select class="fr" name="nbjours-fr">
                            <option value="1" <?php if ($param == 1)echo 'selected="selected"';?>>1 jour</option>
                            <option value="2" <?php if ($param == 2)echo 'selected="selected"';?>>2 jours</option>
                            <option value="3" <?php if ($param == 3)echo 'selected="selected"';?>>3 jours</option>
                            <option value="4" <?php if ($param == 4)echo 'selected="selected"';?>>4 jours</option>
                            <option value="5" <?php if ($param == 5)echo 'selected="selected"';?>>5 jours</option>
                            <option value="6" <?php if ($param == 6)echo 'selected="selected"';?>>6 jours</option>
                            <option value="7" <?php if ($param == 7)echo 'selected="selected"';?>>7 jours</option>
                        </select>
                        <select class="en" name="nbjours-en">
                            <option value="1" <?php if ($param == 1)echo 'selected="selected"';?>>1 day</option>
                            <option value="2" <?php if ($param == 2)echo 'selected="selected"';?>>2 days</option>
                            <option value="3" <?php if ($param == 3)echo 'selected="selected"';?>>3 days</option>
                            <option value="4" <?php if ($param == 4)echo 'selected="selected"';?>>4 days</option>
                            <option value="5" <?php if ($param == 5)echo 'selected="selected"';?>>5 days</option>
                            <option value="6" <?php if ($param == 6)echo 'selected="selected"';?>>6 days</option>
                            <option value="7" <?php if ($param == 7)echo 'selected="selected"';?>>7 days</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-7 col-lg-8 container-fluid">
                    <div class="checkbox">
                        <label><input type="checkbox" id='temperature' checked="checked" name="temperature"> 
                            <span class="fr">Température</span><span class="en">Temperature</span>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="windCond" name="windCond" <?php echo $chekbox[$ventch]; ?> > 
                            <span class="fr">Vent </span><span class="en">Wind</span>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id="precipCond"  checked="checked" name="precipCond"> 
                            <span class="fr">Précipitations</span><span class="en">Precipitations</span>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="cloudCond" checked="checked" id="cloudCond"> <span class="fr">Couverture nuageuse</span><span class="en">Cloud covering</span>
                        </label>
                    </div>
                    <div class="checkbox" id="percentPrecipCond">
                        <label><input type="checkbox" name="percentPrecipCond">
                            <span class="fr">% de précipitations</span><span class="en">% of precipitation</span>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" id='accumCond'  <?php echo $chekbox[$accch];?> name="accumCond"> Accumulation</label>
                    </div>
                </div>
            </form>
            </div>
        <!-- graphique pour les prochains jours -->
        <div class="row scroll">
            <svg height="300px" width="1050px" id="graphique">
                <!-- dessiner le fond -->
                <?php
			$arg = array("x"  => "0", 
						 "y"=>"0" , 
						 "width"=>"100%", 
						 "height"=>"100%",
						 );
			rect($arg);	
                ?>
                <line x1="150" y1="0" x2="150" y2="100%"/>
                <line x1="300" y1="0" x2="300" y2="100%"/>
                <line x1="450" y1="0" x2="450" y2="100%"/>
                <line x1="600" y1="0" x2="600" y2="100%"/>
                <line x1="750" y1="0" x2="750" y2="100%"/>
                <line x1="900" y1="0" x2="900" y2="100%"/>
                <!-- noms des jours -->
                <?php
                    $nbrjour=7;
                    for ($i = 0; $i < $nbrjour; $i++) 
                    {
                        $x3=$i*150+75;
                        setlocale(LC_TIME, 'fr_FR', 'fra');
                        $jourfr= utf8_encode(ucfirst(strftime("%A %e %B",time()+($i)*86400)));
                        setlocale(LC_ALL, "en_US.UTF-8");
                        $jouren= ucfirst(strftime("%A %B %eth ",time()+($i)*86400));
                        $body= '<tspan class="fr">'.$jourfr.'</tspan><tspan class="en">'.$jouren.'</tspan>';
                        //ecrire les jours
                        text($body,array("x"  => $x3, "y"=>"25","style"=>'fill:black', "text-anchor"=> "middle" ));
                    }
                    echo'<!-- points de température -->';
                    $temperature= import_temp($principale);
                    $min_max=min_max($temperature, $nbrjour);
                    dessiner_temp($temperature, $nbrjour, $min_max['min'],$min_max['max'],$min_max['min_key'], $min_max['max_key']);
                    echo'<!-- précipitation-->';
                    dessiner_top($principale, $nbrjour);
                    echo'<!-- Couverture nuageuse -->';
                    $cc=import_cc($principale);
                    dessiner_cc($nbrjour, $cc);
                    echo'<!-- Accumulation -->';
                    $pa=import_pa($principale);
                    dessiner_acc($pa, $nbrjour);
                    echo'<!-- Vent -->';
                    $vent= import_vent($principale);
                    dessiner_vent($vent, $nbrjour);	
                 ?>
            </svg>
        </div>
        <br />
        <!-- prévisions en texte -->
        <?php
            $oMeteoCode = MeteoCodeFactory::fromArray($temperature, $vent, $pa, $cc);
//            var_dump($oMeteoCode->getDayList());
        ?>
        <div class="row">
            <table id="prevision-texte" class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Temp&eacute;rature minimum</th>
                        <th>Temp&eacute;rature maximum</th>
                        <th>Informations compl&eacute;mentaires</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        prevision_text($temperature, $vent, $pa, $cc, $nbrjour);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>                                  		