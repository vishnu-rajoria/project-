<?php
session_start();
require "vendor/autoload.php";
use Razorpay\Api\Api;

$key_id = "rzp_test_avw8jazIUW6v03";
$key_secret = "w4vEgMzMmNdFcYrotHyyvSjB";


$api = new Api($key_id, $key_secret);

//var_dump($api);
$user_id = "5555";
$order_amount = 500;

$order_details = array(
	'receipt' => '123'.rand(200,1000)."_".$user_id, 
	'amount' => $order_amount*100, 
	'currency' => 'INR', 
	'notes'=> array('key1'=> 'value3','key2'=> 'value2')
);

//var_dump($order_details);

$new_order = $api->order->create($order_details);

echo "<pre>";
print_r($new_order);
echo "</pre>";


// order details form the razorpay 

$order_id = $new_order['id'];
$order_receipt = $new_order['receipt'];
$order_amount = $new_order['amount'];
$order_currency = $new_order['currency'];

// Setting the order in SESSION

$_SESSION['razorpay_order_id'] = $order_id;
?>



<button id="rzp-button1">Pay</button>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "<?= $key_id ?>", // Enter the Key ID generated from the Dashboard
    "amount": "<?= $order_amount ?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "INR",
    "name": "Acme Corp", //your business name
    "description": "Test Transaction",
    "image": "https://example.com/your_logo",
    "order_id": "<?= $order_id ?>", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    "callback_url": "status.php",
    "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
        "name": "Gaurav Kumar", //your customer's name
        "email": "gaurav.kumar@example.com",
        "contact": "9000090000" //Provide the customer's phone number for better conversion rates 
    },
    "notes": {
        "address": "Razorpay Corporate Office"
    },
    "theme": {
        "color": "#3399cc"
    }
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>