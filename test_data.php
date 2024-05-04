<?php

$shopId = "33577476";
$secretKey = "d75bef58d21d89d5648d7864b91e4257578a3efe36d544005918e03e4843887c";
$subscriptionKey = "1c524beb4979460d84548faa12182624";

// Parameters from the response
$paywallParams = [
    "uid" => "c32dc84f-070f-4ddb-8a3d-33756c93135c",
    "trackingId" => "10010000A100027",
    "amount" => 10000,
    "currency" => "MXN",
    "description" => "Payment Test",
    "createdAt" => "2023-01-13T13:35:41.4520468Z",
    "returnUrl" => "https://payment-form.payretailers.com/return",
    "cancelUrl" => "https://payment-form.payretailers.com/cancel",
    "notificationUrl" => "https://payment-form.payretailers.com/notification",
    "shopName" => null,
    "language" => "ES",
    "totalAmount" => 100,
    "expirationDate" => null,
    "transactionID" => null,
    "currencySymbol" => null,
    "apiPaymentShopDomainUrl" => "https://api.gateway.payretailers.com/",
    "customer" => [
        "firstName" => "John",
        "lastName" => "Doe",
        "personalId" => null,
        "email" => "test@payretailers.com",
        "country" => "MX",
        "city" => "Ciudad de México",
        "zip" => "06010",
        "address" => "República de Perú 177",
        "phone" => "5299999999999",
        "deviceId" => null,
        "ip" => "150.125.18.159",
        "accountType" => null
    ],
    "form" => [
        "action" => "https://pr1az1pro1paywall1web.z13.web.core.windows.net/?p=c32dc84f-070f-4ddb-8a3d-33756c93135c",
        "method" => "GET"
    ],
    "whitelabel" => null,
    "isLocalCurrency" => false,
    "isConvertedToLocalCurrency" => false,
    "convertedAmountLocalCurrency" => null,
    "localCurrencySymbol" => null,
    "localCurrency" => null,
    "testMode" => true,
    "showModal" => false
];

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.payretailers.com/payments/v2/paywalls",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($paywallParams),
  CURLOPT_HTTPHEADER => [
    "Ocp-Apim-Subscription-Key: $subscriptionKey",
    "Authorization: Basic " . base64_encode("$shopId:$secretKey"),
    "Accept: application/json",
    "Content-Type: application/json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
?>
