<!DOCTYPE html> 
<html>
<head>
<?php
unset($id);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["id"]))
{
    $id = $_POST["id"];
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET["id"]))
{
    $id = $_GET["id"];
}
if (isset($id))
{
    include 'dbc.php';
    $query = sprintf("select zavod.*, DATE_FORMAT(kdy,'%%d.%%m.%%Y') as kdyf from zavod where id=%d;", $id); // if id is not number it fails
    $res = $SQL->query($query) or die("Query failed (".$query . "): ".$SQL->errno.": " . $SQL->error);
    $zavod = $res->fetch_array();
} else
{
	$id="";
    $zavod = array();
}
?>

    <title>1JCBO - Závod</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery.mobile-1.4.5.min.css" />
    <link rel="stylesheet" href="jquery-ui.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="jquery.js"></script>
    <script src="jquery.mobile-1.4.5.min.js" ></script>
    <script src="jquery-ui.js" ></script>
     <script>
  $( function() {
        $( "#datepicker" ).datepicker();
        $( "#datepicker" ).datepicker( "option", "dateFormat", "d.m.yy" );
        <?php
        if (isset($id) && isset($zavod["kdyf"])) {?>
        $("#datepicker").datepicker('setDate', '<?=$zavod["kdyf"]?>');
        <?php } ?>
         
  } );
  </script>
 <meta charset="UTF-8">
</head>
<body>
<div data-role="page">
	<div data-role="header">
	<h1><?=isset($id)? "Editace" : "Vytvoření nového" ?> závodu</h1>
	</div>
    
    <div role="main" class="ui-content">
<form action="zavod_cmd.php" method="post" >
<input name="id" value="<?= $id ?>" type="hidden"/>
<table>
<tr>
    <td><label for="text-basic">Název:</label></td>
    <td><input name="nazev" id="nazev" value="<?= $zavod["nazev"] ?>" type="text"></td>
</tr>
<!-- only for chromy tr>
    <td><label for="date">Kdy:</label>
    <td><input name="kdy" id="kdy" value="" type="date"></td>
</tr -->
<tr>
    <td><label for="date">Kdy:</label>
    <td><input name="kdy" id="datepicker" value="<?= $zavod["kdyf"] ?>" type="text"></td>
</tr>
<tr>
    <td><label for="text-basic">Kde:</label>
    <td><input name="kde" id="kde" value="<?= $zavod["kde"] ?>" type="text"></td>
</tr>
<tr>
    <td><label for="text-basic">Typ:</label>
    <td><select name="typ">
    <?php
    include 'dbc.php';
    $qry = "select id, nazev from zavody_typ order by poradi, nazev";
    $result_res = $SQL->query($qry) or die("Query failed: " . $SQL->error);
    while ($zav_typ = $result_res->fetch_array()) { ?>
        <option value="<?=$zav_typ["id"]?>" <?= ($zavod["type_id"]==$zav_typ["id"]?"selected" : "" ) ?>><?=$zav_typ["nazev"]?></option>
    <?php }
    $result_res->close();
    ?>
    </select>
    </td>
</tr>
<tr>
    <td><label for="text-basic">Kategorie:</label><!-- load by id -->
    <td>
    <fieldset data-role="controlgroup" data-type="horizontal">
        <?php 
        if (isset($id))
        {
        	$refid = $id;
        } else 
        {
        	$refid = -1;
        }
	    $qry = sprintf("select kategorie.id, nazev, zavod_kateg.kateg_id from kategorie left join jcbo.zavod_kateg on (kategorie.id=zavod_kateg.kateg_id and zavod_kateg.zavod_id = %d ) order by id", $refid);
	    $result_res = $SQL->query($qry) or die("Query failed: " . $SQL->error);
	    while ($kateg = $result_res->fetch_array()) {
	    	// kat[] is php specific!  ?>
            <label><?=$kateg["nazev"]?><input name="kat[]" type="checkbox" value="<?=$kateg["id"]?>" <?= isset($kateg["kateg_id"])?"checked":"" ?>></label> 
	    <?php }
	    $result_res->close();
	    ?>
         </fieldset></div>
        </td>
</tr>

<tr>
    <td><label for="text-basic">Vedouci trener:</label><!-- load by id -->
    <td><input name="tren_id" id="" value="<?= $zavod["vedouci_id"] ?>" type="text"></td>
</tr>

<tr>
    <td valign="top" for="text-basic"><label for="textarea">Pozvánka:</label></td>
    <td><textarea cols="40" rows="8" name="pozvanka" id="pozvanka"><?= $zavod["pozvanka"] ?></textarea></td>
</tr>
<tr>
    <td colspan="2"><button class="ui-shadow ui-btn ui-corner-all" type="submit">Ulozit</button></td>
</tr>
</table>

</form>

<?php
# echo $_SERVER['SERVER_NAME']
#$comma_separated = implode(",", $_SERVER);
#echo $comma_separated; // lastname,email,phone
$SQL->close();
?>
</div>
</div>
</body>
</html>
