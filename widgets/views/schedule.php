<div class="col-md-12">
    <?php $i = 0; foreach ($turs as $posit_game): ?>
    <?php if($i != $posit_game['tur']): ?>
        <h5 style="text-align: center;">ROUND <?php echo $posit_game['tur']; $i= $posit_game['tur'];?></h5>
    <?php endif; ?>
    <p class="item">
        <span class="teams-wrap">
            <span class="team">
                <a href="/teams/public/<?=$posit_game['team1']?>">
                    <span>
                        <img src="<?= $posit_game['f_logo'] ?? '/images/hockey/team-logo1.png' ?>" alt="team-logo" onerror="this.src = '/images/hockey/team-logo1.png'" >
                    </span>
                    <span><?=$posit_game['f_name']?></span>
                </a>
            </span>
            <span class="score">
                <span><?=$posit_game['results1']??' -- ' ?>:<?=$posit_game['results2']??' -- ' ?></span>
            </span>
            <span class="team1">
                <a href="/teams/public/<?=$posit_game['team2']?>">
                    <span><?=$posit_game['s_name']?></span>
                    <span>
                        <img src="<?= $posit_game['s_logo'] ?? '/images/hockey/team-logo1.png' ?>" alt="team-logo" onerror="this.src = '/images/hockey/team-logo1.png'"  >
                    </span>
                </a>
            </span>
        </span>
        <span class="game-result"><?=$posit_game['date'] ?></span>
    </p>
<?php endforeach; ?>
</div>