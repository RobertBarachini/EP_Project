function checkout(idnarocila, iduporabnika) {

    var modal = document.getElementById('myModal');

    var request = new XMLHttpRequest();
    var body = {
        "idnarocila": idnarocila + '',
        "iduporabnika": iduporabnika + '',
        "datzac_kosarice": "2019-01-06 17:12:04",
        "datnarocila": "2019-01-06 17:12:04",
        "datposiljanja": "2019-01-06 17:12:04",
        "faza": "N",
        "status": "0",
        "datspr": "2019-01-06 16:12:04",
        "idspr": iduporabnika + ''
    };

    body = JSON.stringify(body);

    request.open('PUT', "http://localhost/api/v1/narocila/update.php", true);
    request.setRequestHeader('Content-Type', 'application/json');
    request.send(body);

    request.addEventListener("load", function () {
        console.log(request.responseText);
        modal.style.display = "block";

    });
    request.addEventListener("error", function () {
        console.log("Ni uspelo zbrisat!!")

    })


}