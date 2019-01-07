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

function removeKebab(idArticla) {
    document.getElementById(idArticla).innerHTML = "";
}

