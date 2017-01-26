<?php
?>
       <!-- <input name="text-1" id="text-1" value="" type="text"> -->
<form method="post">
    <div class="ui-block-1">
        <label for="filterBasic-input2">Jméno</label>
        <input id="filterBasic-input2" data-type="search" placeholder="zavodnik...">

<ul data-role="listview" data-filter="true" data-input="#filterBasic-input2" data-filter-reveal="true" style="display: none">
<li>Acura</li>
<li>Audi</li>
<li>BMW</li>
<li>Cadillac</li>
<li>Ferrari</li>
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

