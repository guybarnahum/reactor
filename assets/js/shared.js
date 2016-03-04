

function init_shared()
{
    if ($('.container').annotator ){
        $('.container').annotator()
                       .annotator('setupPlugins', null, {
                            Auth: { 
                                tokenUrl: 'jwt/token.php'
                            },
                            Filter: false,
                            Permissions: false,
                            AnnotateItPermissions: {}
                    });
    }


    // version ajax

    var url  = 'version.php';
 
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

init_shared();

// ................................................... Page Visibility API setup

var hidden, visibilityChange;

function init_page_visibility_api( callback )
{
    // Set the name of the hidden property and the change event for visibility
    if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support
        hidden = "hidden";
        visibilityChange = "visibilitychange";
    } else if (typeof document.mozHidden !== "undefined") {
        hidden = "mozHidden";
        visibilityChange = "mozvisibilitychange";
    } else if (typeof document.msHidden !== "undefined") {
        hidden = "msHidden";
        visibilityChange = "msvisibilitychange";
    } else if (typeof document.webkitHidden !== "undefined") {
        hidden = "webkitHidden";
        visibilityChange = "webkitvisibilitychange";
    }
}

function set_page_visible_callback( callback )
{
    var ok = (typeof document.addEventListener !== "undefined" ) &&
             (typeof document[hidden]          !== "undefined" )  ;
    
    if (ok){
        document.addEventListener(visibilityChange, callback, false);
    }
    
    return ok;
}

// Helper routine for callback
function isPageHidden()
{
    var dh;
    if ( typeof document[hidden] !== "undefined" ){
        dh = document[hidden];
    }
    
    return dh; // maybe undefined!
}

init_page_visibility_api();

