<?php

$app->get(
    '/',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
        $db = $dbConnection->getDBConnection();
        $book = new BookieMonster\Model\Book($db);

        $allBooks = $book->searchBooks();
        $featuredBooks = $book->getFeaturedBooks();
        if (empty($_SESSION['basket']['products'])) {
            $_SESSION['basket']['products'] = [];
        }

        $totalItems = array_sum(array_column($_SESSION['basket']['products'], 'qty'));

        return $this->renderer->render(
            $response,
            'index.phtml',
            [
                'allBooks'          => $allBooks,
                'featuredBooks'     => $featuredBooks,
                'totalItems'        => $totalItems,
                'addToBasketResult' => true,
            ]
        );
    }
);

$app->post(
    '/',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
        $db = $dbConnection->getDBConnection();
        $book = new BookieMonster\Model\Book($db);

        $allBooks = $book->searchBooks();
        $featuredBooks = $book->getFeaturedBooks();

        if (empty($_SESSION['basket']['products'])) {
            $_SESSION['basket']['products'] = [];
        }
        $basketController = new BookieMonster\Controller\Basket();
        $addToBasketResult = $basketController->addToBasket(
            $_POST['productId'],
            $_POST['qty'],
            $book->getStockLevelByBookId($_POST['productId'])
        );
        $totalItems = array_sum(array_column($_SESSION['basket']['products'], 'qty'));

        return $this->renderer->render(
            $response,
            'index.phtml',
            [
                'allBooks'          => $allBooks,
                'featuredBooks'     => $featuredBooks,
                'totalItems'        => $totalItems,
                'addToBasketResult' => $addToBasketResult,
            ]
        );
    }
);

$app->get(
    '/product/{id:[1-9][0-9]*}',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {

        $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
        $db = $dbConnection->getDBConnection();

        $book = new BookieMonster\Model\Book($db);
        $productNo = $args['id'];
        $bookData = $book->getBookByProductNo($productNo);
        $categoryName = $book->getCategoryName($bookData['category']);
        $formatName = ucfirst($book->getFormatName($bookData['format_id']));
        $availabilityMessage = $book->isAvailable($bookData['stock_level']);
        $otherFormatBookId = $book->getBookIdOfDifferentFormat(
            $bookData['title'],
            $bookData['author'],
            $bookData['format_id']
        );
        if (empty($_SESSION['basket']['products'])) {
            $_SESSION['basket']['products'] = [];
        }
        $totalItems = array_sum(array_column($_SESSION['basket']['products'], 'qty'));

        return $this->renderer->render(
            $response,
            'shopFrontProductPage.phtml',
            [
                'bookData'            => $bookData,
                'categoryName'        => $categoryName,
                'formatName'          => $formatName,
                'availabilityMessage' => $availabilityMessage,
                'otherFormatBookId'   => $otherFormatBookId,
                'totalItems'          => $totalItems,
                'maxQtyReachedMsg'    => null,
            ]
        );
    }
);

$app->post(
    '/product/{id:[1-9][0-9]*}',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {

        $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
        $db = $dbConnection->getDBConnection();

        $book = new BookieMonster\Model\Book($db);
        $productNo = $args['id'];
        $bookData = $book->getBookByProductNo($productNo);
        $categoryName = $book->getCategoryName($bookData['category']);
        $formatName = ucfirst($book->getFormatName($bookData['format_id']));
        $availabilityMessage = $book->isAvailable($bookData['stock_level']);
        $otherFormatBookId = $book->getBookIdOfDifferentFormat(
            $bookData['title'],
            $bookData['author'],
            $bookData['format_id']
        );
        if (empty($_SESSION['basket']['products'])) {
            $_SESSION['basket']['products'] = [];
        }
        $basketController = new BookieMonster\Controller\Basket();
        $result = $basketController->addToBasket(
            $_POST['productId'],
            $_POST['qty'],
            $bookData['stock_level']
        );
        $maxQtyReachedMsg = $basketController->getMaxQtyReachedMsg($result);
        $totalItems = array_sum(array_column($_SESSION['basket']['products'], 'qty'));

        return $this->renderer->render(
            $response,
            'shopFrontProductPage.phtml',
            [
                'bookData'            => $bookData,
                'categoryName'        => $categoryName,
                'formatName'          => $formatName,
                'availabilityMessage' => $availabilityMessage,
                'otherFormatBookId'   => $otherFormatBookId,
                'totalItems'          => $totalItems,
                'maxQtyReachedMsg'    => $maxQtyReachedMsg,
            ]
        );
    }
);

