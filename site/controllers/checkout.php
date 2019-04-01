<?php
use Wagnerwagner\Merx;
use Wagnerwagner\Merx\ProductList;


return function ($site, $page, $kirby) {
  if (merx()->cart()->isEmpty()) {
    go('');
  }
};
