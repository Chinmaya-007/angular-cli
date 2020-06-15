<?php
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Tuupola\Middleware\JwtAuthentication;
use config as dbconnection;

//$app = new \Slim\App(['settings' => ['displayErrorDetails' => true]]);
use \Firebase\JWT\JWT;



$app->add(new Tuupola\Middleware\JwtAuthentication([
    "path" => ["/api1"],
    "ignore" => ["/api1/login","/api1/register","/api1/update","/api1/bidderlogin","/api1/dropdown/","/api1/bidding","/api1/matches","/api1/biddingResult/","/api1/leaderboard","/api1/finishedMatches"],
    "secret" => "chinmaya"
]));
//show all student details

$app->get('/api1/students',function(Request $request, Response $response){
    $sql="select * from info";
    try{
        $db= new db();
        $db=$db->connect();
        $stmt =$db->query($sql);
        $student=$stmt->fetchAll(PDO::FETCH_OBJ);
        $db= null;
        return $response->withJson($student,200);
        //echo json_encode($student);

    }catch(PDOException $e){
        echo '{"error":{"text": '.$e->getMessage().'}';

    }

});

//get single student
$app->get('/api1/students/{id}',function(Request $request, Response $response){
    
    $id = $request->getAttribute('id');
   
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    
    $findCommand = $fm->newFindCommand('studentDetails');
    $findCommand->addFindCriterion('id',$id);
    $result=$findCommand->execute();
    if (FileMaker::isError($result)) {
        echo $result->getMessage();
        exit;
        if ($result->code == 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $data=$result->getRecords()[0]->_impl->_fields;
        //print_r($result);
        if(count($result->getRecords())==1){
            $newresponse = $response->withStatus(200);
        return $response->withJson(["status"=>true,"data"=>$data]);
        } else {
            $newresponse = $response->withStatus(401);
            return $newresponse->withJson(["status"=>false]);
        }
    }

});


$app->get('/api1/studentName/{id}',function(Request $request, Response $response){
    
    $id = $request->getAttribute('id');
   
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    
    $findCommand = $fm->newFindCommand('studentDetails');
    $findCommand->addFindCriterion('id',$id);
    $result=$findCommand->execute();
    if (FileMaker::isError($result)) {
        echo $result->getMessage();
        exit;
        if ($result->code == 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $dataArray = array();

        $records = $result->getRecords();

        foreach($records as $record) {
            // push another array to the main array with all the field names and values
            array_push($dataArray, array(
                'firstName' =>  $record->getField('firstName')
            ));
        }
        
            
        return $response->withJson($record->getField('firstName'), 200);
    }

});


$app->get('/api1/dropdown/{id}',function(Request $request, Response $response){
    
    $id = $request->getAttribute('id');
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    $findCommand = $fm->newFindCommand('studentDetails');
    $findCommand->addFindCriterion('age',$id);
    $result=$findCommand->execute();
    if (FileMaker::isError($result)) {
        echo $result->getMessage();
        exit;
        if ($result->code == 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $dataArray = array();

        $records = $result->getRecords();

        foreach($records as $record) {
            // push another array to the main array with all the field names and values
            array_push($dataArray, array(
                'firstName' =>  $record->getField('firstName'),
                'lastName' => $record->getField('lastName'),
                'id' => (int)$record->getField('id'),
                'points' => (int)$record->getField('points')
                
            ));
        }
        
            
        return $response->withJson($dataArray, 200);
    }

});


$app->get('/api1/credits/{id}',function(Request $request, Response $response){
    
    $id = $request->getAttribute('id');
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    $findCommand = $fm->newFindCommand('bidderDetails');
    $findCommand->addFindCriterion('id',$id);
    $result=$findCommand->execute();
    if (FileMaker::isError($result)) {
        echo $result->getMessage();
        exit;
        if ($result->code == 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $dataArray = array();

    $records = $result->getRecords();

    foreach($records as $record) {
        // push another array to the main array with all the field names and values
        array_push($dataArray, array(
            'credits' =>  $record->getField('credits'),
            
            
        ));
    }
        
            
        return $response->withJson($dataArray, 200);
    }

});


$app->get('/api1/biddinghistory/{id}',function(Request $request, Response $response){
    
    $id = $request->getAttribute('id');
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    $findCommand = $fm->newFindCommand('biddingDetails');
    $findCommand->addFindCriterion('bidderId',$id);
    $result=$findCommand->execute();
    if (FileMaker::isError($result)) {
        echo $result->getMessage();
        exit;
        if ($result->code == 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $dataArray = array();

    $records = $result->getRecords();
    
    function abc($id){
        $dbobj = new dbconnection\dbconnection();
        $fm = $dbobj->connect();
        $findCommand = $fm->newFindCommand('studentDetails');
        $findCommand->addFindCriterion('id',$id);
        $result=$findCommand->execute();
        if (FileMaker::isError($result)) {
            echo $result->getMessage();
            exit;
            if ($result->code == 401) {
            $findError = 'There are no Records that match that request: '. ' (' .
            $result->code . ')';
            } else {
            $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
            . ')';
            }
            $newresponse =  $response->withStatus(404);
            return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
        }
        else{
            $dataArray = array();

            $records = $result->getRecords();

            foreach($records as $record) {
                // push another array to the main array with all the field names and values
                array_push($dataArray, array(
                    'firstName' =>  $record->getField('firstName')
                ));
            }
            
                
            return $record->getField('firstName');
        }
    }

    function tournament($id){
        $dbobj = new dbconnection\dbconnection();
        $fm = $dbobj->connect();
        $findCommand = $fm->newFindCommand('matches');
        $findCommand->addFindCriterion('id',$id);
        $result=$findCommand->execute();
        if (FileMaker::isError($result)) {
            echo $result->getMessage();
            exit;
            if ($result->code == 401) {
            $findError = 'There are no Records that match that request: '. ' (' .
            $result->code . ')';
            } else {
            $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
            . ')';
            }
            $newresponse =  $response->withStatus(404);
            return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
        }
        else{
            $dataArray = array();

            $records = $result->getRecords();

            foreach($records as $record) {
                // push another array to the main array with all the field names and values
                array_push($dataArray, array(
                    'firstName' =>  $record->getField('name')
                ));
            }
            
                
            return $record->getField('name');
        }
    }


    foreach($records as $record) {
        // push another array to the main array with all the field names and values
        array_push($dataArray, array(
            'player1' =>  abc($record->getField('playerId1')),
            'player2' =>  abc($record->getField('playerId2')),
            'player3' =>  abc($record->getField('playerId3')),
            'player4' =>  abc($record->getField('playerId4')),
            'player5' =>  abc($record->getField('playerId5')),
            'tournament' => tournament($record->getField('tournamentId'))
            
        ));
    }
        
            
        return $response->withJson($dataArray, 200);
    }

});

// -------------------------------------------------

$app->get('/api1/biddingResult/{tournament}',function(Request $request, Response $response){
    
    $tournament = $request->getAttribute('tournament');
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    $findCommand = $fm->newFindCommand('biddingDetails');
    $findCommand->addFindCriterion('tournamentId',$tournament);
    $result=$findCommand->execute();
    if (FileMaker::isError($result)) {
        echo $result->getMessage();
        exit;
        if ($result->code == 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $dataArray = array();

    $records = $result->getRecords();
    
    function abc($id,$tournament){
        $dbobj = new dbconnection\dbconnection();
        $fm = $dbobj->connect();
        $findCommand = $fm->newFindCommand('points');
        $findCommand->addFindCriterion('tournamentId',$tournament);
        $result=$findCommand->execute();
        if (FileMaker::isError($result)) {
            echo $result->getMessage();
            exit;
            if ($result->code == 401) {
            $findError = 'There are no Records that match that request: '. ' (' .
            $result->code . ')';
            } else {
            $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
            . ')';
            }
            $newresponse =  $response->withStatus(404);
            return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
        }
        else{
            $dataArray = array();

            $records = $result->getRecords();

            foreach($records as $record) {
                // push another array to the main array with all the field names and values
                array_push($dataArray, array(
                    'firstName' =>  $record->getField('firstName')
                ));
            }
            
                
            return $record->getField($id);
        }
    }
    function name($id){
        $dbobj = new dbconnection\dbconnection();
        $fm = $dbobj->connect();
        $findCommand = $fm->newFindCommand('bidderDetails');
        $findCommand->addFindCriterion('id',$id);
        $result=$findCommand->execute();
        if (FileMaker::isError($result)) {
            echo $result->getMessage();
            exit;
            if ($result->code == 401) {
            $findError = 'There are no Records that match that request: '. ' (' .
            $result->code . ')';
            } else {
            $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
            . ')';
            }
            $newresponse =  $response->withStatus(404);
            return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
        }
        else{
            $dataArray = array();

            $records = $result->getRecords();

            foreach($records as $record) {
                // push another array to the main array with all the field names and values
                array_push($dataArray, array(
                    'firstName' =>  $record->getField('name')
                ));
            }
            
                
            return $record->getField('name');
        }
    }


    foreach($records as $record) {
        // push another array to the main array with all the field names and values
        array_push($dataArray, array(
            'player1' =>  abc($record->getField('playerId1'),$tournament),
            'player2' =>  abc($record->getField('playerId2'),$tournament),
            'player3' =>  abc($record->getField('playerId3'),$tournament),
            'player4' =>  abc($record->getField('playerId4'),$tournament),
            'player5' =>  abc($record->getField('playerId5'),$tournament),
            'name' =>  name($record->getField('bidderId')),
            'totalPoints' => abc($record->getField('playerId1'),$tournament)+abc($record->getField('playerId2'),$tournament)+abc($record->getField('playerId3'),$tournament)+abc($record->getField('playerId4'),$tournament)+abc($record->getField('playerId5'),$tournament),
            
        ));
    }
        
            
        return $response->withJson($dataArray, 200);
    }

});

// ----------------------------------------------------
$app->get('/api1/matches',function(Request $request, Response $response){
    
    
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    $findCommand = $fm->newFindCommand('matches');

    $result=$findCommand->execute();
    if (FileMaker::isError($result)) {
        echo $result->getMessage();
        exit;
        if ($result->code == 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $dataArray = array();
        $records = $result->getRecords();
        $today = date("Y-m-d");
        foreach($records as $record) {
            if($today<$record->getField('startDate')){
                array_push($dataArray, array(
                    'name' =>  $record->getField('name'),
                    'id' =>  $record->getField('id'),
                    'startDate' => $record->getField('startDate')
                )); 
            }
            
        }     
            return $response->withJson($dataArray, 200);
        }

});

$app->get('/api1/finishedMatches',function(Request $request, Response $response){
    
    
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    $findCommand = $fm->newFindCommand('matches');

    $result=$findCommand->execute();
    if (FileMaker::isError($result)) {
        echo $result->getMessage();
        exit;
        if ($result->code == 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $dataArray = array();
        $records = $result->getRecords();
        $today = date("Y-m-d");
        foreach($records as $record) {
            if($today>$record->getField('endDate')){
                array_push($dataArray, array(
                    'name' =>  $record->getField('name'),
                    'id' =>  $record->getField('id'),
                    'endDate' => $record->getField('endDate')
                )); 
            }
            
        }     
            return $response->withJson($dataArray, 200);
        }

});



// add student in the database
$app->post('/api1/register',function(Request $request, Response $response){
    $parsedBody = $request->getParsedBody();
    
    
    

    $val= array(
        "firstName"=> $parsedBody['firstName'],
        "lastName"=> $parsedBody['lastName'],
        "age"=> $parsedBody['age'],
        "gender"=> $parsedBody['gender'],
        "fatherName"=> $parsedBody['fatherName'],
        "motherName"=> $parsedBody['motherName'],
        "email"=> $parsedBody['email'],
        "password"=> $parsedBody['password'],
        "phoneNumber"=> $parsedBody['phoneNumber'],  
        "address1"=> $parsedBody['address1'],
        "address2"=> $parsedBody['address2'],
        "district"=> $parsedBody['district'],
        "state"=> $parsedBody['state'],
        "pinCode"=> $parsedBody['pinCode'],
        "country"=> $parsedBody['country']
    );
    


    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    
    $rec = $fm->createRecord('studentDetails',$val);
    $result = $rec->commit();
    
    if (FileMaker::isError($result)) {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code. ')';
        $newresponse = $response->withStatus(404);
        return $newresponse->withJson(['success'=>false, "message"=>$findError]);
        
    }
    else{
        $newresponse = $response->withStatus(200);
        return $newresponse->withJson(['success'=>true, "message"=>$request->getParsedBody()['phoneNumber']]);
    }


});

$app->post('/api1/bidding',function(Request $request, Response $response){
    $parsedBody = $request->getParsedBody();
    
    
    

    $val= array(
        "bidderId"=> $parsedBody['id'],
        "playerId1"=> $parsedBody['player1'],
        "playerId2"=> $parsedBody['player2'],
        "playerId3"=> $parsedBody['player3'],
        "playerId4"=> $parsedBody['player4'],
        "playerId5"=> $parsedBody['player5'],
        "tournamentId"=> $parsedBody['tournament'],
        
    );
    


    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    
    $rec = $fm->createRecord('biddingDetails',$val);
    $result = $rec->commit();
    
    if (FileMaker::isError($result)) {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code. ')';
        $newresponse = $response->withStatus(404);
        return $newresponse->withJson(['success'=>false, "message"=>$findError]);
        
    }
    else{
        $newresponse = $response->withStatus(200);
        return $newresponse->withJson(['success'=>true, "message"=>$request->getParsedBody()['id']]);
    }


});

$app->put('/api1/update', function(Request $request, Response $response,array $args) {  
   
    
    $parsedBody = $request->getParsedBody();
    $id=$parsedBody['id'];
    $firstName= $parsedBody['firstName'];
    $lastName =  $parsedBody['lastName'];
    $age =  $parsedBody['age'];
    $gender =  $parsedBody['gender'];
    $fatherName= $parsedBody['fatherName'];
    $motherName= $parsedBody['motherName'];
    $email= $parsedBody['email'];
    $phoneNumber= $parsedBody['phoneNumber'];  
    $address1= $parsedBody['address1'];
    $address2= $parsedBody['address2'];
    $district= $parsedBody['district'];
    $state= $parsedBody['state'];
    $pinCode= $parsedBody['pinCode'];
    $country= $parsedBody['country'];
    

    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    $findCommand = $fm->newFindCommand('studentDetails');
    $findCommand->addFindCriterion('id', $id);
    $result=$findCommand->execute();
    if (FileMaker::isError($result)) {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code. ')';
        $newresponse = $response->withStatus(404);
        return $newresponse->withJson(['success'=>false, "message"=>$findError]);
        
    } 
    $findCommand=$result->getRecords()[0];
    $findCommand->setField('firstName', $firstName);
    $findCommand->setField('lastName', $lastName);
    $findCommand->setField('age', $age);
    $findCommand->setField('gender', $gender);
    $findCommand->setField('fatherName', $fatherName);
    $findCommand->setField('motherName', $motherName);
    $findCommand->setField('email', $email);
    $findCommand->setField('phoneNumber', $phoneNumber);
    $findCommand->setField('address1', $address1);
    $findCommand->setField('address2', $address2);
    $findCommand->setField('district', $district);
    $findCommand->setField('state', $state);
    $findCommand->setField('pinCode', $pinCode);
    $findCommand->setField('country', $country);
    $result = $findCommand->commit();
    $newresponse = $response->withStatus(200);
    return $newresponse->withJson(['success'=>true]);
});

$app->put('/api1/students/{id}',function(Request $request, Response $response){
    $id=$request->getAttribute('id');
    $parsedBody = $request->getParsedBody();
    $firstName= $parsedBody['firstName'];
    $lastName =  $parsedBody['lastName'];
    $class =  $parsedBody['class'];
    $dob =  $parsedBody['dob'];
    $fatherName= $parsedBody['fatherName'];
    $motherName= $parsedBody['motherName'];
    $email= $parsedBody['email'];
    $password=$parsedBody['password'];
    $phoneNumber= $parsedBody['phoneNumber'];  
    $altEmail= $parsedBody['altEmail'];    
    $altphoneNumber= $parsedBody['altphoneNumber'];
    $address1= $parsedBody['address1'];
    $address2= $parsedBody['address2'];
    $district= $parsedBody['district'];
    $state= $parsedBody['state'];
    $pinCode= $parsedBody['pinCode'];
    $country= $parsedBody['country'];
    $pAddress1= $parsedBody['pAddress1'];
    $pAddress2= $parsedBody['pAddress2'];
    $pDistrict= $parsedBody['pDistrict'];
    $pState= $parsedBody['pState'];
    $pPinCode= $parsedBody['pPinCode'];
    $pCountry= $parsedBody['pCountry'];
    //print_r($parsedBody);
    

    if($firstName!= NULL || $lastName !=  NULL || $class !=  NULL || $dob !=  NULL|| $fatherName!= NULL || $motherName!= NULL || $email!= NULL|| $password!=NULL|| $phoneNumber!= NULL || $altEmail!= NULL || $altphoneNumber!= NULL || $address1!= NULL || $address2!= NULL || $district!= NULL || $state!= NULL || $pinCode!= NULL || $country!= NULL || $pAddress1!= NULL || $pAddress2!= NULL || $pDistrict!= NULL || $pState!= NULL || $pPinCode!= NULL || $pCountry!= NULL )
    {

        $sql="UPDATE info set 
                            id=:id,
                            firstName=:firstName,
                            lastName=:lastName,
                            class=:class,
                            dob=:dob, 
                            fatherName=:fatherName,
                            motherName=:motherName,
                            email=:email,
                            password=:password, 
                            phoneNumber=:phoneNumber, 
                            altEmail=:altEmail, 
                            altphoneNumber=:altphoneNumber, 
                            address1=:address1, 
                            address2=:address2, 
                            district=:district, 
                            state=:state, 
                            pinCode=:pinCode, 
                            country=:country, 
                            pAddress1=:pAddress1, 
                            pAddress2=:pAddress2, 
                            pDistrict=:pDistrict, 
                            pState=:pState,
                            pPinCode=:pPinCode, 
                            pCountry=:pCountry 
                        where id=:id ";
        
            $db= new db();
            $db=$db->connect();
            $stmt =$db->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':class', $class);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':fatherName', $fatherName);
            $stmt->bindParam(':motherName', $motherName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':phoneNumber', $phoneNumber);
            $stmt->bindParam(':altEmail', $altEmail);    
            $stmt->bindParam(':altphoneNumber', $altphoneNumber);
            $stmt->bindParam(':address1', $address1);
            $stmt->bindParam(':address2', $address2);
            $stmt->bindParam(':district', $district);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':pinCode', $pinCode);
            $stmt->bindParam(':country', $country);
            $stmt->bindParam(':pAddress1', $pAddress1);
            $stmt->bindParam(':pAddress2', $pAddress2);
            $stmt->bindParam(':pDistrict', $pDistrict);
            $stmt->bindParam(':pState', $pState);
            $stmt->bindParam(':pPinCode', $pPinCode);
            $stmt->bindParam(':pCountry', $pCountry);
            $stmt->execute();
            return $response->withStatus(204,"updated");
    }
    else{
        $body = $response->getBody();
        $body->write("All fields are not present");
        return $response->withStatus(405)->withBody($body);
        
    }
    
});


$app->delete('/api1/students/{id}',function(Request $request, Response $response, array $args){
    
    
    // if (! isset($args[1])) {
    //     exit('Please provide a key to verify');
    // }
    // $jwt = $argv[1];
    // $secret="chinmaya";
    // $payload = JWT::decode($jwt,$secret,['HS256']);
    // //$signatureProvided = $tokenParts[2];
    // //$id = $request->getAttribute('id');
    
    // //$sql="DELETE from info where id = $id";
    // try{
        
    //     //$payload = JWT::decode($jwt, $secret, ['HS256']);
    //     $sql = "select * from info where email='$payload->eamil' AND password='$payload->password'";
    //     $db= new db();
    //     $db=$db->connect();
    //     $stmt =$db->query($sql);
    //     $student = $stmt->fetch(PDO::FETCH_OBJ);
    //     if($student != null){
    //         $id =$request->getAttribute('id');
    //         $sql = "delete from info where id=$id";

    //         $stmt = $db->query($sql);
    //         $student_record = $stmt->fetch(PDO::FETCH_OBJ);
    //         if ($student_record != null) {
    //             return $response->withJson($student_record);
    //         }else{
    //             $data_unfound = array('message' => 'Record Not Found');
    //             return $response->withJson($data_unfound, 404);
    //         }

    //     }

    // }catch(PDOException $e){
    //     $body = $response->getBody();
    //     $body->write("Id not found");
    //     return $response->withStatus(400)->withBody($body);

    // }





    
    $id = $request->getAttribute('id');
   echo($id);
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    $findCommand = $fm->newFindCommand('studentDetails');
    $findCommand->addFindCriterion('id',$id);
    $result=$findCommand->execute();
    if (FileMaker::isError($result)) {
        echo $result->getMessage();
        exit;
        if ($result->code == 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $user=$result->getRecords()[0];
        $user->delete();
    }
    
});

$app->post('/api1/login',function(Request $request, Response $response){

    $parsedBody = $request->getParsedBody();
    
    $email= $parsedBody['username'];
    

    $password =  $parsedBody['password'];
    
    
   
    $secret="chinmaya";

    // $db= new db();
    // $fm=$db->connect();
    //$jwt = new config\jwt();
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    //$jwt = new config\jwt();
    $vars = json_decode($request->getBody());
    
    if(array_key_exists('username', $vars) == false || $vars->username == null) {
        $newresponse = $response->withStatus(401);
        return $newresponse->withJson(['status'=>false, 'message'=>'Email is required']);
    }
    if(array_key_exists('password', $vars) == false || $vars->password == null) {
        $newresponse = $response->withStatus(401);
        return $newresponse->withJson(['status'=>false, 'message'=>'password is required']);
    }
    // $email = $vars->email;
    // $password = $vars->password;
    //echo($email);
    
  
    $findCommand = $fm->newFindCommand('studentDetails');
    $findCommand->addFindCriterion('phoneNumber',$email);
    $findCommand->addFindCriterion('password', $password);
    $findCommand->setLogicalOperator(FILEMAKER_FIND_AND);
    $result=$findCommand->execute();
    
    //print_r($result);
    
    if (FileMaker::isError($result)) {
        echo $result->getMessage();
        exit;
        if ($result->code = 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $ph=$result->getRecords()[0]->_impl->_fields['phoneNumber'][0];
        $id=$result->getRecords()[0]->_impl->_fields['id'][0];
        if(count($result->getRecords())==1){
            $token = JWT::encode( $ph,$secret);
        return $response->withJson(["status"=>true,"data"=>$id, "token"=>$token]);
        } else {
            $newresponse = $response->withStatus(401);
            return $newresponse->withJson(["status"=>false, "message"=>"credentials 1 dosent match each other"]);
        }
    }
});

$app->post('/api1/bidderlogin',function(Request $request, Response $response){

    $parsedBody = $request->getParsedBody();
    
    $secret="chinmaya";
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    //$jwt = new config\jwt();
    $vars = json_decode($request->getBody());
    
    if(array_key_exists('username', $vars) == false || $vars->username == null) {
        $newresponse = $response->withStatus(401);
        return $newresponse->withJson(['status'=>false, 'message'=>'Email is required']);
    }
    if(array_key_exists('password', $vars) == false || $vars->password == null) {
        $newresponse = $response->withStatus(401);
        return $newresponse->withJson(['status'=>false, 'message'=>'password is required']);
    }
    
    
    
    $findCommand = $fm->newFindCommand('bidderDetails');
    $findCommand->addFindCriterion('phoneNumber',$vars->username);
    $findCommand->addFindCriterion('password',$vars->password);
    
    $findCommand->setLogicalOperator(FILEMAKER_FIND_AND);
    
    // $findCommand->setLogicalOperator(FILEMAKER_FIND_AND);
    $result=$findCommand->execute();
    
    //print_r($result);
    
    if (FileMaker::isError($result)) {
        
        if ($result->code = 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["status"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $ph=$result->getRecords()[0]->_impl->_fields['phoneNumber'][0];
        $id=$result->getRecords()[0]->_impl->_fields['id'][0];
        if(count($result->getRecords())==1){
            $token = JWT::encode( $ph,$secret);
        return $response->withJson(["status"=>true,"data"=>$id, "token"=>$token]);
        } else {
            $newresponse = $response->withStatus(401);
            return $newresponse->withJson(["status"=>false, "message"=>"credentials 1 dosent match each other"]);
        }
    }
});
    
$app->post('/api1/leaderboard',function(Request $request, Response $response){

    $parsedBody = $request->getParsedBody();
    
    $secret="chinmaya";
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    $vars = json_decode($request->getBody());
    
  
    $findCommand = $fm->newFindCommand('studentDetails');
    $findCommand->addFindCriterion('age',$vars->age);
    $findCommand->addFindCriterion('gender',$vars->gender);
    
    $findCommand->setLogicalOperator(FILEMAKER_FIND_AND);
    $result=$findCommand->execute();
    
    //print_r($result);
    
    if (FileMaker::isError($result)) {
        echo $result->getMessage();
        exit;
        if ($result->code = 401) {
        $findError = 'There are no Records that match that request: '. ' (' .
        $result->code . ')';
        } else {
        $findError = 'Find Error: '. $result->getMessage(). ' (' . $result->code
        . ')';
        }
          $newresponse =  $response->withStatus(404);
          return $newresponse->withJson(["success"=>false,"message"=>"credentials dosent match each other"]);
    }
    else{
        $dataArray = array();
        $records = $result->getRecords();
        foreach($records as $record) {
                array_push($dataArray, array(
                    'firstName' =>  $record->getField('firstName'),
                    'lastName' =>  $record->getField('lastName'),
                    'points' =>  $record->getField('points')
                )); 
            
            
        }     
            return $response->withJson($dataArray, 200);
    }
        
    
});

