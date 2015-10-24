<?php

class  Money
{
    private $amount = 0;
    private $coins = array();

    const TWO_POUNDS = 200;
    const ONE_POUND = 100;
    const FIFTY_PENNIES = 50;
    const TWENTY_PENNIES = 20;
    const TWO_PENNIES = 2;
    const ONE_PENNY = 1;



    private function validateInput($money)
    {
        $pattern = '/^£?\d+(\.\d{1,2})?p?$/';
        $input_valid = preg_match($pattern, $money);

        if ($input_valid) {
            $pattern = '/^£\d+p/';
            $input_invalid = preg_match($pattern, $money);

            if ($input_invalid) {
                throw new Exception('Invalid input.');
            } else {
                $this->moneyStringToPennies($money);
            }
        } else {
            throw new Exception('Invalid input.');
        }
    }



    private function setCoins() {
        $this->coins = array(
            self::TWO_POUNDS => 0,
            self::ONE_POUND => 0,
            self::FIFTY_PENNIES => 0,
            self::TWENTY_PENNIES => 0,
            self::TWO_PENNIES => 0,
            self::ONE_PENNY => 0
        );
    }


    
    private function moneyStringToPennies($money) {
        $pounds = 0;
        $pennies = 0;

        $pattern = '/(.*)\.(.*)/';
        $ret = preg_match($pattern, '14.5p', $matches);

        if ($ret) {
            $pounds = intval($matches[1]);
            $pennies = intval($matches[2]);
        } else {
            $pound_pos = strpos($money, '£');
            if () {

            }
        }
    }
}