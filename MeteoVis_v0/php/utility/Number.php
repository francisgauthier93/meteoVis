<?php

/**
 * Description of Number
 *
 * @author molinspa
 */
class Number
{
    /**
     * Integer
     */
    public static function getInt($uValue)
    {
        return intval($uValue);
    }
    
    public static function getDisplayableInt($uValue)
    {
        return number_format(self::getInt($uValue), 0, '.', ' ');
    }
    
    /**
     * Float
     */
    public static function getFloat($uValue)
    {
        return floatval($uValue);
    }
    
    public static function getDisplayableFloat($uValue)
    {
        return number_format(self::getFloat($uValue), 2, '.', ' ');
    }
}
