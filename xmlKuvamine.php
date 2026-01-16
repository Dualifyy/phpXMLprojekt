<?php


function erialaOtsing($paring){
    global $opilased;
    $tulemus = array();

    foreach($opilased->opilane as $opilane) {
        if (substr(strtolower($opilane->eriala), 0, strlen($paring)) == strtolower($paring)) {
            array_push($tulemus, $opilane);
        } else if (substr(strtolower($opilane->nimi), 0, strlen($paring)) == strtolower($paring)) {
            array_push($tulemus, $opilane);
        } else if (substr(strtolower($opilane->isikukood), 0, strlen($paring)) == strtolower($paring)) {
            array_push($tulemus, $opilane);
        }else if (substr(strtolower($opilane->oppeained), 0, strlen($paring)) == strtolower($paring)) {
            array_push($tulemus, $opilane);
        }
    }
    return $tulemus;
}

function lisaOpilane()
{
    $xmlDoc = new DOMdocument("1.0", "utf-8");
    $xmlDoc->preserveWhiteSpace = false;
    $xmlDoc->load('opilase.xml');
    $xmlDoc->formatOutput = true;
    $xmlOpilane = $xmlDoc->createElement("opilane");
    $xmlDoc->appendChild($xmlOpilane);
    $xmlRoot = $xmlDoc->documentElement;
    $xmlRoot->appendChild($xmlOpilane);
    $elukoht = $xmlDoc->createElement("elukoht");
    $xmlOpilane->appendChild($elukoht);
    unset($_POST["submit"]);
    foreach ($_POST as $voti => $vaartus) {
        $kirje = $xmlDoc->createElement($voti, $vaartus);

        if ($voti == "linn" || $voti == "maakond")
            $elukoht->appendChild($kirje);
        else
            $xmlOpilane->appendChild($kirje);
    }

    $xmlDoc->save("opilase.xml");
    header("Refresh:0");

}
$opilased = simplexml_load_file("opilase.xml");

?>

<!DOCTYPE html>
<html>
<head>
    <title>XML faili kuvamine</title>
    <link rel="stylesheet" href="tabelistiil.css">
</head>
<body>

<h1>XML faili kuvamine</h1>

<form action="?" method="post">
    <label for="otsing">Otsing:</label>
    <input type="text" name="otsing" id="otsing" placeholder="Nimi | Eriala | Isikukood">
    <input type="submit" value="Otsi 🔍">
</form>

<table>
    <tr>
        <th>Opilase nimi</th>
        <th>Isikukood</th>
        <th>Eriala</th>
        <th>Elukoht</th>
        <th>Õppeained</th>
        <th>Pilt</th>
    </tr>

    <?php
    if (!empty($_POST['otsing'])) {
        $tulemus = erialaOtsing($_POST['otsing']);
        foreach ($tulemus as $opilane) {
            echo "<tr>
                <td>{$opilane->nimi}</td>
                <td>{$opilane->isikukood}</td>
                <td>{$opilane->eriala}</td>
                <td>{$opilane->elukoht->linn}, {$opilane->elukoht->maakond}</td>
                <td>{$opilane->oppeained}</td>
                <td>{$opilane->pilt}</td>
              </tr>";
        }
    } else {
        foreach ($opilased->opilane as $opilane) {
            echo "<tr>
                <td>{$opilane->nimi}</td>
                <td>{$opilane->isikukood}</td>
                <td>{$opilane->eriala}</td>
                <td>{$opilane->elukoht->linn}, {$opilane->elukoht->maakond}</td>
                <td>{$opilane->oppeained}</td>
                <td>{$opilane->pilt}</td>
              </tr>";
        }
    }
    ?>

</table>
<form action="" method="post" name="vorm1">
    <tr>
        <td><label for="nimi">Nimi</label></td>
        <td><input type="text" name="nimi" id="nimi" placeholder="nt john doe"></td>
    </tr>
    <tr>
        <td><label for="isikukood">Isikukood</label></td>
        <td><input type="text" name="isikukood" id="isikukood" placeholder="nt 5325524"></td>
    </tr>
    <tr>
        <td><label for="eriala">Eriala</label></td>
        <td><input type="text" name="eriala" id="eriala" placeholder="nt ehitaja"></td>
    </tr>
    <tr>
        <td><label for="linn">Linn</label></td>
        <td><input type="text" name="linn" id="linn" placeholder="nt tallinn"></td>
    </tr>
    <tr>
        <td><label for="maakond">Maakond</label></td>
        <td><input type="text" name="maakond" id="maakond" placeholder="nt harjumaa"></td>
    </tr>
    <tr>
        <td><label for="oppeained">Oppeained</label></td>
        <td><input type="text" name="oppeained" id="oppeained" placeholder="lisa 2"></td>
    </tr>
    <tr>
        <td><label for="pilt">Pilt</label></td>
        <td><input type="text" name="pilt" id="pilt"></td>
    </tr>
    <tr>
        <td><input type="submit"  name="submit" id="submit" value="Sisesta"></td>
        <td></td>
    </tr>
</form>
<?php
if (isset($_POST["submit"])) {
    lisaOpilane();
    echo "Õpilane lisatud!";
}
?>
</body>
</html>
