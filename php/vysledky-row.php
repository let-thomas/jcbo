<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<div data-role="main">
<?php
include 'dbc.php';
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
		
$q_vys="select vysledky.id, jmeno, prijmeni, zavodnik_id, vyhry, prohry, misto, vaha, komentar from vysledky inner join judoka on (judoka.id=zavodnik_id) where zavod_id = ? and kategorie_id=?";
$s_vys = $SQL->prepare($q_vys);
if (! $s_vys) {
	printf("prepare error: %s\n", $SQL->error);
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	die();	
}
$s_vys->bind_param('ii', $zavod_id, $kat_id);
$s_vys->execute();
$s_vys->bind_result($vysledek_id, $jmeno, $prijmeni, $zavodnik_id, $vyhry, $prohry, $misto, $vaha, $komentar);
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
while ($s_vys->fetch()) {// background-color ?>
    <tr > 
    <td id="td_<?=$vysledek_id ?>"><?= $jmeno ?> <?= $prijmeni?> 
        <input type='button' data-icon='edit ' data-iconpos='notext' value='Icon only' data-inline='true' id="edit_<?=$vysledek_id ?>">
        <input type='button' data-icon='delete' data-iconpos='notext' value='Icon only' data-inline='true' id="del_<?=$vysledek_id ?>">
        <input type="hidden" name="vyhry" value="<?=$vyhry?>"> 
        <input type="hidden" name="prohry" value="<?=$prohry?>">
        <input type="hidden" name="misto" value="<?=$misto?>">
        <input type="hidden" name="vaha" value="<?=$vaha?>">
        <input type="hidden" name="komentar" value="<?=$komentar?>">
        <input type="hidden" name="kat_id" value="<?=$kat_id ?>"/>
        <script>
        lidi[<?=$vysledek_id ?>] = "<?= $jmeno ?> <?= $prijmeni?>";
        </script>
    </td>
    <?php 
    printf("<td>%d</td><td>%d</td><td>%s</td>\n", $vyhry, $prohry, (isset($misto)&&$misto>0)?$misto:"bez" );
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
    <input id="v_id" name="v_id" value="" type="hidden" />
    
    <div class="ui-field-contain">
        <input type="text" id="searchField<?=$kat_id ?>" placeholder="závodník ..." tabindex="1" >
        <ul id="suggestions<?=$kat_id ?>" data-role="listview" data-inset="true"></ul>
        
         
    </div>
  <div class="ui-grid-c">
    <div class="ui-block-a"  >
        <label for="in_win">Vítězství</label>
	   <input data-clear-btn="false" name="vyhry" id="in_win" value="" type="number" tabindex="2">
    </div>
    <div class="ui-block-b">
        <label for="in_lose">Prohry</label>
	   <input data-clear-btn="false" name="prohry" id="in_lose" value="" type="number" tabindex="3">
    </div>
    <div class="ui-block-c">
        <label for="in_pos">Umístění</label>
	    <input data-inline="true" data-clear-btn="false" name="position" id="in_pos" value="" type="number" tabindex="4" title="bez= nevyplňovat">
    </div>
    <div class="ui-block-d">
        <label for="in_wgh">Váha</label>
        <input data-inline="true" data-clear-btn="false" name="vaha" id="in_wgh" value="" type="number" tabindex="5" title="">
    </div>
  </div>
<!--  --> 
<div class="ui-grid-a">
    <div class="ui-block-a" >   <!-- data-role="fieldcontain" -->

    <label for="in_comment">Komentář: </label><!-- <input data-clear-btn="true" name="comment" id="in_comment" value="" type="text"> -->
    <textarea rows="1" name="comment" id="in_comment" tabindex="5"></textarea>
    </div>

    <div class="ui-block-b">
    <label for="store<?=$kat_id ?>">&nbsp;</label>
    <!-- <input type="submit" class="ui-btn ui-btn-inline" value="Ulozit a dalsi"> -->
    <!-- <div class="ui-mini"> -->
        <input type="button" data-theme="b" class="ui-btn ui-btn-inline " name="action" id="store<?=$kat_id ?>" value="Ulozit a dalsi" tabindex="6">

    </div>
  </div>
</form>

<?php
$SQL->close();
?>
</div>
<!-- </body>
</html> -->
