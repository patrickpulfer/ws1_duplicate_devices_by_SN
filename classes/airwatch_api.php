<?php

/*



*/

class Airwatch {

    // Variables
        protected $api_mdm_v2 = "/API/mdm/devices/search";
        public $ch;



    public function __construct(){

        // Initialize cURL
            echo 'Initializing cURL... ';
            $this->ch = curl_init();
            echo "OK.\n";
    }

    public function getDevicesIDs(){

        // Variables
            $group_id = Organization_Group_ID;
            $admin_user = Service_Admin_Name;
            $admin_pass = Service_Admin_Pass;
            $tenant_id = API_Tenant_ID;
        
        // Building URL
            $cURL_Endpoint = API_Host . $this->api_mdm_v2 . '/?platform=Android&pagesize=99999&lgid='.$group_id;


        // Execute Call
            echo 'Calling API: '.$cURL_Endpoint;
            curl_setopt_array($this->ch, array(
                CURLOPT_URL => $cURL_Endpoint,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => array(
                        'Authorization: Basic '.base64_encode("$admin_user:$admin_pass"),
                        'aw-tenant-code: '. $tenant_id,
                        'Accept: application/json;version=2'
                ),
            ));
            echo " OK.\n";        
        
        $response = curl_exec($this->ch);
        
        // If cURL fails
            if(!curl_exec($this->ch)){
                die('Error: "' . curl_error($this->ch) . '" - Code: ' . curl_errno($this->ch));
            }

        return $response;
    }

}

?>