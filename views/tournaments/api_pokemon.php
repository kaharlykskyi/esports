<?php
    use yii\helpers\Html;
    use Yii;


    $this->title = Yii::t('app','Choose Pokemon');
    $this->registerCssFile(\Yii::$app->request->baseUrl .'/css/tournaments.css');
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/pokemon.js',
        ['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]
    );

?>
<h4 style="text-align:center;" ><?=Yii::t('app','Enter a string of 6 Pokemon')?></h4>
<div class="container">
    <div class="row" style="margin:30px 0; ">
        <div class="col-md-8 col-md-offset-2" >
            <div class="col-md-8" >
                <textarea class="pokemon-input" cols="30" rows="10"></textarea>
            </div>
            <div class="col-md-4" >
                <button class="btn find-pokemon" ><?=Yii::t('app','Find the Pokemon')?></button>
            </div>
        </div> 
    </div>
    <div class="row" style="margin-top:30px; ">
        <div class="col-md-8 col-md-offset-2 massage_pokemons" 
            style="color:red;text-align: center;display: none;">
            <span><?=Yii::t('app','String must contain 6 Pokemon')?></span>
        </div> 
    </div>
    <div class="row" style="margin-top:15px;margin-bottom:30px; ">
        <div class="col-md-8 col-md-offset-2 container_selected" ></div> 
    </div>
    <div class="row block_form" style="margin:40px 0;display:none;"  >
        <form  method="POST">
        <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
        <div class="col-md-6 col-md-offset-3 " >
            <button class="btn btn-save" ><?=Yii::t('app','Save')?></button>
        </div> 
        <input type="text" name="decstring" hidden="true" class="input_class_cards">
        </form>
    </div>
</div>
