
<?php
// nacteni vysledku z db
$id = $_POST["z_id"];
if (!isset($id))
{
	echo "<h4>invokation error!</h4>\n";
}
include 'dbc.php';

$qry ="select zavod.id as zid, zavod.nazev as zname, kategorie.id as kid, kategorie.nazev as kname  from zavod ";
$qry.=" left join zavod_kateg on (zavod.id=zavod_id) ";
$qry.=" left join kategorie on (kategorie.id = kateg_id) ";
$qry.=" where zavod.id=?";
if (!($stmt = $SQL->prepare($qry))) {
	echo "Prepare failed: (" . $SQL->errno . ") " . $SQL->error;
	die();
}
$stmt->bind_param('i', $id);
$stmt->execute();

/* bind result variables */
$stmt->bind_result($zid, $nazev, $kid, $kname);

if ($stmt->fetch()) {
	printf ("<h3>Vysledky z '%s'</h3>\n", $nazev);
} else
{
	printf("error loading");
	die();
}

?>

<button class="ui-btn ui-btn-inline" id="add_result">Pridat vysledek</button>
<script type="text/javascript">
( function( $ ) {
    // On document ready
      $(function() {
          // Bind to the navigate event
            $( window ).on( "navigate", function() {
              console.log( "navigated!" );
            });          
          $("#add_result").click(function(event){
        	  console.log("tak jsem tu!");
        	  $("#blee").html("<p>tak jsem tu!</p>");
          });
      });
//// possible 1
//      $('#example li:last').val();
// var lastTr = $(bindTable).find("tr:last");
//     $(lastTr).after(this);
}

)( jQuery );
</script>
<?php
do {
	printf("<p>%d %s</p>\n", $kid, $kname);
} while($stmt->fetch());
$stmt->close();
?>
<div id="blee">
<?php
include 'vysledky-row.php';
?>  
  

</div><!-- blee -->
<ul id="">
</ul>

