<?php

/**
 * Description of MeteoCodeFactory
 *
 * @author molinspa
 */
class MeteoCodeFactory
{
    public static function fromArray(array $aArrayTemperature, array $aArrayWind, 
            array $aArrayAccumulation, array $aArrayCloudCover)
    {        
        $aTemperatureList = self::createAirTemperatureObjectFromArray($aArrayTemperature);
        $aWindList = self::createWindObjectFromArray($aArrayWind);
        $aAccumulationList = self::createAccumulationObjectFromArray($aArrayAccumulation);
        $aCloudCoverList = self::createCloudCoverObjectFromArray($aArrayCloudCover);
//        var_dump($aWindList, $aAccumulationList);
        
        $aDayList = self::createDayList($aTemperatureList, $aWindList, 
                $aAccumulationList, $aCloudCoverList);
        
        $oMeteoCode = new MeteoCode($aTemperatureList, $aWindList, $aAccumulationList, 
                $aCloudCoverList, $aDayList);
        
        return $oMeteoCode;
    }
    
    private static function createDayList($aTemperatureList, $aWindList, 
            $aAccumulationList, $aCloudCoverList)
    {
        // init
        $sLastDate = '';
        $aDataPerDayList = array();
        for($i = 0; $i < MAX_NB_DAY; $i++)
        {
            $oCurrentDateTime = new DateTime();
            $oCurrentDateTime->setTimestamp(strtotime('+' . $i . ' day'));
            $sCurrentDate = Date::getDateInFromDateTime($oCurrentDateTime->format(DATE_FORMAT_DATETIME));
            $aDataPerDayList[$sCurrentDate] = array(
                    'temperature' => array(),
                    'wind' => array(),
                    'accumulation' => array(),
                    'cloudCover' => array()
                );
            $sLastDate = $sCurrentDate;
        }
        
        // sort data
        foreach($aTemperatureList as $oTemperature)
        {
            $sCurrentDate = $oTemperature->getDate();
            if(!empty($sCurrentDate) && ($sCurrentDate <= $sLastDate))
            {
                $aDataPerDayList[$sCurrentDate]['temperature'][] = $oTemperature;
            }
        }
        
        foreach($aCloudCoverList as $oCloudCovert)
        {
            $sCurrentDate = $oCloudCovert->getDate();
            if(!empty($sCurrentDate) && ($sCurrentDate <= $sLastDate))
            {
                $aDataPerDayList[$sCurrentDate]['cloudCover'][] = $oCloudCovert;
            }
        }
        
        // ATTENTION Si le vent ou accumulation a lieu sur plusieurs jours 
        // alors il ne sera pris en compte que pour le premier jour
        foreach($aWindList as $oWind)
        {
            $sCurrentDate = Date::getDateInFromDateTime($oWind->getStartDate());
            if(!empty($sCurrentDate) && ($sCurrentDate <= $sLastDate))
            {
                $aDataPerDayList[$sCurrentDate]['wind'][] = $oWind;
            }
        }
        
        foreach($aAccumulationList as $oAccumulation)
        {
            $sCurrentDate = Date::getDateInFromDateTime($oAccumulation->getStartDate());
            if(!empty($sCurrentDate) && ($sCurrentDate <= $sLastDate))
            {
                $aDataPerDayList[$sCurrentDate]['accumulation'][] = $oAccumulation;
            }
        }

        return self::dispatchDay($aDataPerDayList);
    }
    
    private static function dispatchDay(array $aDataPerDayList)
    {
        $iCurrentDayNumber = 0;
        $sPreviousDate = key($aDataPerDayList);
        $aDayList = array();
        foreach($aDataPerDayList as $sCurrentDate => $aDay)
        {
            if($sPreviousDate != $sCurrentDate)
            {
                $iCurrentDayNumber += Date::getDateTimeDayDiff($sPreviousDate, $sCurrentDate);
                $sPreviousDate = $sCurrentDate;
            }
            
            $aTemperatureList = $aDay['temperature'];
            $aWindList = $aDay['wind'];
            $aAccumulationList = $aDay['accumulation'];
            $aCloudCoverList = $aDay['cloudCover'];
            $sLabel = date('l', strtotime($sCurrentDate));
            $fMinimumTemperature = self::getMinimumAirTemperature($aTemperatureList);
            $fMaximumTemperature = self::getMaximumAirTemperature($aTemperatureList);

            $oDay = new Day($iCurrentDayNumber, $sLabel, $fMinimumTemperature,
                    $fMaximumTemperature, $aTemperatureList, $aWindList, 
                    $aAccumulationList, $aCloudCoverList, $sCurrentDate);

            $aDayList[] = $oDay;
        }
        
        return $aDayList;
    }
    
