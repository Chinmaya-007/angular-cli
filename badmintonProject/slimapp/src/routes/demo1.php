<?
$app->get('/api/brands', function($request, $response, $args) {

$fm = new FileMaker('reliaSale', HOST, $this->get('jwt')->username, $this->get('jwt')->password);
$findCommand = $fm->newFindCommand('jq_BRANDS_List');
$findCommand->addFindCriterion('_isActive', 1);
$result = $findCommand->execute();
if (FileMaker::isError($result)) {
    return $response->withJson(array(
        "code" => $result->code,
        "error" => $result->getMessage()
    ), 405);
}

// an empty array to hold arrays of records
$dataArray = array();

$records = $result->getRecords();

foreach($records as $record) {
    // push another array to the main array with all the field names and values
    array_push($dataArray, array(
        'id' => (int) $record->getField('___kpBrandID'),
        'baronCode' => $record->getField('BaronCode'),
        'brandName' => $record->getField('BrandName'),
        'isActive' => (int) $record->getField('_isActive')
    ));
}


return $response->withJson($dataArray, 200);
});