<?php
include 'dbc.php';
// TODO check/save what come from ajax

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST["action"] === 'store') && isset($_POST["formData"]) ) // post vysledku
{
	parse_str($_POST["formData"], $data);
	$zavodnik_id = $data["j_id"];
	$kat_id = $data["kat_id"];
	$zavod_id = $data["z_id"];
	/*$win = $_POST["win"];
	 $lose = $_POST["lose"];
	 $position = $_POST["position"];
	 $comment = $_POST["comment"];*/

	if (isset($data["v_id"])) // update vysledku
	{
		if (!($stmt = $SQL->prepare("UPDATE results set win=?, lose=?, misto=?, komentar=?, vaha=? where id=?"))) {
			echo "Prepare update failed: (" . $SQL->errno . ") " . $SQL->error;
			die();
		}
		$stmt->bind_param('iiisii', $data["win"], $data["lose"], $data["position"], $data["comment"], $data["vaha"], $data["v_id"] );
		$stmt->execute();
		$stmt->close();
		printf("<!-- update %d: %s  -->\n", $SQL->errno, $SQL->error);
	} elseif (isset($zavodnik_id) && isset($kat_id) && isset($zavod_id))
	{
		if (!($stmt = $SQL->prepare("INSERT INTO results(zavodnik_id, zavod_id, kategorie_id, win, lose, misto, komentar, vaha) VALUES (?,?,?,?,?,?,?,?)"))) {
			echo "Prepare insert failed: (" . $SQL->errno . ") " . $SQL->error;
			die();
		}

		$stmt->bind_param('iiiiiisi', $zavodnik_id, $zavod_id, $kat_id, $data["win"], $data["lose"], $data["position"], $data["comment"], $data["vaha"]);
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
	$query = sprintf("delete from results where id = %d", $_POST["id"]);
	$SQL->query($query);
	printf("<!-- smazano %d: %s -->\n", $SQL->errno, $SQL->error);
}

$SQL->close();
?>