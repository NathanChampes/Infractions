<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Liste des Infractions </title>
    <link rel="stylesheet" type="text/css" href="../vue/style/style.css">
</head>

<body>
<button id="back-button">Retour</button>

    <section>
        
        <label></label>
        <h1>Liste des infractions de
            <?php echo $lesConducteurs->getNom() . " " . $lesConducteurs->getPrenom() ?>
        </h1>
    </section>
    <section>
        <label></label>
        <table class="formulaire">
            <tr>
            <?php
                echo $id;
                ?>
                <?php
                echo $datetri;
                 ?>
                <th id="affichable">Numéro d'immatriculation</th>
                <th id="affichable">Numéro de permis / identité</th>
                <?php
                echo $montantTri;
                ?>
                <th id="affichable">Vue</th>
            </tr>
            <?php
            foreach ($lignes as $ligne) {
                echo $ligne;
            }
            ?>
        </table>
    </section>
    <button id="toggle-dark-mode"></button>
    <script type="module" src="../controleur/darkmode.js"></script>
    <script type="module" src="../controleur/triMontant.js"></script>
    <script>
        document.getElementById('back-button').addEventListener('click', function() {
            window.location.href = '../controleur/accueil.php';
        });
    </script>
</body>

</html>