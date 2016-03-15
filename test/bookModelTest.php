<?php
include '../config/localDbConnection.php';
include '../src/Model/BookModel.php';
include '../src/Model/DbConnection.php';

$bookData = [
    'productNo'     => 1,
    'title'         => 'mmmmm',
    'author'        => 'testy',
    'description'   => 'testy',
    'format'        => 1,
    'yearPublished' => '4321',
    'publisher'     => null,
    'image'         => null,
    'costPrice'     => 0.00,
    'sellPrice'     => 2.00,
    'stockLevel'    => 1,
    'category'      => '1',
    'notes'         => 'notes',
];


$dbConnection = new DbConnection($serverName, $dbName, $userName, $password);
$db = $dbConnection->getDBConnection();

$book = new Book($db);
//insert new book test
//$book->setBookProperties($bookData);
//$result = $book->addNewBook($bookData);
//var_dump($result);


//test search
//$results = $book->searchBooks();
//var_dump($results);
//foreach($results as $book){
//    echo $book['id'] . " | ";
//    echo $book['title'] . " | ";
//    echo $book['author'] . "<br>";
//}


//test update
//$updateResults = $book->updateBook($bookData);
//var_dump($updateResults);

//test update feature
//$bookData = [
//    1  => '1',
//    4  => '0',
//    5  => '0',
//    6  => '0',
//    7  => '0',
//    8  => '1',
//    9  => '1',
//    10 => '1',
//    11 => '1',
//    12 => '1',
//];
//$result = $book->updateFeaturedBooks($bookData);
//var_dump($result);
//$results = $book->searchBooks();
//foreach ($results as $book) {
//    echo $book['id'] . " | ";
//    echo $book['title'] . " | ";
//    echo $book['featured'] . "<br>";
//}
//var_dump($results);

//test getCategories
//$categories = $book->getCategories();
//var_dump($categories);
//
//foreach($categories as $category){
//    echo 'id: ' . $category['id'] . ' name: ' . $category['name'] . "<br>";
//}