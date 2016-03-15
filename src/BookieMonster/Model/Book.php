<?php
namespace BookieMonster\Model;

/**
 * Class Book
 *
 * @package BookieMonster\Model
 */
class Book
{
    /**
     * @var integer $productNo     product no stored as book id in database
     * @var string  $title         book's title
     * @var string  $author        book's author
     * @var string  $description   book's description
     * @var integer $format        number indicating format type
     * @var integer $yearPublished year book was published YYYY
     * @var string  $publisher     book's publisher name
     * @var object  $image         image of the book
     * @var float   $costPrice     book's cost price
     * @var float   $selPrice      book's sell price
     * @var integer $stockLevel    number of book currently in stock
     * @var integer $category      number indicating category name
     * @var string  $notes         any useful notes about the book
     * @var integer $featured      number indicating if the book is featured at the moment, default 2 for not featured
     * @var PDO     $dbConnection  database connection
     */
    private $productNo;
    private $title;
    private $author;
    private $description;
    private $format;
    private $yearPublished = null;
    private $publisher;
    private $image = 'default.png';
    private $costPrice;
    private $sellPrice;
    private $stockLevel;
    private $category;
    private $notes;
    private $featured = '0';
    private $dbConnection;

    public function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * sets book's properties from given array
     *
     * @param array $bookData array containing book information
     */
    public function setBookProperties(Array $bookData)
    {
        if (array_key_exists('productNo', $bookData)) {
            $this->productNo = $bookData['productNo'];
        }
        if (array_key_exists('image', $bookData)) {
            $this->image = $bookData['image'];;
        }
        if (array_key_exists('yearPublished', $bookData)) {
            $this->yearPublished = $bookData['yearPublished'];
        }
        $this->title = $bookData['title'];
        $this->author = $bookData['author'];
        $this->description = $bookData['description'];
        $this->format = $bookData['format'];
        $this->publisher = $bookData['publisher'];
        $this->costPrice = $bookData['costPrice'];
        $this->sellPrice = $bookData['sellPrice'];
        $this->stockLevel = $bookData['stockLevel'];
        $this->category = $bookData['category'];
        $this->notes = $bookData['notes'];
    }

