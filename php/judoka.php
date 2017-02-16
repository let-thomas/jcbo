<?php
// now support only need of vysledky

$method = $_GET["method"];
$format = $_GET["format"];
$kat_id = $_GET["kid"];

include 'dbc.php';

if ($method == "list" && $format =="json" && isset($kat_id))
{
	$query ="select clen.id, clen.jmeno, clen.prijmeni from kategorie, clen ";
	$query.=" where kategorie.id=".$kat_id."  and year(narozen) between (year(curdate())-rdo) and (year(curdate())-rod) and status=1  order by prijmeni, jmeno;";
	printf("[\n");
	$res = $SQL->query($query) or die("Query failed: " . $SQL->error);
	$separate = 0;
	while ($row = $res->fetch_array()) {
		if ($separate) printf(",");
		printf("{\"value\":\"%d\",\"label\":\"%s %s\"}", $row["id"], $row["jmeno"], $row["prijmeni"]);
		$separate = 1;
	}
	$res->close();
	printf("]\n");
}

$SQL->close();

?>