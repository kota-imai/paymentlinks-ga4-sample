<?php 

require_once('vendor/autoload.php');
require_once('helper/ga_helper.php');
require_once('./config.php');

if (Config::STRIPE_SECRET_KEY === '')
{
  echo '<h2>Error</h2><div>Stripe secret key is not set in config file</div>';
  exit();
}
if (Config::GA4_MEASURING_ID === '')
{
  echo '<h2>Error</h2><div>Google Analytics Measuring ID is not set in config file</div>';
  exit();
}
if (!isset($_GET['id'])) {
  echo '<h2>Error</h2><div>Checkout Session Id is required</div>';
  exit();
}

$stripe = new \Stripe\StripeClient(
  Config::STRIPE_SECRET_KEY
);
try {
  $sid = $_GET['id'];
  $checkout = $stripe->checkout->sessions->retrieve(
    $sid,
    []
  );
  $line_items = $stripe->checkout->sessions->allLineItems(
    $sid,
    []
  );
  $intent = $stripe->paymentIntents->retrieve(
    $checkout->payment_intent,
    []
  );
  $product = $stripe->products->retrieve(
    $line_items->data[0]->price->product,
    []
  );
  include_once('views/thanks.php');
} catch (Exception $ex) {
  echo '<h2>Stripe API Error</h2><div>' . $ex->getMessage() . '</div>';
}