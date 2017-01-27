<?php
include 'dbc.php';
// TODO check/save what come from ajax

//$kid, $kname
$query="select judoka.* from kategorie, judoka where kategorie.id=4  and year(narozen) between (year(curdate())-rdo) and (year(curdate())-rod)  order by prijmeni, jmeno;";
$res = $SQL->query($query) or die("Query failed: " . $SQL->error);
		
?>
<h5>kategorie <?=$kname ?></h5>

<form method="post">
    <div class="ui-block-1">
        <label for="filterBasic-input2">Jméno</label>
        <input type="text" id="filterBasic-input2" data-type="search" placeholder="zavodnik...">

		<ul data-role="listview" data-filter="true" data-input="#filterBasic-input2" data-filter-reveal="true" style="margin: 0"><!--  display: none -->
        <?php
        while ($row = $res->fetch_array()) {
        	printf("<li>%s %s</li>", $row["prijmeni"], $row["jmeno"]);
        }
        $res->close();
        ?>
		</ul>
       
    </div>
 <div class="ui-grid-b">
    <div class="ui-block-a"  >
        <label for="in_win">Vítězství</label>
	   <input data-clear-btn="false" name="win" id="in_win" value="" type="number">
    </div>
    <div class="ui-block-b">
        <label for="in_lose">Prohry</label>
	   <input data-clear-btn="false" name="lose" id="in_lose" value="" type="number">
    </div>
    <div class="ui-block-c">
        <label for="misto-filter-menu">Umístění</label>
        <select id="misto-filter-menu" data-native-menu="false" class="filterable-select" name="position">
            <option value="0">bez</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="5">5</option>
            <option value="7">7</option>
            <option value="9">9</option>
        </select>
	   <!-- <input data-inline="true" data-clear-btn="false" name="position2" id="in_position2" value="bez" type="number"> -->
    </div>
  </div>
<!--  --> 
<div class="ui-grid-a">
    <div class="ui-block-a">   

    <label for="in_comment">Komentář: </label><input data-clear-btn="true" name="comment" id="in_comment" value="" type="text">
    </div>

    <div class="ui-block-d">
    <input type="submit" class="ui-btn ui-btn-inline" value="Ulozit a dalsi">
    </div>
  </div>
</form>

<?php
$SQL->close();
?>