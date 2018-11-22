<?php
    use app\widgets\Alert;
    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use app\models\servises\FlagServis;
    use Yii;

    $this->registerCssFile('https://use.fontawesome.com/releases/v5.2.0/css/all.css');
    $this->registerCssFile('css/team.css', ['depends' => ['app\assets\AppAsset']]);
    $this->title = $model->name;

    $user = false;
    if (Yii::$app->user->identity) {
        $user = Yii::$app->user->identity->id;
    }
    if(!empty($user_points_month)){
        $sum = json_encode(ArrayHelper::getColumn($user_points_month, 'sum'));
        $y_m = json_encode(ArrayHelper::getColumn($user_points_month, 'y_m'));
        $js_cod ="
            $(document).ready(function(){
                if ($('#bonus-bal').length > 0) {
                    let sum = {$sum};
                    let y_m = {$y_m};
                    $('#bonus-bal').teamGraphTimeseries(y_m,[sum],[0, 50, 100, 150],
                    '250px',true,);
                }
            });
        ";
        $this->registerJs($js_cod, yii\web\View::POS_END);
    }
    
?>

<section class="image-header" style="min-height: 450px; background: url(<?=$model->background()?>) no-repeat right;background-size: cover;">
    <div class="player-photo geme-foto" style="top:300px;">
        <img class="img-responsive" src="<?=FlagServis::getLinkFlag($model->country);?>" alt="flag">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="info">
                    <div class="wrap">
                    </div>
                </div>
            </div>  
        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="captain-bage">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">
                        <?=Yii::t('app','Name')?>
                    </font>
                </font>
            </div>
            <h4 class="player-name">
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;"><?=$model->name?></font>
                </font>
            </h4>
        </div>
        <div class="col-md-3">
            <div class="player-photo">
                <img class="img-responsive" src="<?=$model->avatar()?>" alt="игрок">
            </div>
        </div>
        <div class="col-md-9">
           <div class="summary">
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item">
                            <b><?=Yii::t('app','Nationality')?>:</b>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <img src="<?=FlagServis::getLinkFlag($model->country);?>" style="height:15px;" alt="flag">
                        <?=$model->country?>
                    </div>
                </div>  
                <div class="row" style="margin-bottom: 15px;">  
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Sex')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?=($model->sex == 1 )? Yii::t('app','Male'): (($model->sex == 2 )?Yii::t('app','Female'): '----') ?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Date of Birth')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?=date('Sj F ',strtotime($model->birthday))?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Favorite game')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?php if ($model->gameF):?>
                            <img  style="height: 25px;" src="/images/game/<?=$model->gameF->logo;?>" 
                            alt="<?=$model->gameF->name;?>">
                            <?=$model->gameF->name;?>
                        <?php else: ?>
                            ----
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row player-hockey-wrap" style="margin-bottom: 15px;background-color: transparent;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Fair play')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9 ">
                        <div class="wrapper-circle">
                            <div class="circle-item" >
                                <div class="circle-bar" id="circle_1" data-percent="<?=$model->fair_play?>">
                                </div>
                                    <?php if($user && $capitan_tournament):?>
                                    <?php if($capitan_tournament->tournament->user_id == $user):?>
                                    <form action="/user/remove-rating/<?=$model->id?>" method="POST">
                                        <input type="text" name="tournament" hidden value="<?=$capitan_tournament->tournament->id ?>" >
                                        <?= Html::hiddenInput(
                                            \Yii::$app->getRequest()->csrfParam, 
                                            \Yii::$app->getRequest()->getCsrfToken(), 
                                            []
                                        );?>
                                        <?php
                                            $disabled = '';
                                            if($capitan_tournament->fair_play){
                                                $disabled = 'disabled';
                                            }
                                        ?>
                                        <button class="btn btn-red btn-sm" <?=$disabled?>
                                            style="margin-left:25px;" >
                                            <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                            <?=Yii::t('app','Remove rating')?>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Activities')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?= !empty($model->activities)?$model->activities:'----' ?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <div class="item"><b><?=Yii::t('app','Interests')?>:</b></div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <?= !empty($model->interests)?$model->interests:'----' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="broadcast-list" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="broadcast-item">
            <div class="item-header" id="headingOne">
                <div class="row">
                    <div class="col-md-1 col-sm-2">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="arrow collapsed" aria-expanded="false"><i class="fa fa-caret-down" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="col-md-7 col-sm-10">
                        <div class="item-head-body">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="item">
                                    <b><?=Yii::t('app','Sum of balls')?>:</b>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <?=$model->ball?> 
                                <?=Yii::t('app','ball')?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <?php 
                            $awards_text = "";
                            if ($model->ball>3000) {
                                $awards_text = Yii::t('app','Gold cup');
                                $cup_awards = "fill:gold;";
                            } elseif ($model->ball>2000) {
                                $awards_text = Yii::t('app','Silver cup');
                                $cup_awards = "fill:silver;";
                            } elseif ($model->ball>1000) {
                                $awards_text = Yii::t('app','Bronze cup');
                                $cup_awards = "fill:#cd7f32;";
                            } else {
                                $awards_text = "No awards";
                                $cup_awards = "";
                            }
                        ?>
                        <div class="channel">
                            <p><span><?=$awards_text?></span></p>
                            
                            <?php if($model->ball>1000): ?>
                            <p>
                            <svg id="Layer_1" style="enable-background:new 0 0 100.4 100.4;<?=$cup_awards?>" version="1.1" viewBox="0 0 100.4 100.4" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M88.5,15.3c-0.3-0.3-0.7-0.5-1.1-0.5H72.2v-7c0-0.8-0.7-1.5-1.5-1.5H28c-0.8,0-1.5,0.7-1.5,1.5v7H10.9   c-0.4,0-0.8,0.2-1.1,0.5c-0.3,0.3-0.4,0.7-0.4,1.1c0,0.3,0.3,6.7,2.6,14.1c3.2,9.9,8.6,16.9,15.8,20.1c2.4,8,7.9,14.3,14.8,16.8   v0.3c0,8.3-6.3,14.9-14.4,14.9c-0.8,0-1.5,0.7-1.5,1.5v8.5c0,0.8,0.7,1.5,1.5,1.5h42.5c0.8,0,1.5-0.7,1.5-1.5v-8.5   c0-0.8-0.7-1.5-1.5-1.5c-8.2,0-14.9-6.7-14.9-14.9v-0.2C63,65,68.6,58.6,71,50.4c6.9-3.3,12.2-10.2,15.3-19.9   c2.4-7.4,2.6-13.9,2.6-14.1C89,16,88.8,15.6,88.5,15.3z M12.5,17.8h14v24c0,1.7,0.1,3.3,0.4,4.9C15.5,39.9,13,23,12.5,17.8z    M69.2,85.5V91H29.7v-5.5c8.8-0.7,15.6-8,15.8-17.3c1.2,0.2,2.5,0.4,3.8,0.4c1.2,0,2.4-0.1,3.5-0.3C53.2,77.4,60.3,84.8,69.2,85.5z    M53.3,65.2c-1.3,0.3-2.6,0.5-3.9,0.5c-1.5,0-3-0.2-4.4-0.6c-0.3-0.1-0.8-0.3-1-0.3c-8.3-2.8-14.5-12-14.5-22.9V9.4h39.7v6v1.9   v24.6c0,10.9-6.2,20.1-14.6,22.9 M71.9,46.5c0.2-1.5,0.4-3.1,0.4-4.7v-24h13.6C85.4,23,83,39.4,71.9,46.5z"/><path d="M63.8,27.3l-8.2-1.2l-3.7-7.5c-0.4-0.8-1.3-1.4-2.2-1.4c0,0,0,0,0,0c-0.9,0-1.8,0.5-2.2,1.4l-3.7,7.5l-8.2,1.2   c-0.9,0.1-1.7,0.8-2,1.7c-0.3,0.9-0.1,1.9,0.6,2.5l6,5.8l-1.4,8.2c-0.2,0.9,0.2,1.8,1,2.4c0.4,0.3,0.9,0.5,1.5,0.5   c0.4,0,0.8-0.1,1.1-0.3l7.6-3.8l7.2,3.8c0.8,0.4,1.8,0.4,2.6-0.2c0.8-0.6,1.1-1.5,1-2.4l-1.4-8.2l6-5.8c0.7-0.7,0.9-1.6,0.6-2.5   C65.5,28.1,64.8,27.4,63.8,27.3z M56.6,35.7c-0.4,0.3-0.5,0.8-0.4,1.3l1.4,7.9l-6.9-3.6c-0.4-0.2-0.9-0.2-1.4,0L41.9,45l1.4-8   c0.1-0.5-0.1-1-0.4-1.3l-5.7-5.6l7.9-1.2c0.5-0.1,0.9-0.4,1.1-0.8l3.5-7.2l3.5,7.2c0.2,0.4,0.6,0.8,1.1,0.8l7.9,1.2L56.6,35.7z"/></g>
                                </svg>
                            </p>
                             <?php endif; ?>
                        </div>
                    </div>
                </div>  
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false">
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="timeline-bar">
                            <div class="cup_img cup_img1" >
                                <p>
                                <svg id="Layer_1" style="enable-background:new 0 0 100.4 100.4;fill:#cd7f32;" version="1.1" viewBox="0 0 100.4 100.4" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M88.5,15.3c-0.3-0.3-0.7-0.5-1.1-0.5H72.2v-7c0-0.8-0.7-1.5-1.5-1.5H28c-0.8,0-1.5,0.7-1.5,1.5v7H10.9   c-0.4,0-0.8,0.2-1.1,0.5c-0.3,0.3-0.4,0.7-0.4,1.1c0,0.3,0.3,6.7,2.6,14.1c3.2,9.9,8.6,16.9,15.8,20.1c2.4,8,7.9,14.3,14.8,16.8   v0.3c0,8.3-6.3,14.9-14.4,14.9c-0.8,0-1.5,0.7-1.5,1.5v8.5c0,0.8,0.7,1.5,1.5,1.5h42.5c0.8,0,1.5-0.7,1.5-1.5v-8.5   c0-0.8-0.7-1.5-1.5-1.5c-8.2,0-14.9-6.7-14.9-14.9v-0.2C63,65,68.6,58.6,71,50.4c6.9-3.3,12.2-10.2,15.3-19.9   c2.4-7.4,2.6-13.9,2.6-14.1C89,16,88.8,15.6,88.5,15.3z M12.5,17.8h14v24c0,1.7,0.1,3.3,0.4,4.9C15.5,39.9,13,23,12.5,17.8z    M69.2,85.5V91H29.7v-5.5c8.8-0.7,15.6-8,15.8-17.3c1.2,0.2,2.5,0.4,3.8,0.4c1.2,0,2.4-0.1,3.5-0.3C53.2,77.4,60.3,84.8,69.2,85.5z    M53.3,65.2c-1.3,0.3-2.6,0.5-3.9,0.5c-1.5,0-3-0.2-4.4-0.6c-0.3-0.1-0.8-0.3-1-0.3c-8.3-2.8-14.5-12-14.5-22.9V9.4h39.7v6v1.9   v24.6c0,10.9-6.2,20.1-14.6,22.9 M71.9,46.5c0.2-1.5,0.4-3.1,0.4-4.7v-24h13.6C85.4,23,83,39.4,71.9,46.5z"/><path d="M63.8,27.3l-8.2-1.2l-3.7-7.5c-0.4-0.8-1.3-1.4-2.2-1.4c0,0,0,0,0,0c-0.9,0-1.8,0.5-2.2,1.4l-3.7,7.5l-8.2,1.2   c-0.9,0.1-1.7,0.8-2,1.7c-0.3,0.9-0.1,1.9,0.6,2.5l6,5.8l-1.4,8.2c-0.2,0.9,0.2,1.8,1,2.4c0.4,0.3,0.9,0.5,1.5,0.5   c0.4,0,0.8-0.1,1.1-0.3l7.6-3.8l7.2,3.8c0.8,0.4,1.8,0.4,2.6-0.2c0.8-0.6,1.1-1.5,1-2.4l-1.4-8.2l6-5.8c0.7-0.7,0.9-1.6,0.6-2.5   C65.5,28.1,64.8,27.4,63.8,27.3z M56.6,35.7c-0.4,0.3-0.5,0.8-0.4,1.3l1.4,7.9l-6.9-3.6c-0.4-0.2-0.9-0.2-1.4,0L41.9,45l1.4-8   c0.1-0.5-0.1-1-0.4-1.3l-5.7-5.6l7.9-1.2c0.5-0.1,0.9-0.4,1.1-0.8l3.5-7.2l3.5,7.2c0.2,0.4,0.6,0.8,1.1,0.8l7.9,1.2L56.6,35.7z"/></g>
                                </svg>
                                </p>
                                <p><span>1000 <?=Yii::t('app','ball')?> </span></p>
                            </div>
                            <div class="cup_img cup_img2" >
                                 <p>
                                <svg id="Layer_1" style="enable-background:new 0 0 100.4 100.4;fill:silver;" version="1.1" viewBox="0 0 100.4 100.4" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M88.5,15.3c-0.3-0.3-0.7-0.5-1.1-0.5H72.2v-7c0-0.8-0.7-1.5-1.5-1.5H28c-0.8,0-1.5,0.7-1.5,1.5v7H10.9   c-0.4,0-0.8,0.2-1.1,0.5c-0.3,0.3-0.4,0.7-0.4,1.1c0,0.3,0.3,6.7,2.6,14.1c3.2,9.9,8.6,16.9,15.8,20.1c2.4,8,7.9,14.3,14.8,16.8   v0.3c0,8.3-6.3,14.9-14.4,14.9c-0.8,0-1.5,0.7-1.5,1.5v8.5c0,0.8,0.7,1.5,1.5,1.5h42.5c0.8,0,1.5-0.7,1.5-1.5v-8.5   c0-0.8-0.7-1.5-1.5-1.5c-8.2,0-14.9-6.7-14.9-14.9v-0.2C63,65,68.6,58.6,71,50.4c6.9-3.3,12.2-10.2,15.3-19.9   c2.4-7.4,2.6-13.9,2.6-14.1C89,16,88.8,15.6,88.5,15.3z M12.5,17.8h14v24c0,1.7,0.1,3.3,0.4,4.9C15.5,39.9,13,23,12.5,17.8z    M69.2,85.5V91H29.7v-5.5c8.8-0.7,15.6-8,15.8-17.3c1.2,0.2,2.5,0.4,3.8,0.4c1.2,0,2.4-0.1,3.5-0.3C53.2,77.4,60.3,84.8,69.2,85.5z    M53.3,65.2c-1.3,0.3-2.6,0.5-3.9,0.5c-1.5,0-3-0.2-4.4-0.6c-0.3-0.1-0.8-0.3-1-0.3c-8.3-2.8-14.5-12-14.5-22.9V9.4h39.7v6v1.9   v24.6c0,10.9-6.2,20.1-14.6,22.9 M71.9,46.5c0.2-1.5,0.4-3.1,0.4-4.7v-24h13.6C85.4,23,83,39.4,71.9,46.5z"/><path d="M63.8,27.3l-8.2-1.2l-3.7-7.5c-0.4-0.8-1.3-1.4-2.2-1.4c0,0,0,0,0,0c-0.9,0-1.8,0.5-2.2,1.4l-3.7,7.5l-8.2,1.2   c-0.9,0.1-1.7,0.8-2,1.7c-0.3,0.9-0.1,1.9,0.6,2.5l6,5.8l-1.4,8.2c-0.2,0.9,0.2,1.8,1,2.4c0.4,0.3,0.9,0.5,1.5,0.5   c0.4,0,0.8-0.1,1.1-0.3l7.6-3.8l7.2,3.8c0.8,0.4,1.8,0.4,2.6-0.2c0.8-0.6,1.1-1.5,1-2.4l-1.4-8.2l6-5.8c0.7-0.7,0.9-1.6,0.6-2.5   C65.5,28.1,64.8,27.4,63.8,27.3z M56.6,35.7c-0.4,0.3-0.5,0.8-0.4,1.3l1.4,7.9l-6.9-3.6c-0.4-0.2-0.9-0.2-1.4,0L41.9,45l1.4-8   c0.1-0.5-0.1-1-0.4-1.3l-5.7-5.6l7.9-1.2c0.5-0.1,0.9-0.4,1.1-0.8l3.5-7.2l3.5,7.2c0.2,0.4,0.6,0.8,1.1,0.8l7.9,1.2L56.6,35.7z"/></g>
                                </svg>
                                </p>
                                <p><span>2000 <?=Yii::t('app','ball')?></span></p>
                            </div>
                            <div class="cup_img cup_img3" >
                                <p>
                                <svg id="Layer_1" style="enable-background:new 0 0 100.4 100.4;fill:gold;" version="1.1" viewBox="0 0 100.4 100.4" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M88.5,15.3c-0.3-0.3-0.7-0.5-1.1-0.5H72.2v-7c0-0.8-0.7-1.5-1.5-1.5H28c-0.8,0-1.5,0.7-1.5,1.5v7H10.9   c-0.4,0-0.8,0.2-1.1,0.5c-0.3,0.3-0.4,0.7-0.4,1.1c0,0.3,0.3,6.7,2.6,14.1c3.2,9.9,8.6,16.9,15.8,20.1c2.4,8,7.9,14.3,14.8,16.8   v0.3c0,8.3-6.3,14.9-14.4,14.9c-0.8,0-1.5,0.7-1.5,1.5v8.5c0,0.8,0.7,1.5,1.5,1.5h42.5c0.8,0,1.5-0.7,1.5-1.5v-8.5   c0-0.8-0.7-1.5-1.5-1.5c-8.2,0-14.9-6.7-14.9-14.9v-0.2C63,65,68.6,58.6,71,50.4c6.9-3.3,12.2-10.2,15.3-19.9   c2.4-7.4,2.6-13.9,2.6-14.1C89,16,88.8,15.6,88.5,15.3z M12.5,17.8h14v24c0,1.7,0.1,3.3,0.4,4.9C15.5,39.9,13,23,12.5,17.8z    M69.2,85.5V91H29.7v-5.5c8.8-0.7,15.6-8,15.8-17.3c1.2,0.2,2.5,0.4,3.8,0.4c1.2,0,2.4-0.1,3.5-0.3C53.2,77.4,60.3,84.8,69.2,85.5z    M53.3,65.2c-1.3,0.3-2.6,0.5-3.9,0.5c-1.5,0-3-0.2-4.4-0.6c-0.3-0.1-0.8-0.3-1-0.3c-8.3-2.8-14.5-12-14.5-22.9V9.4h39.7v6v1.9   v24.6c0,10.9-6.2,20.1-14.6,22.9 M71.9,46.5c0.2-1.5,0.4-3.1,0.4-4.7v-24h13.6C85.4,23,83,39.4,71.9,46.5z"/><path d="M63.8,27.3l-8.2-1.2l-3.7-7.5c-0.4-0.8-1.3-1.4-2.2-1.4c0,0,0,0,0,0c-0.9,0-1.8,0.5-2.2,1.4l-3.7,7.5l-8.2,1.2   c-0.9,0.1-1.7,0.8-2,1.7c-0.3,0.9-0.1,1.9,0.6,2.5l6,5.8l-1.4,8.2c-0.2,0.9,0.2,1.8,1,2.4c0.4,0.3,0.9,0.5,1.5,0.5   c0.4,0,0.8-0.1,1.1-0.3l7.6-3.8l7.2,3.8c0.8,0.4,1.8,0.4,2.6-0.2c0.8-0.6,1.1-1.5,1-2.4l-1.4-8.2l6-5.8c0.7-0.7,0.9-1.6,0.6-2.5   C65.5,28.1,64.8,27.4,63.8,27.3z M56.6,35.7c-0.4,0.3-0.5,0.8-0.4,1.3l1.4,7.9l-6.9-3.6c-0.4-0.2-0.9-0.2-1.4,0L41.9,45l1.4-8   c0.1-0.5-0.1-1-0.4-1.3l-5.7-5.6l7.9-1.2c0.5-0.1,0.9-0.4,1.1-0.8l3.5-7.2l3.5,7.2c0.2,0.4,0.6,0.8,1.1,0.8l7.9,1.2L56.6,35.7z"/></g>
                                </svg>
                                </p>
                                <p><span>3000 <?=Yii::t('app','ball')?></span></p>
                            </div>
                            <div class="bar">
                                <div class="date date-1" ></div>
                                <div class="date date-2" ></div>
                                <div class="date date-3" ></div>
                            </div>
                            <?php 
                                $result_persent = $model->ball/40;
                                if ($result_persent>100) {
                                    $result_persent = 100;
                                }
                            ?>
                            <div class="bar bar-result" style="width:<?=$result_persent?>%;">
                                <div class="date date-i" ></div>
                                <div class="my-result" >
                                    <p><?=Yii::t('app','My ball')?></p>
                                    <p><?=$model->ball?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(!empty($user_points)):?>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <table>
                            <tbody>
                                <tr>
                                    <th class="club">
                                        <?=Yii::t('app','Name')?>
                                    </th>
                                    <th>
                                        <?=Yii::t('app','Ball')?>
                                    </th>
                                    <th><?=Yii::t('app','Date')?></th>
                                </tr>
                                <?php foreach($user_points as $user_point ): ?>
                                <tr>
                                    <td class="club">
                                        <?=$user_point->nameBonus?>
                                    </td>
                                    <td><span><?=$user_point->appraisal?></span></td>
                                    <td><?=$user_point->created_at?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php if(!empty($user_points_month)):?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h6><?=Yii::t('app','amount of points by months')?></h6>
            <div class="ct-chart" id="bonus-bal"></div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            <div class="col-md-12">
                <h6><?=Yii::t('app','team member')?></h6>
                <div class="overflow-scroll">
                    <table>
                        <tbody>
                            <tr>
                                <th class="club"><?=Yii::t('app','Team')?></th>
                                <th><?=Yii::t('app','Game')?></th>
                                <th><?=Yii::t('app','Victories')?></th>
                                <th><?=Yii::t('app','Loss')?></th>
                                <th><?=Yii::t('app','W/L Rate')?></th>
                            </tr>
                            <?php foreach($statistic_team as $team ): ?>
                            <tr>
                                <td class="club">
                                    <a href="<?=$team->team->links()?>">
                                        <span class="team">
                                            <img src="<?=$team->team->logo()?>" width="30" height="30" alt="trophy">
                                        </span> 
                                        <span style="margin: auto"><?=$team->team->name?></span>
                                    </a>
                                </td>
                                <td>
                                     <span class="team">
                                            <img src="/images/game/<?=$team->game->logo?>" width="30" height="30" alt="trophy">
                                    </span> 
                                    <span style="margin: auto">
                                        <?=$team->game->name?>
                                    </span>
                                </td>
                                <td><?=$team->victories??'0'?></td>
                                <td><?=$team->loss??'0'?></td>
                                <td><span><?=$team->rate?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