    /**
     * takes book data and inserts it into database, links newly inserted book and its category, sets new book id to
     * productNo property and returns array containing feedback message
     *
     * @param array $bookData
     *
     * @return array $result
     */
    public function addNewBook(Array $bookData)
    {
        $this->setBookProperties($bookData);
        $queryString = 'INSERT INTO `book` (
                          `title`,
                          `author`,
                          `description`,
                          `format_id`,
                          `year_published`,
                          `publisher`,
                          `image`,
                          `cost_price`,
                          `sell_price`,
                          `stock_level`,
                          `notes`,
                          `featured`
                        )
                        VALUES (
                          :title,
                          :author,
                          :description,
                          :format,
                          :yearPublished,
                          :publisher,
                          :image,
                          :costPrice,
                          :sellPrice,
                          :stockLevel,
                          :notes,
                          :featured
                        );';
        try {
            $this->dbConnection->beginTransaction();

            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':format', $this->format);
            $stmt->bindParam(':yearPublished', $this->yearPublished);
            $stmt->bindParam(':publisher', $this->publisher);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':costPrice', $this->costPrice);
            $stmt->bindParam(':sellPrice', $this->sellPrice);
            $stmt->bindParam(':stockLevel', $this->stockLevel);
            $stmt->bindParam(':notes', $this->notes);
            $stmt->bindParam(':featured', $this->featured);
            $stmt->execute();
            $this->productNo = $this->dbConnection->lastInsertId();

            $this->linkBookAndCategory();

            $this->dbConnection->commit();
            $result = 'Successfully inserted new book! New product number is: ' . $this->productNo;

        } catch (\PDOException $e) {
            $this->dbConnection->rollBack();
            $result = 'There has been a problem with inserting new product. Please try again.';
        }

        return $result;
    }

    /**
     * searches for book that containing given string in author or title, return search results
     * if nothing give, defaults to null, and return all books
     *
     * @param string $searchString string to matched with book's title or author
     *
     * @return array $bookSearchResults
     */
    public function searchBooks($searchString = null)
    {
        if ($searchString == null) {
            $queryString = 'SELECT * FROM `book` ORDER BY `date_modified` DESC';
        } else {
            $searchString = '%' . $searchString . '%';
            $queryString = 'SELECT * FROM `book`
                        WHERE (title LIKE :searchString OR author LIKE :searchString)
                        ORDER BY `date_modified` DESC;';
        }
        try {
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindParam(':searchString', $searchString);
            $stmt->execute();

            $bookSearchResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $bookSearchResults = ['error' => 'There has been a problem with retrieving results. Please try again'];
        }

        return $bookSearchResults;
    }

    /**
     * updates featured column for given book id and returns array containing feedback message
     *
     * @param array $bookData array with keys as book ids and values of featured (0 or 1)
     *
     * @return array $updateResult
     */
    public function updateFeaturedBooks(Array $bookData)
    {
        if (!empty($bookData) && is_array($bookData)) {
            if (array_sum($bookData) > 21) {
                $updateResult = 'You have selected too many books to be featured. Maximum number allowed is 8. Please review and try again.';
            } else {
                foreach ($bookData as $productNo => $featured) {
                    $queryString = 'UPDATE `book` SET `featured` = :featured WHERE `id` = :id;';
                    try {
                        $stmt = $this->dbConnection->prepare($queryString);
                        $stmt->bindParam(':featured', $featured);
                        $stmt->bindParam(':id', $productNo);
                        $stmt->execute();
                        $updateResult = 'Successfully updated featured books';
                    } catch (\PDOException $e) {
                        $updateResult = 'There has been a problem with updating featured books. Please try again.';
                    }
                }
            }
        }

        return $updateResult;
    }

    /**
     * updates book record according to given array with book's information and returns array containing feedback
     * message
     *
     * @param array $bookData array containing book information
     *
     * @return array $updateResult
     */
    public function updateBook(Array $bookData)
    {
        $this->setBookProperties($bookData);
        $queryString = 'UPDATE `book` SET
                          `title` = :title,
                          `author` = :author,
                          `description` = :description,
                          `format_id` = :format,
                          `year_published` = :yearPublished,
                          `publisher` = :publisher,
                          `image` = :image,
                          `cost_price` = :costPrice,
                          `sell_price` = :sellPrice,
                          `stock_level` = :stockLevel,
                          `notes` = :notes
                        WHERE `id` = :productNo;';
        try {
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':format', $this->format);
            $stmt->bindParam(':yearPublished', $this->yearPublished);
            $stmt->bindParam(':publisher', $this->publisher);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':costPrice', $this->costPrice);
            $stmt->bindParam(':sellPrice', $this->sellPrice);
            $stmt->bindParam(':stockLevel', $this->stockLevel);
            $stmt->bindParam(':notes', $this->notes);
            $stmt->bindParam(':productNo', $this->productNo);

            $stmt->execute();
            $updateResult = 'Successfully updated book no ' . $this->productNo;

        } catch (\PDOException $e) {
            $updateResult = 'There has been a problem with updating the product. Please try again.';
        }

        return $updateResult;
    }

    /**
     * gets list of categories from database
     *
     * @return array $categories
     */
    public function getCategories()
    {
        $queryString = 'SELECT `id`, `name` FROM `category`';
        try {
            $stmt = $this->dbConnection->query($queryString);
            $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            $categories = ['error' => 'Error'];
        }

        return $categories;
    }

    /**
     * get list of formats from database
     *
     * @return array $formats
     */
    public function getFormats()
    {
        $queryString = 'SELECT `id`, `name` FROM `format`';
        try {
            $stmt = $this->dbConnection->query($queryString);
            $formats = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            $formats = ['error' => 'Error'];
        }

        return $formats;
    }

    /**
     * returns array of featured books
     *
     * @return array $featuredBooks
     */
    public function getFeaturedBooks()
    {
        $queryString = 'SELECT `id`, `title`, `author`, `featured`, `image`, `format_id` FROM `book` WHERE featured = 1;';

        try {
            $stmt = $this->dbConnection->query($queryString);
            $featuredBooks = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            $featuredBooks = ['error' => 'Error'];
        }

        return $featuredBooks;
    }

    /**
     * returns 10 recently updated books
     *
     * @return array $recentlyUpdatedBooks
     */
    public function getRecentlyUpdatedBooks()
    {
        $queryString = 'SELECT `id`, `title`, `author` FROM `book` ORDER BY `date_modified` DESC LIMIT 10';

        try {
            $stmt = $this->dbConnection->query($queryString);
            $recentlyUpdatedBooks = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            $recentlyUpdatedBooks = ['error' => 'Error'];
        }

        return $recentlyUpdatedBooks;
    }

    /**
     * gets book information by given product number
     *
     * @param integer $productNo
     *
     * @return array $bookData
     */
    public function getBookByProductNo($productNo)
    {
        $queryString = 'SELECT book.id as productNo,
                               `title`, `author`,
                               `description`,
                               `format_id`,
                               `year_published`,
                               `publisher`,
                               `image`,
                               `cost_price`,
                               `sell_price`,
                               `stock_level`,
                               `notes`,
                               `featured`,
                               book_category.category_id as category
                       FROM `book`
                       JOIN `book_category` ON book.id = book_category.book_id
                       WHERE book.id = :productNo;';

        try {
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindParam(':productNo', $productNo);
            $stmt->execute();
            $bookData = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $bookData = ['error' => 'Error'];
        }

        return $bookData;
    }

    /**
     * get book data from csv file and writes it into array
     *
     * @param resource $filePath
     *
     * @return array $booksCsvData
     */
    public function getBookDataFromCsvByRow($filePath)
    {
        if (($handle = fopen($filePath, "r")) !== false) {
            $row = 0;
            while (($csvData = fgetcsv($handle, 1000, ",")) !== false) {
                $booksCsvData[$row]['title'] = $csvData[0];
                $booksCsvData[$row]['author'] = $csvData[1];
                $booksCsvData[$row]['description'] = $csvData[3];
                $booksCsvData[$row]['format'] = $csvData[4];
                $booksCsvData[$row]['publisher'] = $csvData[9];
                $booksCsvData[$row]['costPrice'] = $csvData[5];
                $booksCsvData[$row]['sellPrice'] = $csvData[6];
                $booksCsvData[$row]['stockLevel'] = $csvData[7];
                $booksCsvData[$row]['yearPublished'] = $csvData[8];
                $booksCsvData[$row]['category'] = $csvData[2];
                $booksCsvData[$row]['notes'] = $csvData[10];
                $row++;
            }
            fclose($handle);
        }
        unset($booksCsvData['0']);

        return $booksCsvData;
    }

    /**
     * Gets category name by category id
     *
     * @param integer $categoryId the category id
     *
     * @return string $categoryName
     */
    public function getCategoryName($categoryId)
    {
        $queryString = 'SELECT `name` FROM `category` WHERE `id` = :categoryId;';
        try {
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindParam(':categoryId', $categoryId);
            $stmt->execute();
            $categoryName = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $categoryName = ['error' => 'Error'];
        }

        return $categoryName['name'];
    }

    /**
     * Gets format name by category id
     *
     * @param integer $formatId the format id
     *
     * @return string $formatName
     */
    public function getFormatName($formatId)
    {
        $queryString = 'SELECT `name` FROM `format` WHERE `id` = :formatId;';
        try {
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindParam(':formatId', $formatId);
            $stmt->execute();
            $formatName = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $formatName = ['error' => 'Error'];
        }

        return $formatName['name'];
    }

    /**
     * get stock level for given book id
     *
     * @param integer $bookId
     *
     * @return integer $stockLevel
     */
    public function getStockLevelByBookId($bookId)
    {
        $queryString = 'SELECT `stock_level` FROM `book` WHERE `id` = :bookId;';
        try {
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindParam(':bookId', $bookId);
            $stmt->execute();
            $stockLevel = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $stockLevel = ['error' => 'Error'];
        }

        return $stockLevel['stock_level'];
    }

    /**
     * checks the stock level and returns empty string if stock > 0, or message if stock = 0
     *
     * @param integer $stockLevel
     *
     * @return string $availabilityMessage
     */
    public function isAvailable($stockLevel)
    {
        $availabilityMessage = '';
        if (!$stockLevel) {
            $availabilityMessage = 'Item is currently of ouf stock';
        }

        return $availabilityMessage;
    }

    /**
     * gets book id of the same book (by title and author) but different id
     *
     * @param string  $title    book's title
     * @param string  $author   book's author
     * @param integer $formatId book's format id
     */
    public function getBookIdOfDifferentFormat($title, $author, $formatId)
    {
        $queryString = 'SELECT `id`  FROM `book` WHERE NOT `format_id` = :formatId AND `title` = :title AND `author` = :author;';

        try {
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindParam(':formatId', $formatId);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':author', $author);
            $stmt->execute();
            $book = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $book = ['error' => 'Error'];
        }

        return $book['id'];
    }

    /**
     * deletes book from both category table and book table
     *
     * @param $bookId
     *
     * @return $result
     */
    public function deleteBook($bookId)
    {

        $this->dbConnection->beginTransaction();

        $queryString = 'DELETE FROM `book_category` WHERE `book_id` = :bookId;';

        $queryString2 = 'DELETE FROM `book` WHERE `id` = :bookId;';

        try {
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindParam(':bookId', $bookId);
            $stmt->execute();

            $stmt2 = $this->dbConnection->prepare($queryString2);
            $stmt2->bindParam(':bookId', $bookId);
            $stmt2->execute();

            $this->dbConnection->commit();
            $deleteResult = 'Successfully deleted book no ' . $bookId;
        } catch (\PDOException $e) {
            $this->dbConnection->rollBack();
            $deleteResult = 'Error';
        }

        return $deleteResult;
    }

    /**
     * links book and category by their ids
     *
     * @return string $result
     */
    private function linkBookAndCategory()
    {
        $queryString = 'INSERT INTO `book_category` (`book_id`, `category_id`) VALUES (:productNo, :categoryId);';
        try {
            $stmt = $this->dbConnection->prepare($queryString);
            $stmt->bindValue(':productNo', $this->productNo);
            $stmt->bindValue(':categoryId', $this->category);
            $stmt->execute();
            $result = 'Success';
        } catch (\PDOException $e) {
            $result = 'Error';

        }

        return $result;
    }
}
