<?php

$data = array(
    'title'         => '',
    'author'        => "xdvxd",
    'category'      => '30',
    'description'   => 'description',
    'format'        => 'b',
    'yearPublished' => '852836', //FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT
    'publisher'     => 'publisher',
    'costPrice'     => '0.00', //FILTER_VALIDATE_FLOAT, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION
    'sellPrice'     => '2.99', //FILTER_VALIDATE_FLOAT, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION
    'stockLevel'    => '1', //FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT
    'notes'         => 'notes',
);

$arg = [
    'title'         => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags'  => FILTER_REQUIRE_SCALAR,
    ],
    'author'        => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags'  => FILTER_REQUIRE_SCALAR,
    ],
    'category'      => [
        'filter'  => FILTER_VALIDATE_INT,
        'flags'   => FILTER_REQUIRE_SCALAR,
        'options' => ['min_range' => 1, 'max_range' => 29],
    ],
    'description'   => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags'  => FILTER_REQUIRE_SCALAR,
    ],
    'format'        => [
        'filter'  => FILTER_VALIDATE_INT,
        'flags'   => FILTER_REQUIRE_SCALAR,
        'options' => ['min_range' => 1, 'max_range' => 2],
    ],
    'yearPublished' => [
        'filter'  => FILTER_VALIDATE_INT,
        'flags'   => FILTER_REQUIRE_SCALAR,
        'options' => array('min_range' => 1000, 'max_range' => 9999),
    ],
    'publisher'     => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags'  => FILTER_REQUIRE_SCALAR,
    ],
    'costPrice'     => array(
        'filter'  => FILTER_CALLBACK,
        'flags'   => FILTER_REQUIRE_SCALAR,
        'options' => 'validatePrice',
    ),
    'sellPrice'     => array(
        'filter'  => FILTER_CALLBACK,
        'flags'   => FILTER_REQUIRE_SCALAR,
        'options' => 'validatePrice',
    ),
    'stockLevel'    => array(
        'filter'  => FILTER_VALIDATE_INT,
        'flags'   => FILTER_REQUIRE_SCALAR,
        'options' => array('min_range' => 1, 'max_range' => 100),
    ),
    'notes'         => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags'  => FILTER_REQUIRE_SCALAR,
    ],
];

function validatePrice($price)
{
    var_dump($price);
    if ($price > 0 && is_float($price)) {
        return $price;
    }

    return false;
}

//$result = filter_var_array($data, $arg);

$requiredFields = [
    'title',
    'author',
    'category',
    'description',
    'format',
    'costPrice',
    'sellPrice',
    'stockLevel',
];

function checkRequiredFields($requiredFields, $data)
{
    $validationResult = ['validated' => true];
    foreach ($requiredFields as $field) {
        if (array_key_exists($field, $data)) {
            if (!$data[$field]) {
                $validationResult[$field] = false;
            }
        }
    }
    if (in_array(false, $validationResult)) {
        $validationResult['validated'] = false;
    }


    return $validationResult;
}

var_dump(checkRequiredFields($requiredFields, $data));
