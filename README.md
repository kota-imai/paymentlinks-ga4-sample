## 使い方
#### 1. 依存ライブラリの収集
```composer install```

#### 2. .envファイルを作成
.env.sample ファイルをもとに .env ファイルを作成します。以下の値をセットしてください。
- `GA4_MEASUREMENT_ID` ...GoogleAnalytics4の測定ID（G-XXXX）
- `STRIPE_SECRET_KEY` ...StripeのAPIシークレットキー

#### 3. PaymentLinksのリダイレクト先を設定
[Stripeのダッシュボード](https://dashboard.stripe.com/payment-links)からPaymentLinksのリダイレクト先を変更します。
`https://example.com/index.php?id={CHECKOUT_SESSION_ID}`