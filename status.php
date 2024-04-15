<?php
require "vendor/autoload.php";

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

session_start();
print_r($_SESSION);


$key_id = "rzp_test_avw8jazIUW6v03";
$key_secret = "w4vEgMzMmNdFcYrotHyyvSjB";


$success = true;

$error = "Payment Failed";

if (!empty($_POST['razorpay_payment_id']))
{
    $api = new Api($key_id, $key_secret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true)
{
    $html = "<p>Your payment was successful</p>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}

echo $html;