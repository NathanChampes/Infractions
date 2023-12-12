function getDetailsCond() {
    var selectValue = document.getElementById('num_permis').value;
    var xhr = new XMLHttpRequest();

    xhr.open('GET', 'detailsEditCond.php?selectedValue=' + selectValue, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var conducteurDetails = JSON.parse(xhr.responseText);

            var vehiculeDetailsDiv = document.getElementById('conducteurDetails');
            if(selectValue != 0){
                vehiculeDetailsDiv.innerHTML = "Nom: " + conducteurDetails.nom + "<br>" +
                "Prenom: " + conducteurDetails.prenom + "<br>" +
                "Date d'obtention du permis: " + conducteurDetails.datePermis + "<br>";
            }else{
                vehiculeDetailsDiv.innerHTML = "";
            }

        }
    };

    xhr.send();
}


function getDetailsVehicule() {
    var selectValue = document.getElementById('num_immat').value;
    var xhr = new XMLHttpRequest();

    xhr.open('GET', 'detailsEditVehicule.php?selectedValue=' + selectValue, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var vehiculeDetails = JSON.parse(xhr.responseText);
            var vehiculeDetailsDiv = document.getElementById('vehiculeDetails');
            if(selectValue != 0){
            vehiculeDetailsDiv.innerHTML = "Marque: " + vehiculeDetails.marque + "<br>" +
                "Modèle: " + vehiculeDetails.modele + "<br>" + 
                "Date d'immatriculation: " + vehiculeDetails.dateImmat + "<br>" +
                "Numéro de permis du proprietaire: " + vehiculeDetails.numPermis + "<br>";
            }else{
                vehiculeDetailsDiv.innerHTML = "";
            }
        }
    };

    xhr.send();
}
