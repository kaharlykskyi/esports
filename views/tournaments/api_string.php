<?php
    use yii\helpers\Html;
    $this->title = 'Deckstrings';
    $this->registerCssFile(\Yii::$app->request->baseUrl .'/css/tournaments.css');
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/string.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

?>
<h4 style="margin:40px 0;text-align:center;" >Enter the Deckstrings Hearthstone</h4>
<div class="container">
    <div class="row" style="margin:40px 0; ">
        <div class="col-md-8 col-md-offset-2" >
            <div class="col-md-8" >
                <input type="text" class="string-input">
            </div>
            <div class="col-md-4" >
                <button class="btn btn-cards" >Submit</button>
            </div>
        </div> 
    </div>
    <div class="row" style="margin:40px 0; ">
        <div class="col-md-8 col-md-offset-2 container_cards" ></div> 
    </div>
    <div class="row block_form" style="margin:40px 0;display:none;"  >
        <form action="/tournaments/save-cards" method="POST">
        <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
        <div class="col-md-6 col-md-offset-3 " >
            <button class="btn btn-save" >Save</button>
        </div> 
        <input type="text" hidden="true" class="input_class_cards">
        </form>
    </div>
</div>