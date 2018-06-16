<?php
/**
 * Created by PhpStorm.
 * User: MCH3730
 * Date: 09/06/2018
 * Time: 22:30
 */

namespace App\Service;


use Psr\Log\LoggerInterface;

class Greeting
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Greeting constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function greet(string $name): string
    {
        $this->logger->info("Greeted $name");
        return "Hello $name";
    }
}