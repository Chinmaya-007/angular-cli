<?php
namespace config;
class dbconnection{

    

    # this is the include for the API for PHP
    //require_once ('../lib/FileMaker.php');
# instantiate a new FileMaker object
    
    // if (FileMaker::isError($fm)) {
    //     if ($fm->code = 401) {
    //     $findError = 'There are no Records that match that request: '. ' (' .
    //     $fm->code . ')';
    //     } else {
    //     $findError = 'Find Error: '. $fm->getMessage(). ' (' . $fm->code
    //     . ')';
    //     }
    //     }
    public function connect(){
    //     define('FM_HOST', '172.16.9.184');
    //     define('FM_FILE', 'studentDetails.fmp12');
    //     define('FM_USER', 'admin');
    //     define('FM_PASS', '20410samaya');

    // $fm = new \FileMaker(FM_FILE, FM_HOST, FM_USER, FM_PASS);
    $fm = new \FileMaker();
    $fm->setProperty('database', 'studentDetails');
    $fm->setProperty('hostspec', '172.16.9.184');
    $fm->setProperty('username', 'admin');
    $fm->setProperty('password', '20410samaya'); 
             
    if (\FileMaker::isError($fm)) {
        echo "<p>Error: " . $fm->getMessage() . "</p>";
        exit;
    }
    return $fm;
    }
}

