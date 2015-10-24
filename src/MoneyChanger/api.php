<?php
include_once 'Class/Money.php';
include_once 'Class/View.php';

use MoneyChanger\Money as Money;
use MoneyChanger\View as View;

$post = array();
if (!empty($_POST)) {
    $post = $_POST;
}

if ( isset($post['money']) ) {
    try {
        $money = new Money($post['money']);
        unset($post['money']);

        echo 'amount: ' . $money->getAmount() . PHP_EOL;

        $money->exchangeMoney();
        $exchangeString = $money->getCoinsString();

        View::getResponseView($exchangeString);
    } catch (Exception $e) {
        View::getErrorView($e->getMessage());
    }
} else {
    View::getInitialView();
}