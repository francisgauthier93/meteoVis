<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
 xmlns:xd="http://www.oxygenxml.com/ns/doc/xsl"
 xmlns:pro="http://dd.weatheroffice.gc.ca/citypage_weather/docs/README_voicefile.txt"
 exclude-result-prefixes="xd"
    version="1.0">
    <xsl:param name="param" ></xsl:param>
 
 <xsl:template name="repeatAuthorDesc">
  <!-- Nombre de répétitions voulues -->
  <xsl:param name="repeatNum"/>
  <xsl:param name="doc_f"/>
  <xsl:param name="doc_e"/>
  <!-- Condition de non-arrêt de la récursion -->
  <xsl:if test="$repeatNum > 0">
   <!-- Faire -->
   <tr>
    <td><b> 
     <xsl:value-of select="$doc_f/siteData/forecastGroup[1]/forecast[($repeatNum)]/period[1]/@textForecastName"></xsl:value-of>
     <!--<xsl:value-of select="$doc_e/siteData/forecastGroup[1]/forecast[$repeatNum -1]/period[1]/@textForecastName"></xsl:value-of>-->
     :</b>
    
     
     
    </td>
    <td> 
     <!--Afficher les valeurs  de la temperature-->
     <xsl:for-each select="$doc_f/siteData/forecastGroup[1]/forecast[$repeatNum]/temperatures/temperature">
      
      <xsl:value-of select="@class"></xsl:value-of> :
      <xsl:value-of select="."></xsl:value-of><br/>
     </xsl:for-each>
    </td>
    <!--  Vent-->
    <td> 
     <xsl:for-each select="$doc_f/siteData/forecastGroup[1]/forecast[$repeatNum ]/winds/wind">
      <xsl:value-of select="speed"></xsl:value-of> 
      <xsl:value-of select="speed/@units"></xsl:value-of><br/>
      <xsl:value-of select="gust"></xsl:value-of>
      <xsl:value-of select="gust/@units"></xsl:value-of><br/>
      <xsl:value-of select="direction"></xsl:value-of>
     </xsl:for-each>
    </td>
    <!--  TOP-->
    <td> 
     <xsl:for-each select="$doc_f/siteData/forecastGroup[1]/forecast[$repeatNum]/precipitation/accumulation">
      <xsl:value-of select="name"></xsl:value-of> :
      <xsl:value-of select="amount"></xsl:value-of> 
      <xsl:value-of select="amount/@units"></xsl:value-of> 
      <br/>
     </xsl:for-each>
    </td>
    <!-- Affiche le résumé de la prévision -->
    <td><b>Fr: </b><xsl:value-of select="$doc_f/siteData/forecastGroup[1]/forecast[$repeatNum]/textSummary[1]"></xsl:value-of><br/>
     <b>En: </b><xsl:value-of select="$doc_e/siteData/forecastGroup[1]/forecast[$repeatNum]/textSummary[1]"></xsl:value-of>  </td>              
   </tr>
   
   <!-- Appeler la récursion suivante -->
   <xsl:call-template name="repeatAuthorDesc">
    <xsl:with-param name="repeatNum" select="$repeatNum - 1"/>
    <xsl:with-param name="doc_f" select="document('http://dd.weatheroffice.gc.ca/citypage_weather/xml/QC/s0000635_f.xml')" />
    <xsl:with-param name="doc_e" select="document('http://dd.weatheroffice.gc.ca/citypage_weather/xml/QC/s0000635_e.xml')" />
    
   </xsl:call-template>
  </xsl:if>
  
 </xsl:template>
    <xsl:template match="siteData">
    <table id="tabletext" border="1px" > 
    		<tr>
            <td><b>Jour</b></td>
            <td><b>Temp</b></td>
            <td><b>vent</b></td>
    		      <td><b>Précipitation</b></td>
            <td align="center"><b>Résumé</b></td>
            </tr>
     
     
     <xsl:call-template name="repeatAuthorDesc">
      <xsl:with-param name="repeatNum" select="8"/>
      <xsl:with-param name="doc_f" select="document('http://dd.weatheroffice.gc.ca/citypage_weather/xml/QC/s0000635_f.xml')" />
      <xsl:with-param name="doc_e" select="document('http://dd.weatheroffice.gc.ca/citypage_weather/xml/QC/s0000635_e.xml')" />
      
     </xsl:call-template>
     
     
     
     
    </table>
    </xsl:template>
</xsl:stylesheet>