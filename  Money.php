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

    const TWO_POUNDS_STRING = '£2';
    const ONE_POUND_STRING = '£1';
    const FIFTY_PENNIES_STRING = '50p';
    const TWENTY_PENNIES_STRING = '20p';
    const TWO_PENNIES_STRING = '2p';
    const ONE_PENNY_STRING = '1p';


    /**
     * @param String $money Input string to be validated.
     * @throws Exception
     */
    public function __construct($money)
    {
        if ( $this->validateInput($money) ) {
            $this->initCoins();
            $this->moneyStringToPennies($money);
        } else {
            throw new Exception('Invalid money string.');
        }
    }


    /**
     * @param String $money Money string to be validated.
     * @return bool
     */
    private function validateInput($money)
    {
        $ret = false;

        $pattern = '/^£?\d+(\.\d{1,2})?p?$/';
        $input_valid = preg_match($pattern, $money);

        if ($input_valid) {
            $pattern = '/^£\d+p/';
            $input_invalid = preg_match($pattern, $money);

            if ( !$input_invalid ) {
                $ret = true;
            }
        }

        return $ret;
    }


    private function initCoins()
    {
        $this->coins = array(
            self::TWO_POUNDS => 0,
            self::ONE_POUND => 0,
            self::FIFTY_PENNIES => 0,
            self::TWENTY_PENNIES => 0,
            self::TWO_PENNIES => 0,
            self::ONE_PENNY => 0
        );
    }


    /**
     * @param String $money
     */
    private function moneyStringToPennies($money) {
        $pounds = 0;
        $pennies = 0;

        $pattern = '/(.*)\.(.*)/';
        $ret = preg_match($pattern, $money, $matches);

        if ($ret) {
            $pounds = intval($matches[1]);
            $pennies = intval($matches[2]);
        } else {
            $pound_pos = strpos($money, '£');
            if ($pound_pos === FALSE) {
                $pennies = intval($money);
            } else {
                $pounds = intval($money);
            }
        }

        $this->amount = $pounds * 10 + $pennies;
    }


    public function exchangeMoney()
    {
        $amount_left = $this->amount;
        $this->amountToCoins($amount_left);

    }


    /**
     * @param int $amount Ammount in pennies to be changed into coins.
     */
    private function amountToCoins($amount)
    {
        if ($amount <= 0) {
            return;
        } else {
            foreach ($this->coins as $value => $number) {
                if ($amount >= $value) {
                    $number++;
                    $amount -= $value;

                    $this->amountToCoins($amount);
                }
            }
        }
    }


    /**
     * @return int Money amount in pennies.
     */
    public function getAmount()
    {
        return $this->amount;
    }


    /**
     * @return int array Available coins.
     */
    public function getCoins()
    {
        return $this->coins;
    }


    /**
     * @return string Exchanged money to string.
     */
    public function getCoinsString() {
        $ret = '';

        foreach ($this->coins as $value => $number) {
            $ret .= $value . ' x ' . $number . ', ';
        }

        return rtrim($ret, ', ');
    }
}