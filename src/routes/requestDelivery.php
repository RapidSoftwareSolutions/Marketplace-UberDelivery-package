<?php

$app->post('/api/UberDelivery/requestDelivery', function ($request, $response, $args) {
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
    
    $reqFields = ['itemsTitle', 
                'itemsQuantity', 
                'itemsPrice', 
                'itemsCurrencyCode', 
                'pickupLocationAddress', 
                'pickupLocationCity', 
                'pickupLocationState', 
                'pickupLocationPostalCode', 
                'pickupLocationCountry', 
                'pickupContactFirstName', 
                'pickupContactLastName', 
                'pickupContactEmail', 
                'pickupContactPhoneNumber', 
                'dropoffLocationAddress', 
                'dropoffLocationAddress2', 
                'dropoffLocationCity', 
                'dropoffLocationState', 
                'dropoffLocationPostalCode', 
                'dropoffLocationCountry', 
                'dropoffContactFirstName', 
                'dropoffContactLastName', 
                'dropoffContactEmail', 
                'dropoffContactPhoneNumber', 
                'dropoffContactPhoneSmsEnabled'];
    $optFields = ['quoteId', 
                'orderReferenceId', 
                'itemsWidth', 
                'itemsHeight', 
                'itemsLength', 
                'itemsWeight', 
                'itemsIsFragile', 
                'pickupLocationAddress2', 
                'pickupLocationLatitude', 
                'pickupLocationLongitude', 
                'pickupContactCompanyName', 
                'pickupContactPhoneSmsEnabled', 
                'pickupSpecialInstructions', 
                'dropoffLocationLatitude', 
                'dropoffLocationLongitude', 
                'dropoffContactSendEmailNotifications', 
                'dropoffContactSendSmsNotifications', 
                'dropoffSpecialInstructions', 
                'dropoffSignatureRequired', 
                'includesAlcohol'];
    
    $error = [];
    if(empty($post_data['args']['accessToken'])) {
        $error[] = 'accessToken';
    }
    foreach($reqFields as $field) {
        if(strlen($post_data['args'][$field]) == 0) {
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
    
    $body['items'][0]['title'] = $post_data['args']['itemsTitle'];
    $body['items'][0]['quantity'] = (int) $post_data['args']['itemsQuantity'];
    $body['items'][0]['price'] = (float) $post_data['args']['itemsPrice'];
    $body['items'][0]['currency_code'] = $post_data['args']['itemsCurrencyCode'];
    $body['pickup']['location']['address'] = $post_data['args']['pickupLocationAddress'];
    $body['pickup']['location']['city'] = $post_data['args']['pickupLocationCity'];
    $body['pickup']['location']['state'] = $post_data['args']['pickupLocationState'];
    $body['pickup']['location']['postal_code'] = $post_data['args']['pickupLocationPostalCode'];
    $body['pickup']['location']['country'] = $post_data['args']['pickupLocationCountry'];
    $body['pickup']['contact']['first_name'] = $post_data['args']['pickupContactFirstName'];
    $body['pickup']['contact']['last_name'] = $post_data['args']['pickupContactLastName'];
    $body['pickup']['contact']['email'] = $post_data['args']['pickupContactEmail'];
    $body['pickup']['contact']['phone']['number'] = $post_data['args']['pickupContactPhoneNumber'];
    $body['dropoff']['location']['address'] = $post_data['args']['dropoffLocationAddress'];
    $body['dropoff']['location']['address_2'] = $post_data['args']['dropoffLocationAddress2'];
    $body['dropoff']['location']['city'] = $post_data['args']['dropoffLocationCity'];
    $body['dropoff']['location']['state'] = $post_data['args']['dropoffLocationState'];
    $body['dropoff']['location']['postal_code'] = $post_data['args']['dropoffLocationPostalCode'];
    $body['dropoff']['location']['country'] = $post_data['args']['dropoffLocationCountry'];
    $body['dropoff']['contact']['first_name'] = $post_data['args']['dropoffContactFirstName'];
    $body['dropoff']['contact']['last_name'] = $post_data['args']['dropoffContactLastName'];
    $body['dropoff']['contact']['email'] = $post_data['args']['dropoffContactEmail'];
    $body['dropoff']['contact']['phone']['number'] = $post_data['args']['dropoffContactPhoneNumber'];
    $body['dropoff']['contact']['phone']['sms_enabled'] = $post_data['args']['dropoffContactPhoneSmsEnabled'];
    
    
    if(!empty($post_data['args']['quoteId'])) {
        $body['quote_id'] = $post_data['args']['quoteId'];
    }
    if(!empty($post_data['args']['orderReferenceId'])) {
        $body['order_reference_id'] = $post_data['args']['orderReferenceId'];
    }
    if(!empty($post_data['args']['itemsWidth'])) {
        $body['items'][0]['width'] = $post_data['args']['itemsWidth'];
    }
    if(!empty($post_data['args']['itemsHeight'])) {
        $body['items'][0]['height'] = $post_data['args']['itemsHeight'];
    }
    if(!empty($post_data['args']['itemsLength'])) {
        $body['items'][0]['length'] = $post_data['args']['itemsLength'];
    }
    if(!empty($post_data['args']['itemsWeight'])) {
        $body['items'][0]['weight'] = $post_data['args']['itemsWeight'];
    }
    if(!empty($post_data['args']['itemsIsFragile'])) {
        $body['items'][0]['is_fragile'] = $post_data['args']['itemsIsFragile'];
    }
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


    if(!empty($post_data['args']['pickupContactCompanyName'])) {
        $body['pickup']['contact']['company_name'] = $post_data['args']['pickupContactCompanyName'];
    }
    if(!empty($post_data['args']['pickupContactPhoneSmsEnabled'])) {
        $body['pickup']['contact']['phone']['sms_enabled'] = $post_data['args']['pickupContactPhoneSmsEnabled'];
    }
    if(!empty($post_data['args']['pickupSpecialInstructions'])) {
        $body['pickup']['special_instructions'] = $post_data['args']['pickupSpecialInstructions'];
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
    if(!empty($post_data['args']['dropoffContactSendEmailNotifications'])) {
        $body['dropoff']['contact']['send_email_notifications'] = $post_data['args']['dropoffContactSendEmailNotifications'];
    }
    if(!empty($post_data['args']['dropoffContactSendSmsNotifications'])) {
        $body['dropoff']['contact']['send_sms_notifications'] = $post_data['args']['dropoffContactSendSmsNotifications'];
    }
    if(!empty($post_data['args']['dropoffSpecialInstructions'])) {
        $body['dropoff']['special_instructions'] = $post_data['args']['dropoffSpecialInstructions'];
    }
    if(!empty($post_data['args']['dropoffSignatureRequired'])) {
        $body['dropoff']['signature_required'] = $post_data['args']['dropoffSignatureRequired'];
    }
    if(!empty($post_data['args']['includesAlcohol'])) {
        $body['includes_alcohol'] = $post_data['args']['includesAlcohol'];
    }    


    if(isset($post_data['args']['sandbox']) && $post_data['args']['sandbox'] == 1) {
        $query_str = 'https://sandbox-api.uber.com/v1/deliveries';
    } else {
        $query_str = 'https://api.uber.com/v1/deliveries';
    }
    
    $client = $this->httpClient;

    try {

        $resp = $client->post( $query_str, 
            [
                'headers' => $headers,
                'body' => json_encode($body)
            ]);
        $responseBody = $resp->getBody()->getContents();
        
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

