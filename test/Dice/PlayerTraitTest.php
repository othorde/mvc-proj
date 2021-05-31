<?php

declare(strict_types=1);

namespace App\Dice;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use App\Entity\Yatzy;

/**
 * Test cases for the controller Sample.
 */
class PlayerTraitTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new YatzyGame(5, 0, 0);
        $this->assertInstanceOf("\App\Dice\YatzyGame", $controller);
    }

    public function testsetAllPlayers()
    {

        $controller = new YatzyGame(5, 0, 0);
        $hej = $controller->allPlayers = ["hej"];
        $getPlayer = $controller->getAllPlayers();
        $this->assertSame($getPlayer, $hej);

        $getPlayers = $controller->getAllPlayersId();
        $this->assertSame($getPlayers, $hej);
    }

    public function testgetSpecificPlayer()
    {
        $controller = new YatzyGame(5, 0, 0);
        $controller->allPlayersId = [2,3,4,1];
        $getPlayer = $controller->getSpecificPlayer(1);
        $this->assertSame($getPlayer, 3);

        $getPlayer = $controller->getSpecificPlayer(0);
        $this->assertSame($getPlayer, 2);

        $getPlayer = $controller->getSpecificPlayer(3);
        $this->assertSame($getPlayer, 1);

        $getPlayer = $controller->getSpecificPlayer(2);
        $this->assertSame($getPlayer, 4);
    }

    public function testgetNumberOfPlayers()
    {
        $controller = new YatzyGame(5, 0, 0);
        $controller->allPlayersId = [2,3,4,1];
        $nrOfPlayers = $controller->getNumberOfPlayers();
        $this->assertSame($nrOfPlayers, 4);
        $controller->allPlayersId = [1];
        $nrOfPlayers = $controller->getNumberOfPlayers();
        $this->assertSame($nrOfPlayers, 1);
    }

    public function testsetPlayerTurn()
    {
        $controller = new YatzyGame(5, 0, 0);
        $controller->allPlayersId = [2,3,4,1];
        $controller->playersTurnId = 0;
        $playerTurn = $controller->setPlayerTurn();
        $this->assertSame($playerTurn, null);
    }

    public function testgetPlayerTurn()
    {
        $controller = new YatzyGame(5, 0, 0);

        $playerTurn = $controller->getPlayerTurn();
        $this->assertSame($playerTurn, 0);

        $controller->playersTurnId = 1;
        $playerTurn = $controller->getPlayerTurn();
        $this->assertSame($playerTurn, 1);
    }
}
