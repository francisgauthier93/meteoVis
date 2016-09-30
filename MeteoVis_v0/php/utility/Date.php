<?php

/**
 * Description of Date
 *
 * @author molinspa
 */
class Date
{
    public static function setLocalTimeZoneFromZoneNameFr($sAbbrFr)
    {
        $aTranslateZoneNameFrToEn = array(
            'HNP' => 'PST',
            'HNR' => 'MST',
            'HNC' => 'CST',
            'HNE' => 'EST',
            'HNA' => 'AST',
            'HNT' => 'NST',
            'HAP' => 'PDT',
            'HAR' => 'MDT',
            'HAC' => 'CDT',
            'HAE' => 'EDT',
            'HAA' => 'ADT',
            'HAT' => 'NDT'
        );
        
        $sAbbrEn = isset($aTranslateZoneNameFrToEn[$sAbbrFr]) 
                ? $aTranslateZoneNameFrToEn[$sAbbrFr] : null;
        
        $sTimeZoneName = is_null($sAbbrEn) 
                ? DEFAULT_TIME_ZONE_NAME : timezone_name_from_abbr($sAbbrEn);
        
        date_default_timezone_set($sTimeZoneName);
    }
    
    /**
     * Use default time to get local date
     * @param type $sISO8601Date ISO Format
     * @return Locale Date
     */
    public static function getLocalISO8601($sISO8601Date)
    {
        $oDateTime = DateTime::createFromFormat(DateTime::ISO8601, $sISO8601Date);
        $oDateTime->setTimezone(new DateTimeZone(date_default_timezone_get()));
        return $oDateTime->format(DateTime::ISO8601);
    }
    
    /**
     * DateTime Format
     * @param $sISO8601Date Y-m-dTH:i:sZ
     */
    public static function getDateTimeFromISO8601($sISO8601Date)
    {
        $oDateTime = DateTime::createFromFormat(DateTime::ISO8601, $sISO8601Date);
        return $oDateTime->format(DATE_FORMAT_DATETIME);
    }
    
    /**
     * International Date Format
     * @param type $sDateTime Y-m-d H:i:s
     */
    public static function getDateInFromDateTime($sDateTime)
    {
        $oDateTime = DateTime::createFromFormat(DATE_FORMAT_DATETIME, $sDateTime);
        return $oDateTime->format('Y-m-d');
    }
    
    /**
     * International Hour Format
     * @param type $sDateTime Y-m-d H:i:s
     */
    public static function getHourInFromDateTime($sDateTime)
    {
        $oDateTime = DateTime::createFromFormat(DATE_FORMAT_DATETIME, $sDateTime);
        return $oDateTime->format('H:i:s');
    }
    
    /**
     * International Date Format
     * @expected $sISO8601Date Y-m-dTH:i:sZ
     */
    public static function getDateInFromISO8601($sISO8601Date)
    {
        $sDateTime = self::getDateTimeFromISO8601($sISO8601Date);
        return self::getDateInFromDateTime($sDateTime);
    }
    
    /**
     * International Hour Format
     * @expected $sISO8601Date Y-m-dTH:i:sZ
     */
    public static function getHourInFromISO8601($sISO8601Date)
    {
        $sDateTime = self::getDateTimeFromISO8601($sISO8601Date);
        return self::getHourInFromDateTime($sDateTime);
    }
    
    /**
     * Number of days between 2 dateTime
     * @param type $sDateTime1
     * @param type $sDateTime2
     * @return nb days
     */
    public static function getDateTimeDayDiff($sDateTime1, $sDateTime2)
    {
        $oDatetime1 = new DateTime($sDateTime1);
        $oDatetime2 = new DateTime($sDateTime2);
        $oInterval = $oDatetime1->diff($oDatetime2);
        return intval($oInterval->format('%a'));
    }
}
