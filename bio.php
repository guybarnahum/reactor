<?php


function id_to_uri( $id )
{
    $uri = 'bios/' . $id;
    return $uri;
}
    
// ..................................................................... get_bio
    
function get_bio_html( $id )
{
    $uri  = id_to_uri( $id );
    $html = ( $uri !== false )? file_get_contents( $uri ) : '';
    
    return $html;
}

// .................................................................... response
function response()
{
    $args = $_REQUEST;

    $dbg  = isset( $args[ 'debug' ] );
    
    $id   = isset( $args[ 'q' ] )? $args[ 'q' ] : 'none';
    $html = get_bio_html( $id );


    if ( $dbg ){
        echo '<pre>' . print_r( $html, true ) . '</pre>' ;
    }
    
    $res = (object)[ 'q' => $id, 'html'=> $html ];

    return json_encode( $res );
}

echo response();
