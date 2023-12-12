<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="../vue/style/style.css">
</head>

<body>
    <section>
        <label></label>
        <h1>Admin</h1>
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
                <th id="affichable">Numéro de permis</th>
                <th id="affichable">Identité</th>
                <?php echo $montantTri; ?>
                <th id="affichable" colspan="3">Vue</th>
            </tr>
            <?php
            foreach ($lignes as $ligne) {
                echo $ligne;
            }
            ?>
            <td colspan=7></td>
            <td colspan=2>
                <a href="editInf.php?op=a&id=<?php echo $IdInfA ?>">Ajouter</a>
            </td>
        </table>
        <section>
            <label></label>
            <section class="controls">
                <form method="post">
                    <input type="submit" value="Scan JSON" name="scanJSON">
                </form>
                <a id="deconnexion" href="./logout.php">Déconnexion</a>
                <button id="toggle-dark-mode"></button>
            </section>

        </section>
        <script type="module" src="../controleur/validationsuppression.js"></script>
        <script src="../controleur/darkmode.js"></script>
        <script src="../controleur/triMontant.js"></script>
</body>

</html>
<!DOCTYPE html>