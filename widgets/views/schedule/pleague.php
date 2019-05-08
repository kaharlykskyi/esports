<div class="col-md-12">
    <h2 style="text-align: center;">League</h2>
    <?php  $i = 0; foreach ($league as $posit_game): ?>
    <?php if($i != $posit_game['tur']): ?>
        <h5 style="text-align: center;">
            ROUND 
            <?php 
                echo $posit_game['tur']; 
                $i = $posit_game['tur'];
            ?>
        </h5>
    <?php endif; ?>
    <?=$this->render('_items',compact('posit_game')); ?>
<?php endforeach; ?>
<?php if(!empty($cup)):?>
    <h2 style="text-align: center;">TEAMS IN PLAYOFF</h2>
<?php endif; ?>
<?php  $i = 0;  foreach ($cup as $posit_game): ?>
    <?php if($i != $posit_game['tur']): ?>
        <h5 style="text-align: center;">
            ROUND 
            <?php 
                echo $posit_game['tur']; 
                $i = $posit_game['tur'];
            ?>
        </h5>
    <?php endif; ?>
    <?=$this->render('_items',compact('posit_game')); ?>
<?php endforeach; ?>
</div>