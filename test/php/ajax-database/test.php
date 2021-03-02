<!doctype html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
//    date_default_timezone_set("PRC");
    echo date("F d").",&nbsp;".date("Y")."&nbsp;at&nbsp;".date("h:i a");
    $array_test = array("666");
    array_push($array_test, "999");
    echo "$array_test[1]";
    var_dump($array_test);
?>
</body>
</html>