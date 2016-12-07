<?php

namespace Tests\Functional;

class UberAPITest extends BaseTestCase
{
    public function testGetAccessToken() {
        
        $var = '{
                "args": {
                  "clientId": "0r1-bGzzPkiPk_Kvl-s6GV1i3pjMAnOe",
                  "clientSecret": "JOg7iWWJiUoRnCvl_RmXyyHV427nUavnrS9jLpbP"
                }
        }';
        $post_data = json_decode($var, true);
        
        $response = $this->runApp('POST', '/api/UberDelivery/getAccessToken', $post_data);
        
        $token = json_decode($response->getBody())->contextWrites->to->access_token;

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
        
        return $token;
        
    }
    
    /**
     * @depends testGetAccessToken
     */
    public function testRequestDelivery($token) {
        
        $var = '{
                "args": {
                  "accessToken": "'.$token.'",
                  "itemsTitle": "Test title items",
                  "itemsQuantity": "1",
                  "itemsPrice": "100",
                  "itemsCurrencyCode": "USD",
                  "pickupLocationAddress": "143 Ludlow St",
                  "pickupLocationCity": "New York",
                  "pickupLocationState": "NY",
                  "pickupLocationPostalCode": "10002",
                  "pickupLocationCountry": "USA",
                  "pickupContactFirstName": "Sergey",
                  "pickupContactLastName": "Osipchuk",
                  "pickupContactEmail": "triongroup@gmail.com",
                  "pickupContactPhoneNumber": "+381234567890",
                  "dropoffLocationAddress": "9 Doyers St #1",
                  "dropoffLocationAddress2": "9 Doyers St #1",
                  "dropoffLocationCity": "New York",
                  "dropoffLocationState": "NY",
                  "dropoffLocationPostalCode": "10013",
                  "dropoffLocationCountry": "USA",
                  "dropoffContactFirstName": "Test",
                  "dropoffContactLastName": "Testov",
                  "dropoffContactEmail": "test@site.com",
                  "dropoffContactPhoneNumber": "+380051234567",
                  "dropoffContactPhoneSmsEnabled": "false",
                  "includesAlcohol": "false",
                  "sandbox": "1"
                }
        }';
        $post_data = json_decode($var, true);
        
        $response = $this->runApp('POST', '/api/UberDelivery/requestDelivery', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
        
    }
    
    /**
     * @depends testGetAccessToken
     */
    public function testGetDelivery($token) {
        
        $var = '{
                        "args": {
                          "accessToken": "'.$token.'",
                          "deliveryId": "5cc0f005-974e-495d-9693-8b4880e1967e",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);
        
        $response = $this->runApp('POST', '/api/UberDelivery/getDelivery', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
        $this->assertContains('No delivery found', json_decode($response->getBody())->contextWrites->to->message);
        
    }
    
    /**
     * @depends testGetAccessToken
     */
    public function testCancelDelivery($token) {
        
        $var = '{
                        "args": {
                          "accessToken": "'.$token.'",
                          "deliveryId": "5cc0f005-974e-495d-9693-8b4880e1967e",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);
        
        $response = $this->runApp('POST', '/api/UberDelivery/cancelDelivery', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('error', json_decode($response->getBody())->callback);
        $this->assertContains('No delivery found', json_decode($response->getBody())->contextWrites->to->message);
        
    }
    
    /**
     * @depends testGetAccessToken
     */
    public function testGetDeliveries($token) {
        
        $var = '{
                        "args": {
                          "accessToken": "'.$token.'",
                          "offset": "0",
                          "limit": "50",
                          "status": "active",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);
        
        $response = $this->runApp('POST', '/api/UberDelivery/getDeliveries', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
        
    }
    
    /**
     * @depends testGetAccessToken
     */
    public function testGetQuote($token) {
        
        $var = '{
                        "args": {
                          "accessToken": "'.$token.'",
                          "pickupLocationAddress": "143 Ludlow St",
                          "pickupLocationCity": "New York",
                          "pickupLocationState": "NY",
                          "pickupLocationPostalCode": "10002",
                          "pickupLocationCountry": "USA",
                          "dropoffLocationAddress": "9 Doyers St #1",
                          "dropoffLocationAddress2": "9 Doyers St #1",
                          "dropoffLocationCity": "New York",
                          "dropoffLocationState": "NY",
                          "dropoffLocationPostalCode": "10013",
                          "dropoffLocationCountry": "USA",
                          "sandbox": "1"
                        }
                }';
        $post_data = json_decode($var, true);
        
        $response = $this->runApp('POST', '/api/UberDelivery/getQuote', $post_data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertEquals('success', json_decode($response->getBody())->callback);
        
    }

}