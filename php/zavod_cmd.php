<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// create record
	include 'dbc.php';
	
	if (!($stmt = $SQL->prepare("INSERT INTO zavod(nazev, kdy, kde, type_id, vedouci_id, pozvanka) VALUES (?,?,?,?,?,?)"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; 
		die();
	}
	$stmt->bind_param('sssiis', $_POST["nazev"], $_POST["kdy"], $_POST["kde"], $_POST["typ"], $_POST["tren_id"], $_POST["pozvanka"]);
	$stmt->execute();
	$zavod_id=$SQL->insert_id;
	$stmt->close();
	$SQL->close();

	printf("values(%s,%s,%s,%d,%d,%s,).\n", $_POST["nazev"], $_POST["kdy"], $_POST["kde"], $_POST["typ"], $_POST["tren_id"], $_POST["pozvanka"]);
	printf("%d Row inserted with id %d.\n", $stmt->affected_rows, $zavod_id);
	
	//include 'vysledky.php';
	// redirect elsewhere
} else
{
	//nejaky error, redirect na index
	header("Location: " . $_SERVER['CONTEXT_PREFIX'] );
	die();
	/*
	$_SERVER['CONTEXT_PREFIX'];
	echo $_SERVER['SERVER_NAME'];
	$comma_separated = implode(",", $_SERVER);
	echo $comma_separated; // lastname,email,phone
	echo "req: " . $_REQUEST;
	print_r ($_REQUEST);
	$comma_separated = implode(",", $_SERVER);
	echo $comma_separated; // lastname,email,phone
	echo "a ted server<br/>\n";
	print_r ($_SERVER);
	*/
}
?>