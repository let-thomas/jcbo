<!DOCTYPE html> 
<html>
<head>
    <title>1JCBO - prehled zavodu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery.mobile-1.4.5.min.css" />
    <link rel="stylesheet" href="jquery-ui.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="jquery.js"></script>
    <script src="jquery.mobile-1.4.5.min.js" ></script>
 <meta charset="UTF-8">
</head>
<body>
<div data-role="page">
	<div data-role="header">
	<h1>Přehled závodů</h1>
	</div>
    
    <div role="main" class="ui-content">
    <table>
    
<?php
include 'dbc.php';
$res = $SQL->query("select * from zavod order by kdy") or die("Query failed: " . $SQL->error);
while ($zavod = $res->fetch_array()) {
	// asi by bylo lepsi onclick()
?>
    <tr>
        <td><?=$zavod["nazev"] ?></td>
        <td><?=$zavod["kdy"] ?></td>
        <td><a href="zavod.php?id=<?=$zavod["id"] ?>" class="ui-btn ui-corner-all">editace</a></td>
        <td><a href="vysledky.php?z_id=<?=$zavod["id"] ?>" class="ui-btn ui-corner-all">vysledky</a></td>
        <td><a href="zprava.php?id=<?=$zavod["id"] ?>" class="ui-btn ui-corner-all ui-state-disabled">zprava</a></td>
    </li>
    </tr>
<?php 
}
$res->close();
$SQL->close();
?>
    </table>
    </div><!-- main -->
</div><!-- page -->
</body>
</html>
