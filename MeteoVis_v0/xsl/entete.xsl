<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
    <xsl:param name="fichieren" />
    <xsl:variable name="doc" select="document($fichieren)"></xsl:variable>
    <xsl:variable name="nomVilleen" select="$doc/siteData/location[1]/name[1]"/>
    <xsl:variable name="dateen" select="$doc/siteData/currentConditions[1]/dateTime[2]/textSummary[1]"></xsl:variable>
    <xsl:template match="siteData">
        <xsl:variable name="icone" select="/siteData/currentConditions[1]/iconCode[1]"></xsl:variable>
        <xsl:variable name="icone_extension" select="/siteData/currentConditions[1]/iconCode[1]/@format"></xsl:variable>
        <xsl:variable name="condition" select="/siteData/currentConditions[1]/condition[1]"></xsl:variable>
        <xsl:variable name="temp" select="/siteData/currentConditions[1]/temperature[1]"></xsl:variable>
        
        <!-- ***************************************** -->
        <!-- *      condition courante               * -->    
        <!-- ***************************************** -->
        
        <!-- entête -->    
        <xsl:choose>
            <xsl:when test="$icone !=''">
                <div class="col-sm-2">
                <img class="pull-left" src="img/icones_{$icone_extension}/{$icone}.{$icone_extension}" width="70px" title="{$condition}" alt="{$condition}"/>
                </div>
                <div class="col-sm-8">
                    <h1><small class="celsius"><xsl:value-of select="$temp"/></small> 
                        <span class="fr"><xsl:text>  </xsl:text><xsl:value-of select="/siteData/location[1]/name[1]"></xsl:value-of></span>

                        <span class="en"><xsl:text>  </xsl:text><xsl:value-of select="$nomVilleen"></xsl:value-of></span> 
                        <small>
                            <span class="fr"><xsl:text>  </xsl:text><xsl:value-of select="/siteData/currentConditions[1]/dateTime[2]/day[1]/@name"/> </span>
                            <xsl:text>  </xsl:text>
                            <span class="fr"><xsl:value-of select="/siteData/currentConditions[1]/dateTime[2]/textSummary[1]"/></span>
                            <span class="en"><xsl:value-of select="$dateen"/></span> 

                        </small>
                    </h1>
                </div>
            </xsl:when>

            <xsl:otherwise>
                <div class="col-sm-2">
                    <font COLOR="#CDC9C9"><h1 class="celsius"><xsl:value-of select="$temp"/></h1> </font>
                </div>
                <div class="col-sm-8">
                    <h1>
                        <span class="fr"><xsl:text>  </xsl:text><xsl:value-of select="/siteData/location[1]/name[1]"></xsl:value-of></span>
                        <span class="en"><xsl:text>  </xsl:text><xsl:value-of select="$nomVilleen"></xsl:value-of></span> 
                        <small>
                            <span class="fr"><xsl:text>  </xsl:text><xsl:value-of select="/siteData/currentConditions[1]/dateTime[2]/day[1]/@name"/> </span>
                            <xsl:text>  </xsl:text>
                            <span class="fr"><xsl:value-of select="/siteData/currentConditions[1]/dateTime[2]/textSummary[1]"/></span>
                            <span class="en"><xsl:value-of select="$dateen"/></span> 
                        </small>
                    </h1>
                </div>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
</xsl:stylesheet>