$app->get(
    '/basket',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
        $db = $dbConnection->getDBConnection();
        $book = new BookieMonster\Model\Book($db);

        if (empty($_SESSION['basket']['products'])) {
            $_SESSION['basket']['products'] = [];
        }
        $basket = new BookieMonster\Model\Basket($_SESSION['basket']['products']);
        $basketController = new BookieMonster\Controller\Basket();
        $booksInABasket = $basket->getBooksInABasket($book);
        $totalItems = array_sum(array_column($basket->products, 'qty'));
        $totalToPay = $basketController->getTotalToPay($booksInABasket);

        return $this->renderer->render(
            $response,
            'shopFrontBasket.phtml',
            [
                'totalItems'          => $totalItems,
                'booksInABasket'      => $booksInABasket,
                'totalToPay'          => $totalToPay,
                'availabilityMessage' => null,
            ]
        );
    }
);

$app->post(
    '/basket',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
        $db = $dbConnection->getDBConnection();
        $book = new BookieMonster\Model\Book($db);

        if (empty($_SESSION['basket']['products'])) {
            $_SESSION['basket']['products'] = [];
        }
        $basket = new BookieMonster\Model\Basket($_SESSION['basket']['products']);
        $basketController = new BookieMonster\Controller\Basket();

        $result = $basketController->updateBasket(
            $_POST['productId'],
            $_POST['qty'],
            $_SESSION['basket']['products'][$_POST['productId']]['qty'],
            $book->getStockLevelByBookId($_POST['productId'])
        );
        $basket->products = $_SESSION['basket']['products'];
        $booksInABasket = $basket->getBooksInABasket($book);
        $totalItems = array_sum(array_column($basket->products, 'qty'));
        $maxQtyReachedMsg = $basketController->getMaxQtyReachedMsg($result);
        $totalToPay = $basketController->getTotalToPay($booksInABasket);

        return $this->renderer->render(
            $response,
            'shopFrontBasket.phtml',
            [
                'totalItems'          => $totalItems,
                'booksInABasket'      => $booksInABasket,
                'totalToPay'          => $totalToPay,
                'availabilityMessage' => $maxQtyReachedMsg,
            ]
        );
    }
);

$app->post(
    '/checkout',
    function ($request, $response, $args) {
        if (empty($_SESSION['basket']['products'])) {
            $_SESSION['basket']['products'] = [];
        }
        $_SESSION['basket']['total'] = $_POST['total'];
        $totalItems = array_sum(array_column($_SESSION['basket']['products'], 'qty'));

        return $this->renderer->render(
            $response,
            'shopFrontCheckout.phtml',
            ['totalItems' => $totalItems,]
        );
    }
);

$app->post(
    '/confirmation',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
        $db = $dbConnection->getDBConnection();
        $orderDetails = $_POST;

        $order = new BookieMonster\Model\Order($_SESSION['basket']['products'], $_SESSION['basket']['total'], $db);
        $orderController = new BookieMonster\Controller\Order();
        $requiredFieldsResults = $orderController->checkRequiredFields($orderDetails);
        $fieldValidationResults = $orderController->validateBookData($orderDetails);
        if ($requiredFieldsResults['validated'] && $fieldValidationResults['validated']) {
            $result = $order->addOrder($orderDetails);
        }

        unset($_SESSION['basket']['products']);

        if (empty($_SESSION['basket']['products'])) {
            $_SESSION['basket']['products'] = [];
        }
        $totalItems = array_sum(array_column($_SESSION['basket']['products'], 'qty'));

        return $this->renderer->render(
            $response,
            'shopFrontConfirmation.phtml',
            ['result' => $result, 'totalItems' => $totalItems,]
        );
    }
);

