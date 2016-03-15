<?php

namespace BookieMonster\Model;


class Basket
{

    /**
     * @var array $products Book's product ID and its quantity
     * @var array $booksInABasket
     */
    public $products;
    public $itemsInABasket = [];

    /**
     * set product from session basket to products property
     *
     * @param array $products
     */
    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
     * gets is, title, author, format, sell price, image file name, qty for each item in a basket
     *
     * @param Book $book
     *
     * @return array
     */
    public function getBooksInABasket(Book $book)
    {
        foreach ($this->products as $id => $product) {
            $bookInfo = $book->getBookByProductNo($id);
            $qty = $product['qty'];
            $availabilityMessage = '';
            if ($product['qty'] > $bookInfo['stock_level']) {
                $qty = $bookInfo['stock_level'];
                $availabilityMessage = $book->isAvailable($bookInfo['stock_level']);
            }
            $bookFormat = ucfirst($book->getFormatName($bookInfo['format_id']));
            $this->itemsInABasket[$id] = [
                'title'               => $bookInfo['title'],
                'author'              => $bookInfo['author'],
                'format'              => $bookFormat,
                'sellPrice'           => $bookInfo['sell_price'],
                'image'               => $bookInfo['image'],
                'qty'                 => $qty,
                'maxQtyAllowed'       => $bookInfo['stock_level'],
                'availabilityMessage' => $availabilityMessage,
            ];
        }

        return $this->itemsInABasket;
    }
}