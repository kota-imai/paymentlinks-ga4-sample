<?php

require_once('vendor/autoload.php');
require_once('helper/ga_helper.php');

Dotenv\Dotenv::createImmutable(__DIR__)->load();

$stripe = new \Stripe\StripeClient(
  $_ENV['STRIPE_SECRET_KEY']
);

if (!isset($_GET['id'])) {
  echo '<h2>Error</h2><div>Checkout Session Id is required</div>';
  exit();
}
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
  echo '<h2>Stripe API Error</h2>' . '<div>' . $ex->getMessage() . '</div>';
}
