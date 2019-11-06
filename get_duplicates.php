###################################################################################
#
#   Delete Duplicated Devices from VMware Workspace ONE® by Device Serial Number
#
###################################################################################
#
#   ** Get Devices Script **
#
#   This script will fetch all Android devices from VMware Workspace ONE® UEM via API call and calculate which devices are duplicate an safe to delete.
#
#   Author: Patrick Pulfer (patrick.pulfer1@gmail.com)
#
#   Note: I do not accept any responsabilities or liability for using this script.
#
###################################################################################

<?php

// Loading Dependancies
    echo 'Loading dependancies... ';
    require_once './config.php';
    require_once './classes/airwatch_api.php';
    echo "OK.\n";


// Declaring Variables
    $airwatch_class = '';
    $i = 0;
    $duplicate_devices = array();
    $to_delete = array();


// Run AirWatch API    
    $airwatch_class = new Airwatch();
    $response = $airwatch_class->getDevicesIDs();
    $response = json_decode($response, JSON_PRETTY_PRINT);
    $array = $response['Devices'];


// Comparisons to generate list of all devices
    $y=0;
    $z=0;
    foreach($array as $row => $val){
        $i=0;
        foreach($array as $row2 => $val2){

            if($val["SerialNumber"] == $val2['SerialNumber']){
                $i++;
                if($i == 2){
                    $duplicate_devices[$y]['DeviceFriendlyName'] = $val['DeviceFriendlyName'];
                    $duplicate_devices[$y]['Udid'] = $val['Udid'];
                    $duplicate_devices[$y]['SerialNumber'] = $val['SerialNumber'];
                    $duplicate_devices[$y]['LastEnrolledOn'] = DateTime::createFromFormat('Y-m-d\TH:i:s.u',$val['LastEnrolledOn'])->format('Y-m-d H:i:s');
                    $duplicate_devices[$y]['LastSeen'] = DateTime::createFromFormat('Y-m-d\TH:i:s.u',$val['LastSeen'])->format('Y-m-d H:i:s');
                    $y++;
                }
            }
        }
    }


// Print duplicated devices to file
    echo 'Generating list of duplicated devices... ';
    $file_duplicates = fopen('duplicate_devices.json', 'w') or die('Cannot open file. No permissions? File: duplicate_devices.json');
    fwrite($file_duplicates, json_encode($duplicate_devices));
    fclose($file_duplicates);
    echo "OK.\nDuplicate List: duplicate_devices.json\n";


// Comparisons between duplicated by Last_Seen
    $y=0;
    foreach($duplicate_devices as $row => $val){
        $i=0;
        foreach($duplicate_devices as $row2 => $val2){

            if($val['SerialNumber'] == $val2['SerialNumber']){
                $i++;
                if($i == 2){
                    if($val['LastSeen'] > $val2['LastSeen']){
                        $to_delete[$y]['DeviceFriendlyName'] = $val2['DeviceFriendlyName'];
                        $to_delete[$y]['Udid'] = $val2['Udid'];
                        $to_delete[$y]['SerialNumber'] = $val2['SerialNumber'];
                        $to_delete[$y]['LastEnrolledOn'] = $val2['LastEnrolledOn'];
                        $to_delete[$y]['LastSeen'] = $val2['LastSeen'];
                        $y++;
                    }
                    elseif($val['LastSeen'] < $val2['LastSeen']){
                        $to_delete[$y]['DeviceFriendlyName'] = $val['DeviceFriendlyName'];
                        $to_delete[$y]['Udid'] = $val['Udid'];
                        $to_delete[$y]['SerialNumber'] = $val['SerialNumber'];
                        $to_delete[$y]['LastEnrolledOn'] = $val['LastEnrolledOn'];
                        $to_delete[$y]['LastSeen'] = $val['LastSeen'];
                        $y++;
                    }
                }
            }
        }
    }


// Print devices to delete to file
    echo 'Generating list of devices to delete... ';
    $file_to_delete = fopen('to_delete.json', 'w') or die('Cannot open file. No permissions? File: duplicate_devices.json');
    fwrite($file_to_delete, json_encode($to_delete));
    fclose($file_to_delete);
    echo "OK.\nList of devices for deletion: to_delete.json\n";

// Echo list of devices to be deleted
    echo "\nOlder devices To be deleted: ";
    print_r($to_delete);
?>