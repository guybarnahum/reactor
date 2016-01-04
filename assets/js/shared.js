// Annotator

$('.container').annotator()
               .annotator('setupPlugins', null, {
                    Auth: { 
                        tokenUrl: 'http://reactor.barnahum.com/jwt/token.php'
                    },
                    Filter: false,
                    Permissions: false,
                    AnnotateItPermissions: {}
            });

function isString(x) {
    return x !== null &&
           x !== undefined && 
           x.constructor === String
}

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
