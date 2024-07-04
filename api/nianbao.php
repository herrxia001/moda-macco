<?php
$dbHost  		= "127.0.0.1:3306";
$dbUser  		= "zvhjub8k_admin";
$dbPassword   	= "moda-prato23#";
$dbname         = "zvhjub8k_macco";

$mysqli = new mysqli($dbHost, $dbUser, $dbPassword, $dbname);
$mysqli->set_charset("utf8");

$year = date("Y")-1;

show($year, 3);
show($year, 6);
show($year, 9);
show($year, 0);

function show($year, $month){
    global $mysqli;
    $art = [];
    if($month == 3){
        $where = "date >= '".$year."-01-01 00:00:00' AND date <= '".$year."-03-31 23:59:59'";
        $lastwhere = "year = ".($year-1)." AND month = 0";
    }else if($month == 6){
        $where = "date >= '".$year."-04-01 00:00:00' AND date <= '".$year."-06-31 23:59:59'";
        $lastwhere = "year = ".$year." AND month = 3";
    }else if($month == 9){
        $where = "date >= '".$year."-07-01 00:00:00' AND date <= '".$year."-09-31 23:59:59'";
        $lastwhere = "year = ".$year." AND month = 6";
    }else { // 0
        $where = "date >= '".$year."-10-01 00:00:00' AND date <= '".$year."-12-31 23:59:59'";
        $lastwhere = "year = ".$year." AND month = 9";
    }
    
    
    $sql = "SELECT * FROM a_art ORDER BY a_name";
    $result = mysqli_query($mysqli, $sql);
    while ($row = $result->fetch_object()) {
        $art[$row->a_id]['a_code'] = $row->a_code;
        $art[$row->a_id]['t_id'] = $row->t_id;
        $art[$row->a_id]['a_name'] = $row->a_name;
        // in_count //
        $art[$row->a_id]['in_count'] = 0;
        $art[$row->a_id]['in_total'] = 0;
        $sql = "SELECT count, cost, unit FROM a_pur_items WHERE a_id = '".$row->a_id."' AND f_id IN (SELECT f_id FROM a_purs WHERE ".$where.")";
        $result_2 = mysqli_query($mysqli, $sql);
        while ($row_2 = $result_2->fetch_object()) {
            $art[$row->a_id]['in_count'] += floatval($row_2->count) * floatval($row_2->unit);
            $art[$row->a_id]['in_total'] += floatval($row_2->cost) * floatval($row_2->count) * floatval($row_2->unit);
        }
        if($art[$row->a_id]['in_count'] == 0) $art[$row->a_id]['cost'] =$row->cost;
        else $art[$row->a_id]['cost'] = $art[$row->a_id]['in_total'] / $art[$row->a_id]['in_count'];
    
        // out //
        $art[$row->a_id]['out_count'] = 0;
        $art[$row->a_id]['out_total'] = 0;
        $sql = "SELECT count, price, unit, discount FROM a_in_items WHERE a_id = '".$row->a_id."' AND r_id IN (SELECT r_id FROM a_invoice WHERE ".$where.")";
        $result_2 = mysqli_query($mysqli, $sql);
        while ($row_2 = $result_2->fetch_object()) {
            $art[$row->a_id]['out_count'] += floatval($row_2->count) * floatval($row_2->unit);
            $price = $row_2->price * ((100 - $row_2->discount) / 100);
            $art[$row->a_id]['out_total'] += $price * floatval($row_2->count) * floatval($row_2->unit);
        }
    
        // ref //
        $art[$row->a_id]['rf_count'] = 0;
        $art[$row->a_id]['rf_total'] = 0;
        $sql = "SELECT count, price, unit, discount FROM a_rf_items WHERE a_id = '".$row->a_id."' AND rf_id IN (SELECT rf_id FROM a_refund WHERE ".$where.")";
        $result_2 = mysqli_query($mysqli, $sql);
        while ($row_2 = $result_2->fetch_object()) {
            $art[$row->a_id]['rf_count'] += floatval($row_2->count) * floatval($row_2->unit);
            $price = $row_2->price * ((100 - $row_2->discount) / 100);
            $art[$row->a_id]['rf_total'] += $price * floatval($row_2->count) * floatval($row_2->unit);
        }
        // jiezhikucun //
        $lastcount = 0;
        $sql = "SELECT count,dep_count FROM a_art_hist WHERE a_id='".$row->a_id."' AND ".$lastwhere;
        $result_2 = mysqli_query($mysqli, $sql);
        if ($row_2 = $result_2->fetch_object()) {
            $lastcount = $row_2->count - $row_2->dep_count;
        }
        $art[$row->a_id]['count'] = $lastcount + $art[$row->a_id]['in_count'] - $art[$row->a_id]['out_count'] - $art[$row->a_id]['rf_count'];
    }
    $sql = "SELECT * FROM a_art_hist WHERE year = '".$year."' AND month = '".$month."'";
    $result_2 = mysqli_query($mysqli, $sql);
    if (!$row_2 = $result_2->fetch_object()) {
        foreach($art AS $a_id => $element){
            $sql = "INSERT INTO a_art_hist (a_id, year, month, a_code, t_id, a_name, count, cost, in_count, in_total, out_count, out_total, rf_count, rf_total, dep_count) VALUES ";
            $sql .= "('".$a_id."','".$year."','".$month."','".$element['a_code']."','".$element['t_id']."','".$element['a_name']."','".$element['count']."','".$element['cost']."','".$element['in_count']."','".$element['in_total']."','".$element['out_count']."','".$element['out_total']."','".$element['rf_count']."','".$element['rf_total']."',0)";
            echo $sql.";<br>";
            mysqli_query($mysqli, $sql);
        }
    }
}

?>


<!--table border="1">
    <tr>
        <th>a_id</th>
        <th>year</th>
        <th>month</th>
        <th>a_code</th>
        <th>t_id</th>
        <th>a_name</th>
        <th>count</th>
        <th>cost</th>
        <th>in_count</th>
        <th>in_total</th>
        <th>out_count</th>
        <th>out_total</th>
        <th>rf_count</th>
        <th>rf_total</th>
        <th>dep_count</th>
    </tr>
    <?php foreach($art AS $a_id => $element){ ?>
        <tr>
            <td><?= $a_id ?></td>
            <td><?= $year ?></td>
            <td><?= $month ?></td>
            <td><?= $element['a_code'] ?></td>
            <td><?= $element['t_id'] ?></td>
            <td><?= $element['a_name'] ?></td>
            <td><?= $element['count'] ?></td>
            <td><?= $element['cost'] ?></td>
            <td><?= $element['in_count'] ?></td>
            <td><?= $element['in_total'] ?></td>
            <td><?= $element['out_count'] ?></td>
            <td><?= $element['out_total'] ?></td>
            <td><?= $element['rf_count'] ?></td>
            <td><?= $element['rf_total'] ?></td>
            <td>-</td>
        </tr>
    <?php } ?>
</table-->