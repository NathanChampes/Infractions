<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        <?php echo $titre ?>
    </title>
    <link rel="stylesheet" type="text/css" href="../vue/style/style3.css">
</head>
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>

<body>
    <main>
        <section>
            <label></label>
            <h1>
                <?php echo $titre ?>
            </h1>
        </section>
        <form name="add" action="" method="post">
            <section>
                <label>Infraction numéro :
                    <?php echo $id; ?>
                </label>
            </section>

            <section>
                <label for="date">Date :</label>
                <div>
                    <input id="date" name="date" type="date" size="30" maxlength="30" value="<?= $valeurs['date'] ?>"
                    <?php if($op == "m") echo "readonly"?>/>
                    <br />
                    <span class="erreur">
                        <?= $erreurs['date'] ?>
                    </span>
            </section>

            <section>
                <label for="num_permis">Numéro de permis :</label>
                <div>
                    <select name="num_permis" id = "num_permis" onchange = 'getDetailsCond()'>
                        <?php
                        foreach ($permis as $cle => $valeur) {
                            echo "<option value='$cle'";
                            if ($cle == $valeurs['num_permis']) {
                                echo ' selected';
                            }
                            echo ">", $valeur, "</option>";
                        }
                        ?>
                    </select>

                    <div id = "conducteurDetails">
                        
                    </div>
                    <br />
                    <span class="erreur">
                        <?= $erreurs['num_permis'] ?>
                    </span>
                </div>
            </section>

            <section>
                <label for="num_immat">Numéro d'immatriculation :</label>
                <div>
                    <select name="num_immat" id = "num_immat" onchange='getDetailsVehicule()'>
                        <?php
                        foreach ($immats as $cle => $valeur) {
                            echo "<option value='$cle'";
                            if ($cle == $valeurs['num_immat']) {
                                echo ' selected';
                            }
                            echo ">", $valeur, "</option>";
                        }
                        ?>
                    </select>
                    <div id = "vehiculeDetails">
                    </div>
                    <br />
                    <span class="erreur">
                        <?= $erreurs['num_immat'] ?>
                    </span>
                </div>
            </section>

            <section>
                <label for="delits">Delits :</label>
                <div>
                    <?php
                    foreach ($delits as $cle => $valeur) {
                        echo '<input type="checkbox" name="delits[]" value="' . $cle . '"';
                        if ($op == 'm') {
                            if (isset($valeurs['delits'])) {
                                foreach ($valeurs['delits'] as $unDelit) {
                                    if (is_object($unDelit) && $unDelit->getIdDelit() == $cle) {
                                        echo ' checked';
                                    }
                                }
                            }
                        }
                        echo '> ' . $valeur->getNatureDelit() . ', montant : ' . $valeur->getTarifDelit() . '<br>';
                    }
                    ?>
                    <span class="erreur">
                        <?= $erreurs['delits'] ?>
                    </span>
                </div>
            </section>

            <section>
                <label>&nbsp;</label>
                <div>
                    <input type="submit" id="valider" name="valider" value="Valider" />
                    &emsp;
                    <input type="submit" id="annuler" name="annuler" value="Annuler" />
                    
                </div>
            </section>
            <button id="toggle-dark-mode"></button>
        </form>
    </main>
    <script src="../controleur/darkmode.js"></script>
    <script type="module" src="../controleur/validationdate.js"></script>
    <script src = "../controleur/detailsEditInf.js"></script>
</body>

</html>