function test()
{
    var xhr = new XMLHttpRequest();
    xhr.open( "GET", "/reponse.txt" );
    xhr.responseType = "document/txt";

    xhr.addEventListener
    ( "load",

        function()
        {
            var rep = xhr.response;
            console.log( rep );
            var div = document.createElement( "div" )
            div.appendChild(
                document.createTextNode( rep )
            );
            document.getElementById( "testFonc" ).appendChild( div );
        }

    );

    xhr.send();
}

$(document).ready(function () {
    $("img").unveil();
});

document.getElementById( "testFonc" ).addEventListener( "click", test, false );
