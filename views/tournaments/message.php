<div class="container">
    <div class="row" style="margin-top: 45px;margin-bottom: 45px;">
        <div class="col-md-8 col-md-offset-2">
            <div class="alert-warning alert fade in">
                <?php if(isset($user) && !isset($team)): ?>
                    <h5>The player is already in the tournament</h5>
                <?php elseif(isset($user) && isset($team)): ?>
                    <h5>Team player already in the tournament</h5>
                <?php elseif(!isset($user) && isset($team)): ?>
                    <h5>There are no required number of players in the team</h5>
                <?php endif; ?>    
            </div>
        </div>
    </div>
</div>