<?php

$app->post('/api/UberDelivery/getQuote', function ($request, $response, $args) {
    $settings =  $this->settings;
    
    $data = $request->getBody();

    if($data=='') {
        $post_data = $request->getParsedBody();
    } else {
        $toJson = $this->toJson;
        $data = $toJson->normalizeJson($data); 
        $data = str_replace('\"', '"', $data);
        $post_data = json_decode($data, true);
    }
    
    if(json_last_error() != 0) {
        $error[] = json_last_error_msg() . '. Incorrect input JSON. Please, check fields with JSON input.';
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'JSON_VALIDATION';
        $result['contextWrites']['to']['status_msg'] = implode(',', $error);
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }
    
    $reqFields = ['pickupLocationAddress',
                'pickupLocationCity', 
                'pickupLocationState', 
                'pickupLocationPostalCode', 
                'pickupLocationCountry', 
                'dropoffLocationAddress', 
                'dropoffLocationAddress2', 
                'dropoffLocationCity', 
                'dropoffLocationState', 
                'dropoffLocationPostalCode', 
                'dropoffLocationCountry'];
    
    $error = [];
    if(empty($post_data['args']['accessToken'])) {
        $error[] = 'accessToken';
    }
    foreach($reqFields as $field) {
        if(empty($post_data['args'][$field])) {
            $error[] = $field;
        }
    }
    
    if(!empty($error)) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = "REQUIRED_FIELDS";
        $result['contextWrites']['to']['status_msg'] = "Please, check and fill in required fields.";
        $result['contextWrites']['to']['fields'] = $error;
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    }
    
    $headers['Authorization'] = "Bearer " . $post_data['args']['accessToken'];
    $headers['Content-Type'] = 'application/json';
    
    $body['pickup']['location']['address'] = $post_data['args']['pickupLocationAddress'];
    $body['pickup']['location']['city'] = $post_data['args']['pickupLocationCity'];
    $body['pickup']['location']['state'] = $post_data['args']['pickupLocationState'];
    $body['pickup']['location']['postal_code'] = $post_data['args']['pickupLocationPostalCode'];
    $body['pickup']['location']['country'] = $post_data['args']['pickupLocationCountry'];
    $body['dropoff']['location']['address'] = $post_data['args']['dropoffLocationAddress'];
    $body['dropoff']['location']['address_2'] = $post_data['args']['dropoffLocationAddress2'];
    $body['dropoff']['location']['city'] = $post_data['args']['dropoffLocationCity'];
    $body['dropoff']['location']['state'] = $post_data['args']['dropoffLocationState'];
    $body['dropoff']['location']['postal_code'] = $post_data['args']['dropoffLocationPostalCode'];
    $body['dropoff']['location']['country'] = $post_data['args']['dropoffLocationCountry'];
 
    
    if(!empty($post_data['args']['pickupLocationAddress2'])) {
        $body['pickup']['location']['address_2'] = $post_data['args']['pickupLocationAddress2'];
    }

    if(!empty($post_data['args']['pickupLocation'])) {
        $body['pickup']['location']['latitude'] = implode(",",$post_data['args']['pickupLocation'])[0];
        $body['pickup']['location']['longitude'] = implode(",",$post_data['args']['pickupLocation'])[1];
    }

    if(!empty($post_data['args']['pickupLocationLatitude'])) {
        $body['pickup']['location']['latitude'] = $post_data['args']['pickupLocationLatitude'];
    }
    if(!empty($post_data['args']['pickupLocationLongitude'])) {
        $body['pickup']['location']['longitude'] = $post_data['args']['pickupLocationLongitude'];
    }


    if(!empty($post_data['args']['dropoffLocation'])) {
        $body['dropoff']['location']['latitude'] = implode(",",$post_data['args']['dropoffLocation'])[0];
        $body['dropoff']['location']['longitude'] = implode(",",$post_data['args']['dropoffLocation'])[1];
    }

    if(!empty($post_data['args']['dropoffLocationLatitude'])) {
        $body['dropoff']['location']['latitude'] = $post_data['args']['dropoffLocationLatitude'];
    }
    if(!empty($post_data['args']['dropoffLocationLongitude'])) {
        $body['dropoff']['location']['longitude'] = $post_data['args']['dropoffLocationLongitude'];
    }  

    if(isset($post_data['args']['sandbox']) && $post_data['args']['sandbox'] == 1) {
        $query_str = 'https://sandbox-api.uber.com/v1/deliveries/quote';
    } else {
        $query_str = 'https://api.uber.com/v1/deliveries/quote';
    }
    
    $client = $this->httpClient;

    try {

        $resp = $client->post( $query_str, 
            [
                'headers' => $headers,
                'body' => json_encode($body)
            ]);
        $responseBody = $resp->getBody()->getContents();
        $code = $resp->getStatusCode();
        $res = json_decode($responseBody);
        
        if($resp->getStatusCode() == '201') {
            $result['callback'] = 'success';
            $result['contextWrites']['to'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody();
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = json_decode($responseBody);

    } catch (GuzzleHttp\Exception\ServerException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = json_decode($responseBody);

    } catch (GuzzleHttp\Exception\BadResponseException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = json_decode($responseBody);

    } catch (GuzzleHttp\Exception\ConnectException $exception) {

        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'INTERNAL_PACKAGE_ERROR';
        $result['contextWrites']['to']['status_msg'] = 'Something went wrong inside the package.';

    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
});

