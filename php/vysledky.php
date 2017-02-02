<!DOCTYPE head PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>1JCBO - Výsledky závodu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery.mobile-1.4.5.min.css" />
    <link rel="stylesheet" href="jquery-ui.css">
    <link rel="stylesheet" href="jcbo.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="jquery.js"></script>
    <script src="jquery.mobile-1.4.5.min.js" ></script>
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
	$query=sprintf("select id, nazev, kdy from zavod where id=%d",$zavod_id);
	$result = $SQL->query($query) or die("Query failed: " . $SQL->error);
	if ($row = $result->fetch_array()) {?>
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
	    <?php
	    }
	    $result->close();
}
$SQL->close();
?>


<div id="show">
  <!-- ITEMS TO BE DISPLAYED HERE -->
</div>
</div><!-- main -->
</div><!-- page -->
</body>
</html>

