<?php
    use yii\helpers\Html;
    $this->title = 'Choose Pokemon';
    $this->registerCssFile(\Yii::$app->request->baseUrl .'/css/tournaments.css');
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/pokemon.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

?>
<h4 style="text-align:center;" >SELECT 6 POKEMONS FOR THE GAME</h4>
<div class="container">
    <div class="row" style="margin:30px 0; ">
        <div class="col-md-8 col-md-offset-2" >
            <div class="col-md-8" >
                <input type="text" class="pokemon-input">
            </div>
            <div class="col-md-4" >
                <button class="btn find-pokemon" >Find the Pokemon</button>
            </div>
        </div> 
    </div>
    <div class="row" style="margin-top:30px; ">
        <div class="col-md-8 col-md-offset-2 container_pokemons" ></div> 
    </div>
    <div class="row" style="margin-top:15px;margin-bottom:30px; ">
        <div class="col-md-8 col-md-offset-2">
            <p style="text-align: center;"><b>Selected Pokemon</b></p><hr>
        </div>
        <div class="col-md-8 col-md-offset-2 container_selected" ></div> 
    </div>
    <div class="row block_form" style="margin:40px 0;display:none;"  >
        <form  method="POST">
        <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
        <div class="col-md-6 col-md-offset-3 " >
            <button class="btn btn-save" >Save</button>
        </div> 
        <input type="text" name="decstring" hidden="true" class="input_class_cards">
        </form>
    </div>
</div>
