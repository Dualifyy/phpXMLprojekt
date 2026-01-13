<?php
require ('funktsioonid.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>XML faili kuvamine funktsioonide abil</title>
</head>
<body>
<h1>ERR RSS Uudised</h1>
<?php
uudised('https://www.err.ee/rss', 5);
?>
<h1>Postimees RSS Uudised</h1>
<?php
uudised('https://www.postimees.ee/rss', 5);
?>
</body>
</html>