$app->get(
    '/adminDashboard',
    function ($request, $response, $args) {
        session_destroy();
        ini_set('session.gc_maxlifetime', 7200);
        session_start();

        return $this->renderer->render($response, 'adminDashboard.phtml', $args);
    }
);

$app->get(
    '/adminDashboard/Home',
    function ($request, $response, $args) {
        //check session variables and decide where to send user
        if (isset($_SESSION['user']) && $_SESSION['loggedIn']) {
            return $this->renderer->render($response, 'adminDashboardHome.phtml', $args);
        } else {
            header('Location: http://0.0.0.0:8080/adminDashboard');
            exit;
        }
    }
);

$app->post(
    '/adminDashboard/Home',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
        $db = $dbConnection->getDBConnection();
        $loginAttempt = new BookieMonster\Controller\Login($db);
        $loginAttempt->setUserCredentials($_POST['username'], $_POST['password']);
        $loginAttempt->verifyLogin();
        if (isset($_SESSION['user']) && $_SESSION['loggedIn']) {
            return $this->renderer->render($response, 'adminDashboardHome.phtml', $args);
        } else {
            header('Location: http://0.0.0.0:8080/adminDashboard');
            exit;
        }
    }
);

$app->get(
    '/adminDashboard/AddBook',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        if (isset($_SESSION['user']) && $_SESSION['loggedIn']) {
            $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
            $db = $dbConnection->getDBConnection();
            $book = new BookieMonster\Model\Book($db);
            $categories = $book->getCategories();
            $formats = $book->getFormats();

            return $this->renderer->render(
                $response,
                'adminDashboardAddBook.phtml',
                ['categories' => $categories, 'formats' => $formats, 'result' => null]
            );
        } else {
            header('Location: http://0.0.0.0:8080/adminDashboard');
            exit;
        }
    }
);

$app->post(
    '/adminDashboard/AddBook',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        if (isset($_SESSION['user']) && $_SESSION['loggedIn']) {
            $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
            $db = $dbConnection->getDBConnection();
            $book = new BookieMonster\Model\Book($db);
            $categories = $book->getCategories();
            $formats = $book->getFormats();
            $bookData = $_POST;
            $bookController = new BookieMonster\Controller\Book();
            $imageValidationResult = $bookController->validateImageFile($_FILES);
            $requiredFieldsResults = $bookController->checkRequiredFields($bookData);
            $fieldValidationResults = $bookController->validateBookData($bookData);

            if ($imageValidationResult ['validated'] &&
                $requiredFieldsResults['validated'] &&
                $fieldValidationResults['validated']
            ) {
                if (($bookController->getImageFileName($_FILES) === null)) {
                    $bookData['image'] = 'default.png';
                } else {
                    $bookData['image'] = $bookController->getImageFileName($_FILES);
                    move_uploaded_file(
                        $_FILES['image']['tmp_name'],
                        __DIR__ . '/../public/img/uploadedimg/' . $bookData['image']
                    );
                }
                $result = $book->addNewBook($bookData);
            } else {
                $result = 'Data did not pass validation. please make sure all required fields have been filled in correctly and try again.';
            }

            return $this->renderer->render(
                $response,
                'adminDashboardAddBook.phtml',
                ['result' => $result, 'categories' => $categories, 'formats' => $formats]
            );
        } else {
            header('Location: http://0.0.0.0:8080/adminDashboard');
            exit;
        }
    }
);
$app->get(
    '/adminDashboard/EditBook',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        if (isset($_SESSION['user']) && $_SESSION['loggedIn']) {
            $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
            $db = $dbConnection->getDBConnection();
            $book = new BookieMonster\Model\Book($db);
            $searchInput = null;
            if (array_key_exists('search-input', $_GET)) {
                $searchInput = $_GET['search-input'];
                $recentlyUpdatedBooks = $book->searchBooks($searchInput);
            } else {
                $recentlyUpdatedBooks = $book->getRecentlyUpdatedBooks();
            }

            return $this->renderer->render(
                $response,
                'adminDashboardEditBookFindBook.phtml',
                ['recentlyUpdatedBooks' => $recentlyUpdatedBooks, 'searchInput' => $searchInput, 'result' => null]
            );
        } else {
            header('Location: http://0.0.0.0:8080/adminDashboard');
            exit;
        }
    }
);

