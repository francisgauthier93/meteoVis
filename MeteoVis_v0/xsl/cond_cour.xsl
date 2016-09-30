<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:param name="fichieren" />
    <xsl:variable name="doc" select="document($fichieren)"></xsl:variable>
    <xsl:variable name="conditionen" select="$doc/siteData/currentConditions[1]/condition[1]"/>
    <xsl:variable name="venten" select="$doc/siteData/currentConditions[1]/wind[1]/direction[1]"></xsl:variable>
    <xsl:template match="siteData">
    <xsl:variable name="icone" select="/siteData/currentConditions[1]/iconCode[1]"></xsl:variable>
    <xsl:variable name="condition" select="/siteData/currentConditions[1]/condition[1]"></xsl:variable>
    <xsl:variable name="temp" select="/siteData/currentConditions[1]/temperature[1]"></xsl:variable>
    <!-- ***************************************** -->
    <!-- *      condition courante               * -->    
    <!-- ***************************************** -->
           
            <!-- Conditions courantes -->
            
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <table class="table table-condensed">
                        <colgroup>
                            <col style="width:50%"/>
                            <col style="width:50%"/>
                        </colgroup>
                        <tbody>
                            <tr><th>Condition</th>
                                <td><span class="fr"> <xsl:value-of select="$condition"/></span><span class="en"><xsl:value-of select="$conditionen"/></span></td>
                            </tr>
                            <tr><th><span class="fr">Pression</span><span class="en">Pressure</span></th><td><xsl:value-of select="/siteData/currentConditions[1]/pressure[1]"/> kPa</td></tr>
                            <tr><th><span class="fr">Tendance</span><span class="en">Tendency</span></th>
                                <td><span class="fr"><xsl:value-of select="/siteData/currentConditions[1]/pressure[1]/@tendency"/></span><span class="en">going down</span></td>
                            </tr>
                            <tr><th><span class="fr">Visibilité</span><span class="en">Visibiliy</span></th><td>
                                <xsl:if test="/siteData/currentConditions[1]/visibility[1] !=''">
                
                                    <xsl:value-of select="/siteData/currentConditions[1]/visibility[1]"/>  km
                            </xsl:if>
                            </td></tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <table class="table table-condensed">
                        <colgroup>
                            <col style="width:50%"/>
                            <col style="width:50%"/>
                        </colgroup>
                        <tbody>
                            <tr><th><span class="fr">Température</span><span class="en">Temperature</span></th><td class="celsius"><xsl:value-of select="$temp"/></td></tr>
                            <tr><th><span class="fr">Point de rosée</span><span class="en">Dewpoint</span></th><td class="celsius"><xsl:value-of select="/siteData/currentConditions[1]/dewpoint[1]"/></td></tr>
                            <tr><th><span class="fr">Humidité</span><span class="en">Humidity</span></th><td><xsl:value-of select="/siteData/currentConditions[1]/relativeHumidity[1]"/>  %</td></tr>
                            <tr><th><span class="fr">Vent</span><span class="en">Wind</span></th>
                                <td><span class="fr"><xsl:value-of select="/siteData/currentConditions[1]/wind[1]/direction[1]"/><xsl:text> </xsl:text></span><span class="en"><xsl:value-of select="$venten"/> <xsl:text> </xsl:text></span> <xsl:value-of select="/siteData/currentConditions[1]/wind[1]/speed[1]"/> km/h</td></tr>
                        </tbody>
                    </table>
                </div>
        
       
    </xsl:template>
</xsl:stylesheet>