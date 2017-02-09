<!DOCTYPE html>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?> 
<html>
<head>
<title>1JCBO - Výsledky závodu</title>
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
    <script src="vysledky.js"></script>
    <style>
    li { border-style: none; }
    .ui-li-static { padding: 0 0;}
    
    </style>
    <script type="text/javascript">
    var lidi = [];
    </script>
    
</head>
<body>
<div data-role="page">

    <?php
    $nav_menu="vysledky";
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

if (!isset($zavod_id))
{
	// show selection
	?>
    <form method="post" action="vysledky.php">
    <div class="ui-field-contain ">
        <label for="zavod-filter-menu">Vyber turnaj:</label>
<!--         <div class="ui-btn ui-btn-inline"> -->
        <select id="zavod-filter-menu" data-native-menu="false" class="filterable-select" name="z_id" data-inline='true' >
            <option>Vyber závod ...</option>
         <?php // onchange="myFunction()"
         $query="select id, nazev, kdy from zavod order by kdy"; // where year(kdy)=year(now) ";
         $result = $SQL->query($query) or die("Query failed: " . $SQL->error);
         while ($row = $result->fetch_array()) {?>
         <option value="<?=$row["id"]?>"><?=$row["nazev"]?> <?=$row["kdy"]?></option>
         <?php
         }
         $result->close();
         ?>
        </select>
<!--         </div> -->
        <input type='submit' data-icon='action' data-iconpos='notext' value='Icon only' data-inline='true'  id="go">
        <!-- class="ui-btn-inline"  -->
    </div>
    </form>    
    <?php
    // + rok
} else 
{
	//printf("<p>v elsu</p>\n");
	$qry ="select zavod.id as zid, zavod.nazev as zname, kategorie.id as kid, kategorie.nazev as kname  from zavod ";
	$qry.=" left join zavod_kateg on (zavod.id=zavod_id) ";
	$qry.=" left join kategorie on (kategorie.id = kateg_id) ";
	$qry.=" where zavod.id=?";
	if (!($stmt = $SQL->prepare($qry))) {
		echo "Prepare failed: (" . $SQL->errno . ") " . $SQL->error;
		die();
	}
	$stmt->bind_param('i', $zavod_id);
	$stmt->execute();
	
	$stmt->store_result();
	//printf("<p>stmt->num_rows: %d</p>\n", $stmt->num_rows);
	
	/* bind result variables */
	$stmt->bind_result($zid, $nazev, $kid, $kname);
	
	if ($stmt->fetch()) {
		printf ("<h3>Vysledky z '%s'</h3>\n", $nazev);
		//printf("<!-- %d - %d - %s -->\n", $zid, $kid, $kname);
	} else
	{
		printf("error loading");
		die();
	}
	
	$first_kat = $kid;
	if ($stmt->num_rows < 1)
	{
		printf("Nejsou zadane kategorie!");
	} else 
	{
?>

<div data-role="tabs" id="tabs">
  <div data-role="navbar">
    <ul>

<?php 	
		$first_flag = 1;
		do {
			/*printf("<div id=\"kt%d\">\n", $kid);
			printf("<p>%d %s</p>\n", $kid, $kname);
			//include 'vysledky-row.php';
			printf("<hr/>\n");
			printf("</div><!-- kt%d -->\n", $kid);*/
			//
			?>
	        <li><a href="vysledky-row.php?zid=<?=$zavod_id?>&kid=<?= $kid?>" data-ajax="false" <?= $first_flag? "class='ui-btn-active'":""?>><?=$kname?></a></li>
	        <?php 
	        $first_flag = 0;
	        
		} while($stmt->fetch());
?>
    </ul>
  </div>
</div>
<?php
	} // if more then 1
?>

<?php 	
	$stmt->close();
} //else if zavod
$SQL->close();
?>

</div><!-- main -->
</div><!-- page -->
</body>
</html>

