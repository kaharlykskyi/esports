<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    use app\models\Tournaments;
    use dosamigos\ckeditor\CKEditor;

    $this->title = 'Topic';
    $this->registerCssFile('css/forum/thread.css', ['depends' => ['app\assets\AppAsset']]);
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
<div class="row">
    <h6 style="text-align: center;"><?=$topic->name?></h6>


    
        <?php foreach ($posts as $post):?>
        <div class="col-sm-10 col-sm-offset-1 post-element">
            <div class="col-sm-3 author-avatar">
               <a href="#"><img src="/images/common/author-avatar.jpg" alt="author-avatar"></a>
               <p class='name' ><?=$post->user->name?></p>
           </div>
            <div class="col-sm-9"><?=$post->text?></div>

        </div>
        
        <?php endforeach; ?>
    
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