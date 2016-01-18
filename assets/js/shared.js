// Annotator

function isString(x) {
    return x !== null &&
           x !== undefined && 
           x.constructor === String
}

function isLocal(){
    return (window.location.protocol == 'file:');
}

function init_common()
{
    $('.container').annotator()
                   .annotator('setupPlugins', null, {
                        Auth: { 
                            tokenUrl: 'http://reactor.barnahum.com/jwt/token.php'
                        },
                        Filter: true,
                        Permissions: false,
                        AnnotateItPermissions: {}
                });


    // version ajax

    var url  = 'http://reactor.barnahum.com/version.php';
 
    // call back function from url
    $.getJSON( url, function(data) {
        
                        if ( isString( data ) ){
                            
                            console.log( 'version data :' + data );
                            
                            if (data.length > 12){
                                data = data.substr(0,11)+'&hellip;';
                                console.log( 'version data shorten to :' + data );
                            }
                            
                            $('.version').text( data );
                        }
                    });
}

if (!isLocal()) init_common();