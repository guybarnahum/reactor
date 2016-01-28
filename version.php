<?php

function get_version( $touch = false )
{
    $ver   = @file_get_contents( __DIR__ . '/version.txt' );
    $build = @file_get_contents( __DIR__ . '/build.txt'   );
    
    $num = intval( $build ); // its 0 in case of missing or invalid value
    
    if ( $touch ){
        $num += 1;
        file_put_contents( __DIR__ . '/build.txt' , $num  );
    }
    
    return "$ver$num";
}
    
echo json_encode(get_version());
