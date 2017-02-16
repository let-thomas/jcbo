<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?><!DOCTYPE html>
<html>
<?php
include 'common.inc';

function sql_error_l($msg) {
	printf("<p>%s</p>", msg);
	printf("\n</body>\n</html>\n");
}
$redirect="";
$message="";
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	// create record
	include 'dbc.php';
	$id = $_POST["id"];
	if (isset($id) && strlen($id)>0) // if passed id the update
	{
		if (!($stmt = $SQL->prepare("update zavod set nazev=?, kdy=STR_TO_DATE(?,'%d.%m.%Y'), kde=?, typ_id=?, vedouci_id=?, pozvanka=? where id=?"))) {
			sql_error_l("Prepare update failed: (" . $SQL->errno . ") " . $SQL->error);
			die();
		}
		$stmt->bind_param('sssiisi', $_POST["nazev"], $_POST["kdy"], $_POST["kde"], $_POST["typ"], $_POST["tren_id"], $_POST["pozvanka"], $id);
	} else
	{
		unset($id);
		$message="insert; ";
		if (!($stmt = $SQL->prepare("INSERT INTO zavod(nazev, kdy, kde, typ_id, vedouci_id, pozvanka) VALUES (?,STR_TO_DATE(?,'%d.%m.%Y'),?,?,1,?)"))) {
			sql_error_l("Prepare insert failed: (" . $SQL->errno . ") " . $SQL->error); 
			die();
		}
		$stmt->bind_param('sssis', $_POST["nazev"], $_POST["kdy"], $_POST["kde"], $_POST["typ"], /*$_POST["tren_id"],*/ $_POST["pozvanka"]);
	}
	$stmt->execute();
	if (isset($id))
	{
		$zavod_id = $id;
		unset($id);
		$message.="id = " . $zavod_id;
	} else
	{
		$zavod_id=$SQL->insert_id;
		$message.="id = " . $zavod_id;
	}
	$stmt->close();

	//printf("values(%s,%s,%s,%d,%d,%s,).\n", $_POST["nazev"], $_POST["kdy"], $_POST["kde"], $_POST["typ"], $_POST["tren_id"], $_POST["pozvanka"]);
	//printf("Row inserted with id %d.\n", $zavod_id);
	
	// now save related kategories if any
	// delete existing ones
	$qry = sprintf("delete from zavod_kateg where zavod_id=%d", $zavod_id);
	$SQL->query($qry);
	$kat_arr = $_POST["kat"];
	//printf("kategories: %s.\n", $kat_arr);
	if (!($stmt = $SQL->prepare("insert into zavod_kateg(zavod_id, kateg_id) values (?,?);"))) {
		sql_error_l("Prepare insert2 failed: (" . $SQL->errno . ") " . $SQL->error);
		die();
	}
	$stmt->bind_param('ii', $zavod_id, $kat_id);
	foreach ($kat_arr as &$one_kat) {
		$kat_id = $one_kat;
		$stmt->execute();
	}
	
	
	$stmt->close();
	
	$SQL->close();
	
	//include 'vysledky.php';
	//header("Location: " . $CTX_PREFIX . "/vysledky.php?z_id=" . $zavod_id); /* Redirect browser */
	$redirect = sprintf("vysledky.php?z_id=%d", $zavod_id);
	/*
	printf("<head>\n");
	printf("<meta http-equiv=\"refresh\" content=\"0; url=%s/vysledky.php?z_id=%d\" />\n", $CTX_PREFIX, $zavod_id);
	printf("</head>\n");
	die();*/
} else
{
	//printf("<p>jsem v tom else\n</body></html>");
	
	//nejaky error, redirect na index
	/*header("Location: " . $CTX_PREFIX );
	die();*/
	$redirect = "";
	
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
<head>
  <meta http-equiv="refresh" content="1; url=<?= $CTX_PREFIX ?>/<?= $redirect?>" />
</head>
<body>
<p><?= $message ?></p>
<p><a href="<?= $CTX_PREFIX ?>/<?= $redirect?>">prokracuj k vysledkum</a></p>
  <script>
  //console.log("jdu na to");
  window.location.replace("<?= $CTX_PREFIX ?>/<?= $redirect?>");
  </script>
</body>
</html>
