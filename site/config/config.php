<?php
require_once('mailFunctions.php');

return [
  'locale' => 'de_DE.utf-8',
  'checkoutPage' => 'kasse',
  'ww.merx.currency' => 'EUR',
  'ww.merx.currencySymbol' => '€',
  'ww.merx.email' => 'info@babyreport.de',
  'ww.merx.ordersPage' => 'rechnungen',

  'thumbs' => [
    'quality' => 80,
  ],

  'cache' => [
    'pages' => [
      'active' => true,
      'ignore' => function ($page) {
        // only cache product and legal pages
        if (in_array((string)$page->intendedTemplate(), ['product', 'legal'])) {
          return false;
        }
        return true;
      },
    ]
  ],
  'routes' => [
    [
      'method' => 'post',
      'pattern' => 'shop-api/add-to-cart',
      'action' => function() {
        try {
          $data = kirby()->request()->data();
          merx()->cart()->add([
            'id' => $data['id'],
            'quantity' => $data['quantity']
          ]);
          return [
            'status' => 201,
            'redirect' => option('checkoutPage'),
          ];
        } catch (Kirby\Exception\Exception $ex) {
          return $ex->toArray();
        }
      },
    ],
    [
      'pattern' => 'shop-api/get-client-secret',
      'action' => function() {
        $merx = merx();
        $cart = $merx->cart();
        $paymentIntent = $cart->getStripePaymentIntent();
        kirby()->session()->set('ww.site.paymentIntentId', $paymentIntent->id);
        return [
          'clientSecret' => $paymentIntent->client_secret,
        ];
      },
    ],
    [
      'method' => 'post',
      'pattern' => 'shop-api/update-cart-item',
      'action' => function () {
        try {
          $data = kirby()->request()->data();
          $cart = merx()->cart()->update([
            [
              'id' => $data['id'],
              'quantity' => (float)($data['quantity'] ?? 1),
            ],
          ]);
          $data = [
              'items' => $cart->getFormattedItems(),
              'tax' => formatPrice($cart->getTax()),
              'sum' => formatPrice($cart->getSum()),
          ];
          if ($cart->isEmpty()) {
            $data['error'] = I18n::translate('error.merx.checkout.emptycart');
          }
          return [
            'status' => 200,
            'data' => $data,
          ];
        } catch (Kirby\Exception\Exception $ex) {
          return $ex->toArray();
        }
      }
    ],
    [
      'method' => 'post',
      'pattern' => 'shop-api/submit',
      'action' => function() {
        try {
          $data = $_POST;
          $paymentIntentId = kirby()->session()->get('ww.site.paymentIntentId');
          $data = array_merge($data, [
            'stripePaymentIntentId' => $paymentIntentId,
          ]);
          $redirect = merx()->initializePayment($data);
          return [
            'status' => 201,
            'redirect' => url($redirect),
          ];
        } catch (Kirby\Exception\Exception $ex) {
          return $ex->toArray();
        }
      },
    ]
  ],

  'hooks' => [
    'page.changeStatus:after' => function($newPage, $oldPage) {
      if ((string)$newPage->intendedTemplate() === 'order' && $newPage->isListed()) {
        sendConfirmationMail($newPage);
        sendNewOrderToAdmin($newPage);
      }
    },
    'page.update:after' => function ($newPage, $oldPage) {
      if ((string)$newPage->intendedTemplate() === 'order' && $newPage->isListed()) {
        if ($newPage->shipped()->toBool() !== $oldPage->shipped()->toBool()) {
          if ($newPage->shipped()->isTrue()) {
            kirby()->impersonate('kirby');
            $newPage = $newPage->update([
              'shippingDate' => time(),
            ])->save();
            sendShippedMail($newPage);
          } else {
            $newPage->update([
              'shippingDate' => '',
            ]);
          }
        }
        if ($newPage->paymentComplete()->toBool() !== $oldPage->paymentComplete()->toBool()) {
          if ($newPage->paymentComplete()->isTrue()) {
            kirby()->impersonate('kirby');
            $newPage = $newPage->update([
              'payedDate' => time(),
            ]);
            if ((string)$newPage->paymentMethod() === 'invoice') {
              sendPayedMail($newPage);
            }
          } else {
            $newPage->update([
              'payedDate' => '',
            ]);
          }
        }
      }
    },
  ]
];
