<?php
    
$_REQUEST[ 'Access-Control-Allow-Origin' ] = '*';

set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
    
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
    $acao = isset($args[ 'Access-Control-Allow-Origin' ])?
                  $args[ 'Access-Control-Allow-Origin' ] : false;
    
    try{
        $html = file_get_contents( $uri );
    }
    catch( Exception $e ){
        $html = '';
        $err  = $e->getMessage();
    }
    
    $res = (object)[ 'q'    => $id,
                     'html' => $html,
                     'err'  => $err,
                     'Access-Control-Allow-Origin' => $acao ];

    return $res ;
}

$res = response();
    
if ( $res.Access-Control-Allow-Origin ){
    header("Access-Control-Allow-Origin: " . $res.Access-Control-Allow-Origin );
}

echo json_encode($res);
    
