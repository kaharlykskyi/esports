<div class="col-md-12">
    <h2 style="text-align: center;">Cup (Single elimination)</h2>
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