<?php

function respond($response = false)
{
    if ($response == false) {
        $response = $GLOBALS['response'];
    }
    
    die(json_encode($response));
}

header('Content-type:application/json');

$response = [
    'success' => false,
    'data' => []
];

if (empty($data = $_POST['data']) || empty($data['purpose'])) {
    $response['data'] = 'No purpose defined';
    respond();
}

switch ($data['purpose']) {
    case 'bbcode-preview':
        if (!empty($data['message'])) {
            $response['success'] = true;
            
            $response['data'] = format(preFormat($data['message']));
        }
        
        respond();
        break;
    
    case 'verify-new-topic':
        $response['data'] = Topics::CreateError($data);
        $response['success'] = true;
        
        respond();
        break;
    
    case 'verify-registration':
        $response['data'] = Users::CreateError($data);
        $response['success'] = true;
        
        respond();
        break;
}

respond();
