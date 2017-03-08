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
    <?php
    $nav_menu="prehled";
    include 'header.inc';
    ?>
    
    
    <div role="main" class="ui-content">
    <table data-role="table" id="cr-table" data-mode="reflow" class="ui-responsive">
    <thead>
        <tr>
	      <th data-priority="1">Název</th>
	      <th data-priority="2">Kdy</th>
          <th></th>
          <th></th>
        
        </tr>
    </thead>
    <tbody>
    
<?php
include 'dbc.php';
$res = $SQL->query("select * from zavod order by kdy") or die("Query failed: " . $SQL->error);
while ($zavod = $res->fetch_array()) {
	// asi by bylo lepsi onclick()
?>
    <tr>
        <td><?=$zavod["nazev"] ?>
          <a href="zavod.php?id=<?=$zavod["id"] ?>" class="ui-btn ui-shadow ui-corner-all ui-btn-inline ui-icon-edit  ui-btn-icon-notext">editace</a> <!-- ui-corner-all ui-btn-icon-left -->
        </td>
        <td><?=$zavod["kdy"] ?></td>
        <td><a href="vysledky.php?z_id=<?=$zavod["id"] ?>" class="ui-btn ui-corner-all">vysledky</a></td>
        <td><a href="zprava.php?z_id=<?=$zavod["id"] ?>" class="ui-btn ui-corner-all">zprava</a></td>
    </li>
    </tr>
<?php 
}
$res->close();
$SQL->close();
?>
    </tbody>
    </table>
    </div><!-- main -->
</div><!-- page -->
</body>
</html>
