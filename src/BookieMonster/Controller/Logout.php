<?php

namespace BookieMonster\Controller;

/**
 * Class Logout
 *
 * @package BookieMonster\Controller
 */
class Logout
{
    public function __construct()
    {
        session_destroy();
    }
}
