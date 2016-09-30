<?php

/**
 * Description of MeteoController
 *
 * @author molinspa
 */
include 'meteoRealisations.php';

include 'additionalInfoGen.php';

class MeteoController extends BaseAppController
{
    private $oMeteoCode;
    private $sLocationCode;
    
    
    
    public function setUp()
    {
        if(Superglobal::isPostKey('code'))
        {
            $this->sLocationCode = Superglobal::getPostValueByKey('code');
        }
        else
        {
            $this->sLocationCode = Config::get('location.default.city.code');
        }
    }
    
    public function weather()
    {
        if(Superglobal::isPostKey('prov')
                && Superglobal::isPostKey('ville'))
        {
            $province = Superglobal::getPostValueByKey('prov');
            $sCityId = Superglobal::getPostValueByKey('ville');
        }
        else
        {
            $province = Config::get('location.default.city.province.abbr.fr');
            $sCityId = Config::get('location.default.city.id');
        }
        
        $oWeatherView = new WeatherView();
        $sHead = $oWeatherView->getCurrentConditionHeader($province, $sCityId, 'entete.xsl');
        $sBody = $oWeatherView->getCurrentConditionBody($province, $sCityId, 'cond_cour.xsl');
        
        $oMeteoCodeService = new MeteoCodeService();
        $this->oMeteoCode = $oMeteoCodeService->GetMeteoCodeFromLocationCode($this->sLocationCode);
        unset($oMeteoCodeService);
        
        if(is_null($this->oMeteoCode))
        {
            throw new LocationNotExistsException('Location code : ' . $this->sLocationCode);
        }
        
        $sNextHours = $oWeatherView->getNextHoursTemperature(3, $this->oMeteoCode);
        
        $this->registry->template->sHead = $sHead;
        $this->registry->template->sBody = $sBody;
        $this->registry->template->sNextHours = $sNextHours;
        $this->registry->template->show('weather');
    }
    
    public function graph()
    {
        $oGraphView = new GraphView($this->oMeteoCode);
        $this->registry->template->sDayTitle = $oGraphView->getDay();
        $sTemperatureSvg = $oGraphView->getTemperature();
        $sTemperatureSvg .= $oGraphView->getMinimumLine();
        $sTemperatureSvg .= $oGraphView->getAverageLine();
        $sTemperatureSvg .= $oGraphView->getZeroLine();
        $sTemperatureSvg .= $oGraphView->getMaximumLine();
        $this->registry->template->sTemperatureSvg = $sTemperatureSvg;
        $this->registry->template->sPrecipitationSvg = $oGraphView->getPrecipitation();
        $this->registry->template->sCloudCoverSvg = $oGraphView->getCloudCover();
        $this->registry->template->sWindSvg = $oGraphView->getWind();
        $this->registry->template->sAccumulationSvg = $oGraphView->getAccumulation();
        
//        Util::var_dump($sTemperatureSvg); die;
        
        $this->registry->template->iGraphWidth = Config::get('meteo.graph.measure.iWidth');
        $this->registry->template->iGraphHeight = Config::get('meteo.graph.measure.iHeight');
        $this->registry->template->iDayWidth = Config::get('meteo.graph.measure.iDayWidth');
        
        $this->registry->template->sSnowImagePath = Config::get('path.relative.root_to_image')
                . Config::get('path.folder.img_graph') . Config::get('meteo.graph.image.snow');
        $this->registry->template->sRainImagePath = Config::get('path.relative.root_to_image')
                . Config::get('path.folder.img_graph') . Config::get('meteo.graph.image.rain');
        $this->registry->template->sArrowImagePath = Config::get('path.relative.root_to_image')
                . Config::get('path.folder.img_graph') . Config::get('meteo.graph.image.arrow');
        
        $this->registry->template->sSkySunnyImagePath = Config::get('path.relative.root_to_image')
                . Config::get('path.folder.img_graph') . Config::get('meteo.graph.image.sky_sunny');
        $this->registry->template->sSkyFairImagePath = Config::get('path.relative.root_to_image')
                . Config::get('path.folder.img_graph') . Config::get('meteo.graph.image.sky_fair');
        $this->registry->template->sSkyMostlySunnyImagePath = Config::get('path.relative.root_to_image')
                . Config::get('path.folder.img_graph') . Config::get('meteo.graph.image.sky_mostly_sunny');
        $this->registry->template->sSkyPartlyCloudyImagePath = Config::get('path.relative.root_to_image')
                . Config::get('path.folder.img_graph') . Config::get('meteo.graph.image.sky_partly_cloudy');
        $this->registry->template->sSkyMostlyCloudyImagePath = Config::get('path.relative.root_to_image')
                . Config::get('path.folder.img_graph') . Config::get('meteo.graph.image.sky_mostly_cloudy');
        $this->registry->template->sSkyBrokenImagePath = Config::get('path.relative.root_to_image')
                . Config::get('path.folder.img_graph') . Config::get('meteo.graph.image.sky_broken');
        $this->registry->template->sSkyCloudyImagePath = Config::get('path.relative.root_to_image')
                . Config::get('path.folder.img_graph') . Config::get('meteo.graph.image.sky_cloudy');
        
        $this->registry->template->show('graph');
    }
    
