<div class="col-md-12">
    <h2 style="text-align: center;">League (Group + Playoff)</h2>
    <?php  $sw = 0; $g = 0; $i = 0; foreach ($gleague as $posit_game): ?>
    <?php if($posit_game->group != $g): ?>
        <h4 style="text-align: center;padding-bottom: 0;color:#005db4;">
            <?php 
                $wiget->group($posit_game);
                $g = $posit_game->group;
                $sw = 1;  
            ?>
        </h4>
    <?php endif; ?>
    <?php if($i != $posit_game['tur'] || $sw ): ?>
        <h5 style="text-align: center;">
            ROUND 
            <?php 
                echo $posit_game['tur']; 
                $i = $posit_game['tur'];
                $sw = 0;
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