$app->get(
    '/adminDashboard/EditBook/{id:[1-9][0-9]*}',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        if (isset($_SESSION['user']) && $_SESSION['loggedIn']) {
            $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
            $db = $dbConnection->getDBConnection();
            $book = new BookieMonster\Model\Book($db);
            $categories = $book->getCategories();
            $formats = $book->getFormats();
            $productNo = $args['id'];
            $bookData = $book->getBookByProductNo($productNo);

            return $this->renderer->render(
                $response,
                'adminDashboardEditBook.phtml',
                ['categories' => $categories, 'formats' => $formats, 'bookData' => $bookData, 'result' => null]
            );
        } else {
            header('Location: http://0.0.0.0:8080/adminDashboard');
            exit;
        }
    }
);

$app->post(
    '/adminDashboard/EditBook',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        if (isset($_SESSION['user']) && $_SESSION['loggedIn']) {
            $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
            $db = $dbConnection->getDBConnection();
            $book = new BookieMonster\Model\Book($db);
            $result = null;
            if (isset($_POST['deleteId'])) {
                $result = $book->deleteBook($_POST['deleteId']);
                unset($_POST['deleteId']);
            }
            $searchInput = null;
            if (array_key_exists('search-input', $_GET)) {
                $searchInput = $_GET['search-input'];
                $recentlyUpdatedBooks = $book->searchBooks($searchInput);
            } else {
                $recentlyUpdatedBooks = $book->getRecentlyUpdatedBooks();
            }

            return $this->renderer->render(
                $response,
                'adminDashboardEditBookFindBook.phtml',
                ['recentlyUpdatedBooks' => $recentlyUpdatedBooks, 'searchInput' => $searchInput, 'result' => $result]
            );
        } else {
            header('Location: http://0.0.0.0:8080/adminDashboard');
            exit;
        }
    }
);

$app->post(
    '/adminDashboard/ManageFeatured',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        if (isset($_SESSION['user']) && $_SESSION['loggedIn']) {
            $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
            $db = $dbConnection->getDBConnection();
            $book = new BookieMonster\Model\Book($db);
            $bookData = $_POST['featuredBooks'];
            $result = $book->updateFeaturedBooks($bookData);
            $searchInput = null;
            $featuredBooks = $book->getFeaturedBooks();
            foreach ($featuredBooks as &$featuredBook) {
                $featuredBook['format'] = ucfirst($book->getFormatName($featuredBook['format_id']));
                unset($featuredBook['format_id']);
            }
            $tableTitle = 'Current Featured Books...';
            $searchBoxValue = '';
            if ($searchInput === '') {
                $tableTitle = 'Displaying all books...';
            }
            if ($searchInput) {
                $searchBoxValue = $searchInput;
                $tableTitle = 'Found ' . count($featuredBooks) . ' results for "' . $searchInput . '":';
            }

            return $this->renderer->render(
                $response,
                'adminDashboardManageFeatured.phtml',
                [
                    'featuredBooks'  => $featuredBooks,
                    'searchInput'    => $searchInput,
                    'result'         => $result,
                    'tableTitle'     => $tableTitle,
                    'searchBoxValue' => $searchBoxValue,
                ]
            );
        } else {
            header('Location: http://0.0.0.0:8080/adminDashboard');
            exit;
        }
    }
);

