<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use app\models\Tournaments;
    use dosamigos\ckeditor\CKEditor;
    use kartik\datetime\DateTimePicker;

    $this->title = 'Topic-Schedule';
    $this->registerCssFile('css/forum/thread.css', ['depends' => ['app\assets\AppAsset']]);
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/forum/index.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

$team1 = $topic->teamS;
$team2 = $topic->teamF;
?>


<div class="container">
    
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 tems_vs">
           <div class="col-sm-3 ">
            <p><img src="<?=$team1->logo?>" alt=""></p>
            </div>
            <div class="col-sm-6 ">
                <p style="text-transform: uppercase;font-weight: bold; "><a href="/tournaments/public/<?=$topic->tournament_id?>"><?=$topic->tournament->name?></a>&nbsp;&nbsp;<span>ROUND  <?=$topic->tur?></span></p>
                <h6><a href="/teams/public/<?=$topic->team1?>"> <?=$team1->name?></a>&nbsp;&nbsp;<span style="color:red;font-size: 25px;" >VS</span>&nbsp;&nbsp;<a href="/teams/public/<?=$topic->team2?>"><?=$team2->name?></a></h6>
                <p style="margin-bottom: 0;" ><?=date(' m \of F, Y ',strtotime($topic->date))?></p>
                <p style="margin-bottom: 0;" ><?=date('h:i',strtotime($topic->date))?></p>
            </div>
            <div class="col-sm-3 ">
                <p><img src="<?=$team2->logo?>" alt=""></p>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 35px;" >
        <p style="text-align: center;">
            <span style="font-size: 18px;font-weight: bold;" >Satge:</span>
            <span>Before the match</span>
        </p>
        <p style="text-align: center;" ><button class="btn cahenge_date" >Chenge match date</button></p>
    </div>

    <div class="row">
        <?php $form = ActiveForm::begin([ 
            'method' => 'post',
            'validateOnBlur'=>false,  
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'template' => '{label}{hint}{input}{error}',
                'labelOptions' => ['class' => 'col-sm-12 control-label'],
            ],
        ]); 
        $form->errorCssClass = false;
        $form->successCssClass = false;

        ?>
        <div class="col-sm-10 col-sm-offset-1 tems_vs cahenge_date_panel">
           <div class="col-md-12 ">
                <div class="col-md-6 ">
                    <label class="col-sm-12 control-label" for="scheduleteams-date">Curent date:</label>
                    <input type="text" class="form-control" value=" <?=date('Y-m-d H:i') ?>"  readonly>
                </div>
                <div id="datechenge" class="col-md-6 ">
                        <?php  
                            echo $form->field($topic, 'date')->widget(DateTimePicker::className(),[
                            'name' => 'datetime_10',
                            'options' => [  
                                'placeholder' => 'Select operating time ...',
                                'autocomplete'=>"off",'class'=>'datainput',
                            ],
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'format' => 'yyyy-MM-dd hh:i',
                                'startDate' => date("Y-m-d H:i"),
                                'todayHighlight' => true
                            ]])->label('Chenge date:'); 
                        ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

<div class="row">
   


    
        <?php foreach ($posts as $post):?>
        <div class="col-sm-10 col-sm-offset-1 post-element">
            <div class="col-sm-3 author-avatar">
               <a href="#"><img src="/images/common/author-avatar.jpg" alt="author-avatar"></a>
               <p class='name' ><?=$post->user->name?></p>
           </div>
            <div class="col-sm-9"><?=$post->text?></div>

        </div>
        
        <?php endforeach; ?>

<?php $form = ActiveForm::begin([ 
    'method' => 'post',
    'validateOnBlur'=>false,  
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => '{label}{hint}{input}{error}',
        'labelOptions' => ['class' => 'col-sm-12 control-label'],
    ],
]); 
$form->errorCssClass = false;
$form->successCssClass = false;

?>
    
<?php if(!$topic->status): ?>
    <div class="col-md-8 col-md-offset-2" style="margin-top: 25px;margin-bottom: 25px;"> 
        <?= $form->field($new_post, 'text')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'basic'
        ])->label(false); ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary formbtn btn_mobil']) ?>
    </div>
<?php endif; ?>
</div>   

<?php ActiveForm::end(); ?>
</div>