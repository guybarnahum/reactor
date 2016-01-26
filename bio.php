<?php


function id_to_uri( $id )
{
    $uri = 'bios/' . $id;
    return $uri;
}
    
// ..................................................................... get_bio
    
function get_bio_html( $id )
{
    
    return $html;
}

// .................................................................... response
function response()
{
    $args = $_REQUEST;

    $dbg  = isset( $args[ 'debug' ] );
    
    $id   = isset( $args[ 'q' ] )? $args[ 'q' ] : 'none';
    $uri  = id_to_uri( $id );
    $err  = 'ok';
    
    try{
        $html = file_get_contents( $uri );
    }
    catch( Exception $e ){
        $html = '';
        $err  = $e->getMessage();
    }
    
    $res = (object)[ 'q' => $id, 'html'=> $html, 'err'=> $err ];

    return json_encode( $res );
}

echo response();
