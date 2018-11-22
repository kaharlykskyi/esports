<?php
    use yii\helpers\Html;
    use Yii;

    $this->title = Yii::t('app','Enter Character Details');
    $this->registerCssFile(\Yii::$app->request->baseUrl .'/css/tournaments.css');
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/wow.js',
        ['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]
    );

?>
<h4 style="text-align:center;" ><?=$this->title?></h4>
<div class="container">
    <div class="row" style="margin:10px 0; ">
        <div class="col-md-6 col-md-offset-3 input_details" >
            <label ><?=Yii::t('app','Select region')?></label>
            <div class="item select-show string-region">
                <select class="basic" >
                    <option  value="eu" >eu</option>
                    <option  value="us" >us</option> 
                    <option  value="kr" >kr</option>
                    <option  value="tw" >tw</option>
                </select>
            </div>
        </div> 
        <div class="col-md-6 col-md-offset-3  input_details" >
            <label ><?=Yii::t('app','Enter a realm')?></label>
            <input type="text" class="string-realm"
                placeholder="Realm"   >
        </div> 
        <div class="col-md-6 col-md-offset-3  input_details" >
            <label ><?=Yii::t('app','Enter a name')?></label>
            <input type="text" class="string-name"
                placeholder="Name"    >
        </div>
        <div class="col-md-6 col-md-offset-3  input_details" >
            <label ><?=Yii::t('app','Enter a fields')?></label>
            <input type="text" class="string-fields"
                placeholder="Fields"   >
        </div>          
        <div class="col-md-12" style="margin-top:20px;text-align:center;">
            <button class="btn btn-detals" ><?=Yii::t('app','Submit')?></button>
        </div>
    </div>
    <div class="row" style="margin:30px 0; ">
        <div class="col-md-6 col-md-offset-3 content_profile" >
            <ul></ul>
        </div>
    </div>
    <div class="row block_forms" style="margin:40px 0;display:none;"  >
        <form  method="POST">
        <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
        <div class="col-md-6 col-md-offset-3 " >
            <button class="btn btn-save" ><?=Yii::t('app','Save')?></button>
        </div> 
        <input type="text" name="decstring" hidden="true" class="input_class_detalis">
        </form>
    </div>
</div>
