<!DOCTYPE html> 
<html>
<head>
    <title>1JCBO - bodovani zavodu</title>
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
    <table>
    <thead>
	    <tr>
	    <th>Nazev</th><th>koef</th><th>koment</th><th>typ</th><th>misto</th><th>bodu</th>
	    </tr>
    </thead>
    <tbody>
<?php
include 'dbc.php';
$res = $SQL->query("select typ_zavodu.*, bodovani.misto, bodovani.bodu from typ_zavodu left join bodovani on (typ_zavodu.id = typ_zavodu_id) order by sortorder, misto");
if (!$res)
{	
	printf("prepare error: %s\n", $SQL->error);
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	die();	
}
$sid=-1;
while ($typ = $res->fetch_array()) {
	?>
    <tr>
        <td>
    <?php 
    if ($sid === $typ["id"]) {} // nix
    else {
    	$sid = $typ["id"];
    ?>
        (<?=$typ["id"]?>) <b><?=$typ["nazev"]?></b>
        <?php } // if else?>
        </td>
    <td><?=$typ["vaha"]?></td>
    <td><i><?=$typ["comment"]?></i></td>
    <td><?=$typ["typ"]?></td>
    <td><?=$typ["misto"]?></td>
    <td><?=$typ["bodu"]?></td>
    </tr>
    <?php 
}
?>  
	</tbody>
	</table>  
    </div><!-- main -->
</div><!-- page -->
</body>
</html>
