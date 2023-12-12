<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Liste des Infractions </title>
    <link rel="stylesheet" type="text/css" href="../vue/style/style2.css">
</head>

<body>
    <main>
    <button id="back-button">Retour</button>
    
        <section>
            <h1>Détails de l'infraction numéro
                <?php echo $idInfraction ?>
            </h1>
        </section>
        <section>
            <h3>Informations sur le conducteur</h3>
            <p>Infraction commise par
                <?php echo $leConducteur->getNom() . " " . $leConducteur->getPrenom() ?>
                qui a eu son permis le
                <?php $x = date_create($leConducteur->getDatePermis());
                echo date_format($x, 'd/m/Y'); ?>
            </p>
        </section>
        <section>
            <h3>Informations sur l'infraction</h3>
            <p>
                L'infraction a été commise le
                <?php echo date_format($date, 'd/m/Y') ?>
            </p>
        </section>
        <section>
            <h3>Informations sur le véhicule</h3>
            <p>
                La voiture était immatriculée
                <?php echo $numImmat . " le " . date_format($dateImmat, 'd/m/Y'); ?>
            </p>
            <p> La voiture est une
                <?php echo $modele . ' de la marque ' . $marque; ?>
        </section>
        <section>
            <h3>Informations sur les délits </h3>
            <table class="formulaire">
                <tr>
                    <th id="affichable">Numéro du délit</th>
                    <th id="affichable">Nature du délit</th>
                    <th id="affichable">Tarif de l'amende</th>
                </tr>
                <?php
                foreach ($lignes as $ligne) {
                    echo $ligne;
                }
                ?>
            </table>
            <p> Soit un total de <?php echo $totalTarif."€"; ?>
            </p>
        </section>
        <button id="toggle-dark-mode"></button>
    </main>


    <script src="../controleur/darkmode.js"></script>
    <script>
        document.getElementById('back-button').addEventListener('click', function() {
            window.history.back();
        });
    </script>
</body>

</html>