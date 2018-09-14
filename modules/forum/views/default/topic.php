<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use app\models\Tournaments;
    use dosamigos\ckeditor\CKEditor;
    use yii\widgets\Breadcrumbs;

    $this->title = 'Topic';
    $this->registerCssFile('css/forum/thread.css', ['depends' => ['app\assets\AppAsset']]);
    $this->params['breadcrumbs'][] = ['label' => 'Forum', 'url' => ['/forum/'.$topic->tournament->id] ];
    $this->params['breadcrumbs'][] = ['label' => 'Tournament', 'url' => ['/tournaments/public/'.$topic->tournament->id] ];
    $this->params['breadcrumbs'][] = ['label' => $topic->name];
?>

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
<div class="container">
    <?=  Breadcrumbs::widget(['links' => $this->params['breadcrumbs']?? [], ]) ?>
<div class="row">
    <h6 style="text-align: center;"><?=$topic->name?></h6>


    
    <?php foreach ($posts as $post):?>
        <div class="col-sm-10 col-sm-offset-1 post-element">
            <div class="col-sm-2 author-avatar">
               <a href="#"><img src="/images/common/author-avatar.jpg" alt="author-avatar"></a>
           </div>
            <div class="col-sm-10">
                <p>
                    <span style="font-weight:bold;" ><?=$post->user->name?></span>
                    <span style="float: right;color:#afacac;" ><?=date(' m \of F, Y ',$post->created_at)?></span></p>
                <div class="content_text"> <?=$post->text?></div>
            </div>
        </div>
    <?php endforeach; ?>
    
<?php if(!$topic->status): ?>
    <div class="col-md-10 col-md-offset-1 " style="margin-top: 35px;margin-bottom: 25px;padding: 0;"> 
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