<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?><!DOCTYPE html> 
<html>
<title>1JCBO - Zpráva ze závodu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery.mobile-1.4.5.min.css" />
    <link rel="stylesheet" href="jcbo.css">
    <script src="jquery.js"></script>
    <script src="jquery.mobile-1.4.5.min.js" ></script>
    <script src="jqm.autoComplete-1.5.2-min.js"></script>
    <meta charset="UTF-8">
    <style>
    li { border-style: none; }
    .ui-li-static { padding: 0 0;}
    
    </style>
    
</head>

<body>
<div data-role="page">

    <?php
    $nav_menu="zprava";
    $nav_title="1JCBO - zpráva trenéra";
    include 'header.inc';
    ?>


    <div role="main" class="ui-content">
    <h3>Zpráva trenéra</h3>

<?php
include 'dbc.php';

if (!isset($zavod_id) && isset($_POST["z_id"]))
{
	$zavod_id = $_POST["z_id"];
}
if (!isset($zavod_id))
{
	$zavod_id = $_GET["z_id"];
}

if (isset($zavod_id))
{
$q_zavod="select nazev, kdy, kde, hodnoceni from zavod where id=?";
$s_zavod = $SQL->prepare($q_zavod);
if (! $s_zavod) {
	printf("prepare error: %s\n", $SQL->error);
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	die();
}
$s_zavod->bind_param('i', $zavod_id);
$s_zavod->execute();
$s_zavod->bind_result($nazev, $kdy, $kde, $hodnoceni);
if ($s_zavod->fetch())
{
	?>
    <h2><?=$nazev ?></h2>
    <div class="ui-grid-a ui-responsive" >
            <div class="ui-block-a">Datum</div>
            <div class="ui-block-b"><?=$kdy?></div>
            <div class="ui-block-a">Kde</div>
            <div class="ui-block-b"><?=$kde?></div>
   </div>
   <h3>Hodnocení</h3>
   <p><?= $hodnoceni?></p>
    
    <?php 
} else
{
	printf("<!-- no fetch -->\n");
}

$s_zavod->close();


$q_vys ="select jmeno, prijmeni, zavodnik_id, vyhry, prohry, misto, komentar, vaha, nazev, bodu  from vysledky "; 
$q_vys.="inner join clen on (clen.id=zavodnik_id) ";
$q_vys.="inner join kategorie on (kategorie.id = kategorie_id) ";
$q_vys.="where zavod_id = ? ";
$q_vys.="order by kategorie_id, prijmeni";
$s_vys = $SQL->prepare($q_vys);
if (! $s_vys) {
	printf("prepare error: %s\n", $SQL->error);
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	die();
}
$s_vys->bind_param('i', $zavod_id);
$s_vys->execute();
$s_vys->bind_result($jmeno, $prijmeni, $zavodnik_id, $vyhry, $prohry, $misto, $komentar, $vaha, $kat_nazev, $bodu);
$s_vys->store_result();

$kat_nazev_was = "";
?>
<?php
while ($s_vys->fetch()) {
	if ($kat_nazev !== $kat_nazev_was)
	{?>
        <h3>Kategorie <?= $kat_nazev?></h3>
        <div class="ui-grid-d ui-responsive" style='background-color:rgb(233,233,233)'>
            <div class="ui-block-a">Jméno</div>
            <div class="ui-block-b">váha</div>
            <div class="ui-block-c">výhry</div>
            <div class="ui-block-d">prohry</div>
            <div class="ui-block-e">místo</div>
        </div>
        <?php  
        $kat_nazev_was = $kat_nazev;
	}
?>
	<div class="ui-grid-d ui-responsive" style='background-color:#F4F4F8'>
		<div class="ui-block-a"><strong><?=$jmeno ." " . $prijmeni ?></strong></div>
        <div class="ui-block-b"><?=$vaha?>kg</div>
		<div class="ui-block-c"><?=$vyhry?></div>
		<div class="ui-block-d"><?=$prohry?></div>
		<div class="ui-block-e"><?=(isset($misto)&&$misto>0)?$misto:"bez"?> (<?=$bodu ?>bodů)</div>
	</div>
<?php 
	if (isset($komentar) && $komentar !== '') {?>
		<div class='ui-grid-solo ui-responsive'>
        <div class="ui-block-a"><i><?=$komentar?></i><br/>&nbsp;</div>
		</div>
<?php }
}
?>
</tbody>
</table>
<?php 
$SQL->close();
} else
{
	printf("I do not know which competition!");
}
?>
<div>TODO: zhodnoceni</div>
<div>Reklamy?</div>
    </div><!-- main -->
</div><!-- page -->

</body>
</html>
