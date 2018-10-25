<div class="col-md-12">
    <?php $i = 0; $g = 0; foreach ($turs as $posit_game): ?>
    <?php if(($g != $posit_game['group'])&& !is_null($posit_game['group'])): ?>
        <h4 style="text-align: center;">
            GROUP 
            <?php 
                echo $posit_game['group']; 
                $g = $posit_game['group'];
            ?>
        </h4>
    <?php endif; ?>
    <?php if($i != $posit_game['tur']): ?>
        <h5 style="text-align: center;">
            ROUND 
            <?php 
                echo $posit_game['tur']; 
                $i = $posit_game['tur'];
            ?>
        </h5>
    <?php endif; ?>
    <p class="item">
        <span class="teams-wrap">
            <span class="team">
                <a href="<?= $posit_game->teamF->links() ?>">
                    <span>
                        <img src="<?= $posit_game->teamF->logo() ?>" alt="team-logo" onerror="this.src = '/images/hockey/team-logo1.png'" >
                    </span>
                    <span><?=$posit_game->teamF->name?></span>
                </a>
            </span>
            <span class="score">
               <a href="/matches/public/<?=$posit_game->id?>"><span><?=$posit_game['results1']??' -- ' ?>:<?=$posit_game['results2']??' -- ' ?></span></a> 
            </span>
            <span class="team1">
                <a href="<?= $posit_game->teamS->links() ?>">
                    <span><?=$posit_game->teamS->name?></span>
                    <span>
                        <img src="<?= $posit_game->teamS->logo() ?>" alt="team-logo" onerror="this.src = '/images/hockey/team-logo1.png'"  >
                    </span>
                </a>
            </span>
        </span>
        <span class="game-result"><?=$posit_game['date'] ?></span>
    </p>
<?php endforeach; ?>
</div>