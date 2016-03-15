<?php

namespace BookieMonster\Controller;

/**
 * Class BookController
 *
 * @package BookieMonster\Controller
 */
class Book
{
    /**
     * @var array   $allowedImageFileType list of allowed image file types
     * @var integer $allowedImageFileSize maximum file size for uploaded image
     * @var array   $validationSettings   setting for validation form fields
     * @var array   $requiredFields       list of required form fields
     * @var string  $imageFileName        name for uploaded book image
     */
    private $allowedImageFileTypes = array('image/png', 'image/jpeg');
    private $allowedImageFileSize = 400000;
    private $validationSettings = [
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
            'filter' => FILTER_VALIDATE_FLOAT,
            'flags'  => FILTER_REQUIRE_SCALAR,
        ),
        'sellPrice'     => array(
            'filter' => FILTER_VALIDATE_FLOAT,
            'flags'  => FILTER_REQUIRE_SCALAR,
        ),
        'stockLevel'    => array(
            'filter'  => FILTER_VALIDATE_INT,
            'flags'   => FILTER_REQUIRE_SCALAR,
            'options' => array('min_range' => 0, 'max_range' => 100),
        ),
        'notes'         => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'flags'  => FILTER_REQUIRE_SCALAR,
        ],
    ];
    private $requiredFields = [
        'title',
        'author',
        'category',
        'description',
        'format',
        'costPrice',
        'sellPrice',
        'stockLevel',
    ];

    /**
     * formats,validates all book data, returns true if passed, false otherwise
     *
     * @param array $bookData
     *
     * @return array $validationResult
     */
    public function validateBookData(Array $bookData)
    {
        $validationResult['validated'] = true;
        $bookData = $this->formatInputStrings($bookData);
        $bookData['costPrice'] = $this->validatePrice($bookData['costPrice']);
        $bookData['sellPrice'] = $this->validatePrice($bookData['sellPrice']);
        $results = filter_var_array($bookData, $this->validationSettings);
        foreach ($results as $inputField => $result) {
            if ($result === false) {
                $validationResult[$inputField] = $result;
            }
        }
        if (in_array(false, $validationResult)) {
            $validationResult['validated'] = false;
        }

        return $validationResult;
    }

    /**
     * validates uploaded image file
     *
     * @param array $fileData
     *
     * @return array $validationResult
     */
    public function validateImageFile(Array $fileData)
    {
        $validationResult = ['validated' => true];
        if (is_uploaded_file($fileData['image']['tmp_name'])) {
            $validationResult['fileType'] = $this->validateFileType($fileData);
            $validationResult['fileSize'] = $this->validateFileSize($fileData);
        }
        if (in_array(false, $validationResult)) {
            $validationResult['validated'] = false;
        }

        return $validationResult;
    }

    /**
     * get new image file name
     *
     * @param array $fileData
     *
     * @return string $imageFileName
     */
    public function getImageFileName(Array $fileData)
    {
        $imageFileName = null;
        if (is_uploaded_file($fileData['image']['tmp_name'])) {
            $fileName = $fileData['image']['name'];
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            date_default_timezone_set('Europe/London');
            $newFileName = date('d-m-Y_H:i:s', time()) . '.' . $extension;
            $imageFileName = $newFileName;
        }

        return $imageFileName;
    }

    /**
     * @param array $fileData
     *
     * @return array $validationResult
     */
    public function validateCsvFile(Array $fileData)
    {
        $validationResult = ['validated' => true];
        if (is_uploaded_file($fileData['csv']['tmp_name'])) {
            $validationResult['fileType'] = in_array($fileData['csv']['type'], ['text/csv']);
            $validationResult['fileSize'] = $fileData['csv']['type'] < 200000;
            $this->setCsvFileName($fileData);
        }
        if (in_array(false, $validationResult)) {
            $validationResult['validated'] = false;
        }

        return $validationResult;
    }

    /**
     * checks if required fields has been filled
     *
     * @param array $bookData
     *
     * @return array $validationResult
     */
    public function checkRequiredFields($bookData)
    {
        $validationResult = ['validated' => true];
        foreach ($this->requiredFields as $field) {
            if (array_key_exists($field, $bookData)) {
                if($bookData['stockLevel'] == 0) {
                    continue;
                }
                if (!$bookData[$field]) {
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
     * sets name for uploaded csv file
     *
     * @param array $fileData
     *
     * @return string $newFileName
     */
    public function setCsvFileName(Array $fileData)
    {
        if (is_uploaded_file($fileData['csv']['tmp_name'])) {
            $fileName = $fileData['csv']['name'];
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            date_default_timezone_set('Europe/London');
            $newFileName = date('d-m-Y_H:i:s', time()) . '.' . $extension;

            return $newFileName;
        }
    }

    /**
     * validates file type
     *
     * @param array $fileData contains uploaded files data
     *
     * @return bool
     */
    private function validateFileType(Array $fileData)
    {
        if (!in_array($fileData['image']['type'], $this->allowedImageFileTypes)) {
            return false;
        }

        return true;
    }

    /**
     * validates file size
     *
     * @param array $fileData contains uploaded files data
     *
     * @return bool
     */
    private function validateFileSize(Array $fileData)
    {
        if (!($fileData['image']['size'] < $this->allowedImageFileSize)) {
            return false;
        }

        return true;
    }

    /**
     * add backslashes to book data input strings that need to be escaped
     *
     * @param array $bookData
     *
     * @return array $bookData
     */
    private function formatInputStrings($bookData)
    {
        $bookData['title'] = addslashes($bookData['title']);
        $bookData['author'] = addslashes($bookData['author']);
        $bookData['description'] = addslashes($bookData['description']);
        $bookData['publisher'] = addslashes($bookData['description']);
        $bookData['notes'] = addslashes($bookData['notes']);

        return $bookData;

    }

    /**
     * check if input price is float and if it is greater than 0.01
     *
     * @param float $price
     *
     * @return bool
     */
    private function validatePrice($price)
    {
        if ($price >= 0.00) {
            return true;
        }

        return false;
    }

}
