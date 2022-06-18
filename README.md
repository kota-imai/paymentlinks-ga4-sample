## 使い方
#### 1. 依存ライブラリの収集
```$ composer install```

#### 2. .envファイルを作成
sample.config.php ファイルをもとに config.php ファイルを作成します。以下の値をセットしてください。
```
  const GA4_MEASURING_ID  = {{GoogleAnalytics4の測定ID(G-XXXX)};
  const STRIPE_SECRET_KEY = {{StripeのAPIシークレットキー}};
```

#### 3. PaymentLinksのリダイレクト先を設定
[Stripeのダッシュボード](https://dashboard.stripe.com/payment-links)からPaymentLinksのリダイレクト先を変更します。<br>
`https://example.com/index.php?id={CHECKOUT_SESSION_ID}`