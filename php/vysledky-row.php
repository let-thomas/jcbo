<!--  < ! DOCTYPE html> 
<html>
<body> -->
<div data-role="main">
<?php
include 'dbc.php';
// TODO check/save what come from ajax

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST["action"] === 'store') && isset($_POST["formData"]) ) // post zavodnika
{
	parse_str($_POST["formData"], $data);
	$zavodnik_id = $data["j_id"];
	$kat_id = $data["kat_id"];
	$zavod_id = $data["z_id"];
	/*$win = $_POST["win"];
	$lose = $_POST["lose"];
	$position = $_POST["position"];
	$comment = $_POST["comment"];*/
	
	if (isset($zavodnik_id) && isset($kat_id) && isset($zavod_id))
	{
		if (!($stmt = $SQL->prepare("INSERT INTO vysledky(zavodnik_id, zavod_id, kategorie_id, win, lose, misto, komentar) VALUES (?,?,?,?,?,?,?)"))) {
			echo "Prepare insert failed: (" . $SQL->errno . ") " . $SQL->error;
			die();
		}
		
		$stmt->bind_param('iiiiiis', $zavodnik_id, $zavod_id, $kat_id, $data["win"], $data["lose"], $data["position"], $data["comment"]);
		$stmt->execute();
		$stmt->close();
	}
}
// v id je iz zavodu
//$kat_id, $kname
if (!isset($kat_id) or !isset($zavod_id))
{
	$zavod_id = $_GET["zid"];
	$kat_id = $_GET["kid"];
}

if (!isset($kat_id) or !isset($zavod_id))
{
	printf("<!-- kat/zav id unknown -->\n</div>\n");
	return;
}
// if kateg = 99 (pripravky) then kyu <= 5
$query="select judoka.* from kategorie, judoka where kategorie.id=".$kat_id."  and year(narozen) between (year(curdate())-rdo) and (year(curdate())-rod)  order by prijmeni, jmeno;";
$res = $SQL->query($query) or die("Query failed: " . $SQL->error);
		
$q_vys="select jmeno, prijmeni, zavodnik_id, win, lose, misto from vysledky inner join judoka on (judoka.id=zavodnik_id) where zavod_id = ? and kategorie_id=?";
$s_vys = $SQL->prepare($q_vys);
$s_vys->bind_param('ii', $zavod_id, $kat_id);
$s_vys->execute();
$s_vys->bind_result($jmeno, $prijmeni, $zavodnik_id, $win, $lose, $misto);
$s_vys->store_result();
//printf("<p>stmt->num_rows: %d</p>\n", $stmt->num_rows);
if ($s_vys->num_rows > 0) {
?>
<h5>kategorie <?=$kname ?></h5>
<table data-role="table" data-mode="reflow" class="ui-responsive" id="vysledky" >
<thead>
	<tr>
	<th>Jméno</th><th>výhry</th><th>prohry</th><th>místo</th>
	</tr>
</thead>
<tbody>
<?php 
while ($s_vys->fetch()) {
    printf("<tr >\n"); // background-color
    printf("<td>%s %s</td><td>%d</td><td>%d</td><td>%s</td>\n", $jmeno, $prijmeni, $win, $lose, (isset($misto)&&$misto>0)?$misto:"bez" );
    printf("</tr>\n");
}
?>
</tbody>
</table>
<?php
} // if some rows
?>

<form method="post" data-ajax="false" id="form<?=$kat_id ?>">
    <input id="kat" name="kat_id" value="<?=$kat_id ?>" type="hidden" />
    <input id="zavod" name="z_id" value="<?=$zavod_id ?>" type="hidden" />
    <input id="judoka<?=$kat_id ?>" name="j_id" value="" type="hidden" />
    
    <div class="ui-field-contain">
        <input type="text" id="searchField<?=$kat_id ?>" placeholder="závodník ..." >
        <ul id="suggestions<?=$kat_id ?>" data-role="listview" data-inset="true"></ul>
        
         
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
        <label for="in_pos">Umístění</label>
        <!--select id="misto-filter-menu" data-native-menu="false" class="filterable-select" name="position">
            <option value="0">bez</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="5">5</option>
            <option value="7">7</option>
            <option value="9">9</option>
        </select-->
	    <input data-inline="true" data-clear-btn="false" name="position" id="in_pos" value="" type="number">
    </div>
  </div>
<!--  --> 
<div class="ui-grid-a">
    <div class="ui-block-a" >   <!-- data-role="fieldcontain" -->

    <label for="in_comment">Komentář: </label><!-- <input data-clear-btn="true" name="comment" id="in_comment" value="" type="text"> -->
    <textarea rows="1" name="comment" id="in_comment"></textarea>
    </div>

    <div class="ui-block-d">
    <!-- <input type="submit" class="ui-btn ui-btn-inline" value="Ulozit a dalsi"> -->
    <input type="button" data-theme="b" class="ui-btn ui-btn-inline" name="action" id="store<?=$kat_id ?>" value="Ulozit a dalsi">
    </div>
  </div>
</form>

<?php
$SQL->close();
?>
</div>
<!-- </body>
</html> -->
