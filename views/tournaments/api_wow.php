<?php
    use yii\helpers\Html;
    $this->title = 'Input data herois';
    $this->registerCssFile(\Yii::$app->request->baseUrl .'/css/tournaments.css');
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/wow.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

?>
<h4 style="text-align:center;" ><?=$this->title?></h4>
<div class="container">
    <div class="row" style="margin:10px 0; ">
        <div class="col-md-6 col-md-offset-3  input_descstring" >
            <input type="text" class="string-input">
        </div> 
        <div class="col-md-6 col-md-offset-3  input_descstring" >
            <input type="text" class="string-input">
        </div>
        <div class="col-md-6 col-md-offset-3  input_descstring" >
            <input type="text" class="string-input">
        </div>           
        <div class="col-md-12" style="margin-top:20px;text-align:center;">
            <button class="btn btn-cards" >Submit</button>
        </div>
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
