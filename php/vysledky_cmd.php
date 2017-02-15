<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include 'dbc.php';
// TODO check/save what come from ajax

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST["action"] === 'store') && isset($_POST["formData"]) ) // post vysledku
{
	parse_str($_POST["formData"], $data);
	$zavodnik_id = $data["j_id"];
	$kat_id = $data["kat_id"];
	$zavod_id = $data["z_id"];
	/*$vyhry = $_POST["vyhry"];
	 $prohry = $_POST["prohry"];
	 $position = $_POST["position"];
	 $comment = $_POST["comment"];*/

	if (isset($data["v_id"]) && $data["v_id"] > 0) // update vysledku
	{
		if (!($stmt = $SQL->prepare("UPDATE vysledky set vyhry=?, prohry=?, misto=?, komentar=?, vaha=? where id=?"))) {
			echo "Prepare update failed: (" . $SQL->errno . ") " . $SQL->error;
			die();
		}
		$stmt->bind_param('iiisii', $data["vyhry"], $data["prohry"], $data["position"], $data["comment"], $data["vaha"], $data["v_id"] );
		$stmt->execute();
		$stmt->close();
		printf("<!-- update %d: %s  -->\n", $SQL->errno, $SQL->error);
	} elseif (isset($zavodnik_id) && isset($kat_id) && isset($zavod_id))
	{
		if (!($stmt = $SQL->prepare("INSERT INTO vysledky(zavodnik_id, zavod_id, kategorie_id, vyhry, prohry, misto, komentar, vaha) VALUES (?,?,?,?,?,?,?,?)"))) {
			echo "Prepare insert failed: (" . $SQL->errno . ") " . $SQL->error;
			die();
		}

		$stmt->bind_param('iiiiiisi', $zavodnik_id, $zavod_id, $kat_id, $data["vyhry"], $data["prohry"], $data["position"], $data["comment"], $data["vaha"]);
		$stmt->execute();
		$stmt->close();
		printf("<!-- vlozeno %d: %s  -->\n", $SQL->errno, $SQL->error);
	} else 
	{
		printf("<!-- nevlozeno  -->\n");
	}
	
	
	
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST["action"] === 'delete') && isset($_POST["id"]) ) // delete vysledku
{
	$query = sprintf("delete from vysledky where id = %d", $_POST["id"]);
	$SQL->query($query);
	printf("<!-- smazano %d: %s -->\n", $SQL->errno, $SQL->error);
}

$SQL->close();
?>