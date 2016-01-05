<?php

/*
 Make sure this file is set as DirectoryIndex in .htaccess
 DirectoryIndex __FILE__
*/


Header( "HTTP/1.1 301 Moved Permanently" );
Header( "Location: http://reactor.barnahum.com/index-alt.html" );
?>