	//for debug purpose
    public function log1( $data ){
        echo '<script>';
        echo 'console.log('. json_encode( $data ) .')';
        echo '</script>';
    }
    
    public function forecast()
    {
        $iNbDays = Config::get('meteo.limit.day.max');
        $sForecast = '';
        //$info = new addInfo($this->oMeteoCode);
        for($i = 0; $i < $iNbDays; $i++)
        {
            $sForecast .= '<tr>'
                    . '<td data-title="Day" data-original-translation>' . Date::getDisplayableDate(Date::getDateFromNow($i)) . '</td>'
                    . '<td data-title="Minimum">' . $this->getMinMaxTempOneDay('min',$i) . '</td>'
                    . '<td data-title="Maximum">' . $this->getMinMaxTempOneDay('max',$i) . '</td>'
                    //. '<td data-title="Information">' . /*eval("NP(D('le'),N('souris'))")*/ . /*$info->getAdditionalInfo()/* NP(D("le"),N("souris")) .*/ '</td>'
                    // Additional Information is generated in jsrealbLoaderFr.php
            		. '</tr>';
        }
        #$this->log1($this->oMeteoCode->getAirTemperatureList());
        #$this->log2($this->oMeteoCode->getAirTemperatureList()[0]);
        
        $this->registry->template->sForecast = $sForecast;
        //should Load JSrealB here
        $this->registry->template->show('forecast');
        
        //here we'll modify the json file for the realisations
        
        //MeteoRealisations!!
        $meteoReal = new MeteoRealisation($this->oMeteoCode);
        
        $meteoReal->updateMeteo();

    }
    
    //Should be a separate file
    public function getMinMaxTempOneDay($minOrMax, $day){
    	$aAirTemperatureList = $this->oMeteoCode->getAirTemperatureList();
    	
    	$oAirTemperature0 = $aAirTemperatureList[0];
    	$startDate = Date::getDisplayableHour($oAirTemperature0->getStartDate());
    	$firstDelay = (integer) substr($startDate, 0, 2);  
		
    	if(!empty($aAirTemperatureList))
    	{
    		$minTemp = null;
    		$maxTemp = null;
    		$i = ($day == 0)? 0 : (24-$firstDelay)+24*($day-1);
    		$tStop = (24-$firstDelay)+24*$day;
    		if($tStop > count($aAirTemperatureList)){$tStop = count($aAirTemperatureList);}
    		for(; $i < $tStop ; $i++)
    		{
    			$oAirTemperature = $aAirTemperatureList[$i];
    			$sDate = $oAirTemperature->getStartDate();
    			if($maxTemp == null){
    				$maxTemp = $oAirTemperature->getMaxValue();
    				$minTemp = $oAirTemperature->getMinValue();
    			}
    			else{
    				$max= $oAirTemperature->getMaxValue();
    				$min= $oAirTemperature->getMinValue();
    				if($max > $maxTemp){
    					$maxTemp = $max;
    				}
    				if($min < $minTemp){
    					$minTemp = $min;
    				}
    			}
    		} 		
    	}
        $tempUnit = $oAirTemperature0->getUnit();
        $tempUnitString = ($tempUnit == "celsius")?"°C":"°F";
    	if($minOrMax == 'min'){;
    		return $minTemp . " " . $tempUnitString;
    	}
    	else if($minOrMax == 'max'){
    		return $maxTemp . " " . $tempUnitString;
    	}
    	else{
    		return null;
    	}
    }
    
    
    

//     public function getAvCloudList($list,$day){ //works for cloud cover
//         $oList0 = $list[0];
//         $startDate = Date::getDisplayableHour($oList0->getStartDate());
//         $firstDelay = (integer) substr($startDate, 0, 2);
//         $avListAM = ();
//         $avListPM = ();
//         if(!empty($list)){
//             $cloud = null;
//             //$maxTemp = null;
//             $i = ($day == 0)? 0 : (24-$firstDelay)+24*($day-1);
//             $tStop = (24-$firstDelay)+24*$day;
//             if($tStop > count($list)){$tStop = count($list);}
//             for(; $i < $tStop ; $i++)
//             {
//                 $oItem = $list[$i];
//                 $cDate = $oItem->getStartDate();
//                 $cTime = Date::getDisplayableHour($cDate);
//                 $cTime = (integer) substr($cTime, 0, 2);                        
//                 if($cTime < 12){
//                     $avListAM[]= $oItem;
//                 }
//                 else{
//                     $avListPM[]= $oItem;
//                 }
//             }
//         }
//         $avAM = 0;
//         $avPM = 0;
//         $av = 0;
//         for($j=0;j<count($avListAM);j++){
//             $avAM += $avListAM[$j];
//         }
//         $av += $avAM; 
//         for($k=0;j<count($avListPM);k++){
//             $avPM += $avListPM[$j];
//         }
//         $av += $avPM;
//         //Moyennes
//         $av /= $k+$j;
//         $avAM /= $j;
//         $avPM /= $k;
//     }
}
?>
