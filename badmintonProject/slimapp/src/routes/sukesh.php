<?
$app->get('/api/users/{id}/matchingjobs/{jobid}', function(Request $request, Response $response, array $args)
{ 
    $jwt = new config\jwt();
            
            if( $request->hasHeader("Authorization") == false) {
                $newresponse = $response->withStatus(400);
                return $newresponse->withJson(["message"=>"required jwt token is not recieved"]);
            }
            $header = $request->getHeader("Authorization");
            $vars = $header[0];
            $token = json_decode($jwt->jwttokendecryption($vars));
            if( $token->verification == "failed") {
                $newresponse = $response->withStatus(401);
                return $newresponse->withJson(["message"=>"you are not authorized"]);
            }
    $Id = $args['id'];
    $jobid = $args['jobid'];
    $dbobj = new dbconnection\dbconnection();
    $fm = $dbobj->connect();
    $userdata = array( 
        "__kf_JobId"=>$jobid,
        "__kf_UserId"=>$Id
    );
    $stmt = $fm->createRecord('Application', $userdata);
    $apply = $stmt->commit();
    if (FileMaker::isError($apply)) {
        $findError = 'Find Error: '. $apply->getMessage(). ' (' . $apply->getCode(). ')';
        $newresponse = $response->withStatus(404);
        return $newresponse->withJson(['success'=>false, "message"=>$findError]);        
    }
    else{
        $newresponse = $response->withStatus(200);
        return $newresponse->withJson(['success'=>true, "message"=>"Applied successfully"]);
    }
});