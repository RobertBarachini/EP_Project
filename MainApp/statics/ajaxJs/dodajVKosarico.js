function dodajVKosarico(iduporabnika) {
    console.log(iduporabnika);
    var request = new XMLHttpRequest();
    request.open('GET',"http://localhost/api/v1/narocila/read.php",true);
    request.setRequestHeader('Content-Type', 'application/json');
    request.send();

    request.addEventListener("load", function() {
        var response = JSON.parse(request.responseText);
        if(response.message === "No objects found.") {

        }


    });

    request.addEventListener("error", function() {
        console.log("NAPAKA!");
    });
}