<h6>Urlaub</h6>
<div class="row">
    <?php
    echo "<div class='col s4 m3 l2'>";
    echo "<a href='" . route('web::urlaub::legacy', ['option' => 'uebersicht']) . "'>Übersicht</a>";
    echo "</div>";
    echo "<div class='col s4 m3 l2'>";
    echo "<a href='" . route('web::urlaub::legacy', ['option' => 'monatsansicht']) . "'>Monatsansicht</a>";
    echo "</div>";
    echo "<div class='col s4 m3 l2'>";
    echo "<a href='" . route('web::urlaub::legacy', ['option' => 'urlaubsplan_jahr']) . "'>Urlaubsplan PDF</a>";
    echo "</div>";
    ?>
</div>
    