$app->get(
    '/adminDashboard/ManageFeatured',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        if (isset($_SESSION['user']) && $_SESSION['loggedIn']) {
            $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
            $db = $dbConnection->getDBConnection();
            $book = new BookieMonster\Model\Book($db);
            $searchInput = null;
            if (array_key_exists('search-input', $_GET)) {
                $searchInput = $_GET['search-input'];
                $featuredBooks = $book->searchBooks($searchInput);
                foreach ($featuredBooks as &$featuredBook) {
                    $featuredBook['format'] = ucfirst($book->getFormatName($featuredBook['format_id']));
                    unset($featuredBook['format_id']);
                }
            } else {
                $featuredBooks = $book->getFeaturedBooks();

                foreach ($featuredBooks as &$featuredBook) {
                    $featuredBook['format'] = ucfirst($book->getFormatName($featuredBook['format_id']));
                    unset($featuredBook['format_id']);
                }
            }
            $tableTitle = 'Current Featured Books...';
            $searchBoxValue = '';
            if ($searchInput === '') {
                $tableTitle = 'Displaying all books...';
            }
            if ($searchInput) {
                $searchBoxValue = $searchInput;
                $tableTitle = 'Found ' . count($featuredBooks) . ' results for "' . $searchInput . '":';
            }

            return $this->renderer->render(
                $response,
                'adminDashboardManageFeatured.phtml',
                [
                    'featuredBooks'  => $featuredBooks,
                    'searchInput'    => $searchInput,
                    'result'         => null,
                    'tableTitle'     => $tableTitle,
                    'searchBoxValue' => $searchBoxValue,
                ]
            );
        } else {
            header('Location: http://0.0.0.0:8080/adminDashboard');
            exit;
        }
    }
);

$app->post(
    '/adminDashboard/csvUpload',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        if (isset($_SESSION['user']) && $_SESSION['loggedIn']) {
            $dbConnection = new BookieMonster\Model\DbConnection($serverName, $dbName, $userName, $password);
            $db = $dbConnection->getDBConnection();
            $book = new BookieMonster\Model\Book($db);
            $bookController = new BookieMonster\Controller\Book();
            if ($_FILES['csv']['error'] == 0) {
                if ($bookController->validateCsvFile($_FILES)) {
                    $csvFilePath = __DIR__ . '/../data/uploadedCsv/' . $bookController->setCsvFileName($_FILES);
                    move_uploaded_file(
                        $_FILES['csv']['tmp_name'],
                        $csvFilePath
                    );
                    $booksCsvData = $book->getBookDataFromCsvByRow($csvFilePath);
                    $row = 0;
                    foreach ($booksCsvData as $bookData) {
                        $row++;
                        $requiredFieldsResults = $bookController->checkRequiredFields($bookData);
                        $fieldValidationResults = $bookController->validateBookData($bookData);
                        if ($requiredFieldsResults['validated'] && $fieldValidationResults['validated']) {
                            $result[$row]['success'] = $book->addNewBook($bookData);
                        } else {
                            $result[$row]['failure'] = 'Data in row ' . $row . ' did not pass validation.' . "</br>";
                            foreach ($requiredFieldsResults as $key => $field) {
                                if ($key == 'validated') {
                                    continue;
                                }
                                $result[$row]['failure'] .= $key . ' is required field.' . "</br>";
                            }
                            foreach ($fieldValidationResults as $key => $field) {
                                if ($key == 'validated') {
                                    continue;
                                }
                                $result[$row]['failure'] .= $key . ' field has invalid value' . "</br>";
                            }

                        }
                    }
                } else {
                    $result['failure'] = [0 => 'Invalid file'];
                }
            } else {
                $result['failure'] = [0 => 'No file Chosen'];
            }

            return $this->renderer->render(
                $response,
                'adminDashboardCsvUpload.phtml',
                ['results' => $result]
            );
        } else {
            header('Location: http://0.0.0.0:8080/adminDashboard');
            exit;
        }
    }
);

$app->get(
    '/adminDashboard/csvUpload',
    function ($request, $response, $args) use ($serverName, $dbName, $userName, $password) {
        if (isset($_SESSION['user']) && $_SESSION['loggedIn']) {
            return $this->renderer->render($response, 'adminDashboardCsvUpload.phtml', ['results' => []]);
        } else {
            header('Location: http://0.0.0.0:8080/adminDashboard');
            exit;
        }
    }
);
