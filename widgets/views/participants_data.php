

<div class="container" style="margin-bottom: 30px;">
    <?php  if($access==1): 
        $users_tournaments = $model->getPlayersTeams();
    ?>
    <p style="text-align: center;color: red;" >
        To adjust player’s “fair play” rating, please proceed to his profile page
    </p>
        <?php $i = 0; foreach ($users_tournaments as $users_tournament):?>
            <?php if (!is_null($users_tournament->team->single_user)): ?>
                <h6 style="text-align:center;" >single player</h6>
            <?php elseif ($users_tournament->team->id != $i):?>
                <?php $i = $users_tournament->team->id; ?>
                <h6 style="text-align:center;" ><b>Team:</b> 
                    <a href="<?=$users_tournament->team->links()?>">
                        <?=$users_tournament->team->name?>
                            
                        </a>
                    </h6>
            <?php endif; ?>
                <p style="text-align:center;" ><b>User:</b> 
                    <a href="/user/public/<?=$users_tournament->user->id?>?tournament=<?=$model->id?>">
                        <b><?=$users_tournament->user->name?></b>
                    </a>
                </p>
                <div style="text-align:center;" >
                    <?=$wget->getPers($users_tournament->text)?>
                </div>
        <?php endforeach; ?>
    <?php endif; ?> 

    <?php if($access==2): 
        $users_tournaments = $model->getPlayersTeam(\Yii::$app->user->identity->id);
    ?>
        <?php $i = 0; foreach ($users_tournaments as $users_tournament):?>
            <?php if ($users_tournament->team->id != $i):?>
                <?php $i = $users_tournament->team->id; ?>
                <h6 style="text-align:center;" >
                    <?= $users_tournament->team->single_user?'single player':$users_tournament->team->name?>
                </h6>
            <?php endif; ?>
                <p style="text-align:center;" ><b>User:</b> 
                    <a href="/user/public/<?=$users_tournament->user->id?>">
                       <b> <?=$users_tournament->user->name?> </b>
                    </a>
                </p>
                <div style="text-align:center;" >
                    <?=$wget->getPers($users_tournament->text)?>
                </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if($access==3): 
        $users_tournaments = $model->getPlayer(\Yii::$app->user->identity->id);
    ?>
            <?php if ($users_tournament->team->id != $i):?>
                <h6 style="text-align:center;" >
                    <?=$users_tournament->team->single_user?'single player':$users_tournament->team->name?>
                </h6>
            <?php endif; ?>
                <p style="text-align:center;" ><b>User:</b> <?=$users_tournament->user->name?></p>
                <div style="text-align:center;" >
                    <?=$wget->getPers($users_tournament->text)?>
                </div>
    <?php endif; ?>

</div>
