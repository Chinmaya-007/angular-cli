<?
$app->post('/filemaker/api/doctor/login', function(Request $request, Response $response, array $args)
{

    $email =$request->getParam('username');
    $pass =$request->getParam('password');
    
    $body = $response->getBody();




    try{
        $layout_name = 'studentdetails';

        $findcommand = $fm->newFindCommand($layout_name);
        $findcommand->addFindCriterion('phoneNumber', $email);
        $findcommand->addFindCriterion('Password', $pass_secure);
        $findcommand->setLogicalOperator(FILEMAKER_FIND_AND);
        $result = $findcommand->execute();


        if (FileMaker::isError($result)) {
            $data_unfound = array('message' => 'Record Not Found',  'status'=> '400');
            return $newResponse = $response->withJson($data_unfound,400);
        }       
 
        if($result){
            $payload = array(
                'iat' => time(),
                'iss' => 'slimproject',
                'exp' => time() + (60*30),
                'userName' => $pass
            );
            $jwt = new auth\jwt();
            $token = $jwt->encode($payload, $secret);
            $records = $result->getRecords();
            foreach($records as $record){
                $data = array(
                
                "Name"=> $record->getField('firstName'), 
                'Token' => $token);
            }
            return $newResponse = $response->withJson($data,200);
        }
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}}';
    }
});