    private static function createAirTemperatureObjectFromArray(array $aArrayTemperature)
    {
        $aTemperatureList = array();
        foreach($aArrayTemperature as $aTemperature)
        {
            $sDate = Date::getDateInFromISO8601(
                    Date::getLocalISO8601($aTemperature['heure']));
            $sHour = Date::getHourInFromISO8601(
                    Date::getLocalISO8601($aTemperature['heure']));
            $aTemperatureList[] = new AirTemperature($sDate, $sHour, 
                    $aTemperature['temperature_air'], UNIT_CELSIUS);
        }
        
        return $aTemperatureList;
    }
    
    private static function createWindObjectFromArray(array $aArrayWind)
    {
        $aWindList = array();
        foreach($aArrayWind as $aWind)
        {
            $sStartDate = Date::getDateTimeFromISO8601(
                    Date::getLocalISO8601($aWind['start']));
            $sEndDate = Date::getDateTimeFromISO8601(
                    Date::getLocalISO8601($aWind['end']));
            $fMinSpeed = Number::getFloat($aWind['vitesse_min']);
            $fMaxSpeed = Number::getFloat($aWind['vitesse_max']);
            $sDirection = (empty($aWind['direction']) || is_null($aWind['direction'])) 
                    ? 'N/A' : $aWind['direction'];
            
            $aWindList[] = new Wind($sStartDate, $sEndDate, $fMinSpeed, 
                    $fMaxSpeed, $sDirection);
        }
        
        return $aWindList;
    }
    
    private static function createAccumulationObjectFromArray(array $aArrayAccumulation)
    {
        $aAccumulationList = array();
        foreach($aArrayAccumulation as $aAccumulation)
        {
            $sStartDate = Date::getDateTimeFromISO8601(
                    Date::getLocalISO8601($aAccumulation['start']));
            $sEndDate = Date::getDateTimeFromISO8601(
                    Date::getLocalISO8601($aAccumulation['end']));
            $fMinimumTotal = Number::getFloat($aAccumulation['acc_tot_min']);
            $fMaximumTotal = Number::getFloat($aAccumulation['acc_tot_max']);
            $fMinimumValue = Number::getFloat($aAccumulation['acc_hor_min']);
            $fMaximumValue = Number::getFloat($aAccumulation['acc_hor_max']);
            $sType = $aAccumulation['type_prec'];
            $aAccumulationList[] = new Accumulation($sStartDate, $sEndDate, 
                    $fMinimumValue, $fMaximumValue, $fMinimumTotal, $fMaximumTotal, $sType);
        }
        
        return $aAccumulationList;
    }
    
    private static function createCloudCoverObjectFromArray(array $aArrayCloudCover)
    {
        $aCloudCoverList = array();
        foreach($aArrayCloudCover as $aCloudCover)
        {
            $sDate = Date::getDateInFromISO8601(
                    Date::getLocalISO8601($aCloudCover['valid_time']));
            $sHour = Date::getHourInFromISO8601(
                    Date::getLocalISO8601($aCloudCover['valid_time']));
            $iValue = Number::getInt($aCloudCover['cloudCover']);
            $aCloudCoverList[] = new CloudCover($sDate, $sHour, $iValue);
        }
        
        return $aCloudCoverList;
    }
    
    private static function getMinimumAirTemperature(array $aTemperatureList)
    {
        $fMinimumTemperature = null;
        if(!empty($aTemperatureList))
        {
            $fMinimumTemperature = $aTemperatureList[0]->getValue();
            foreach($aTemperatureList as $oTemperature)
            {
                if($oTemperature->getValue() < $fMinimumTemperature)
                {
                    $fMinimumTemperature = $oTemperature->getValue();
                }
            }
        }
        
        return $fMinimumTemperature;
    }
    
    private static function getMaximumAirTemperature(array $aTemperatureList)
    {
        $fMaximumTemperature = null;
        if(!empty($aTemperatureList))
        {
            $fMaximumTemperature = $aTemperatureList[0]->getValue();
            foreach($aTemperatureList as $oTemperature)
            {
                if($oTemperature->getValue() > $fMaximumTemperature)
                {
                    $fMaximumTemperature = $oTemperature->getValue();
                }
            }
        }
        
        return $fMaximumTemperature;
    }
}