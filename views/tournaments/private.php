<?php
	$this->registerCssFile('css/tournament-public.css', ['depends' => ['app\assets\AppAsset']]);
?>

<div class="container">
    <div class="site-error">

        <h1 style="text-align: center;"><?=$model->name?></h1>

        <div class="alert alert-danger">
            You do not have access to a private tournament
        </div>
    </div>
</div>