function updateRating(novaOcena,idartikla, naziv, opis, cena, povprecnaOcena, stOcen) {

    var novoStOcen = stOcen+1;
    var novaPovprecnaOcnea= (stOcen * povprecnaOcena + novaOcena)/novoStOcen;
    novaPovprecnaOcnea = novaPovprecnaOcnea.toFixed(2);
    console.log(novoStOcen, novaPovprecnaOcnea)


    var request = new XMLHttpRequest();
    var body = {
        "idartikla" : idartikla + '',
        "naziv" : naziv + '',
        "opis" : opis + '',
        "cena" : cena + '',
        "st_ocen": novoStOcen + '',
        "povprecna_ocena":novaPovprecnaOcnea + '',
        "status": 1 + '',
        "idspr":-1 + ''
    };


    var b = JSON.stringify(body);

    request.open('PUT',"http://localhost/api/v1/artikli/update.php",true);
    request.setRequestHeader('Content-Type', 'application/json');
    request.send(b);

    request.addEventListener("load", function() {
        var response = JSON.parse(request.responseText);
        console.log(response)
        document.getElementById("povpOcena").innerHTML = "<span>Povprečna ocena: </span>" + novaPovprecnaOcnea;
        document.getElementById("stOc").innerHTML = "<span>Stevilo ocen: </span>" + novoStOcen;

    });
    request.addEventListener("error", function() {
        console.log("NAPAKA!");
    });
}
