<?php

/**
 * Description of MeteoCode
 *
 * @author molinspa
 */
class MeteoCode
{

    private $aTemperatureList;
    private $aWindList;
    private $aAccumulationList;
    private $aCloudCoverList;
    private $aDayList;

    public function __construct($aTemperatureList, $aWindList, $aAccumulationList,
            $aCloudCoverList, $aDayList)
    {
        $this->aTemperatureList = $aTemperatureList;
        $this->aWindList = $aWindList;
        $this->aAccumulationList = $aAccumulationList;
        $this->aCloudCoverList = $aCloudCoverList;
        $this->aDayList = $aDayList;
    }

    public function getTemperatureList()
    {
        return $this->aTemperatureList;
    }

    public function getWindList()
    {
        return $this->aWindList;
    }

    public function getAccumulationList()
    {
        return $this->aAccumulationList;
    }

    public function getCloudCoverList()
    {
        return $this->aCloudCoverList;
    }

    public function getDayList()
    {
        return $this->aDayList;
    }
}
