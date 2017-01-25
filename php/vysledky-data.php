
<?php
// nacteni vysledku z db
$id = $_POST["z_id"];
if (!isset($id))
{
	echo "<h4>invokation error!</h4>\n";
}
include 'dbc.php';

if (!($stmt = $SQL->prepare("select nazev from zavod where id=?"))) {
	echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	die();
}
$stmt->bind_param('i', $id);
$stmt->execute();

/* bind result variables */
$stmt->bind_result($nazev);

if ($stmt->fetch()) {
	printf ("<h3>Vysledky z '%s'</h3>\n", $nazev);
}
$stmt->close();
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
<div id="blee">
  <!-- ITEMS TO BE DISPLAYED HERE -->
</div>
<ul id="">
</ul>

