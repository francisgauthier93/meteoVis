<?php
function precipitation($x, $y,$from, $dur, $image)
{
		
return <<<PREC
	<image class="precipCond" x=$x y=$y width="9" height="9" xlink:href="img/svg/$image">
          <animate  attributeName="y" attributeType="XML" from="$from" to="300" begin="0s" dur="$dur" repeatCount="1500">
          </animate>
    </image>
	
PREC;
	
}
function cc($x,$image)
{
		
return <<<CC
	<image class="cloudCond" x=$x y="40" width="25" height="30" xlink:href="img/svg/$image"></image>
	
CC;
	
}
function acc($Mx, $L1x, $L2x, $L2y, $L3x, $L3y, $couleur, $datatitlefr, $datatitleen)
{
		
return <<<ACC
	
<path d="M $Mx 300 L $L1x 300 L $L2x $L2y L $L3x $L3y z" style="fill:$couleur" data-title="$datatitlefr" class="fr accumCond" />
<path d="M $Mx 300 L $L1x 300 L $L2x $L2y L $L3x $L3y z" style="fill:$couleur" data-title="$datatitleen" class="en accumCond" />
ACC;
	
}
?>