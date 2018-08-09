<?php
    use app\widgets\Alert;
    use yii\helpers\Html;

    $this->registerCssFile('css/profile.css', ['depends' => ['app\assets\AppAsset']]);
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/profile.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);
    $this->title = 'Profile';
    $this->params['breadcrumbs'][] = $this->title;
?>

   

<section class="image-header img-url" style="margin-bottom:70px">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="info">
                    <div class="wrap">
                        <div class="col-md-12">
                            <div class="youplay-user"> 
                                <a href="https://wp.nkdev.info/youplay/members/craager/" class="angled-img">
                                    <div class="img"> 
                                        <img src="https://cdn-wp.nkdev.info/youplay/wp-content/uploads/avatars/1/3e326e4e6643db89fc3bf1447d9474e3-bpfull.jpg" class="avatar user-1-avatar avatar-200 photo" width="200" height="200" alt="Profile picture of nK">
                                    </div> 
                                </a>
                                <div class="user-data">
                                    <h2 class="user-data-h2">nK</h2> @craager
                                    <div class="youplay-user-activity">
                                        <div>
                                            <div class="title"> active 16 hours, 36 minutes ago</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
            
        </div>
    </div>
    <div class="youplay-user-navigation">
        <div class="container">
            <ul class="flickity-enabled is-draggable nav nav-tabs" tabindex="0">
                <li id="activity-personal-li" class="current selected active is-selected" aria-selected="true" ><a id="user-activity" data-toggle="tab" href="#panel1">Profile</a></li>
                <li id="xprofile-personal-li" aria-selected="false" ><a id="user-xprofile" data-toggle="tab" href="#panel2">Activity</a></li>
                <li id="blogs-personal-li" aria-selected="false" ><a id="user-blogs" data-toggle="tab" href="#panel3">My teams <span class="badge mnb-1"><?=$teams['count_teams']?></span></a></li>
                <li id="friends-personal-li" aria-selected="false" ><a id="user-friends" data-toggle="tab" href="#panel4">Friends<span class="badge mnb-1 sr-only">0</span></a></li> 
                <li id="seting-personal-li" aria-selected="false" ><a id="user-seting" data-toggle="tab" href="#panel5">Settings<span class="badge mnb-1 sr-only">0</span></a></li>     
            </ul>
        </div>
    </div>
</section>

<div class="container"> 
     <?= Alert::widget()?>
