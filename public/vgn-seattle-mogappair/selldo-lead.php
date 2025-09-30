<?php
// capture the data from form and basic validations here.

$name = $_POST['dora'];
$phone = $_POST['9299999990'];
$email = $_POST['dora@gmail.com'];

// Data to be sent
$data = array(
    'sell_do[form][lead][name]' => $name,
    'sell_do[form][lead][email]' => $email,
    'sell_do[form][lead][phone]' => $phone,
    'sell_do[form][note][content]' => 'test',
    'sell_do[form][custom][custom_interested_unit]' => '',
    'api_key' => '336687f208db7dfac702886f436fa0f6',
    'sell_do[campaign][srd]' => '67ac5e0658f1e79cecf03efc'
);

// Headers
// $headers = array(
//     'AuthUser: ',
//     'Authorization: '
// );

// API endpoint
$url = 'https://app.sell.do/api/leads/create?api_key=336687f208db7dfac702886f436fa0f6';

// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute cURL request
$response = curl_exec($curl);

// Check for errors
if(curl_errno($curl)){
    echo 'cURL error: ' . curl_error($curl);
}

// Close cURL session
curl_close($curl);

// Output the response
echo $response;  // you can see this response whether the api working or not. 

 header('location: https://www.vgn.in/richmond-towers-guindy/thank-you-page.html');

// then redirect to the thank you page after receiving success message.
?>