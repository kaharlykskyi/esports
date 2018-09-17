<?php
    
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use dosamigos\ckeditor\CKEditor;
    use yii\widgets\Breadcrumbs;
    $this->registerCssFile('css/forum/thread.css', ['depends' => ['app\assets\AppAsset']]);
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/forum/index.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);
    $this->title = 'Forum';
    
    $this->params['breadcrumbs'][] = ['label' => 'Tournament', 'url' => ['/tournaments/public/'.$model->id] ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
     <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']?? [], ]) ?>
    <div class="row">
        <h2 style="text-align:center; " >Tournament thread </h2>
        <div class="col-md-10 col-md-offset-1" style="margin-bottom: 35px;">
            <div class="col-md-12 detail" >
                <div class="col-sm-3 img_content"  >
                    <a href="championship.html" title="The Greatest League">
                        <img src="/images/hockey/championship-ico.jpg" alt="champ-img">
                    </a>
                </div>
                <div class="col-sm-9 content_detals">
                    <?php if($model->user_id == \Yii::$app->user->identity->id):  ?>
                        <button  id="text_forum" class="btn"  >Edit</button>
                    <?php endif; ?>
                    <h6>Tournament schelude</h6>
                    <div id="content_text_forum" >
                      <?=$model->forum_text?>        
                    </div>
                </div>
                <span id='down-text' class="glyphicon glyphicon-chevron-down" style="display:none;"  ></span>
            </div>
        </div>
    </div>
    <?php if($model->user_id == \Yii::$app->user->identity->id):  ?>
    <div class="row text_forum_form" style="display:none;">
        <?php $form = ActiveForm::begin([ 
            'method' => 'post',
            'action' => '/forum/update-forum-text/'.$model->id,
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
        <div class="col-md-8 col-md-offset-2" style="margin-top: 25px;margin-bottom: 25px;"> 
            <?= $form->field($model, 'forum_text')->widget(CKEditor::className(), [
                'options' => ['rows' => 6],
                'preset' => 'basic'
                ])->label(false); ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary formbtn btn_mobil']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="club-standings overflow-scroll">
                    <h6 style="text-align: center;" >Match topic</h6>
                    <table class="table-standings">
                        <tbody>
                            <?php $topicsa = $model->getScheduleLeague(); ?>
                            <?php $g=0; $i=0; foreach ($topicsa as $topic):?>
                                    <?php if($g!=(int)$topic['group']&&!is_null($topic['group'])): ?>
                                        <?php $g = (int)$topic['group']?>
                                        <tr >
                                            <td colspan="3" style="font-weight: bold; text-align: center;font-size: 20px;" >GROUP <?=$g?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if($i!=(int)$topic['tur']): ?>
                                        <?php $i = (int)$topic['tur']?>
                                        <tr >
                                            <td colspan="3"  style="text-align: center;" >Round <?=$i?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td class="up">
                                            <span class="team"><a href="/forum/topic-schedule/<?=$topic['id']?>"><img src="<?=$topic['f_logo']?>" alt="">&#160;&#160;&#160;<?=$topic['f_name']?> <span style="font-weight: bold;font-size: 14px;">vs</span>  <?=$topic['s_name'] ?>&#160;&#160;&#160;<img src="<?=$topic['s_logo']?>" alt=""></a></span> 
                                        </td>
                                        <td><?=$topic['tur']?> Round</td>
                                        <td><?= $topic['count_post'] ?><i class="glyphicon glyphicon-comment"></i></td>
                                    </tr>
                            <?php endforeach; ?>
                            <?php $topicsa = $model->getScheduleCup(); ?>
                            <?php $a=0; foreach ($topicsa as $topic):?>
                                    <?php if($a!=(int)$topic['tur']): ?>
                                        <?php $a = (int)$topic['tur']?>
                                        <tr>
                                            <td colspan="3" height="100%" style="text-align: center;" >Round <?=$a?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td class="up">
                                            <span class="team"><a href="/forum/topic-schedule/<?=$topic['id']?>"><img src="<?=$topic['f_logo']?>" alt="">&#160;&#160;&#160;<?=$topic['f_name']?> <span style="font-weight: bold;font-size: 14px;">vs</span>  <?=$topic['s_name'] ?>&#160;&#160;&#160;<img src="<?=$topic['s_logo']?>" alt=""></a></span> 
                                        </td>
                                        <td><?=$topic['tur']?> Round</td>
                                        <td><?= $topic['count_post'] ?><i class="glyphicon glyphicon-comment"></i></td>
                                    </tr>
                            <?php endforeach; ?>
                       </tbody>
                </table>
            </div>
            <div >
                <a  href="/forum/create-topic/<?=$model->id?>" class="btn" style="float:right;" >Create new topic</a>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top:30px;">
        <?php foreach ($topics as $topic):?>
            <?php if(is_null($topic->num_schedule)): ?>
            <div class="col-md-10 col-md-offset-1" >
                <div class="author-box">
                    <div class="top">
                        <div class="avatar"><a href="/forum/topic/<?=$topic->id?>"><img src="/images/common/author-avatar.jpg" alt="author-avatar"></a></div>
                        <div class="info">
                            <div class="name"><a href="/forum/topic/<?=$topic->id?>"><?=$topic->name ?></a></div>
                            <p>Created: <?=date(' h:i, m \of F, ',$topic->created_at)?> </p>
                            <p>Status: <?=$topic->status==0 ? 'Open': 'Close'?></p>
                        </div>
                        <div class="message_info">
                            <span><?= $topic->countPost() ?> </span><i class="glyphicon glyphicon-comment"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
