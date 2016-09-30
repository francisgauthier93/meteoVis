<?php

/**
 * Description of Conversion
 *
 * @author molinspa
 */
class Conversion
{
    private static function jsonpp($json, $html = false, $tabspaces = null)
    {
        $tabcount = 0;
        $result = '';
        $inquote = false;
		$inarray = false;
        $ignorenext = false;

        if ($html) {
            $tab = str_repeat("&nbsp;", ($tabspaces == null ? 4 : $tabspaces));
            $newline = "<br/>";
        } else {
            $tab = ($tabspaces === null ? "\t" : str_repeat(" ", $tabspaces));
            $newline = "\n";
        }

        for($i = 0; $i < strlen($json); $i++) {
            $char = $json[$i];

            if ($ignorenext) {
                $result .= $char;
                $ignorenext = false;
            } else {
                switch($char) {
                    case ':':
                        $result .= $char . (!$inquote ? " " : "");
                        break;
                    case '{':
                        if (!$inquote) {
                            $tabcount++;
                            $result .= $char . $newline . str_repeat($tab, $tabcount);
                        }
                        else {
                            $result .= $char;
                        }
                        break;
                    case '}':
                        if (!$inquote) {
                            $tabcount--;
                            $result = trim($result) . $newline . str_repeat($tab, $tabcount) . $char;
                        }
                        else {
                            $result .= $char;
                        }
                        break;
                    case ',':
                        if (!$inquote && !$inarray) {
                            $result .= $char . $newline . str_repeat($tab, $tabcount);
                        }
                        else {
                            $result .= $char;
                        }
                        break;
                    case '"':
                        $inquote = !$inquote;
                        $result .= $char;
                        break;
                    case '[':
                    case ']':
                        $inarray = !$inarray;
                        $result .= $char;
                        break;
                    case '\\':
                        if ($inquote) $ignorenext = true;
                        $result .= $char;
                        break;
                    default:
                        $result .= $char;
                }
            }
        }

        return $result;
    }

    public static function getJsonFromArray(array $aTarget, $bCompress = false)
    {
        // All PHP
        $sOptions = JSON_UNESCAPED_UNICODE;
        $sJsonContent = json_encode($aTarget, $sOptions);
        if(!$bCompress)
        {
            $sJsonContent = self::jsonpp($sJsonContent, false, 4);
        }
        
        // PHP 5.4
//        $sOptions = ($bCompress) ? JSON_UNESCAPED_UNICODE : (JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
//        $sJsonContent = json_encode($aTarget, $sOptions);
        
        // PHP 5.3
//        $sJsonContent = json_encode($aTarget, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        
        if(json_last_error() === JSON_ERROR_NONE 
//                && $sJsonContent !== false && !is_null($sJsonContent) && !empty($sJsonContent)
                )
        {
            return $sJsonContent;
        }
        else
        {
            throw new InvalidJsonException('Try to convert array to json');
        }
    }
    
    public static function getArrayFromJson($sJson)
    {
        $aArray = json_decode($sJson, true);

        if(json_last_error() === JSON_ERROR_NONE 
//                && $aArray !== false && !is_null($aArray) && is_array($aArray)
                )
        {
            return $aArray;
        }
        else
        {
            throw new InvalidJsonException('Try to convert json to array');
        }
    }
}