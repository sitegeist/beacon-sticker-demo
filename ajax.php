<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 02.05.16
 * Time: 18:00
 */

$GLOBALS['file'] = 'data.txt';

function pushBeacon($beacon) {
    file_put_contents($GLOBALS['file'],json_encode($beacon)."\n",FILE_APPEND);
}

function popBeacons($deviceToken) {
    $beacons = array();
    $beacon = null;
    $beaconsForOtherDevices = '';
    if(file_exists($GLOBALS['file'])) {
        $file = fopen($GLOBALS['file'], "r");
        while (!feof($file)) {
            $line = fgets($file);
            if ($line) {
                //var_dump(json_decode(substr($line,0,-1)));
                $beacon = json_decode(substr($line,0,-1));
                if($beacon->token==$deviceToken) {
                    $beacons[] = $beacon;
                }
                else {
                    $beaconsForOtherDevices .= $line;
                }
            }
        }
        rsort($beacons);
        fclose($file);
        if($beaconsForOtherDevices == '') {
            unlink($GLOBALS['file']);
        }
        else {
            file_put_contents($GLOBALS['file'],$beaconsForOtherDevices);
        }
    }
    return $beacons;
}

if(isset($_POST['url'])){
    if($_POST['url'] != '') {
        pushBeacon($_POST);
    }
}
else {
    $deviceToken = $_GET['token'];
    $beacons = popBeacons($deviceToken);

    header("Content-type: application/json; charset=utf-8");
    echo json_encode($beacons);
    exit();
}