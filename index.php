<?php

require_once('vendor/autoload.php');
require_once('ga_helper.php');

Dotenv\Dotenv::createImmutable(__DIR__)->load();

$stripe = new \Stripe\StripeClient(
  $_ENV['STRIPE_SECRET_KEY']
);

if (isset($_GET['id'])) {
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
}
?>

<!DOCTYPE html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
  <title>Thank You for your purchase</title>
  <?php print_ga_tag();?>
</head>

<body>
  <div class="jumbotron text-center">
    <h1 class="display-3">Thank You!</h1>
    <p class="lead"> お客様のご注文内容は以下の通りです</p>
    <p class="lead">
    <div class="d-flex justify-content-center container mt-5">
      <div class="card p-3 bg-white" style="width: 20rem;">
        <div class="about-product text-center mt-2">
          <img src="<?=$product->images[0]?>" width="150">
        </div>
        <div class="stats mt-2">
          <?php
          foreach ($line_items->data as &$item) {
            echo '<div class="d-flex justify-content-between p-price"><span>'
              . urldecode($item->description)
              . ' x' . $item->quantity . '</span><span>'
              . $item->price->unit_amount . ' ' . strtoupper($item->price->currency) . '</span></div>';
          }
          ?>
        </div>
        <hr>
        <div class="d-flex justify-content-between total font-weight-bold mt-4"><span>合計</span><span><?=$checkout->amount_total?> <?=strtoupper($checkout->currency)?></span></div>
      </div>
    </div>
    </p>
    <p class="lead">
      <a class="btn btn-primary btn-lg" href="<?= $intent->charges->data[0]->receipt_url ?>" role="button" target="_blank">領収書をダウンロードする
      </a>
    </p>
    <p>
      お問い合わせは <a href="">こちら</a>
    </p>
  </div>

  <?php
  ga_purchase_event(
    $sid,
    $checkout->amount_total,
    strtoupper($checkout->currency)
  );
  ?>
  </body>

</html>