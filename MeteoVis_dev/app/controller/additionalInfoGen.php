<?php 
include 'jsrealbLoaderFr.php'; //ceci fait le tout
?>
<script type="text/javascript">

	 //console.log(texte);
	 //console.log("Voilà: "+texte);
	//$("#forecastTable tr:eq(1)").append("<td>start:"+texte+"</td>");
</script>
<?php
    /**
    * 
    */
    // class  blabla extends BaseAppController
    // {
    //     private $oMeteoCode;
    //     private $sLocationCode;
        
    //     function __construct($arg)
    //     {
    //         # code...
    //         $this->argument = $arg;
    //     }

    //     public function setUp()
    //     {
    //         if(Superglobal::isPostKey('code'))
    //         {
    //             $this->sLocationCode = Superglobal::getPostValueByKey('code');
    //         }
    //         else
    //         {
    //             $this->sLocationCode = Config::get('location.default.city.code');
    //         }
    //     }

    //     $oMeteoCodeService = new MeteoCodeService();
    //     $oMeteoCode = $this->oMeteoCodeService->GetMeteoCodeFromLocationCode($this->sLocationCode);
    // }


    // $key = "teste";
    // $value = "clée";
    // $this->registry->set($key, $value);
    // echo '<script>';
    // echo 'console.log('. json_encode( $this->registry->template-> ) .')';
    // echo '</script>';
//$sLocationCode;

if(Superglobal::isPostKey('code'))
{
    $sLocationCode = Superglobal::getPostValueByKey('code');
}
else
{
    $sLocationCode = Config::get('location.default.city.code');
}

$oMeteoCodeService = new MeteoCodeService();
$oMeteoCode = $oMeteoCodeService->GetMeteoCodeFromLocationCode($sLocationCode);
unset($oMeteoCodeService);
$oAirTempList = $oMeteoCode->getAirTemperatureList();
$i=9;
$start = $oAirTempList[$i]->getStartDate();
$end = $oAirTempList[$i]->getEndDate(); //same as $start
$tempM= $oAirTempList[$i]->getMaxValue();
$tempm= $oAirTempList[$i]->getMinValue(); //same as $tempM
$tempUnit = $oAirTempList[$i]->getUnit();

$cloudList = $oMeteoCode->getCloudCoverList();

$cloudI = $cloudList[$i];
$cloudValue = $cloudI->getValue();
$cloudUnit = $cloudI->getUnit();

// $instructions;
// $.getJSON(BASE_URL + "public/data/jsreal-realization-instruction.json", function(data) {
//                 $instructions = data;
//             });



echo '<script type="text/javascript">';
//echo '$("#forecastTable tr:eq(1)").append("<td>start:"+"' . $start . '"+"</td>");';
// echo '$("#forecastTable tr:eq(2)").append("<td>tempMax:"+"' . $tempM . '"+"</td>");';
// echo '$("#forecastTable tr:eq(3)").append("<td>cloudV:"+"' . $cloudValue . '"+"</td>");';
// echo '$("#forecastTable tr:eq(4)").append("<td>cloudU:"+"' . $cloudUnit . '"+"</td>");';
// echo '$("#forecastTable tr:eq(5)").append("<td>tempU:"+"' . $tempUnit . '"+"</td>");';
// echo '$("#forecastTable tr:eq(6)").append("<td>tempU:"+"' . "NP(N('souris'))". '"+"</td>");';


//echo '$("#forecastTable tr:gt(1)").append("<td>"+NP(D("le"),N("souris"))+"</td>");';
echo '</script>';

?>
