<?php

die();

$q = mysql_query('SELECT * FROM `katalog_error` WHERE `error` LIKE "{%"');
while($res = mysql_fetch_object($q))
{
    $data = json_decode($res->error);
    
    if($data->GET->st == 1)
        var_dump($data);
}