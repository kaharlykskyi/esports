<?php

    if ($tournament->game_id ==1) {
        if (!empty($data)&&is_array($data)) {
           foreach ($data as $element) {
             echo '<img class="img_data"
             src="/images/game/hearthstone/'.$element.'.png" >';
         }
        } else {
            echo "no data";
        }
    }

    if ($tournament->game_id == 2) {
        if (!empty($data)&&is_array($data)) {
            echo "<img src='/images/game/{$data['icons']['.']}.png' title='{$data['name']}'>";
        } else {
            echo "no data";
        }
    }
