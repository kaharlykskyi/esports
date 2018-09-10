<?php
    use app\widgets\Alert;
    use yii\helpers\Html;
    $this->registerCssFile('https://use.fontawesome.com/releases/v5.2.0/css/all.css');
    $this->registerCssFile('css/forum/thread.css', ['depends' => ['app\assets\AppAsset']]);
    //$this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/profile.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);
    $this->title = 'Forum';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <h2 style="text-align:center; " >Tournament thread </h2>
        <div class="col-md-10 col-md-offset-1 detail" style="margin-bottom: 35px;">
            <div class="col-sm-3 img_content"  >
                <a href="championship.html" title="The Greatest League">
                    <img src="/images/hockey/championship-ico.jpg" alt="champ-img">
                </a>
            </div>
            <div class="col-sm-9 content_detals">
                <button class="btn">Edit</button>
                <h6>Tournament schelude</h6>
                <ul>
                    <li>Team1 <span>vs</span> Team2  20:45, 10 of September, 2018</li>
                    <li>Team1 <span>vs</span> Team2 20:45, 10 of September, 2018</li>
                    <li>Team1 <span>vs</span> Team2 20:45, 10 of September, 2018</li>
                    <li>Team1 <span>vs</span> Team2 20:45, 10 of September, 2018</li>
                    <li>Team1 <span>vs</span> Team2 20:45, 10 of September, 2018</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="club-standings overflow-scroll">
                    <h6 style="text-align: center;" >Match topic</h6>
                    <table class="table-standings">
                        <tbody>
                            <tr>
                                <td class="up">
                                    <span class="team"><a href="#">Team1 vs Team2</a></span> 
                                </td>
                                <td>Round</td>
                                <td>2<i class="glyphicon glyphicon-comment"></i></td>
                                
                            </tr>
                            <tr>
                                <td class="down">
                                    <span class="team"><a href="#">Team1 vs Team2</a></span> 
                                </td>
                                <td>Round</td>
                                <td>2<i class="glyphicon glyphicon-comment"></i></td>
                               
                            </tr>
                            <tr>
                                <td class="none">
                                    <span class="team"><a href="#">Team1 vs Team2</a></span> 
                                </td>
                                <td>Round</td>
                                <td>2<i class="glyphicon glyphicon-comment"></i></td>
                                
                            </tr>
                            <tr>
                                <td class="down">
                                    <span class="team"><a href="#">Team1 vs Team2</a></span> 
                                </td>
                                <td>Round</td>
                                <td>2<i class="glyphicon glyphicon-comment"></i></td>
                                
                            </tr>
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
        <div class="col-md-10 col-md-offset-1" >
            <div class="author-box">
                <div class="top">
                    <div class="avatar"><a href="/forum/topic/<?=$topic->id?>"><img src="/images/common/author-avatar.jpg" alt="author-avatar"></a></div>
                    <div class="info">
                        <div class="name"><a href="/forum/topic/<?=$topic->id?>"><?=$topic->name ?></a></div>
                        <p>Created 10:45, 10 of September </p>
                        <p>Status: Opened</p>
                    </div>
                    <div class="message_info">
                        <span>1 </span><i class="glyphicon glyphicon-comment"></i>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>


</div>
