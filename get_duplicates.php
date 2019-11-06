###################################################################################
#
#   Delete Duplicated Devices from VMware Workspace ONE by Device Serial Number
#
###################################################################################
#
#   Get Devices Script
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

// Attempting to create the Devices List File
    echo 'Attempting to open or create file devices.json... ';
    $file = 'devices.json';
    $handle = fopen($file, 'w+') or die('Cannot open file. No permissions? File: '.$file);
    echo "OK.\n";

// Run AirWatch API    
    $airwatch_class = new Airwatch();
    $airwatch_class = $airwatch_class->getDevicesIDs();

//
    echo 'Writting to devices.json... ';
    fwrite($handle, $airwatch_class);
    echo "OK.\n";
    fclose($handle);


//





?>