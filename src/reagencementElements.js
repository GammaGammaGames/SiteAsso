function test()
{
    var div = document.createElement( "div" )
    div.appendChild(
        document.createTextNode( "coucou" )
    );
    document.getElementById( "testFonc" ).appendChild( div );
}

document.getElementById( "testFonc" ).addEventListener( "click", test, false );
