# List duplicated devices by Serial Number from VMware Workspace ONE® UEM API

## This script will fetch all Android devices from VMware Workspace ONE® UEM via API call and calculate which devices are duplicate an safe to delete.



### Author: Patrick Pulfer (patrick.pulfer1@gmail.com)
### **Note**: I do not accept any responsabilities or liability for using this script.

Requirements:
- A web server running in Linux
- PHP7.X with cURL extension
- Edit *config.php* file to add required details 



To generate a JSON file with list of devices to delete:
    
    php get_duplicates.php
