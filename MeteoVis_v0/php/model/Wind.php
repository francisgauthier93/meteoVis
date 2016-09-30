<?php

/**
 * Description of Wind
 *
 * @author molinspa
 */
class Wind
{
    private $sStartDate;
    private $sEndDate;
    private $fMinSpeed;
    private $fMaxSpeed;
    private $sDirection;
    
    function __construct($sStartDate, $sEndDate, $fMinSpeed, 
            $fMaxSpeed, $sDirection)
    {
        $this->sStartDate = $sStartDate;
        $this->sEndDate = $sEndDate;
        $this->fMinSpeed = $fMinSpeed;
        $this->fMaxSpeed = $fMaxSpeed;
        $this->sDirection = $sDirection;
    }
    
    function getStartDate()
    {
        return $this->sStartDate;
    }

    function getEndDate()
    {
        return $this->sEndDate;
    }

    function getMinSpeed()
    {
        return $this->fMinSpeed;
    }

    function getMaxSpeed()
    {
        return $this->fMaxSpeed;
    }

    function getDirection()
    {
        return $this->sDirection;
    }
}
