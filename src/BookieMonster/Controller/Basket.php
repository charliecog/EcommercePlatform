<?php

namespace BookieMonster\Controller;

/**
 * Class Basket
 *
 * @package BookieMonster\Controller
 */
class Basket
{
    /**
     * @var array $products Book's product ID and its quantity
     */
    private $totalToPay;

    public function getTotalToPay(Array $itemsInABasket)
    {
        $this->calculateTotalToPay($itemsInABasket);

        return $this->totalToPay;
    }

    /**
     * adds product id and its qty to the basket, disallow to add if qty in a basket will exceed current stock level
     *
     * @param integer $productId
     * @param integer $qty
     * @param integer $stockLevel
     *
     * @return bool
     */
    public function addToBasket($productId, $qty, $stockLevel)
    {
        if ($qty && $productId) {
            if (array_key_exists($productId, $_SESSION['basket']['products'])) {
                if ($qty + $_SESSION['basket']['products'][$productId]['qty'] > $stockLevel) {
                    $result = false;
                } else {
                    $_SESSION['basket']['products'][$productId]['qty'] += $qty;
                    $result = true;
                }
            } else {
                $_SESSION['basket']['products'][$productId] = ['qty' => $qty];
                $result = true;
            }
        } else {
            //TODO: do something
        }
        unset($_POST['productId']);
        unset($_POST['qty']);

        return $result;
    }

    /**
     * get message depending if mas qty has been reached, return empty string if it has not
     *
     * @param bool $result
     *
     * @return string $maxQtyReachedMsg
     */
    public function getMaxQtyReachedMsg($result)
    {
        if ($result) {
            $maxQtyReachedMsg = '';
        } else {
            $maxQtyReachedMsg = 'We currently do not have that many copies in stock. ';
        }

        return $maxQtyReachedMsg;
    }

    /**
     * updates qty in a basket for given book id, removes book if given qty is 0
     *
     * @param integer $updatedBookId
     * @param integer $updatedBookQty
     * @param integer $currentQty
     * @param integer $stockLevel
     *
     * @return bool
     */
    public function updateBasket($updatedBookId, $updatedBookQty, $currentQty, $stockLevel)
    {
        $updatedBookQty = $this->setUpdatedBookQty(
            $currentQty,
            $updatedBookQty,
            $stockLevel
        );
        if ($updatedBookQty == 0) {
            unset($_SESSION['basket']['products'][$updatedBookId]);
            $result = true;
        } elseif ($updatedBookQty &&
            $updatedBookId &&
            array_key_exists($updatedBookId, $_SESSION['basket']['products'])
        ) {
            $_SESSION['basket']['products'][$updatedBookId]['qty'] = $updatedBookQty;
            $result = true;
        } else {
            //TODO:do something
        }
        unset($_POST['productId']);
        unset($_POST['qty']);

        return $result;
    }

    /**
     * sets values of qty depending on current stock level and requested qty
     *
     * @param integer $currentQty
     * @param integer $updatedQty
     * @param integer $stockLevel
     *
     * @return integer $updatedBookQty
     */
    private function setUpdatedBookQty(
        $currentQty,
        $updatedQty,
        $stockLevel
    ) {
        if (($updatedQty > 0) && ($updatedQty <= $stockLevel)) {
            $updatedBookQty = $updatedQty;
        } elseif (($updatedQty > 0) && ($updatedQty > $stockLevel)) {
            $updatedBookQty = $currentQty;
        } else {
            $updatedBookQty = 0;
        }

        return $updatedBookQty;
    }

    /**
     * calculates total order
     *
     * @param array $itemsInABasket
     */
    private function calculateTotalToPay(Array $itemsInABasket)
    {
        $totalToPay = 0.00;
        foreach ($itemsInABasket as $item) {
            $totalToPay += $item['qty'] * $item['sellPrice'];
        }

        $this->totalToPay = $totalToPay;
    }
}