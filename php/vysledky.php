<!DOCTYPE html> 
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
    <script src="jqm.autoComplete-1.5.2.js"></script>
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
    <div class="ui-field-contain">
        <label for="zavod-filter-menu">Vyber turnaj:</label></td>
            <select id="zavod-filter-menu" data-native-menu="false" class="filterable-select" name="z_id">
            <option>Vyber závod ...</option>
         <?php
         $query="select id, nazev, kdy from zavod order by kdy"; // where year(kdy)=year(now) ";
         $result = $SQL->query($query) or die("Query failed: " . $SQL->error);
         while ($row = $result->fetch_array()) {?>
         <option value="<?=$row["id"]?>"><?=$row["nazev"]?> <?=$row["kdy"]?></option>
         <?php
         }
         $result->close();
         ?>
        </select>
    </div>
    </form>    
    <?php
    // + rok
} else 
{
	/*
	$query=sprintf("select id, nazev, kdy from zavod where id=%d",$zavod_id);
	$result = $SQL->query($query) or die("Query failed: " . $SQL->error);
	if ($row = $result->fetch_array()) {
		/*
	         <!--  h3>Vysledky turnaje <?=$row["nazev"]?> <?=$row["kdy"]?></h3 -->
	         <script>
	         console.log( "delame!" );
	         
	         var dataString = "z_id="+<?=$zavod_id ?>; 
	
	         $.ajax({ 
	           type: "POST", 
	           url: "vysledky-data.php", 
	           data: dataString, 
	           complete: function() { 
	               var obj = $("#searchField"); 
	               console.log("po ajaxu\n"); },
	           success: function(result){ 
	             $("#show").html(result);
	             var obj = $("#searchField"); 
	             console.log("pre create\n");
	             $("#show").trigger('create') ;
	             $("#show").trigger('show.postinit') ;
	             $("input[id^='searchField']").trigger('searchField.postinit') ;
	
	             console.log("post create\n");
	             //$("#jakotable").trigger('create') ;
	           }
	         });
	         
	         </script>
	         ?>
	    <?php* /
		
	    }
	    $result->close();
	    */
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
	if ($stmt->num_rows > 1)
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
	else {
		//printf("<p>no proste nemam</p>\n");
	}
	// printout results of first kat
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

