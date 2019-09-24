<?php

/*



*/

class Airwatch {

    // Workspace ONE UEM
        protected $host;
        protected $tenant_id;
        protected $group_id;

    // Service Admin Credentials
        protected $admin_user;
        protected $admin_pass;

    // Host APIs
        protected $api_mdm_v2 = "/API/mdm/devices/search";


    public function __construct(){

        // Initialize cURL
            $ch = curl_init();
    }

    public function getDevicesIDs{
        
        // Building URL
            $cURL_Endpoint = $host . $api_mdm_v2 . '/?=' . $group_id;

        // Execute Call
            curl_setopt_array($ch, array(
                CURLOPT_URL => $cURL_Endpoint;
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => array(
                        'Authorization: Basic '.base64_encode("$admin_user:$admin_pass"),
                        'aw-tenant-code: '. $tenant_id,
                        'Accept: application/json;version=2'
                ),
            ));        
        
        $response = curl_exec($ch);
        
        // If cURL fails
            if(!curl_exec($ch)){
                die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
            }
    }

}

?>