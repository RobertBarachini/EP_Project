function dodajVKosarico(iduporabnika, idartikla) {
    var jeDobil = false;
    console.log(iduporabnika, idartikla);
    var request = new XMLHttpRequest();

    request.open('GET', "http://localhost/api/v1/narocila/read.php", true);
    request.setRequestHeader('Content-Type', 'application/json');
    request.send();

    request.addEventListener("load", function () {
        var response = JSON.parse(request.responseText);
        console.log(response);
        if (response.message === "No objects found.") {
            var telo = {
                "iduporabnika": iduporabnika + '',
                "idspr": iduporabnika + ''
            };

            telo = JSON.stringify(telo);
            var req = new XMLHttpRequest();
            req.open("POST", "http://localhost/api/v1/narocila/create.php", true);
            req.setRequestHeader('Content-Type', 'application/json');
            req.send(telo);

            req.addEventListener("load", function () {
                var resp = JSON.parse(req.responseText);
                console.log("ID NAROCILA, IDARTIKLA in ID UPORABNIKA", resp.id, idartikla, iduporabnika);
                var telo_artikli = {
                    "idnarocila": resp.id + '',
                    "idartikla": idartikla + '',
                    "kolicina": 1 + '',
                    "idspr": iduporabnika + ''
                };
                telo_artikli = JSON.stringify(telo_artikli);
                var reqq = new XMLHttpRequest();
                reqq.open("POST", "http://localhost/api/v1/narocila_artikli/create.php", true);
                reqq.setRequestHeader('Content-Type', 'application/json');
                reqq.send(telo_artikli);

                reqq.addEventListener("load", function () {
                    var respp = JSON.parse(reqq.responseText);
                    console.log("maka", respp);
                    document.getElementById("success").hidden = false;
                    document.getElementById("button").disabled = true;
                    document.getElementById("button").innerHTML = "<i></i>" + "Že v Košarici!"
                });

                reqq.addEventListener("error", function () {
                    console.log("Napaka pri POST narocila_artikli")
                    document.getElementById("error").hidden = false;
                })

            });
            req.addEventListener("error", function () {
                console("Napaka pri POST narocila");
                document.getElementById("error").hidden = false;
            });
        } else {
            for (var i = 0; i < response.body.length; i++) {
                console.log(response.body[i]['iduporabnika'], iduporabnika, response.body[i]['faza']);
                if (response.body[i]['iduporabnika'] === (iduporabnika + '') && response.body[i]['faza'] === 'K') {
                    console.log("ID NAROCILA, IDARTIKLA in ID UPORABNIKA", response.body[i]['idnarocila'], idartikla, iduporabnika);
                    var telo_artikli = {
                        "idnarocila": response.body[i]['idnarocila'] + '',
                        "idartikla": idartikla + '',
                        "kolicina": 1 + '',
                        "idspr": iduporabnika + ''
                    };
                    telo_artikli = JSON.stringify(telo_artikli);
                    var reqq = new XMLHttpRequest();
                    reqq.open("POST", "http://localhost/api/v1/narocila_artikli/create.php", true);
                    reqq.setRequestHeader('Content-Type', 'application/json');
                    reqq.send(telo_artikli);

                    reqq.addEventListener("load", function () {
                        var respp = JSON.parse(reqq.responseText);
                        console.log("maka", respp);
                        document.getElementById("success").hidden = false;
                        document.getElementById("button").disabled = true;
                        document.getElementById("button").innerHTML = "<i></i>" + "Že v Košarici!"
                    });

                    reqq.addEventListener("error", function () {
                        console.log("Napaka pri POST narocila_artikli")
                        document.getElementById("error").hidden = false;
                    });
                    jeDobil = true;
                    break;
                }
            }
            if (!jeDobil) {
                telo = {
                    "iduporabnika": iduporabnika + '',
                    "idspr": iduporabnika + ''
                };

                telo = JSON.stringify(telo);
                req = new XMLHttpRequest();
                req.open("POST", "http://localhost/api/v1/narocila/create.php", true);
                req.setRequestHeader('Content-Type', 'application/json');
                req.send(telo);

                req.addEventListener("load", function () {
                    var resp = JSON.parse(req.responseText);
                    console.log("ID NAROCILA, IDARTIKLA in ID UPORABNIKA", resp.id, idartikla, iduporabnika);
                    var telo_artikli = {
                        "idnarocila": resp.id + '',
                        "idartikla": idartikla + '',
                        "kolicina": 1 + '',
                        "idspr": iduporabnika + ''
                    };
                    telo_artikli = JSON.stringify(telo_artikli);
                    var reqq = new XMLHttpRequest();
                    reqq.open("POST", "http://localhost/api/v1/narocila_artikli/create.php", true);
                    reqq.setRequestHeader('Content-Type', 'application/json');
                    reqq.send(telo_artikli);

                    reqq.addEventListener("load", function () {
                        var respp = JSON.parse(reqq.responseText);
                        console.log("maka", respp);
                        document.getElementById("success").hidden = false;
                        document.getElementById("button").disabled = true;
                        document.getElementById("button").innerHTML = "<i></i>" + "Že v Košarici!"
                    });

                    reqq.addEventListener("error", function () {
                        console.log("Napaka pri POST narocila_artikli")
                        document.getElementById("error").hidden = false;
                    })

                });
                req.addEventListener("error", function () {
                    console("Napaka pri POST narocila");
                    document.getElementById("error").hidden = false;
                });
            }
        }


    });

    request.addEventListener("error", function () {
        console.log("NAPAKA!");
        document.getElementById("error").hidden = false;
    });
}