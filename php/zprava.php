<!DOCTYPE html> 
<html>
<title>1JCBO - Zpráva ze závodu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery.mobile-1.4.5.min.css" />
    <!-- <link rel="stylesheet" href="jquery-ui.css"> -->
    <link rel="stylesheet" href="jcbo.css">
    <script src="jquery.js"></script>
    <!-- <script src="jquery-3.1.1.min.js"></script> -->
    <script src="jquery.mobile-1.4.5.min.js" ></script>
    <!-- <script src="jquery-ui.js" ></script> -->
    <script src="jqm.autoComplete-1.5.2-min.js"></script>
<!--  
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
    <script src="jqm.autoComplete-1.5.2-min.js"></script> -->
    
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
    include 'header.inc';
    ?>


    <div role="main" class="ui-content">

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

$q_vys ="select jmeno, prijmeni, zavodnik_id, win, lose, misto, komentar, nazev  from vysledky "; 
$q_vys.="inner join judoka on (judoka.id=zavodnik_id) ";
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
$s_vys->bind_result($jmeno, $prijmeni, $zavodnik_id, $win, $lose, $misto, $komentar, $kat_nazev);
$s_vys->store_result();

$kat_nazev_was = "";
?>
<table data-role="table" data-mode="reflow" class="ui-responsive" id="vysledky" >
<thead>
<tr style='background-color:rgb(233,233,233)'>
<th>Jméno</th><th>výhry</th><th>prohry</th><th>místo</th>
</tr>
</thead>
<tbody>
<?php
while ($s_vys->fetch()) {
	printf("<tr style='background-color:#F4F4F8'>\n");
	printf("<td><strong>%s %s</strong></td><td>%d</td><td>%d</td><td>%s</td>\n", $jmeno, $prijmeni, $win, $lose, (isset($misto)&&$misto>0)?$misto:"bez" );
	printf("</tr>\n");
	if (isset($komentar) && $komentar !== '') {
		printf("<tr >\n");
		printf("<td colspan='4'><i>%s</i></td>\n", $komentar );
		printf("</tr>\n");
	}
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
    </div><!-- main -->
</div><!-- page -->

</body>
</html>
