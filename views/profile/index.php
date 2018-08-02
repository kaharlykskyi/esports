<?php
use app\widgets\Alert;

$this->registerCssFile('css/profile.css', ['depends' => ['app\assets\AppAsset']]);
$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= Alert::widget()?>

<section class="image-header img-url">
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
    		<ul class="flickity-enabled is-draggable" tabindex="0">
    			<div class="flickity-viewport" style="height: 45px; touch-action: pan-y;">
    				<div class="flickity-slider" style="left: 0px; transform: translateX(0%);">
    					<li id="activity-personal-li" class="current selected active is-selected" aria-selected="true" ><a id="user-activity" href="https://wp.nkdev.info/youplay/members/craager/activity/">Profile</a></li>
    					<li id="xprofile-personal-li" aria-selected="false" ><a id="user-xprofile" href="https://wp.nkdev.info/youplay/members/craager/profile/">Friends</a></li>
    					<li id="blogs-personal-li" aria-selected="false" ><a id="user-blogs" href="https://wp.nkdev.info/youplay/members/craager/blogs/">Groups <span class="badge mnb-1">4</span></a></li>
    					<li id="friends-personal-li" aria-selected="false" ><a id="user-friends" href="https://wp.nkdev.info/youplay/members/craager/friends/">Forums <span class="badge mnb-1 sr-only">0</span></a></li>
    					<!-- <li id="groups-personal-li" aria-selected="false" style="position: absolute; left: 33.57%;"><a id="user-groups" href="https://wp.nkdev.info/youplay/members/craager/groups/">Groups <span class="badge mnb-1">1</span></a></li>
    					<li id="forums-personal-li" aria-selected="false" style="position: absolute; left: 44.06%;"><a id="user-forums" href="https://wp.nkdev.info/youplay/members/craager/forums/">Forums</a></li> -->
    				</div>
    			</div>
    		</ul>
    	</div>
    </div>
</section>
<section class="standing-cup" style="margin-bottom: 30px;">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
                <ul class="tab-filters">
                    <li class="active"><a href="#qualification">Personal</a></li>
                    <li><a href="#quarterfinal">Mentions</a></li>
                    <li><a href="#semifinal">Favorites</a></li>
                    <li><a href="#final">Friends</a></li>
                    <li><a href="#final">Groups</a></li>
                </ul>
        	</div>
        	<div class="col-md-6">
        		<div class="row">
        			<div class="col-md-2 no-pading">
        				<div style="margin-left: 40px;" ><span>Show:</span></div>
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
        			</div>
        		</div>
        		
                   
                </div>
        </div>	
	</div>
</section>

<div class="container">
	<div class="row">
		<div class="col-md-9 ">
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
		
		<div class="col-md-3"></div>
	</div>
</div>

