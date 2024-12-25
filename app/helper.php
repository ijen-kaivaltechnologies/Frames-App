<?php 

function showResponse($result, $message)
{
    
    $response = [
        'success' => true,
        'data'    => $result,    
        'message' => $message,
    ];
  
    return response()->json($response, 200);

}

function sendResponse($result, $message)
{
    
    // $transformedResult = [
    //     'id' => $result['id'],
    //     'priority' => $result['priority'],
    //     'categoryName' => isset($result['catagory_name']),
    //     'categoryImageUrl' => isset($result['catagory_url']),
    // ];  

    $response = [
        'success' => true,
        'data'    => $result,
        'message' => $message,
    ];
  
    return response()->json($response, 200);

}

function sendError($error, $errorMessages = [], $code = 404)
{
    $response = [
        'success' => false,
        'message' => $error,
    ];
  
    if(!empty($errorMessages)){
        $response['data'] = $errorMessages;
    }
  
    return response()->json($response, $code);
}
