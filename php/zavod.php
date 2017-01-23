<!DOCTYPE head PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>1JCBO - Vytvoření závodu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js" ></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
     <script>
  $( function() {
        $( "#datepicker" ).datepicker();
        $( "#datepicker" ).datepicker( "option", "dateFormat", "d.m.yy" );
  } );
  </script>
 <meta charset="UTF-8">
</head>
<body>
<h1>Vytvoření nového závodu</h1>
<form action="zavod_cmd.php" method="post" >
<table>
<tr>
    <td><label for="text-basic">Název:</label></td>
    <td><input name="nazev" id="nazev" value="" type="text"></td>
</tr>
<!-- only for chromy tr>
    <td><label for="date">Kdy:</label>
    <td><input name="kdy" id="kdy" value="" type="date"></td>
</tr -->
<tr>
    <td><label for="date">Kdy:</label>
    <td><input name="kdy" id="datepicker" value="" type="text"></td>
</tr>
<tr>
    <td><label for="text-basic">Kde:</label>
    <td><input name="kde" id="kde" value="" type="text"></td>
</tr>
<tr>
    <td><label for="text-basic">Typ:</label>
    <td><select name="typ">
    <?php
    include 'dbc.php';
    $qry = "select id, nazev from zavody_typ order by nazev";
    $result_res = $SQL->query($qry) or die("Query failed: " . $SQL->error);
    while ($row = $result_res->fetch_array()) { ?>
        <option value="<?=$row["id"]?>"><?=$row["nazev"]?></option>
    <?php } ?>
    </select>
    </td>
</tr>
<tr>
    <td><label for="text-basic">Vedouci trener:</label><!-- load by id -->
    <td><input name="tren_id" id="" value="" type="text"></td>
</tr>

<tr>
    <td valign="top" for="text-basic"><label for="textarea">Pozvánka:</label>
    <td><textarea cols="40" rows="8" name="pozvanka" id="pozvanka"></textarea>
</tr>
</table>
<a href="#" class="ui-shadow ui-btn ui-corner-all">Link button</a>
<button class="ui-shadow ui-btn ui-corner-all" type="submit">Ulozit</button>
</form>

<?php
# echo $_SERVER['SERVER_NAME']
#$comma_separated = implode(",", $_SERVER);
#echo $comma_separated; // lastname,email,phone
$SQL->close();
?>
</table>
</body>
</html>
