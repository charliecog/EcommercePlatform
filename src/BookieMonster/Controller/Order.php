<?php

namespace BookieMonster\Controller;

/**
 * Class Order
 *
 * @package BookieMonster\Controller
 */
class Order
{
    /**
     * @var array $validationSettings
     * @var array $billingAddressValidationSettings
     * @var array $requiredFields
     */
    private $validationSettings = [
        'customerEmail'         => [
            'filter' => FILTER_VALIDATE_EMAIL,
            'flags'  => FILTER_REQUIRE_SCALAR,
        ],
        'customerName'        => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' =>'/([a-zA-Z]+\s?\-?\'?[a-zA-Z]+)/'),
        ],
        'customerSurname'   => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' =>'/([a-zA-Z]+\s?\-?\'?[a-zA-Z]+)/'),
        ],
        'deliveryAddress'   => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' =>'/([a-zA-Z]+\s?\-?\'?[a-zA-Z]+)/'),
        ],
        'deliveryCity'   => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' =>'/([a-zA-Z]+\s?\-?\'?[a-zA-Z]+)/'),
        ],
        'deliveryPostcode'   => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' =>'/[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}/i'),
        ],
        'nameOnCard'   => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' =>'/([a-zA-Z]+\s?\-?\'?[a-zA-Z]+)/'),
        ],
        'cardNumber'    => [
            'filter'  => FILTER_VALIDATE_INT,
            'flags'   => FILTER_REQUIRE_SCALAR,
            'options' => array('min_range' =>1000000000000000, 'max_range' => 9999999999999999),
        ],
    ];

    private $billingAddressValidationSettings = [
        'billingAddress'   => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' =>'/([a-zA-Z]+\s?\-?\'?[a-zA-Z]+)/'),
        ],
        'billingCity'   => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' =>'/([a-zA-Z]+\s?\-?\'?[a-zA-Z]+)/'),
        ],
        'billingPostcode'   => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => array('regexp' =>'/[A-Z]{1,2}[0-9][0-9A-Z]?\s?[0-9][A-Z]{2}/i'),
        ],
    ];
    private $requiredFields = [
        'customerEmail',
        'customerName',
        'customerSurname',
        'customerEmail',
        'deliveryAddress',
        'deliveryCity',
        'deliveryPostcode',
        'nameOnCard',
        'cardNumber',
    ];


    /**
     * checks if required fields has been filled
     *
     * @param array $orderDetails
     *
     * @return array $validationResult
     */
    public function checkRequiredFields($orderDetails)
    {
        $validationResult = ['validated' => true];

        foreach ($this->requiredFields as $field) {
            if (array_key_exists($field, $orderDetails)) {
                if (!$orderDetails[$field]) {
                    $validationResult[$field] = false;
                }
            }
        }
        if (in_array(false, $validationResult)) {
            $validationResult['validated'] = false;
        }

        return $validationResult;
    }

    /**
     * validates all book data, returns true if passed, false otherwise
     *
     * @param array $orderDetails
     *
     * @return array $validationResult
     */
    public function validateBookData(Array $orderDetails)
    {
        $validationResult['validated'] = true;
        if($orderDetails['billingAddress'] &&
            $orderDetails['billingAddress'] &&
            $orderDetails['billingAddress']
        ) {
            $billingAddressResults = filter_var_array($orderDetails, $this->billingAddressValidationSettings);
            foreach ($billingAddressResults as $inputField => $result) {
                if ($result === false) {
                    $validationResult[$inputField] = $result;
                }
            }
        }
        $orderDetailsResults = filter_var_array($orderDetails, $this->validationSettings);
        foreach ($orderDetailsResults as $inputField => $result) {
            if ($result === false) {
                $validationResult[$inputField] = $result;
            }
        }
        if (in_array(false, $validationResult)) {
            $validationResult['validated'] = false;
        }

        return $validationResult;
    }

}