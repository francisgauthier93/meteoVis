<?php

/**
 * Description of StrTest
 *
 * @author molinspa
 */
class StrTest extends PHPUnit_Framework_TestCase
{
    public function testStringBetween()
    {
        $sString1 = 'bonjour';
        $this->assertEquals(Str::getStringBetween($sString1, 'b', 'r'), 'onjou');
        $this->assertEquals(Str::getStringBetween($sString1, 'o', 'o'), 'nj');
        $this->assertEquals(Str::getStringBetween($sString1, 'b', 'k'), 'onjour');
        $this->assertEquals(Str::getStringBetween($sString1, 'z', 'k'), 'bonjour');
        $this->assertEquals(Str::getStringBetween($sString1, 'bo', 'ur'), 'njo');
        $this->assertEquals(Str::getStringBetween($sString1, '', 'onjour'), 'b');
        $this->assertEquals(Str::getStringBetween($sString1, 'bonjou', ''), 'r');
    }
}