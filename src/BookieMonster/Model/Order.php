<?php


namespace BookieMonster\Model;

/**
 * Class Order
 *
 * @package BookieMonster\Model
 */
class Order
{
    /**
    * @var array $itemsOrdered;
    * @var float $total;
    * @var string $customerName;
    * @var string $customerSurname;
    * @var string $customerEmail;
    * @var string $deliveryAddress;
    * @var string $billingAddress;
    * @var string $nameOnCard;
    * @var integer $cardNumber;
    * @var PDO $dbConnection;
    * @var integer $orderId;
     */
    private $itemsOrdered;
    private $total;
    private $customerName;
    private $customerSurname;
    private $customerEmail;
    private $deliveryAddress;
    private $billingAddress;
    private $nameOnCard;
    private $cardNumber;
    private $dbConnection;
    private $orderId;

    public function __construct(Array $basket, $total, $dbConnection)
    {
        $this->itemsOrdered = $basket;
        $this->total = $total;
        $this->dbConnection = $dbConnection;
    }

    /**
     * assigns order details from a form to the properties
     *
     * @param array $orderDetails
     */
    public function setOrderDetails(Array $orderDetails)
    {
        $this->customerName = $orderDetails['customerName'];
        $this->customerSurname = $orderDetails['customerSurname'];
        $this->customerEmail = $orderDetails['customerEmail'];
        $this->deliveryAddress = $orderDetails['deliveryAddress'] . ',' . $orderDetails['deliveryCity'] . ',' . $orderDetails['deliveryPostcode'];
        if ($this->checkBillingAddress(
            $orderDetails['billingAddress'],
            $orderDetails['billingCity'],
            $orderDetails['billingPostcode']
        )
        ) {
            $this->billingAddress = $orderDetails['billingAddress'] . ',' . $orderDetails['billingCity'] . ',' . $orderDetails['billingPostcode'];
        } else {
            $this->billingAddress = $this->deliveryAddress;
        }
        $this->nameOnCard = $orderDetails['nameOnCard'];
        $this->cardNumber = substr($orderDetails['cardNumber'], -4);
    }

    /**
     * add order details to database
     *
     * @param array $formData
     *
     * @return string $result
     */
    public function addOrder(Array $formData)
    {
        $this->setOrderDetails($formData);
        $queryString = 'INSERT INTO `order` (
                                `total`,
                                `customer_name`,
                                `customer_surname`,
                                `customer_email`,
                                `delivery_address`,
                                `billing_address`,
                                `name_on_card`,
                                `card_number`
                              )
                              VALUES (
                                :total,
                                :customerName,
                                :customerSurname,
                                :customerEmail,
                                :deliveryAddress,
                                :billingAddress,
                                :nameOnCard,
                                :cardNumber);';
        try {
            $this->dbConnection->beginTransaction();
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindParam(':total', $this->total);
            $stmt->bindParam(':customerName', $this->customerName);
            $stmt->bindParam(':customerSurname', $this->customerSurname);
            $stmt->bindParam(':customerEmail', $this->customerEmail);
            $stmt->bindParam(':deliveryAddress', $this->deliveryAddress);
            $stmt->bindParam(':billingAddress', $this->billingAddress);
            $stmt->bindParam(':nameOnCard', $this->nameOnCard);
            $stmt->bindParam(':cardNumber', $this->cardNumber);
            $stmt->execute();
            $this->orderId = $this->dbConnection->lastInsertId();

            foreach ($this->itemsOrdered as $bookId => $book) {
                $this->linkOrderAndBook($bookId, $book['qty']);
            }

            $this->dbConnection->commit();
            $result = 'Your reference number is:  ' . $this->orderId;
        } catch (\PDOException $e) {
            $this->dbConnection->rollBack();
            $result = 'There has been a problem with your order. Please try again.';
        }

        return $result;
    }

    /**
     * checks if billing address has been given, if any of the fields are empty it returns false,
     * all billing address fields must be filled to return true
     *
     * @param string $billingAddress
     * @param string $billingCity
     * @param string $billingPostcode
     *
     * @return bool
     */
    private function checkBillingAddress($billingAddress, $billingCity, $billingPostcode)
    {
        $result = true;
        if (!$billingAddress ||
            !$billingCity ||
            !$billingPostcode
        ) {
            $result = false;
        }

        return $result;
    }

    /**
     * links order and book by their ids
     *
     * @param integer $bookId
     * @param integer $qty
     *
     * @return string $result
     */
    private function linkOrderAndBook($bookId, $qty)
    {
        $queryString = 'INSERT INTO `order_book` (`order_id`, `book_id`, `quantity`) VALUES (:orderId, :bookId, :qty);';
        try {
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindValue(':orderId', $this->orderId);
            $stmt->bindValue(':bookId', $bookId);
            $stmt->bindValue(':qty', $qty);
            $stmt->execute();
            $result = 'Success';
        } catch (\PDOException $e) {
            $result = 'Error';

        }

        return $result;
    }
}