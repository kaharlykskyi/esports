<?php
    $this->registerJsFile(\Yii::$app->request->baseUrl . '/js/profile/string.js',['depends' => 'yii\web\JqueryAsset','position' => yii\web\View::POS_END]);

?>

<div class="container">
    <div class="row" style="margin-top:40px;">
        <div class="col-md-8 col-md-offset-2" >
            <div class="col-md-6" >
                <input type="text">
            </div>
            <div class="col-md-6" >
                <input type="submit" class="btn">
            </div>
            
        </div> 
    </div>
</div>