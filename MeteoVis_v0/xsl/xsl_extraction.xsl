<?xml version="1.0" encoding="UTF-8"?><!-- DWXMLSource="http://dd.weatheroffice.gc.ca/citypage_weather/xml/QC/s0000635_f.xml" -->
<!DOCTYPE xsl:stylesheet  [
	<!ENTITY nbsp   "&#160;">
	<!ENTITY copy   "&#169;">
	<!ENTITY reg    "&#174;">
	<!ENTITY trade  "&#8482;">
	<!ENTITY mdash  "&#8212;">
	<!ENTITY ldquo  "&#8220;">
	<!ENTITY rdquo  "&#8221;"> 
	<!ENTITY pound  "&#163;">
	<!ENTITY yen    "&#165;">
	<!ENTITY euro   "&#8364;">
]>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<xsl:output method="html" encoding="UTF-8" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:param name="doc37"></xsl:param>
<xsl:param name="doc02"></xsl:param>
    <xsl:template match="cmml">
   
        <xsl:variable name="code" select="r71.1"></xsl:variable>
       <html>
            <head>
            <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
            <title></title>
           
          
            </head>
        <body>
  
            
                <!--*************** cloud cover************-->
                    <xsl:call-template name="cloudCover">   
                        <xsl:with-param name="doc" select="$doc02"></xsl:with-param>
                    </xsl:call-template> 
            <xsl:call-template name="cloudCover">   
                <xsl:with-param name="doc" select="$doc37"></xsl:with-param>
            </xsl:call-template> 
               
               <!-- ***********Precipitation event********** -->
                    <xsl:call-template name="PrecipitationEvent">    
                        <xsl:with-param name="doc" select="$doc02"></xsl:with-param>
                    </xsl:call-template> 
            <xsl:call-template name="PrecipitationEvent">    
                <xsl:with-param name="doc" select="$doc37"></xsl:with-param>
            </xsl:call-template> 
                
                <!-- ***********probability of precipitation********** -->
                    <xsl:call-template name="pop">       
                        <xsl:with-param name="doc" select="$doc02"></xsl:with-param>
                    </xsl:call-template> 
            <xsl:call-template name="pop">       
                <xsl:with-param name="doc" select="$doc37"></xsl:with-param>
            </xsl:call-template> 
                <!-- ***********Acumulation List********** -->
                    <xsl:call-template name="acc">  
                        <xsl:with-param name="doc" select="$doc02"></xsl:with-param>
                    </xsl:call-template>
            <xsl:call-template name="acc">  
                <xsl:with-param name="doc" select="$doc37"></xsl:with-param>
            </xsl:call-template>
                <!--****************** Temperature *************-->
                    <xsl:call-template name="temperature"> 
                        <xsl:with-param name="doc" select="$doc02"></xsl:with-param>
                    </xsl:call-template> 
            <xsl:call-template name="temperature"> 
                <xsl:with-param name="doc" select="$doc37"></xsl:with-param>
            </xsl:call-template> 
                <!--****************** Vent *************-->
                    <xsl:call-template name="vent">
                        <xsl:with-param name="doc" select="$doc02"></xsl:with-param>
                    </xsl:call-template> 
            <xsl:call-template name="vent">
                <xsl:with-param name="doc" select="$doc37"></xsl:with-param>
            </xsl:call-template> 
                <!--****************** visibility-list *************-->
                    <xsl:call-template name="visibility">    
                        <xsl:with-param name="doc" select="$doc02"></xsl:with-param>
                    </xsl:call-template>
            <xsl:call-template name="visibility">    
                <xsl:with-param name="doc" select="$doc37"></xsl:with-param>
            </xsl:call-template>
            
                
            
       <!-- <FORM NAME="Choix" id="listejour" method="post" action="index.php">
        
      <input type="submit" name="bouton" />-->
     <!-- </FORM>-->
        </body>
        </html>
    </xsl:template>
    <!-- ******************************************************************-->
    <xsl:template name="cloudCover">
        <xsl:param name="doc" select="0"></xsl:param>
        <xsl:variable name="meteocode" select="document($doc)"></xsl:variable>
        <table border="2px">
        <xsl:for-each select="$meteocode/cmml/data/forecast/meteocode-forecast">
            <xsl:if test=" location/msc-zone-code='r71.1'">
               
                    <tr>
                        <td><font color="blue">msc-zone-name lang="fr"</font></td>
                        <td><xsl:value-of select="location/msc-zone-name"/></td>
                        <td><font color="blue">msc-zone-code</font></td>
                        <td><xsl:value-of select="location/msc-zone-code"/></td>
                    </tr>
            <xsl:for-each select="parameters/cloud-list/cloud-cover">
            <tr>
                <td><font color="blue">cloud-list units="deci"</font></td>
                <xsl:for-each select="current()/@*">
                    <td>
                        <font color="red"><xsl:value-of select="name()"/></font>
                        <xsl:value-of select="."/>
                    </td>
                </xsl:for-each>
                <td align="center"><b><xsl:value-of select="."/></b></td>
            </tr>
            </xsl:for-each>
               </xsl:if>
        </xsl:for-each>
           
        </table>
    </xsl:template>
    <!-- **************************************************************** -->
    <xsl:template name="PrecipitationEvent">
        <xsl:param name="doc"></xsl:param>
        <xsl:variable name="meteocode" select="document($doc)"></xsl:variable>
        <table border="2px">
            <xsl:for-each select="$meteocode/cmml/data/forecast/meteocode-forecast">
                <xsl:if test=" location/msc-zone-code='r71.1'">
        <xsl:for-each select="parameters/precipitation-list/precipitation-event">
            <tr>
                <td><font color="blue">precipitation-event</font></td>
                <xsl:for-each select="current()/@*">
                    <td>
                        <font color="red"><xsl:value-of select="name()"/></font>
                        <xsl:value-of select="."/>
                    </td>
                </xsl:for-each>
                <td align="center"><b><xsl:value-of select="."/></b></td>
                
            </tr>
        </xsl:for-each>
                </xsl:if>
            </xsl:for-each>
            
        </table>
    </xsl:template>
    <!-- **************************************************************** -->
    <xsl:template name="pop">
        <xsl:param name="doc"></xsl:param>
        <xsl:variable name="meteocode" select="document($doc)"></xsl:variable>
        <table border="2px">
            <xsl:for-each select="$meteocode/cmml/data/forecast/meteocode-forecast">
                <xsl:if test=" location/msc-zone-code='r71.1'">
                <xsl:for-each select="parameters/probability-of-precipitation-list/probability-of-precipitation">
            <tr>
                <td><font color="blue">probability-of-precipitation</font></td>
                <xsl:for-each select="current()/@*">
                    <td>
                        <font color="red"><xsl:value-of select="name()"/></font>
                        <xsl:value-of select="."/>
                    </td>
                </xsl:for-each>
                <td align="center"><b><xsl:value-of select="."/></b></td>
                
            </tr>
                </xsl:for-each>
                </xsl:if>
            </xsl:for-each>
        </table>
    </xsl:template>
    <!-- **************************************************************** -->
    <xsl:template name="acc">
        <xsl:param name="doc"></xsl:param>
        <xsl:variable name="meteocode" select="document($doc)"></xsl:variable>
        <table border="2px">
            <xsl:for-each select="$meteocode/cmml/data/forecast/meteocode-forecast">
                <xsl:if test=" location/msc-zone-code='r71.1'">
                    
                <xsl:for-each select="parameters/accum-list/accum-amount">
            <tr>
                <td><font color="blue">accum-list</font></td>
                <td><font color="red">lower-limit :</font><xsl:value-of select="lower-limit"/></td>
                <td><font color="red">upper-limit :</font><xsl:value-of select="upper-limit"/></td>
                
                    <xsl:for-each select="current()/@*">
                    <td>
                        <font color="red"><xsl:value-of select="name()"/></font>
                        <xsl:value-of select="."/>
                    </td>
                    </xsl:for-each>
            </tr>
                </xsl:for-each>
                </xsl:if>
            </xsl:for-each>
        </table>
    </xsl:template>
    <!-- **************************************************************** -->
    <xsl:template name="temperature">
        <xsl:param name="doc"></xsl:param>
        <xsl:variable name="meteocode" select="document($doc)"></xsl:variable>
        <table border="2px">
            <xsl:for-each select="$meteocode/cmml/data/forecast/meteocode-forecast">
                <xsl:if test=" location/msc-zone-code='r71.1'">
                    
                <xsl:for-each select=" parameters/temperature-list">
            <tr>
                <td><font color="blue">temperature-list</font></td>
                <td>type: <xsl:value-of select="@type"/></td>
            </tr>
                <xsl:if test="@type='air' or @type='dew-point'">
                <xsl:for-each select="temperature-value">
                    <tr>
                        <xsl:for-each select="current()/@*">
                            <td>
                                <font color="red"><xsl:value-of select="name()"/></font>
                                <xsl:value-of select="."/>
                            </td>
                        </xsl:for-each>
                        
                        <td><font color="red">lower-limit :</font><xsl:value-of select="lower-limit"/></td>
                        <td><font color="red">upper-limit :</font><xsl:value-of select="upper-limit"/></td>
                    </tr> 
                </xsl:for-each>
                </xsl:if>
                <xsl:if test="@type='climatology' or @type='sea-surface'">
                <xsl:for-each select="temperature-value">
                    <tr>
                        <xsl:for-each select="current()/@*">
                            <td>
                                <font color="red"><xsl:value-of select="name()"/></font>
                                <xsl:value-of select="."/>
                            </td>
                        </xsl:for-each>
                        
                        <td> <xsl:value-of select="."/></td>
                    </tr> 
                </xsl:for-each>
                </xsl:if>
            </xsl:for-each>
                </xsl:if>
            </xsl:for-each>
        </table>
    </xsl:template>
    <!-- **************************************************************** -->
    <xsl:template name="vent">
        <xsl:param name="doc"></xsl:param>
        <xsl:variable name="meteocode" select="document($doc)"></xsl:variable>
        <table border="2px">
            <xsl:for-each select="$meteocode/cmml/data/forecast/meteocode-forecast">
                <xsl:if test=" location/msc-zone-code='r71.1'">
                    
            <xsl:for-each select="parameters/wind-list/wind">
            <tr>
                <td><font color="blue">Vent</font></td>
                <xsl:for-each select="current()/@*">
                    <td>
                        <font color="red"><xsl:value-of select="name()"/></font>
                        <xsl:value-of select="."/>
                    </td>
                </xsl:for-each>
            </tr>
            <tr>
                <td><font color="green">wind speed</font></td>
                <td><font color="red">lower-limit :</font><xsl:value-of select=" wind-speed/lower-limit"/></td>
                <td><font color="red">upper-limit :</font><xsl:value-of select=" wind-speed/upper-limit"/></td>
            </tr>
            <tr>
                <td><font color="green">gust speed</font></td>
                <td><font color="red">lower-limit :</font><xsl:value-of select=" wind-speed/lower-limit"/></td>
                <td><font color="red">upper-limit :</font><xsl:value-of select=" wind-speed/upper-limit"/></td>
            </tr>
        </xsl:for-each>
                </xsl:if>
            </xsl:for-each>
        </table>
    </xsl:template>
    <!-- **************************************************************** -->
    <xsl:template name="visibility">
        <xsl:param name="doc"></xsl:param>
        <xsl:variable name="meteocode" select="document($doc)"></xsl:variable>
        <table border="2px">
            <xsl:for-each select="$meteocode/cmml/data/forecast/meteocode-forecast">
                <xsl:if test=" location/msc-zone-code='r71.1'">
                <xsl:for-each select="parameters/visibility-list">
            <tr>
                <td><font color="blue">visibility</font></td>
                <xsl:for-each select="current()/@*">
                    <td>
                        <font color="red"><xsl:value-of select="name()"/></font>
                        <xsl:value-of select="."/>
                    </td>
                </xsl:for-each>
                <td> <xsl:value-of select="."/></td>
            </tr>
        </xsl:for-each>
                </xsl:if>
            </xsl:for-each>
        </table>
    </xsl:template>
</xsl:stylesheet>