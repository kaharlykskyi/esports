<div class="container" style="margin-top: 50px;">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 text-center" style="margin-bottom: 40px;">
            <h2>New invite to the team</h2>
            <div class="col-md-12" style="margin-bottom: 60px;">
            	<div class="col-md-5" class="clearfix" >
            		<a href="/teams/public/<?=$team->id?>" target="_blank">
	            		<img src="<?=$team->logo?>" style="border-radius: 50%;width: 100px;
	            		margin-right: 27px; float:right;">
	            	</a>
            	</div>
            	<div class="col-md-6 text-left" style="margin-top:18px;font-size: 20px; " >
            		<p><a href="/teams/public/<?=$team->id?>" target="_blank"><b><?=$team->name?></b></a></p>
            		<p><b><?=$team->game->name?></b></p>
            	</div>
            </div>
			<div class="col-md-6">
				<a href="/profile/confirmation-team?confirmation_tokin=<?=$confirmation_tokin?>&status=2" class="btn">ACCEPT</a>
			</div>
			<div class="col-md-6">
				<a href="/profile/confirmation-team?confirmation_tokin=<?=$confirmation_tokin?>&status=3" class="btn btn-red">DECLINE</a>
			</div>
		</div>
	</div>
</div>