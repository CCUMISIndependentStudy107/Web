<?php
    $Material1 = $_POST['Material1'];
    $Electric1 = $_POST['Electric1'];
    $Process1_1 = $_POST['Process1_1'];
    $Process1_2 = $_POST['Process1_2'];
    $Mileage1 = $_POST['Mileage1'];
    $Gasoline1 = $_POST['Gasoline1'];
    $Material2 = $_POST['Material2'];
    $Electric2 = $_POST['Electric2'];
    $Process2_1 = $_POST['Process2_1'];
    $Process2_2 = $_POST['Process2_2'];
    $Mileage2 = $_POST['Mileage2'];
    $Gasoline2 = $_POST['Gasoline2'];
    $Mweight1 = $_POST['Mweight1'];
    $Mweight2 = $_POST['Mweight2'];
    $MElec = $_POST['MElec'];
    $MWeight = $_POST['MWeight'];
    $Expiration = $_POST['Expiration'];
    $Bamboo = $_POST['Bamboo'];
    $process_rate = 1.02;
    $gas_rate = 0.22;
    $year_rate = 4*0.4*3.1;
    $value = ((($Electric1+$Process1_1+$Process1_2)*$process_rate)+$Mileage1*$gas_rate)*$Mweight1;
    $value += ((($Electric2+$Process2_1+$Process2_2)*$process_rate)+$Mileage2*$gas_rate)*$Mweight2;
    $value += $MElec*$process_rate;
    $value += $Expiration*$Bamboo*$year_rate;
    $value *= $MWeight;
?>