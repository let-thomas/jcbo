<div data-role="header" style="overflow:hidden;">
       <h1><?=isset($nav_title)? $nav_title : "Závody" ?></h1>
       <div data-role="navbar">
         <ul>
            <li><a href="zavody.php" <?= $nav_menu=="prehled"? "class='ui-btn-active'":"" ?>>Přehled</a>
            <li><a href="zavod.php" <?= $nav_menu=="novy"? "class='ui-btn-active'":"" ?>>Nový</a>
            <li><a href="vysledky.php" <?= $nav_menu=="vysledky"? "class='ui-btn-active'":"" ?>>Výsledky</a>
            <li><a href="zebricek.php" <?= $nav_menu=="zebrik"? "class='ui-btn-active'":"" ?>>Žebříček</a>
            <?php
            if ($nav_menu=="zprava") {
            ?>
            <li><a href="zprava.php" class='ui-btn-active'>Zpráva</a>
            <?php
            }
            ?>
         </ul>
       </div><!-- /navbar -->
    </div>
