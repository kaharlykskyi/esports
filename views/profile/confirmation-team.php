<div class="container" style="margin: 50px 0">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 text-center" style="margin-bottom: 40px;">
            <h2>New invite to the team</h2>
            <div class="col-md-12" style="margin-bottom: 60px;">
            	<div class="col-md-6" style="text-align: center;" >
            		<img src="<?=$team->logo?>" style="border-radius: 50%;">
            	</div>
            	<div class="col-md-6">
            		<p>Team: <b><?=$team->name?></b></p>
            		<p>Game: <b><?=$team->game->name?></b></p>
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