<!DOCTYPE html>
<html>
<head>
    <title>Changement de mot de passe</title>
    <link rel="stylesheet" type="text/css" href="../vue/style/login.css">
</head>
<body>
    <h1>Changement de mot de passe</h1>
    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
    <form action="changement_mdp.php" method="post">
        <label for="num_permis">Numéro de permis :</label><br>
        <input type="text" id="num_permis" name="num_permis"><br>
        <label for="ancien_mot_de_passe">Ancien mot de passe :</label><br>
        <input type="password" id="ancien_mot_de_passe" name="ancien_mot_de_passe"><br>
        <label for="nouveau_mot_de_passe">Nouveau mot de passe :</label><br>
        <input type="password" id="nouveau_mot_de_passe" name="nouveau_mot_de_passe"><br>
        <input type="submit" id="valider" name="valider" value="Valider" />
        <input type="submit" id="annuler" name="annuler" value="Annuler" />
        <button id="toggle-dark-mode"></button>
    </form>
    <script src="../controleur/darkmode.js"></script>
</body>
</html>