<?php

namespace MoneyChanger;


class Money
{
    private $input_string = '';
    private $amount = 0;
    private $amount_left = 0;

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
     * @throws \Exception
     */
    public function __construct($money)
    {
        $valid_input = $this->validateInput($money);

        if ( $valid_input ) {
            $this->input_string = $money;
            $this->initCoins();
            $this->moneyStringToPennies($money);
        } else {
            throw new \Exception('Invalid money string.');
        }
    }


    /**
     * @param String $money Money string to be validated.
     * @return bool
     */
    private function validateInput($money)
    {
        $ret = false;

        $pattern = '/^(£|)\d+(\.\d*)?p?$/';
        $input_valid = preg_match($pattern, $money, $matches);

        if ($input_valid) {
            $ret = true;
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
            $pounds = preg_replace('/£/', '', $matches[1]);
            $pennies = preg_replace('/p/', '', $matches[2]);
            $pennies = $this->roundPennies($pennies);
        } else {
            $pound_pos = strpos($money, '£');
            if ($pound_pos === FALSE) {
                $pennies = preg_replace('/p/', '', $money);
            } else {
                $pounds = preg_replace('/£/', '', $money);
            }
        }

        $this->amount_left = $this->amount = $pounds * 100 + $pennies;
    }


    /**
     *  Exchange money by the fewest amount of coins.
     */
    public function exchangeMoney()
    {
        if ($this->amount_left <= 0) {
            return;
        } else {
            foreach ($this->coins as $value => $number) {
                if ($this->amount_left >= $value) {
                    $this->coins[$value]++;
                    $this->amount_left -= $value;

                    $this->exchangeMoney();
                }
            }
        }
    }


    /**
     * Round pennies to two digit integer.
     * @param int $pennies
     * @return int
     */
    private function roundPennies($pennies) {
        $number_string = '0.' . $pennies;
        $float = number_format($number_string, 2);

        $rounded_pennies = 100 * $float;

        return $rounded_pennies;
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
     * @param $coin One of available coin type.
     * @return string
     */
    private function coinToString($coin) {

        switch ($coin) {
            case self::TWO_POUNDS:
                $ret =  self::TWO_POUNDS_STRING;
                break;
            case self:: ONE_POUND:
                $ret =  self::ONE_POUND_STRING;
                break;
            case self::FIFTY_PENNIES:
                $ret =  self::FIFTY_PENNIES_STRING;
                break;
            case self::TWENTY_PENNIES:
                $ret =  self::TWENTY_PENNIES_STRING;
                break;
            case self::TWO_PENNIES:
                $ret =  self::TWO_PENNIES_STRING;
                break;
            case self::ONE_PENNY:
                $ret =  self::ONE_PENNY_STRING;
                break;
            default:
                $ret = '';
                break;
        }

        return $ret;
    }


    /**
     * @return string Exchanged money to string in format: 123p = 1 x £1, 1 x 20p, 1 x 2p, 1 x 1p
     */
    public function getCoinsString() {
        $ret = '';

        $ret .= $this->input_string . ' = ';
        foreach ($this->coins as $value => $number) {

            if ($number) {
                $ret .= $number . ' x ' . $this->coinToString($value) . ', ';
            }
        }

        return rtrim($ret, ', ');
    }
}