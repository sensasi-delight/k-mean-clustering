<?php
/*
$data = [
    ['nama' => 0, 'data' => [1, 1, 2]],
    ['nama' => 1, 'data' => [3, 1, 2]],
    ['nama' => 2, 'data' => [1, 3, 4]],
    ['nama' => 3, 'data' => [3, 3, 8]],
    ['nama' => 4, 'data' => [7, 7, 1]],
    ['nama' => 5, 'data' => [9, 9, 2]],
];*/

include("new_thyroid_normal_array.php");

$dataset = $new_thyroid;
$k=3;

$no = 0;
foreach ($dataset as $value) {
    $clusters[$no++]=[$value];
}


while (count($clusters)>$k) {
    $temp_jarak = '';
    foreach ($clusters as $key1 => $cluster_1) {
        foreach ($clusters as $key2 => $cluster_2) {
            if ($key1!=$key2) {
                foreach ($cluster_1 as $data1) {
                    foreach ($cluster_2 as $data2) {
                        $jarak = 0;
                        foreach ($data1['data'] as $i => $value) {
                            $jarak += pow(abs($value-$data2['data'][$i]), 2);
                 //           echo $value."-".$data2[$i]." ";
                        }
                        $jarak = sqrt($jarak);
             //           echo "<PRE>"; print_r($jarak); die();
                        if ($jarak < $temp_jarak || $temp_jarak == '') {
                            $temp_jarak = $jarak;
                            $temp_key1=$key1;
                            $temp_key2=$key2;
                        }
                    }
                }
                
            }        
        }
    }

    foreach ($clusters[$temp_key2] as $key => $value) {
        array_push($clusters[$temp_key1], $value);
    }

    unset($clusters[$temp_key2]);
    //echo "<PRE>";
    //print_r($cluster);
    //echo "------------------------------------------------------------";
}
sort($clusters);
/*
foreach ($clusters as $key => $value) {
    echo "Cluster ".($key+1)." : ";
    foreach ($value as $key => $value) {
        echo $value['data_ke'].", ";
    }
    echo "<BR>";
}*/

?>
<TABLE border='0' style="text-align:center">
    <TR style="font-weight:bold">
        <TD>Data ke</TD>
        <TD colspan="<?php echo count($dataset[0]['data']); ?>">Data (Normalisasi)</TD>
        <TD>Class</TD>
        <TD>Cluster ke</TD>
    </TR>
<?php foreach ($clusters as $i => $value) {
    //echo "Cluster ".($key+1)." : ";
    foreach ($value as $j => $value) { ?>
    <TR>
        <TD><?php echo $value['data_ke']; ?></TD>
        <?php $data_ke=$value['data_ke']-1; 
        foreach ($dataset[$data_ke]['data'] as $k => $dimensi) {
            echo "<TD>".$dimensi."</TD>";
        } ?>
        <TD><?php echo $dataset[$data_ke]['class']; ?></TD>
        <TD><?php echo $i+1; ?> </TD>
    </TR>
        <?php
    }
} ?>

</TABLE>
