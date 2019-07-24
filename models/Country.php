<?php
class Country
{
    //DB stuff
    private $conn;
    private $table = 'country';

    //Country Properties
    public $name;
    public $code2;
    public $code3;
    public $calling_code;
    public $capital;
    public $currency_code;
    public $language;
    public $region;
    public $timezone;
    public $currencies_used;
    public $flagl

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //Get Country
    // function read()
    // {
    //     //Create query
    //     $query = 'SELECT
    //         country.name,
    //         country.code2,
    //         country.code3,
    //         country.calling_code,
    //         country.capital,
    //         country.currency_code,
    //         country.name
    //         '
    // }
}
