function updatePrice(naziv, idnarocila_artikli, idnarocila, idartikla) {
    /* var yourSelect = document.getElementsByName( "selectCena");
    var selectZaCeno = document.getElementsByName( "cena");
    var selectZaCenoSkupno = document.getElementsByName( "cenaSkupna");
    var st,novaCena, splitajCeno; */
    var yourSelect = document.getElementById( naziv);
    var selectZaCeno = document.getElementById( "cena/"+naziv);
    var selectZaCenoSkupno = document.getElementById( "cenaSkupna/"+naziv);

    var st = yourSelect.options[yourSelect.selectedIndex].value;
    var splitajCeno = selectZaCeno.innerText.split(" ");
    console.log(splitajCeno);
    splitajCeno = splitajCeno[0].substring(1);
    novaCena = st*parseFloat(splitajCeno);


    var request = new XMLHttpRequest();
    var body = {

        "idnarocila_artikli": idnarocila_artikli + '',
        "idnarocila": idnarocila + '',
        "idartikla": idartikla + '',
        "kolicina": st + '',
        "status": "0",
        "datspr": "2019-01-06 17:16:55",
        "idspr": "1"
    };

    body = JSON.stringify(body);

    request.open('PUT',"https://localhost/api/v1/narocila_artikli/update.php",true);
    request.setRequestHeader('Content-Type', 'application/json');
    request.send(body);

    request.addEventListener("load", function () {

        selectZaCenoSkupno.innerHTML = novaCena.toFixed(2) + " EUR"
        console.log(request.responseText);

    });
    request.addEventListener("error", function () {
        console.log("Ni uspelo zbrisat!!")

    })

}

function removeKebab(idArticla, idnarocila_artikla) {
    console.log(idnarocila_artikla, idArticla);
    var request = new XMLHttpRequest();

    var body = {
        "idnarocila_artikli" : idnarocila_artikla + ''
    };

    console.log(body);
    body = JSON.stringify(body);
    console.log(body);

    request.open('DELETE',"https://localhost/api/v1/narocila_artikli/delete.php",true);
    request.setRequestHeader('Content-Type', 'application/json');
    request.send(body);

    request.addEventListener("load", function () {

        document.getElementById(idArticla).innerHTML = "";

    });
    request.addEventListener("error", function () {
        console.log("Ni uspelo zbrisat!!")

    });


}

