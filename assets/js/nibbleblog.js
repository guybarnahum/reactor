function unescape( str ) {
    
    str = str.replace( /&lt;/g   , "<"  );
    str = str.replace( /&gt;/g   , ">"  );
    str = str.replace( /&quot;/g , '"'  );
    return str;
}

function nibbleblog_entries_to_tags_csv( data )
{
    var tags_csv = "";
    
    for(var ix=0; ix < data.length; ix++ ){
        
        var tags = data[ix].tags;
        for( var jx=0; jx< tags.length; jx++ ){
            var tag = tags[ jx ].name_human;
            if ( tags_csv.indexOf( tag ) == -1 ){
                tags_csv += tag + ",";
            }
        }
    }
    
    return tags_csv;
}

function nibbleblog_tags_csv_to_filter_html( tags_csv )
{
    var tags = tags_csv.split( ',' );
    if ( tags.length < 2 ) return '';
    
    var html  = "<ul class='isotope-filters small-screen-center'>\n";
        html += "   <li>\n";
        html += "       <a class='pseudo-border active' data-filter='*' href='#'>All</a>\n";
        html += "   </li>\n";

    for( var ix = 0 ; ix < tags.length; ix++ ){

        tag   = tags[ ix ];
        if ( tag == '') continue;

        html += "   <li>\n";
        html += "       <a class='pseudo-border' data-filter='." + tag + "' href='#'>" + tag + "</a>\n";
        html += "   </li>";
    }
        html += "</ul>\n";
    return html;
}

function nibbleblog_entry_to_html( entry )
{
    var title    = entry.title;
    var content  = unescape( entry.content );
    var category = entry.category;
    var url      = entry.url;
    var updated  = new Date( entry.updated ).toDateString();
    var tags     = entry.tags;
    var tags_str = '';
    
    for( var ix = 0; ix < tags.length; ix++ ){
        tags_str += tags[ ix ].name_human + ' ';
    }
    
    var html = "<!-- blog entry: " + title + " tags: " + tags_str + "-->" ;
    html += "<li class='col-xs-6 post-item isotope-item " + tags_str +"'>\n";
    html += "   <div class='grid-post swatch-white-red'>\n";
    html += "       <article class='post post-showinfo'>\n";
    html += "           <div class='post-media overlay'>\n";
    html += "               <a  class='feature-image magnific hover-animate'\n";
    html += "                   href='assets/images/design/vector/img-4-800x600.png'\n";
    html += "                   title='Thats a nice image'>\n";
    html += "                   <img alt='some image'\n";
    html += "                        src='assets/images/design/vector/img-4-800x600.png'>\n";
    html += "                   <i class='fa fa-search-plus'></i>\n";
    html += "               </a>\n";
    html += "           </div>\n";
    html += "           <div class='post-head small-screen-center'>\n";
    html += "               <h2 class='post-title'>\n";
    html += "                   <a href='#'>\n";
    html +=                         title;
    html += "                   </a>\n";
    html += "               </h2>\n";
    html += "               <small class='post-author'>\n";
    html += "                   <a href='#'>John Langan,</a>\n";
    html += "               </small>\n";
    html += "               <small class='post-date'>\n";
    html += "                   <a href='#'>"+updated+"</a>\n";
    html += "               </small>\n";
    html += "               <div class='post-icon flat-shadow flat-hex'>\n";
    html += "                   <div class='hex hex-big'>\n";
    html += "                       <i class='fa fa-camera'></i>\n";
    html += "                   </div>\n";
    html += "               </div>\n";
    html += "           </div>\n";
    html += "           <div class='post-body'>\n";
    html += "               <p>\n";
    html +=                     content;
    html += "               </p>\n";
    html += "               <a class='more-link' href='"+url+"'>\n";
    html += "                   read more\n";
    html += "               </a>\n";
    html += "           </div>\n";
    html += "           <div class='bordered post-extras text-center'>\n";
    html += "               <div class='text-center'>\n";
    html += "                   <span class='post-category'>\n";
    html += "                       <a href='"+url+"'>\n";
    html += "                           <i class='fa fa-folder-open'></i>\n";
    html += "                          "+category+"\n";
    html += "                       </a>\n";
    html += "                   </span>\n";
    
    if ( tags.length > 0 ){
        html += "                   <span class='post-tags'>\n";
        html += "                       <i class='fa fa-tags'></i>\n";
        for( var ix = 0 ; ix < tags.length; ix++ ){
            
            var tag_url  = tags[ ix ].url;
            var tag_name = tags[ ix ].name_human;
            
            html += "                       <a href='"+tag_url+"'>\n";
            html += "                       "+tag_name+"\n";
            html += "                       </a>\n";
        }
        html += "                   </span>\n";
    }
    
    html += "                   <span class='post-link'>\n";
    html += "                       <a href='"+url+"'>\n";
    html += "                           <i class='fa fa-comments'></i>\n";
    html += "                           2 comments\n";
    html += "                       </a>\n";
    html += "                   </span>\n";
    html += "               </div>\n";
    html += "           </div>\n";
    html += "       </article>\n";
    html += "   </div>\n";
    html += "</li>\n";
    
    return html;
}

function nibbleblog_entries_to_html( data )
{
    var html  = "<ul class='list-unstyled isotope no-transition row blog-entries'>\n";
    for( var ix = 0 ; ix < data.length; ix++ ){
        html += nibbleblog_entry_to_html( data[ ix ] );
    }
    html += "</ul>\n";
    
    return html;
}

function nibbleblog_to_html( obj )
{
    var entries  = obj.data;
    var tags_csv = nibbleblog_entries_to_tags_csv( entries );
    
    var html  = "<div class='container'>\n";
        html += nibbleblog_tags_csv_to_filter_html( tags_csv );
        html += nibbleblog_entries_to_html( entries );
        html += "<\div>\n";
    
    return html;
}

function init_blog()
{
    // blog entries ajax

    var url  = 'nibbleblog/json.php';
 
    // call back function from url
    $.getJSON( url,
            function(data) {
              var h = nibbleblog_to_html( data );
              $('.blog').html( h );
              
            });
}

init_blog();