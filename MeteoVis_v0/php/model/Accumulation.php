<?php

/**
 * Description of Accumulation
 *
 * @author molinspa
 */
class Accumulation
{
    private $sStartDate;
    private $sEndDate;
    private $fMinimumValue;
    private $fMaximumValue;
    private $fMinimumTotal;
    private $fMaximumTotal;
    private $sType;
    
    function __construct($sStartDate, $sEndDate, $fMinimumValue, $fMaximumValue,
            $fMinimumTotal, $fMaximumTotal, $sType)
    {
        $this->sStartDate = $sStartDate;
        $this->sEndDate = $sEndDate;
        $this->fMinimumValue = $fMinimumValue;
        $this->fMaximumValue = $fMaximumValue;
        $this->fMinimumTotal = $fMinimumTotal;
        $this->fMaximumTotal = $fMaximumTotal;
        $this->sType = $sType;
    }

    function getStartDate()
    {
        return $this->sStartDate;
    }

    function getEndDate()
    {
        return $this->sEndDate;
    }

    function getMinimumValue()
    {
        return $this->fMinimumValue;
    }

    function getMaximumValue()
    {
        return $this->fMaximumValue;
    }

    function getMinimumTotal()
    {
        return $this->fMinimumTotal;
    }

    function getMaximumTotal()
    {
        return $this->fMaximumTotal;
    }

    function getType()
    {
        return $this->sType;
    }
}
