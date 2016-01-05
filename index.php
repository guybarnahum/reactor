<?php

/*
 Make sure this file is set as DirectoryIndex in .htaccess
 DirectoryIndex __FILE__
*/

$host=$_SERVER[ 'HTTP_HOST' ];
    
Header( "HTTP/1.1 301 Moved Permanently" );
Header( "Location: http://$host/index-alt.html" );
?>