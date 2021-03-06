var zeOcenu= false;
function updateRating(novaOcena,idartikla, naziv, opis, cena, povprecnaOcena, stOcen, iduporabnika, status) {
    console.log()
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
        "status": status + '',
        "idspr":-1 + ''
    };


    var b = JSON.stringify(body);

    request.open('PUT',"https://localhost/api/v1/artikli/update.php",true);
    request.setRequestHeader('Content-Type', 'application/json');
    request.send(b);

    request.addEventListener("load", function() {
        var response = JSON.parse(request.responseText);
        console.log(response)
        document.getElementById("povpOcena").innerHTML = "<span>Povprečna ocena: </span>" + novaPovprecnaOcnea;
        document.getElementById("stOc").innerHTML = "<span>Stevilo ocen: </span>" + novoStOcen;
        if(!zeOcenu) {
            var req = new XMLHttpRequest();
            var telo = {
                "idartikla": idartikla + '',
                "iduporabnika":iduporabnika + '',
                "ocena": novaOcena + '',
                "idspr": 1 + ''
            }

            var telo = JSON.stringify(telo);
            req.open('POST',"https://localhost/api/v1/artikli_ocene/create.php",true)
            req.setRequestHeader('Content-Type', 'application/json');
            req.send(telo);

            req.addEventListener("load", function () {
                var resp = JSON.parse(req.responseText);
                zeOcenu = true;
                document.getElementById("star-5").disabled = true;
                document.getElementById("star-4").disabled = true;
                document.getElementById("star-3").disabled = true;
                document.getElementById("star-2").disabled = true;
                document.getElementById("star-1").disabled = true;
                document.getElementById("tekst").innerHTML= "<span style='color: red'> Hvala za oceno! </span>";

            });
            req.addEventListener("error", function() {
                console.log("NAPAKA!");
            });
        }


    });
    request.addEventListener("error", function() {
        console.log("NAPAKA!");
    });
}