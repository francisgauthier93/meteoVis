<?php

/**
 * Description of AirTemperature
 *
 * @author molinspa
 */
class AirTemperature
{
    private $sDate;
    private $sHour;
    private $fValue;
    private $sUnit;
    
    function __construct($sDate, $sHour, $fValue, $sUnit)
    {
        $this->sDate = $sDate;
        $this->sHour = $sHour;
        $this->fValue = $fValue;
        $this->sUnit = $sUnit;
    }

    function getDate()
    {
        return $this->sDate;
    }

    function getHour()
    {
        return $this->sHour;
    }

    function getValue()
    {
        return $this->fValue;
    }
    
    function getUnit()
    {
        return $this->sUnit;
    }
}
