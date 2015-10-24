<?php
include_once 'Class/Money.php';
include_once 'Class/View.php';

use MoneyChanger\Money as Money;
use MoneyChanger\View as View;

$testArray = array(
    '4' => 4,
    '85' => 85,
    '197p' => 197,
    '2p' => 2,
    '1.87' => 187,
    '£1.23' => 123,
    '£2p' => 200,
    '£10' => 1000,
    '£1.87' => 187,
    '£1p' => 100,
    '£1.p' => 100,
    '001.41p' => 141,
    '4.235p' => 424,
    '£1.257422457p' => 126,
    '' => 'not valid',
    '1x' => 'not valid',
    '£1x.0p' => 'not valid',
    '£p' => 'not valid'
);

testMoneyValidateInput($testArray);
testMoneyStringToPennies($testArray);
testMoneyExchangeMoney($testArray);
testMoneyGetCoinsString($testArray);


function testMoneyValidateInput($testArray) {
    echo 'TEST: ' . __METHOD__ . PHP_EOL;

    foreach ($testArray as $input => $output) {
        echo $input . ' => ' . $output . ' === ';

        try {
            $money = new Money($input);
            echo 'OK' . PHP_EOL;
        } catch (Exception $e) {
            echo 'FAIL' . PHP_EOL;
        }
    }
}

function testMoneyStringToPennies($testArray) {
    echo 'TEST: ' . __METHOD__ . PHP_EOL;

    foreach ($testArray as $input => $output) {
        try {
            $money = new Money($input);
            $amount = $money->getAmount();

            echo $input . ' => ' . $output . ' === ' . $amount . PHP_EOL;
        } catch (Exception $e) {
        }
    }
}

function testMoneyExchangeMoney($testArray) {
    echo 'TEST: ' . __METHOD__ . PHP_EOL;

    foreach ($testArray as $input => $output) {
        try {
            $money = new Money($input);
            $money->exchangeMoney();

            echo '========' . PHP_EOL;
            echo $input . ' => ' . $output  . PHP_EOL;
            var_export($money->getCoins());
            echo PHP_EOL;

        } catch (Exception $e) {
        }
    }
}

function testMoneyGetCoinsString($testArray) {
    echo 'TEST: ' . __METHOD__ . PHP_EOL;

    foreach ($testArray as $input => $output) {
        try {
            $money = new Money($input);
            $money->exchangeMoney();

            echo '========' . PHP_EOL;
            echo $input . ' => ' . $output  . PHP_EOL;
            echo $money->getCoinsString() . PHP_EOL;
            echo PHP_EOL;

        } catch (Exception $e) {
        }
    }
}

