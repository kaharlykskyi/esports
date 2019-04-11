<?php

//AppAsset::register($this);

?> 
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/css/style.min.css">
    <link rel="stylesheet" href="/bracket/jquery.bracket.min.css">
    <link rel="stylesheet" href="/css/tournament-public.css">
    <script type="text/javascript" src="/js/library/jquery.js"></script>
    <script type="text/javascript" src="/bracket/jquery.bracket.min.js"></script>
    <script type="text/javascript" src="/js/profile/cup.js"></script>
</head>
<body>
<?php $this->beginBody() ?>
<?=$content?>
<?php $this->endBody() ?>
</body>
</html> 
<?php $this->endPage() ?>
