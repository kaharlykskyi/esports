<?php

namespace app\models\servises;

use Yii;

class ApiString 
{

    public function __construct($string) 
    {
        $data  = base64_decode($string);



        echo "<pre>";
        print_r(unpack('C*', $data));
        echo "</pre>";
        exit;
    }

}