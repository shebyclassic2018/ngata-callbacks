! function( t, e ) {
    "function" == typeof define && define.amd ? define( e ) : "object" == typeof exports ? module.exports = e() : t.ToastMaker = e()
}( this, function( t ) {
    return function( t, e, s ) {
        function i( t, e, s, i, n ) {
            var a = Array.isArray( t ) ? "array" : typeof t;
            if ( i && ( null == t || "" === t ) ) throw "Invalid argument '" + e + "'. Argument is either empty, null or undefined";
            if ( a !== s ) throw "Invalid argument '" + e + "'. Type must be " + s + " but found " + a;
            if ( n && -1 == n.indexOf( t ) ) throw "Invalid value " + t + " specified for argument '" + e + "'. Allowed - " + n.join( " | " )
        }
        i( t, "text", "string", !0 ), i( s = s || {}, "options", "object" ), i( e = e || 3e3, "timeout", "number" ), s.styles = s.styles || {}, i( s.styles, "styles", "object" ), s.align = s.align || "center", i( s.align, "align", "string", !0, [ "left", "center", "right" ] ), s.valign = s.valign || "bottom", i( s.valign, "valign", "string", !0, [ "top", "bottom" ] ), s.classList = s.classList || [], i( s.classList, "classList", "array" );
        var n = [ "toastmaker", "toastmaker-" + s.valign, "toastmaker-" + s.align ];
        s.classList = s.classList.concat( n );
        var a = document.createElement( "div" );
        s.classList.forEach( function( t ) {
            if ( "string" != typeof t ) throw "Invalid css class '" + JSON.stringify( t ) + "'. CSS class must be of type string";
            a.classList.add( t )
        } );
        var o = document.createTextNode( t );
        for ( var r in a.appendChild( o ), a.style.animationDuration = e / 1e3 + "s", s.styles ) {
            if ( "string" != typeof s.styles[ r ] && "number" != typeof s.styles[ r ] ) throw "Invalid value '" + JSON.stringify( s.styles[ r ] ) + "' specified for style '" + r + "'. Style value must be of type string or number";
            a.style[ r ] = s.styles[ r ]
        }
        document.body.appendChild( a ), setTimeout( function() {
            document.body.removeChild( a )
        }, e )
    }
} );