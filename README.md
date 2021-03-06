[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/UberDelivery/functions?utm_source=RapidAPIGitHub_UberDeliveryFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)

# UberDelivery Package
Request an Uber or Uber delivery all from within your app.
* Domain: [https://uber.com](https://uber.com)
* Credentials: clientId, clientSecret

## How to get credentials: 
0. Go to the [Uber developers area](https://developer.uber.com/) 
1. Sign in or Log in
2. Register an UberRush app.

## Custom datatypes:
 |Datatype|Description|Example
 |--------|-----------|----------
 |Datepicker|String which includes date and time|```2016-05-28 00:00:00```
 |Map|String which includes latitude and longitude coma separated|```50.37, 26.56```
 |List|Simple array|```["123", "sample"]```
 |Select|String with predefined values|```sample```
 |Array|Array of objects|```[{"Second name":"123","Age":"12","Photo":"sdf","Draft":"sdfsdf"},{"name":"adi","Second name":"bla","Age":"4","Photo":"asfserwe","Draft":"sdfsdf"}] ```



## UberDelivery.getAccessToken
Generate Access Token.

| Field        | Type       | Description
|--------------|------------|----------
| clientId     | credentials| The Client ID obtained from Uber.
| clientSecret | credentials| The Client Secret obtained from Uber.

## UberDelivery.requestDelivery
The Delivery endpoint allows a delivery to be requested given the delivery information and quote ID.

| Field                               | Type  | Description
|-------------------------------------|-------|----------
| accessToken                         | String| The valid access token.
| itemsTitle                          | String| The title of the item. Limited to 128 characters.
| itemsQuantity                       | Number| The number of this item.
| itemsPrice                          | String| The price of the item.
| itemsCurrencyCode                   | String| The currency code of the item price. The currency code follows the ISO 4217 standard.
| pickupLocationAddress               | String| The top address line of the delivery pickup location.
| pickupLocationCity                  | String| The city of the delivery pickup location.
| pickupLocationState                 | String| The state of the delivery pickup location such as "CA".
| pickupLocationPostalCode            | String| The postal code of the delivery pickup location.
| pickupLocationCountry               | String| The country of the pickup location such as "US".
| pickupContactFirstName              | String| The first name of the contact. This field is optional if pickup.contact.company_name is provided. Limited to 128 characters.
| pickupContactLastName               | String| The last name of the contact. This field is optional if pickup.contact.company_name is provided. Limited to 128 characters.
| pickupContactEmail                  | String| The email of the contact.
| pickupContactPhoneNumber            | String| The phone number of the contact. Phone number should start with + followed by the country code and then the local number (e.g., +18005555555).
| dropoffLocationAddress              | String| The top address line of the delivery drop-off location.
| dropoffLocationAddress2             | String| The second address line of the delivery drop-off location such as the apartment number. Limited to 128 characters.
| dropoffLocationCity                 | String| The city of the delivery drop-off location.
| dropoffLocationState                | String| The state of the delivery drop-off location such as "CA".
| dropoffLocationPostalCode           | String| The postal code of the delivery drop-off location.
| dropoffLocationCountry              | String| The country of the delivery pickup location such as "US".
| dropoffContactFirstName             | String| The first name of the contact. Limited to 128 characters.
| dropoffContactLastName              | String| The last name of the contact. Limited to 128 characters.
| dropoffContactEmail                 | String| The email of the contact.
| dropoffContactPhoneNumber           | String| The phone number of the contact.
| dropoffContactPhoneSmsEnabled       | String| If the phone has SMS capabilities. 1 or 0
| quoteId                             | String| Optional: The ID of the quoted price of the delivery. This field is optional. If missing, the fee for the delivery will be determined at the time of request.
| orderReferenceId                    | String| Optional: The merchant-supplied order reference identifier. This field is optional. Limited to 256 characters.
| itemsWidth                          | String| Optional: The width of the item in inches.
| itemsHeight                         | String| Optional: The height of the item in inches.
| itemsLength                         | String| Optional: The length of the item in inches.
| itemsWeight                         | String| Optional: The weight of the item in pounds.
| itemsIsFragile                      | String| Optional: If the item is fragile. 1 if true
| pickupLocationAddress2              | String| Optional: The second address line of the delivery pickup location such as the apartment number. Limited to 128 characters.
| pickupLocation              | Map| Optional: Latitude and longitude of the pickup location. If UberRUSH cannot geocode the given address, the latitude and longitude coordinates will be used if provided.
| pickupContactCompanyName            | String| Optional: The company name of the contact. Limited to 128 characters.
| pickupContactPhoneSmsEnabled        | String| Optional: If the phone has SMS capabilities. 1 if true
| pickupSpecialInstructions           | String| Optional: Special instructions for the pickup. Limited to 256 characters.
| dropoffLocation             | Map| Optional: Latitude and longitude of the dropoff location. If UberRUSH cannot geocode the given address, the latitude and longitude coordinates will be used if provided.
| dropoffContactSendEmailNotifications| String| Optional: If Uber should send email delivery notifications. 1 if true Default to true.
| dropoffContactSendSmsNotifications  | String| Optional: If Uber should send SMS delivery notifications. 1 if true Default to true.
| dropoffSpecialInstructions          | String| Optional: Special instructions for the drop-off. Limited to 256 characters.
| dropoffSignatureRequired            | String| Optional: If signature is required for drop-off. 1 if true Default to false.
| includesAlcohol                     | String| Optional: Indicates if the delivery includes alcohol. 1 if true This feature is only available to whitelisted businesses.
| sandbox                          | String| Optional: UberAPI Sandbox: 1 to select sandbox



## UberDelivery.getDelivery
Get the real time status of an ongoing delivery that was created using the Delivery endpoint.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The valid access token.
| deliveryId | String| Unique identifier representing a Delivery.
| sandbox                          | String| Optional: UberAPI Sandbox: 1 to select sandbox


## UberDelivery.cancelDelivery
Cancels an existing delivery.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The valid access token.
| deliveryId | String| Unique identifier representing a Delivery.
| sandbox                          | String| Optional: UberAPI Sandbox: 1 to select sandbox


## UberDelivery.getDeliveries
Get a list of all deliveries, ordered chronologically by time of creation.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| The valid access token.
| offset     | Number| Offset the list of returned results by this amount.
| limit      | Number| Number of items to retrieve. Maximum is 50.
| status     | Select| A status value to filter for. List of status strings can be found https://developer.uber.com/docs/rush/statuses. Additionally supports a value of active that will return all ongoing deliveries. A delivery is considered active if the status field value is either en_route_to_pickup, at_pickup, en_route_to_dropoff or at_dropoff.
| sandbox                          | String| Optional: UberAPI Sandbox: 1 to select sandbox


## UberDelivery.getQuote
Generate a delivery quote, given a pickup and dropoff location. On-demand and scheduled delivery quotes will be returned.

| Field                    | Type  | Description
|--------------------------|-------|----------
| accessToken              | String| The valid access token.
| pickupLocationAddress    | String| The top address line of the delivery pickup location.
| pickupLocationCity       | String| The city of the delivery pickup location.
| pickupLocationState      | String| The state of the delivery pickup location such as "CA".
| pickupLocationPostalCode | String| The postal qcode of the delivery pickup location.
| pickupLocationCountry    | String| The country of the pickup location such as "US".
| dropoffLocationAddress   | String| The top address line of the delivery drop-off location.
| dropoffLocationAddress2  | String| The second address line of the delivery drop-off location such as the apartment number. Limited to 128 characters.
| dropoffLocationCity      | String| The city of the delivery drop-off location.
| dropoffLocationState     | String| The state of the delivery drop-off location such as "CA".
| dropoffLocationPostalCode| String| The postal code of the delivery drop-off location.
| dropoffLocationCountry   | String| The country of the delivery pickup location such as "US".
| pickupLocationAddress2   | String| Optional: The second address line of the delivery pickup location such as the apartment number. Limited to 128 characters.
| pickupLocation   | Map| Optional: Latitude ang longitude of the pickup location. If UberRUSH cannot geocode the given address, the latitude and longitude coordinates will be used if provided.
| dropoffLocation  | Map| Optional: Latitude and longitude of the dropoff location. If UberRUSH cannot geocode the given address, the latitude and longitude coordinates will be used if provided.
| sandbox                          | String| Optional: UberAPI Sandbox: 1 to select sandbox
