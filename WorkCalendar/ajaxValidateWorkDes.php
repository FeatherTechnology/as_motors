<?php
include '../ajaxconfig.php';

if(isset($_POST['workdes_id'])){
    $workdes_id = $_POST['workdes_id'];
}

    $ifhas = "+kpi";
    if (strstr($workdes_id, $ifhas)) {
        //"The substring was found in the string";
        $kpi_name = "";
        $krakpi_ref_id = strstr($workdes_id, $ifhas, true);
        $getqry = "SELECT * FROM krakpi_creation_ref WHERE krakpi_ref_id ='".strip_tags($krakpi_ref_id)."' and status = 0";
        $res3 = $con->query($getqry);
        while($row3 = $res3->fetch_assoc()){
            $kpi_name = $row3["kpi"];        
        }
        $workDescription['description'] = $kpi_name;

    } else {
        //"The substring was not found in the string";
        $rr_id = $workdes_id;
        $rr_name = "";
        $getqry = "SELECT * FROM rr_creation_ref WHERE rr_ref_id ='".strip_tags($rr_id)."' and status = 0";
        $res3 = $con->query($getqry);
        while($row3 = $res3->fetch_assoc()){
            $rr_name = $row3["rr"];        
        }
        $workDescription['description'] = $rr_name;
    }


echo json_encode($workDescription);
?>