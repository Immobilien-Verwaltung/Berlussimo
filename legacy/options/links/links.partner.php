<h6>Partner</h6>
<div class="row">
    <?php
    echo "<div class='col s4 m3 l1'>";
    echo "<a href='" . route('web::partner::legacy', ['option' => 'partner_liste']) . "'>Alle</a>";
    echo "</div>";
    echo "<div class='col s4 m3 l1'>";
    echo "<a href='" . route('web::partner::legacy', ['option' => 'partner_erfassen']) . "'>Neu</a>";
    echo "</div>";
    echo "<div class='col s4 m3 l1'>";
    echo "<a href='" . route('web::partner::legacy') . "'>Suchen</a>";
    echo "</div>";
    echo "<div class='col s4 m3 l1'>";
    echo "<a href='" . route('web::partner::legacy', ['option' => 'partner_umsatz']) . "'>Umsatz</a>";
    echo "</div>";
    echo "<div class='col s4 m3 l1'>";
    echo "<a href='" . route('web::partner::legacy', ['option' => 'serienbrief']) . "'>Serienbrief</a>";
    echo "</div>";
    ?>
</div>
    