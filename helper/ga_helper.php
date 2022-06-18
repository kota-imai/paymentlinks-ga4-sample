<?php 

function print_ga_tag()
{
  echo '
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=' . Config::GA4_MEASURING_ID . '"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag("js", new Date());
    gtag("config", "' . Config::GA4_MEASURING_ID . '");
    </script>';
}

function ga_purchase_event($session_id, $value, $currency)
{
  echo '
    <script>
    gtag("event", "purchase", {
      "transaction_id": "' . $session_id . '",
      "value": "' . $value . '",
      "currency": "' . $currency . '",
    });
    </script>';
}