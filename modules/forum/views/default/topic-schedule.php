<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use app\models\Tournaments;
    use dosamigos\tinymce\TinyMce;
    use kartik\datetime\DateTimePicker;
    use yii\widgets\Breadcrumbs;

    


$team1 = $topic->teamS;
$team2 = $topic->teamF;
$this->title = $team1->name.' vs '.$team2->name;
$this->registerCssFile('css/forum/thread.css', ['depends' => ['app\assets\AppAsset']]);
$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/forum/index.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

$time_match = time();
$time_do_match = strtotime('-30 minute',strtotime($topic->date));

$time_do_start = strtotime('-2 day',strtotime($topic->date));

if ($time_do_start < time()) {
    $time_do_start = time();
}

$this->params['breadcrumbs'][] = ['label' => $topic->tournament->name, 'url' => ['/tournaments/public/'.$topic->tournament->id] ];
$this->params['breadcrumbs'][] = ['label' => 'Forum', 'url' => ['/forum/'.$topic->tournament->id] ];
$this->params['breadcrumbs'][] = ['label' => $team1->name.' vs '.$team2->name];

?>

<div class="container">
    <?=  Breadcrumbs::widget(['links' => $this->params['breadcrumbs']?? [], ]) ?>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 tems_vs">
           <div class="col-sm-2 ">
            <p> <a href="/teams/public/<?=$topic->team1?>"><img src="<?=$team1->logo?>"></a></p>
            </div>
            <div class="col-sm-8 ">
                <p style="text-transform: uppercase;font-weight: bold;margin: 0; "><a href="/tournaments/public/<?=$topic->tournament_id?>"><?=$topic->tournament->name?></a></p>
                <p style="font-weight: bold;text-align: center;margin: 0;"><span>ROUND  <?=$topic->tur?></span></p>
                    <div class="row" style="font-weight: bold;font-size:13px;">
                        <div class="col-sm-5" style="text-align:right;padding: 0;" ><a href="/teams/public/<?=$topic->team1?>"> <?=$team1->name?></a></div>
                        <div class="col-sm-2" style="text-align:center;font-size: 25px;padding: 0;" ><span>VS</span></div>
                        <div class="col-sm-5" style="padding: 0;"><a href="/teams/public/<?=$topic->team2?>"><?=$team2->name?></a></div>
                    </div>
                <p style="margin-bottom: 0;font-size:13px;" ><?=date(' d \of F, Y ',strtotime($topic->date))?></p>
                <p style="margin-bottom: 0;font-size:13px;" ><?=date('H:i',strtotime($topic->date))?></p>
            </div>
            <div class="col-sm-2 ">
                <p><a href="/teams/public/<?=$topic->team2?>"><img src="<?=$team2->logo?>" ></a></p>
            </div>
        </div>
    </div>
<?php if(($topic->status != 1)&&($time_match < $time_do_match)&&((\Yii::$app->user->identity->id==$team1->capitan)||(\Yii::$app->user->identity->id==$team2->capitan)||(\Yii::$app->user->identity->id == $topic->tournament->user_id))): ?>
    <div class="row" style="margin-top: 35px;" >
        <p style="text-align: center;">
            <span style="font-size: 18px;font-weight: bold;" >Stage:</span>
            <span>Before the match</span>
        </p>
        <p style="text-align: center;" ><button class="btn cahenge_date" >Chenge match date</button></p>
    </div>

    <div class="row">
        <?php $form = ActiveForm::begin([ 
            'method' => 'post',
            'action' => '/forum/data-update/'.$topic->id,
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
        <div class="col-sm-10 col-sm-offset-1 tems_vs cahenge_date_panel" style="display: none;">
           <div class="col-md-12 ">
                <div class="col-md-6 ">
                    <label class="col-sm-12 control-label" for="scheduleteams-date">Curent date:</label>
                    <input type="text" class="form-control" value=" <?=date('Y-m-d H:i',strtotime($topic->date))?>"  readonly>
                </div>
                <div id="datechenge" class="col-md-6 ">
                        <?php  
                            echo $form->field($topic, 'date')->widget(DateTimePicker::className(),[
                            'name' => 'datetime_10',
                            'readonly' => true ,
                            'removeButton' => false ,
                            'options' => [  
                                'placeholder' => 'Select operating time ...',
                                'autocomplete'=>"off",'class'=>'datainput',
                            ],
                            'convertFormat' => true,
                            'pluginOptions' => [
                                'format' => 'yyyy-MM-dd H:i',
                                'startDate' => date("Y-m-d H:i",$time_do_start),
                                'endDate'  => date("Y-m-d H:i",strtotime('+2 day',strtotime($topic->date))),
                                'todayHighlight' => true
                            ]])->label('Chenge date:'); 
                        ?>
                </div>
                <div class="col-sm-12" style="text-align: center;margin-top: 15px;">
                    <input type="submit" class = 'btn btn-primary' value="Save" style = 'width: 160px;'>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
<?php else: ?>
    <div class="row" style="margin-top: 35px;" >
        <p style="text-align: center;">
            <span style="font-size: 18px;font-weight: bold;" >Stage:</span>
            <span>Prepare the game</span>
        </p>
    </div>
<?php endif; ?>
<div class="row" style="margin-top: 25px;">
    <?php foreach ($posts as $post):?>
        <div class="col-sm-10 col-sm-offset-1 post-element">
            <div class="col-sm-2 author-avatar">
               <a href="#"><img src="/images/common/author-avatar.jpg" alt="author-avatar"></a>
           </div>
            <div class="col-sm-10">
                <p>
                    <span style="font-weight:bold;" ><?=$post->user->name?></span>
                    <span style="float: right;color:#afacac;" >
                        <?= date(' d \of F, Y ',$post->created_at)?>
                    </span>
                </p>
                <div class="content_text"> <?=$post->text?></div>
            </div>
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
    
<?php if($topic->status !=2): ?>
    <div class="col-xs-10 col-xs-offset-1 " style="margin-top: 35px;margin-bottom: 25px;padding: 0;"> 
        <?= $form->field($new_post, 'text')->widget(TinyMce::className(), [
        'options' => ['rows' => 6],
        'language' => 'en',
        'clientOptions' => [
            'plugins' => [
                "image",
                'advlist autolink lists link charmap  print hr preview pagebreak',
                'searchreplace wordcount textcolor visualblocks visualchars code fullscreen nonbreaking',
                'save insertdatetime media table contextmenu template paste image'
            ],
            'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
        ]
        ])->label(false); ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary formbtn btn_mobil']) ?>
    </div>
<?php endif; ?>
</div>   

<?php ActiveForm::end(); ?>
</div>


