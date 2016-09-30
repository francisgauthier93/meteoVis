<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
    version="1.0">
<xsl:output method="html" encoding="UTF-8" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
    <xsl:param name="province"></xsl:param>
    <xsl:param name="ville"></xsl:param>  
    <xsl:template match="siteList">
        
         <xsl:for-each select= "site">
            <xsl:if test=" starts-with($province, province/@en)">
                <xsl:if test="starts-with($ville, city/@en)">
                    <xsl:variable name="meteocode02" select="meteocode02/@id"></xsl:variable>
                    <xsl:variable name="meteocode37" select="meteocode37/@id"></xsl:variable>
                    <xsl:variable name="province" select="meteocode37/@dir"></xsl:variable>
                    <xsl:variable name="code" select="region/@code"></xsl:variable>
                 
                    <FORM method="post" action="php/csv_bd.php">
                        <input name="id02" type="hidden" value="{$meteocode02}"/> 
                        <input name="id37" type="hidden" value="{$meteocode37}"/> 
                        <input name="province" type="hidden" value="{$province}"/>
                        <input name="code" type="hidden" value="{$code}"/>
                        <!--<input type="submit" accept="true"  value="OK"/>-->
                    </FORM>
            </xsl:if>
            </xsl:if>
        </xsl:for-each>
        
    </xsl:template>
</xsl:stylesheet>