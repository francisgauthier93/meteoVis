<?php

/**
 * Description of CloudCover
 *
 * @author molinspa
 */
class CloudCover
{
    private $sDate;
    private $sHour;
    private $iValue;
    
    function __construct($sDate, $sHour, $iValue)
    {
        $this->sDate = $sDate;
        $this->sHour = $sHour;
        $this->iValue = $iValue;
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
        return $this->iValue;
    }
}
