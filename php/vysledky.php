<!DOCTYPE head PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>1JCBO - Výsledky závodu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery.mobile-1.4.5.min.css" />
    <link rel="stylesheet" href="jquery-ui.css">
    <link rel="stylesheet" href="jcbo.css">
    <!-- script src="jquery-3.1.1.min.js"></script> -->
    <script src="jquery.js"></script>
    <script src="jquery.mobile-1.4.5.min.js" ></script>
	<meta charset="UTF-8">
    <script src="jcbo.js"></script>
   <script>

</script>
</head>
<body>
<div data-role="page">
    <div data-role="header">
    <h1>Vložení výsledků závodu</h1>
    </div>

<div role="main" class="ui-content">

<?php
include 'dbc.php';
if (!isset($zavod_id))
{
	$zavod_id = $_POST["z_id"];
}

if (isset($zavod_id))
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
           success: function(result){ 
             $("#show").html(result); 
           }
         });
         </script>
    <?php
    }
    $result->close();
} else 
{
	// show selection
	?>
    <form method="post" action="vysledky_cmd.php">
    <table>
    <tr>
    <td><label for="title-filter-menu">Vyber turnaj:</label></td>
    <td>        <select id="title-filter-menu" data-native-menu="false" class="filterable-select" name="z_id">
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
    </td>
    </tr>
    </table>
    </form>    
    <!-- rok -->
    <?php 
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

