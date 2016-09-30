<?php

function tag($tag, $body, $attrs = "")
{
    if(is_array($attrs))
    {
        $res = "";
        foreach($attrs as $key => $value)
        {
            $res = $res . " " . $key . "='" . $value . "'";
        }
        $attrs = $res;
    }
    echo "<$tag" . ($attrs ? " " : "") . "$attrs>$body</$tag>";
}

function tagwb($tag, $attrs = "")
{
    return tag($tag, "", $attrs);
}

function line($attrs = "")
{
    return tagwb("line", $attrs);
}

function rect($attrs = "")
{
    return tagwb("rect", $attrs);
}

function text($body, $attrs = "")
{
    return tag("text", $body, $attrs);
}

function circle($attrs = "")
{
    return tagwb("circle", $attrs);
}

function image($attrs = "")
{
    return tagwb("image", $attrs);
}

function input($attrs = "")
{
    return tagwb("input", $attrs);
}

function path($attrs = "")
{
    return tagwb("path", $attrs);
}

?>
