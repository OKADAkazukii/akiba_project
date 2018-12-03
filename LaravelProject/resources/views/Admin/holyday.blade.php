@extends('layouts.app')

@section('content')
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title>休日設定ページ</title>
    </head>
    <body>
        <h3>休日設定</h3>
        <?php
 　　　     $ym_now = date("Ym");
 　　　     $y = substr($ym_now,0,4);
 　　　     $m = substr($ym_now,4,2);
 　　　 ?>
 　　　     <table border="1">
 　　　     <tr>
 　　　     <th>日</th>
 　　　     <th>月</th>
 　　    　 <th>火</th>
 　　　     <th>水</th>
 　　    　 <th>木</th>
            <th>金</th>
            <th>土</th>
            </tr>
             <tr>
        <?php
            $wd1 = date("w",mktime(0,0,0,$m,1,$y));
            for ($i = 1; $i <= $wd1; $i++) {
            echo "<td> </td>";
        }
            $d = 1;
            while(checkdate($m,$d,$y)){
            echo "<td>$d</td>";
            if (date("w",mktime(0,0,0,$m,$d,$y)) == 6 ) {
            echo "</tr>";
            if (checkdate($m,$d +1,$y)) {
            echo "<tr>";
      
       }
       }
           $d++;
       }
           $wdx = date("w",mktime(0,0,0,$m +1,0,$y));
           for ($i = 1; $i < 7 - $wdx; $i++) {
           echo "<td> </td>";
       }
           ?>
           </tr>
           </table>
    </body>
</html>




