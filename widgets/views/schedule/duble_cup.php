<div class="col-md-12">
    <h2 style="text-align: center;">Cup (Duble elimination)</h2>
    <?php  $i = 0; $g = 0; foreach ($dcup as $posit_game): ?>
        <?php if($i != $posit_game['tur']): ?>
            <h4 style="text-align: center;padding-bottom: 0;color:#005db4;">
                <?php 
                    if ($posit_game->group != $g) {
                        $wiget->group($posit_game);
                        $g = $posit_game->group;
                    }
                     
                ?>
            </h4>
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