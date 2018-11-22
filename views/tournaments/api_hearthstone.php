<?php
    use yii\helpers\Html;
    use Yii;

    $this->title = 'Deckstrings Hearthstone';
    $this->registerCssFile(\Yii::$app->request->baseUrl .'/css/tournaments.css');
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/string.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

    if(!empty($model->data)) {
        $json_data = json_decode($model->data);

        switch ($json_data->system) {
            case 'Bo1':
                $count_input = 2;
                break;
            case 'Bo3':
                $count_input = 3;
                break;
            case 'Bo5':
                $count_input = 4;
                break;
        }

        if ($json_data->game_mode == 'Last hero standing') {
            $count_input++;
        }
    }
?>
<h4 style="text-align:center;" ><?=Yii::t('app','Enter the')?> Deckstrings Hearthstone</h4>
<div class="container">
    <div class="row" style="margin:10px 0; ">
        <?php for ($i=0; $i < $count_input; $i++): ?>
        <div class="col-md-6 col-md-offset-3  input_descstring" >
            <input type="text" class="string-input">
        </div>
        <?php endfor;?>            
        <div class="col-md-12" style="margin-top:20px;text-align:center;">
            <button class="btn btn-cards" ><?=Yii::t('app','Submit')?></button>
        </div>
    </div>
    <div class="row" style="margin:20px 0; ">
        <div class="col-md-8 col-md-offset-2 container_cards" ></div> 
    </div>
    <div class="row block_form" style="margin:40px 0;display:none;"  >
        <form  method="POST">
        <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam,\Yii::$app->getRequest()->getCsrfToken(),[]);?>
        <div class="col-md-6 col-md-offset-3 " >
            <button class="btn btn-save"  style="padding: 10px;"><?=Yii::t('app','Keep my classes')?></button>
        </div> 
            <input type="text" name="decstring" hidden="true" class="input_class_cards">
        </form>
    </div>
</div>