</div>
<div class="container"  >
    <div class="row">
        <div class="col-md-9 ">

            <div class="tab-content">
                <div id="panel1" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-md-6" style="margin-left: 10px;">
                            <div class="tags my_btn">
                                <a href="#" >View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h4>Base</h4>
                        <table class="table table-profile" >
                            <tbody>
                                <tr>
                                    <td style="width: 250px;"  >Name</td>
                                    <td>nK</td>
                                </tr>
                                <tr>
                                    <td>Sex</td>
                                    <td>Male</td>
                                </tr>
                                <tr>
                                    <td>Relationship status</td>
                                    <td>Married</td>
                                </tr>
                                <tr>
                                    <td>Birthday</td>
                                    <td>1985-01-01</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h4>Contact information</h4>
                        <table class="table table-profile">
                            <tbody>
                                <tr>
                                    <td style="width: 250px;"  >Hometown</td>
                                    <td>New York</td>
                                </tr>
                                <tr>
                                    <td>Mobile</td>
                                    <td>+1 111 *** ** 1</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>nk*******@gmail.com</td>
                                </tr>
                                <tr>
                                    <td>Instagram</td>
                                    <td>@instagram</td>
                                </tr>
                                <tr>
                                    <td>Twitter</td>
                                    <td>@twitter</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h4>Interests</h4>
                        <table class="table table-profile">
                            <tbody>
                                <tr>
                                    <td style="width: 250px;"  >Activities</td>
                                    <td    >Nisi cras quis parturient morbi purus egestas eros duis ridiculus.
                                    Mattis torquenttaciti consectetuer nascetur. Curabitur arcu ligula euismod eleifend gravida sit nam nostra vel nostra lacus mollis morbi facilisis scelerisque. Ad lacinia id est arcu suscipit placerat elementum mi nec feugiat magna erat hendrerit lacus facilisi id sapien potenti.
                                    </td>
                                </tr>
                                <tr>
                                    <td>Interests</td>
                                    <td>Parturient. Duis nisl donec habitasse, eu sodales netus commodo litora eleifend fusce erat sociis leo montes auctor netus duis rutrum magnis mauris sollicitudin malesuada nam mauris venenatis sagittis neque quisque risus ante mattis Vitae ac senectus ridiculus diam, commodo nulla aenean nascetur nulla dictumst potenti nulla litora per fusce sollicitudin.</td>
                                </tr>
                                <tr>
                                    <td>Favorite games</td>
                                    <td>Bloodborne, Dark Souls II, The Witcher</td>
                                </tr>
                                

                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="panel2" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-7">
                            <ul class="tab-filters">
                                <li class="active"><a href="#qualification">Personal</a></li>
                                <li><a href="#quarterfinal">Mentions</a></li>
                                <li><a href="#semifinal">Favorites</a></li>
                                <li><a href="#final">Friends</a></li>
                                <li><a href="#final">Groups</a></li>
                            </ul>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                            <!-- <div class="col-md-2 no-pading">
                                <div  ><span>Show:</span></div>
                            </div>
                            <div class="col-md-10">
                                <div class="item select-show">
                                    <div class="fancy-select ">
                                        <select class="basic" name="RegisterForm[country]" required>
                                            <option value="-1">— Everything —</option>
                                            <option value="activity_update">Updates</option>
                                            <option value="new_blog">New Sites</option>
                                            <option value="new_blog_post">Posts</option>
                                            <option value="new_blog_comment">Comments</option>
                                            <option value="friendship_accepted,friendship_created">Friendships</option>
                                            <option value="created_group">New Groups</option>
                                            <option value="joined_group">Group Memberships</option>
                                            <option value="group_details_updated">Group Updates</option>
                                            <option value="bbp_topic_create">Topics</option>
                                            <option value="bbp_reply_create">Replies</option> 

                                        </select>
                                    </div>    
                                </div>
                            </div> -->
                            </div>   
                        </div>
                    </div>
                    <div class="wrap-lists">    
                        <div class="lists">
                            <div class="youplay-timeline-icon "> 
                                <a href="https://wp.nkdev.info/youplay/members/craager/"> 
                                    <img src="https://cdn-wp.nkdev.info/youplay/wp-content/uploads/avatars/1/3e326e4e6643db89fc3bf1447d9474e3-bpthumb.jpg" class="avatar user-1-avatar avatar-80 photo" width="80" height="80" alt="Profile picture of nK"> 
                                </a>
                            </div>
                                
                                <div class="wrap">     
                                    <h3 class="activity-header">
                                        <p>
                                            <a href="https://wp.nkdev.info/youplay/members/craager/" rel="nofollow">nK</a> replied to the topic 
                                            <a href="https://wp.nkdev.info/youplay/forums/topic/tomb-rider/">Tomb Rider</a> in the forum 
                                            <a href="https://wp.nkdev.info/youplay/forums/forum/games/xbox/">Xbox</a> 
                                            <a href="https://wp.nkdev.info/youplay/forums/topic/tomb-rider/#post-657" class="view youplay-timeline-date pt-5 bp-tooltip">
                                                <span class="time-since">2 years ago</span>
                                            </a>
                                        </p>
                                    </h3>
                                    <div class="clearfix"></div>
                                    <div class="activity-inner">
                                        <p>
                                            Rutrum potenti fusce justo per felis dignissim, molestie orci facilisis et phasellus enim. Malesuada amet justo. Cum ultrices. Suscipit vel orci lorem. Torquent ipsum, pretium cras conubia, posuere urna donec […]
                                        </p>
                                    </div>
                                </div>
                        </div>
                        <div class="lists">
                            <div class="youplay-timeline-icon "> 
                                <a href="https://wp.nkdev.info/youplay/members/craager/"> 
                                    <img src="https://cdn-wp.nkdev.info/youplay/wp-content/uploads/avatars/1/3e326e4e6643db89fc3bf1447d9474e3-bpthumb.jpg" class="avatar user-1-avatar avatar-80 photo" width="80" height="80" alt="Profile picture of nK"> 
                                </a>
                            </div>
                                
                                <div class="wrap">     
                                    <h3 class="activity-header">
                                        <p>
                                            <a href="https://wp.nkdev.info/youplay/members/craager/" rel="nofollow">nK</a> replied to the topic 
                                            <a href="https://wp.nkdev.info/youplay/forums/topic/tomb-rider/">Tomb Rider</a> in the forum 
                                            <a href="https://wp.nkdev.info/youplay/forums/forum/games/xbox/">Xbox</a> 
                                            <a href="https://wp.nkdev.info/youplay/forums/topic/tomb-rider/#post-657" class="view youplay-timeline-date pt-5 bp-tooltip">
                                                <span class="time-since">2 years ago</span>
                                            </a>
                                        </p>
                                    </h3>
                                    <div class="clearfix"></div>
                                    <div class="activity-inner">
                                        <p>
                                            Rutrum potenti fusce justo per felis dignissim, molestie orci facilisis et phasellus enim. Malesuada amet justo. Cum ultrices. Suscipit vel orci lorem. Torquent ipsum, pretium cras conubia, posuere urna donec […]
                                        </p>
                                    </div>
                                </div>
                        </div>              
                    </div>
                </div>
                <div id="panel3" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-7" style="margin-bottom: 25px;" >
                            <?php if ($teams['btn']>0): ?>
                                <a href="/profile/create-team" class="btn btn-primary">Create team</a>
                            <?php endif;?>
                        </div>
                        <div class="col-md-5" style="margin-bottom:30px;">
                            <div class="row">
                            <!-- <div class="col-md-3 no-pading">
                                <div  ><span>Order By:</span></div>
                            </div>
                            <div class="col-md-9">
                                <div class="item select-show">
                                    <div class="fancy-select ">
                                        <select class="basic" name="RegisterForm[country]" required>
                                            <option value="active">Last Active</option>
                                            <option value="popular">Most Members</option>
                                            <option value="newest">Newly Created</option>
                                            <option value="alphabetical">Alphabetical</option> 

                                        </select>
                                    </div>    
                                </div>
                            </div> -->
                            </div>   
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table" >
                            <tbody>
                                <?php foreach ($teams['teams'] as $team):?>
                                    <tr>
                                        <td style="width: 130px; vertical-align: middle" >
                                            <div class="img-game">
                                                <a href="/teams/public/<?=$team->id?>"><img src="<?=$team->logo ?>" class="avatar group-1-avatar avatar-100 photo" width="100" height="100" alt="Team logo"></a>
                                            </div>
                                        </td>
                                        <td style="vertical-align: middle; padding-left: 20px;">
                                            <div class="item-title">
                                                <a href="/teams/public/<?=$team->id?>"><?=$team->name?></a>
                                            </div>
                                            <div class="item-meta">
                                                <span class="date">Created <?= date("d-m-Y",$team->created_at) ?></span>
                                            </div>
                                            <div class="item-desc">
                                                <p><?= $team->game->name ?></p>
                                            </div>
                                            <div class="members-small">
                                                <p> <?= $team->coutUsers() ?> member(s)</p>
                                            </div>
                                        </td>
                                        <!--<td style="vertical-align: middle">
                                            <?php /*if($team->capitan == \Yii::$app->user->identity->id ): */?>
                                                <a class="btn edit-team" href="#myModal1" data-toggle="modal" data-game-id="<?/*=$team->id */?>">Add new members</a>
                                            <?php /*endif; */?>
                                        </td>-->
                                        <td class="text-right" style="vertical-align: middle">
                                            <div class="meta">
                                                <?php if($team->capitan == \Yii::$app->user->identity->id ): ?>
                                                <a class="btn edit-team" href="#myModal1" data-toggle="modal" data-game-id="<?=$team->id ?>">Add new members</a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="meta">
                                                <?php if($team->capitan == \Yii::$app->user->identity->id ): ?>
                                                    <a href="/profile/update-team?id=<?=$team->id?>" class="btn edit-team edit-btn">Edit team</a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div id="myModal1" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <input type="text" class="modal_search" placeholder="Search for players" >
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn search_btn" id="search_mod">Search</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 " id='content_modal'>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
                <div id="panel4" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-7" style="margin-bottom:30px;">
                            <div class="row">
                            <!-- <div class="col-md-3 no-pading">
                                <div  ><span>Order By:</span></div>
                            </div>
                            <div class="col-md-9">
                                <div class="item select-show">
                                    <div class="fancy-select ">
                                        <select class="basic" name="RegisterForm[country]" required>
                                            <option value="active">Last Active</option>
                                            <option value="popular">Most Members</option>
                                            <option value="newest">Newly Created</option>
                                            <option value="alphabetical">Alphabetical</option> 

                                        </select>
                                    </div>    
                                </div>
                            </div> -->
                            </div>   
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-12">
                            <div class="members friends">
                                <div id="" class="alert alert-info">
                                    <p class="m-0">Sorry, no members were found.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="panel5" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 40px;" >
                            <form action="/profile/settings" method="post">
                                <?= Html::hiddenInput(\Yii::$app->getRequest()->csrfParam, \Yii::$app->getRequest()->getCsrfToken(), []);?>
                                <div class="checkbox">
                                    <input type="checkbox" name="visible" class='filter-check' id="check_visible" <?= \Yii::$app->user->identity->visible ? 'checked': ''?>>
                                    <label for="check_visible" >
                                        <span style="font-size: 18px;position: relative;bottom: 5px;">I allow to send me invites to the teams</span>
                                    </label>
                                 </div>
                                <button type="submit" class="btn submit-btn" >Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3"></div>
    </div>
</div>

