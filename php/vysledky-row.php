<?php
include 'dbc.php';
// TODO check/save what come from ajax

// v id je iz zavodu
//$kid, $kname

if (!isset($kid) or !isset($id))
{
	printf("<!-- kat/zav id unknown -->\n");
	return;
}
// if kateg = 99 (pripravky) then kyu <= 5
$query="select judoka.* from kategorie, judoka where kategorie.id=".$kid."  and year(narozen) between (year(curdate())-rdo) and (year(curdate())-rod)  order by prijmeni, jmeno;";
$res = $SQL->query($query) or die("Query failed: " . $SQL->error);
		
$q_vys="select jmeno, prijmeni, zavodnik_id, win, lose, misto from vysledky inner join judoka on (judoka.id=zavodnik_id) where zavod_id = ?"; // and kateg=
$s_vys = $SQL->prepare($q_vys);
$s_vys->bind_param('i', $id);
$s_vys->execute();
$s_vys->bind_result($jmeno, $prijmeni, $zavodnik_id, $win, $lose, $misto);

?>
<h5>kategorie <?=$kname ?></h5>
<table data-role="table" data-mode="reflow" class="ui-responsive" >
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

<form method="post" data-ajax="false" id="form<?=$kid ?>">
    <input id="kat" name="kat" value="<?=$kid ?>" type="hidden" />
    
    <div class="ui-field-contain">
        <input type="text" id="searchField" placeholder="závodník ..." >
        <ul id="suggestions" data-role="listview" data-inset="true"></ul>
        
         <!--        
        <label for="name<?=$kid ?>-filter-menu">Jméno:</label>
        <select id="name<?=$kid ?>-filter-menu" data-native-menu="false" class="filterable-select" name="judoka">
            <option>Vyber závodníka ...</option>
            <!-- <option value="orange">Orange</option>
            <option value="apple">Apple</option>
            <option value="peach">Peach</option>
            <option value="lemon">Lemon</option> - ->
        <?php
/*         while ($row = $res->fetch_array()) {
            printf("<option value=\"%d\">%s %s</option>", $row["id"], $row["prijmeni"], $row["jmeno"]);
        }
        $res->close();
 */        ?>
        </select>
         -->
    <!-- script>

        $("#mainPage").bind("pageshow", function(e) {

            var autocompleteData = [
                { label: "jiri petr", value: "val1"},
                { label: "piri chmyri", value: "val2"},
                { label: "vlada made", value: "val13"},
                { label: "chlap toma", value: "val4"},
                { label: "tomas comas", value: "val5"},
            ];

            $("#searchField").autocomplete({
                target: $('#suggestions'),
                source: autocompleteData,
                callback: function(e) {
                    var $a = $(e.currentTarget);
                    $('#searchField').val( $a.data('autocomplete').value );
                    $("#searchField").autocomplete('clear');
                },
                link: 'target.html?term=',
                minLength: 1
            });
        });
    </script> -->
         
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
    <input type="button" data-theme="b" class="ui-btn ui-btn-inline" name="submit" id="submit" value="Ulozit a dalsi">
    </div>
  </div>
</form>

<?php
$SQL->close();
?>