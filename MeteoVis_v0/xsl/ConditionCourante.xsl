<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    
    <xsl:template match="siteData">
    <fieldset id="nom_ville">
        <xsl:value-of select="/siteData/location[1]/name[1]"></xsl:value-of>
        </fieldset>
        <br/>
        <h3> <xsl:value-of select="/siteData/currentConditions[1]/dateTime[2]/day[1]/@name"/> le <xsl:value-of select="/siteData/currentConditions[1]/dateTime[2]/textSummary[1]"/></h3>
    <xsl:variable name="icone" select="/siteData/currentConditions[1]/iconCode[1]"></xsl:variable>
    <xsl:variable name="condition" select="/siteData/currentConditions[1]/condition[1]"></xsl:variable>
    <xsl:variable name="temp" select="/siteData/currentConditions[1]/temperature[1]"></xsl:variable>
    
    <div id="currentcond">
        <div id="currentcond-left"><img id="currentimg" src="img/icones_png/{$icone}.png"   width="100" alt="{$condition}" title="{$condition}"></img>
            
            <p class="temperature"><xsl:value-of select="format-number($temp,'##0')"/><sup>
                <a href="/forecast/city_f.html?qc-147&amp;unit=i" title="Convertir en unités impériales">°C</a>
            </sup>
            </p>
        </div>
    </div>
    <div id="currentcond-content">
        <!--<div id="cityobserved">
            <dl>
                <dt>Enregistrées à: </dt>
                <dd>
                    <xsl:value-of select="/siteData/currentConditions[1]/station[1]"/>
                </dd>
                <dd class="dd1"></dd>
                <dt>Date: </dt>
                <dd>
                    <xsl:value-of select="/siteData/currentConditions[1]/dateTime[2]/textSummary[1]"/>
                </dd>
            </dl>
        </div>-->
        <div id="citycondition">
            <ul>
                <li class="leftList">
                    <dl class="leftCol">
                        <dt>Condition:</dt>
                        <dd>
                            <xsl:value-of select="$condition"/>
                        </dd>
                        <dd class="dd1"></dd>
                        <dt>Pression:</dt>
                        <dd>
                            <xsl:value-of select="/siteData/currentConditions[1]/pressure[1]"/>
                            <xsl:text> </xsl:text>
                            <xsl:value-of select="/siteData/currentConditions[1]/pressure[1]/@units"/>
                        </dd>
                        <dd class="dd1"></dd>
                        <dt>Tendance:</dt>
                        <dd>
                            <xsl:value-of select="/siteData/currentConditions[1]/pressure[1]/@tendency"/>
                        </dd>
                        <dd class="dd1"></dd>
                        <dd class="dd1"></dd>
                        <dt>Visibilité:</dt>
                        <dd>
                            <xsl:value-of select="/siteData/currentConditions[1]/visibility[1]"/> 
                            <xsl:text> </xsl:text>
                            <xsl:value-of select="/siteData/currentConditions[1]/visibility[1]/@units"/>
                        </dd>
                        <dd class="dd1"></dd>
                        
                        
                        <dd class="dd1"></dd> </dl>
                </li>
                <li class="rightList">
                    <dl class="rightCol">
                        <dt>Température:</dt>
                        <dd><xsl:value-of select="$temp"/>°C</dd>
                        <dd class="dd1"></dd>
                        <dt>Point de rosée:</dt>
                        <dd>
                            <xsl:value-of select="/siteData/currentConditions[1]/dewpoint[1]"/>
                            <xsl:text> °</xsl:text>
                            <xsl:value-of select="/siteData/currentConditions[1]/dewpoint[1]/@units"/>
                        </dd>
                        <dd class="dd1"></dd>
                        <dt>Humidité:</dt>
                        <dd>
                            <xsl:value-of select="/siteData/currentConditions[1]/relativeHumidity[1]"/> 
                            <xsl:text> </xsl:text>
                            <xsl:value-of select="/siteData/currentConditions[1]/relativeHumidity[1]/@units"/>
                        </dd>
                        <dd class="dd1"></dd>
                        <dt>Vent:</dt>
                        <dd class="longContent">
                            <xsl:value-of select="/siteData/currentConditions[1]/wind[1]/direction[1]"/>
                            <xsl:text> </xsl:text>
                            <xsl:value-of select="/siteData/currentConditions[1]/wind[1]/speed[1]"/>
                            <xsl:text> </xsl:text>
                            <xsl:value-of select="/siteData/currentConditions[1]/wind[1]/speed[1]/@units"/>
                        </dd>
                        <dd class="dd1"></dd>
                    </dl>
                </li>
                
            </ul>
        </div>
        
        
    </div>
    </xsl:template>
</xsl:stylesheet>