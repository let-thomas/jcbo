<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?><!DOCTYPE html>
<html>
<title>1JCBO - zebrik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery.mobile-1.4.5.min.css" />
    <link rel="stylesheet" href="jcbo.css">
    <script src="jquery.js"></script>
    <script src="jquery.mobile-1.4.5.min.js" ></script>
    <script src="jqm.autoComplete-1.5.2-min.js"></script>
    <meta charset="UTF-8">
</head>

<body>
<div data-role="page">

    <?php
    $nav_menu="zebrik";
    $nav_title="1JCBO - žebříček";
    include 'header.inc';
    ?>

<?php
// todo jine roky
$rok=2017;
?>

    <div role="main" class="ui-content">
    <h3>Zebricek za rok <?=$rok ?></h3>
 
<?php
include 'dbc.php';
$qry ="select clen.jmeno, clen.prijmeni, vysledky.zavodnik_id, kategorie_id, kategorie.nazev, sum(bodu) as bodu ";
$qry.="from zavod, vysledky, kategorie, clen ";
$qry.="where year(kdy) = ? ";
$qry.="and zavod.id = vysledky.zavod_id ";
$qry.="and vysledky.kategorie_id = kategorie.id ";
$qry.="and clen.id = zavodnik_id ";
$qry.="group by zavodnik_id, kategorie_id ";
$qry.="order by kategorie_id, bodu desc";
$stmt = $SQL->prepare($qry);
$stmt->bind_param('i', $rok);
$stmt->execute();
$stmt->bind_result($jmeno, $prijmeni, $zavodnik_id, $kategorie_id, $nazev, $bodu);

?>
    <div class="ui-grid-b ui-responsive" style='background-color:#F4F4F8'>
    

<?php
while ($stmt->fetch()) {
	?>
        <div class="ui-block-a"><strong><?=$jmeno ." " . $prijmeni ?></strong></div>
        <div class="ui-block-b"><?=$nazev?></div>
        <div class="ui-block-c"><?=$bodu?></div>
    
<?php
}

$stmt->close();
$SQL->close();
?>
</div>
</div><!-- main -->
</div><!-- page -->
</body>
</html>