<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <html>
      <head>
        <title>Sitemap Vertical Tree</title>
        <style>
          body { font-family: sans-serif; }
          .tree ul {
            list-style-type: none;
            padding-left: 40px;
            position: relative;
          }
          .tree ul::before {
            content: "";
            border-left: 1px solid #ccc;
            position: absolute;
            top: 0; bottom: 0; left: 15px;
          }
          .tree li {
            margin: 0;
            padding: 10px 5px 0 25px;
            position: relative;
          }
          .tree li::before {
            content: "";
            position: absolute;
            top: 15px; left: 0;
            width: 20px; border-top: 1px solid #ccc;
          }
          .node {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 5px 10px;
            border-radius: 6px;
            background: #f9f9f9;
            min-width: 200px;
          }
        </style>
      </head>
      <body>
        <h2>Sitemap Tree (Vertical)</h2>
        <div class="tree">
          <ul>
            <xsl:for-each select="urlset/url">
              <li>
                <div class="node">
                  <xsl:value-of select="loc"/>
                </div>
              </li>
            </xsl:for-each>
          </ul>
        </div>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>
