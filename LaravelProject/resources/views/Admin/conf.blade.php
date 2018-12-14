<!DOCTYPE html> 
<html>
<head>
    <meta charset= "utf-8">
    <title>管理者料率変更</title>
</head>
    <body>
    <h3>管理者料率変更</h3>

    <?php
    foreach ($status as $value){
    echo '<a href="/manager/',$value->id,'">',$value->employment_status,'</a>','<br>'; 
    }


    ?>
