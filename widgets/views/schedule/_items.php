
<article class="edgtf-match-status-to_be_played">
    <div class="edgtf-match-item-holder">
        <a href="/matches/public/<?=$posit_game->id?>"></a>
        <div class="edgtf-match-single-team">
            <div class="edgtf-match-item-image-holder">
                <img src="<?= $posit_game->teamF->logo() ?>" onerror="this.src = '/images/hockey/team-logo1.png'">
            </div>
            <div class="edgtf-match-item-text-holder">
                <h6 class="edgtf-match-team-title">
                    <?=$posit_game->teamF->name()?>                
                </h6>
            </div>
        </div>
        <div class="edgtf-match-vs-image">
            <?php $vs =(!empty($posit_game['results2'])||!empty($posit_game['results1']))?'vs_dark.png':'vs_finished.png' ?>
            <img src="/images/tournaments/<?=$vs?>">
        </div>
        <div class="edgtf-match-single-team">
            <div class="edgtf-match-item-image-holder">
                <img src="<?= $posit_game->teamS->logo()?>" onerror="this.src = '/images/hockey/team-logo1.png'">
            </div>
            <div class="edgtf-match-item-text-holder">
                <h6 class="edgtf-match-team-title">
                    <?=$posit_game->teamS->name()?>               
                </h6>
            </div>
        </div>
        <div class="edgtf-match-info">
            <div class="edgtf-match-category">
                <span class="edgtf-match-category-holder">
                    <span>all matches</span>
                    <span>
                        <?=(!empty($posit_game['results2'])||!empty($posit_game['results1']))?'latest results':'upcoming matches'?>
                    </span>
                </span>                         
            </div>
            <h5 class="edgtf-match-title"  style="padding: 0;">
                <span><?=$posit_game['results1']??' -- ' ?>:<?=$posit_game['results2']??' -- ' ?></span>  
            </h5>
            <div class="edgtf-match-date">
                <span class="edgtf-match-date"><?=$posit_game['date'] ?></span>   
            </div>
        </div>
    </div>
</article>


