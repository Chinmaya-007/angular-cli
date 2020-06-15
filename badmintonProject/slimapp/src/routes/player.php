<?php
use Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;
use Tuupola\Middleware\JwtAuthentication;
use Firebase\JWT\JWT;
use Firebase\Token\TokenException;
use Firebase\Token\TokenGenerator;




$app->add(new Tuupola\Middleware\JwtAuthentication([
    "path" => ["/api"],
    "ignore" => ["/api/login"],
    "secret" => "chinmaya"
]));



//show all student details

$app->get('/api/students',function(Request $request, Response $response){
    $sql="select * from playerdetails";
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
$app->get('/api/students/{id}',function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql="select * from playerdetails where id = $id";
    try{
        $db= new db();
        $db=$db->connect();
        $stmt =$db->query($sql);
        $student=$stmt->fetchAll(PDO::FETCH_OBJ);
        $db= null;
        if($student!=NULL)
        {
            return $response->withJson(["val"=>$student,"status"=>true]);

        }
        else{
            $body = $response->getBody();
            $body->write('No student found with this id');
            return $response->withStatus(404)->withBody($body);
        }
        

    }catch(PDOException $e){
        echo '{"error":{"text": '.$e->getMessage().'}';

    }

});


// add student in the database
$app->post('/api1/register/',function(Request $request, Response $response){
    $parsedBody = $request->getParsedBody();

    $id="0";
    $firstName= $parsedBody['firstName'];
    $lastName = $parsedBody['lastName'];
    $gender = $parsedBody['gender'];
    $age = $parsedBody['age'];
    $fatherName= $parsedBody['fatherName'];
    $motherName= $parsedBody['motherName'];
    $email= $parsedBody['email'];
    $password=$parsedBody['password'];
    $phoneNumber= $parsedBody['phoneNumber'];  
    $address1= $parsedBody['address1'];
    $address2= $parsedBody['address2'];
    $district= $parsedBody['district'];
    $pinCode= $parsedBody['pinCode'];
    
    

    $sql="INSERT INTO playerdetails VALUES 
    (:id,:firstName, :lastName, :gender, :age, :fatherName, :motherName, :email,:phoneNumber, :password, :address1, :address2, :district, :pinCode) ";
    try{
        $db= new db();
        $db=$db->connect();
        $stmt =$db->prepare($sql);

        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':firstName',$firstName);
        $stmt->bindParam(':lastName',$lastName);
        $stmt->bindParam(':gender',$gender);
        $stmt->bindParam(':age',$age);
        $stmt->bindParam(':fatherName',$fatherName);
        $stmt->bindParam(':motherName', $motherName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':address1', $address1);
        $stmt->bindParam(':address2', $address2);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':pinCode', $pinCode);
        $stmt->execute();
        //$student=$stmt->fetchAll(PDO::FETCH_OBJ);
        
        return $response->withJson(["status"=>true]);


    }catch(PDOException $e){
        echo '{"error":{"text": '.$e->getMessage().'}';
        //$app->response->setStatus(404);

    }

});


$app->put('/api/students/{id}',function(Request $request, Response $response){
    $id=$request->getAttribute('id');
    $parsedBody = $request->getParsedBody();

    $firstName= $parsedBody['firstName'];
    $lastName =  $parsedBody['lastName'];
    $class =  $parsedBody['class'];
    $age =  $parsedBody['age'];
    $fatherName= $parsedBody['fatherName'];
    $motherName= $parsedBody['motherName'];
    $email= $parsedBody['email'];
    $password=$parsedBody['password'];
    $phoneNumber= $parsedBody['phoneNumber'];  
    $altEmail= $parsedBody['altEmail'];    
    $altPhoneNumber= $parsedBody['altPhoneNumber'];
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
    

    $sql="UPDATE playerdetails set 
                        id=:id,
                        firstName=:firstName,
                        lastName=:lastName,
                        class=:class,
                        age=:age, 
                        fatherName=:fatherName,
                        motherName=:motherName,
                        email=:email,
                        password=:password, 
                        phoneNumber=:phoneNumber, 
                        altEmail=:altEmail, 
                        altPhoneNumber=:altPhoneNumber, 
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
                    where id=$id ";
    try{
        $db= new db();
        $db=$db->connect();
        $stmt =$db->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':class', $class);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':fatherName', $fatherName);
        $stmt->bindParam(':motherName', $motherName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':altEmail', $altEmail);    
        $stmt->bindParam(':altPhoneNumber', $altPhoneNumber);
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
            echo '{"notice":{"text": "Customer updated"}';
        


    }catch(PDOException $e){
        echo '{"error":{"text": '.$e->getMessage().'}';
        $app->response->setStatus(404);

    }

});


$app->delete('/api/students/{id}',function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    $sql="DELETE from playerdetails where id = $id";
    try{
        $db= new db();
        $db=$db->connect();
        $stmt =$db->prepare($sql);
        $stmt->execute();
        $db= null;

        echo '{"notice":{"text": "student deleted"}';
        


    }catch(PDOException $e){
        echo '{"error":{"text": '.$e->getMessage().'}';

    }

});

$app->post('/api/login',function(Request $request, Response $response){

    $parsedBody = $request->getParsedBody();
    
    $email= $parsedBody['email'];
    $password =  $parsedBody['password'];

    
    
    $sql="SELECT * from playerdetails where email ='$email' AND password='$password'";
    try{
        $db= new db();
        $db=$db->connect();
        $stmt =$db->query($sql);
        $student=$stmt->fetch(PDO::FETCH_OBJ);
        $secret="chinmaya";

        $db= null;
        if($student!=NULL){
            $issuedAt = time();
            $expirationTime = $issuedAt + 60*60;  // jwt valid for 60 seconds from the issued time
            $payload = array(
            'userid' => $email,
            'iat' => $issuedAt,
            'exp' => $expirationTime
            );
            
            $alg = 'HS256';
            $token = JWT::encode($payload, $secret, $alg);
            return $response->withJson(["val"=>$student,"status"=>true, "token"=>$token]);

        }
        else{
            return $response->withJson(["status"=>false]);
        }
        


    }catch(PDOException $e){
        echo '{"error":{"text": '.$e->getMessage().'}';

    }
 
    
});
?>