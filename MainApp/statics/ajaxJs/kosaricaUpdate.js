function updatePrice() {
    var yourSelect = document.getElementsByName( "selectCena");
    var selectZaCeno = document.getElementsByName( "cena");
    var selectZaCenoSkupno = document.getElementsByName( "cenaSkupna");
    var st,novaCena, splitajCeno;
    for(var i = 0; i<yourSelect.length; i++) {
        st = yourSelect[i].options[ yourSelect[i].selectedIndex].value;
        splitajCeno = selectZaCeno[i].innerText.split(" ")[0];
        splitajCeno = splitajCeno.substring(1);
        novaCena = st*parseInt(splitajCeno);
        selectZaCenoSkupno[i].innerHTML = novaCena.toFixed(2) + " EUR"
    }
}

function removeKebab(idArticla, idnarocila_artikla) {
    console.log(idnarocila_artikla);
    var request = new XMLHttpRequest();

    var body = {
        "idnarocila_artikli" : idnarocila_artikla + ''
    };

    console.log(body);
    body = JSON.stringify(body);
    console.log(body);

    request.open('DELETE',"http://localhost/api/v1/narocila_artikli/delete.php",true);
    request.setRequestHeader('Content-Type', 'application/json');
    request.send(body);

    request.addEventListener("load", function () {

        document.getElementById(idArticla).innerHTML = "";

    });
    request.addEventListener("error", function () {
        console.log("Ni uspelo zbrisat!!")

    });


}

