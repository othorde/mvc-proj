<?php

declare(strict_types=1);

namespace App\Dice;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Sample.
 */
class YatzyGameTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new YatzyGame(2, 0, 0);
        $this->assertInstanceOf("\App\Dice\YatzyGame", $controller);
        $this->assertInstanceOf("\App\Dice\DiceHand", $controller);
    }

    /* testar sätta round till ett värde och ser om det är vad som retuneras av metoden
    Testar else satsen genom att skicka in värdet null, vilket innebär att värdet ej är satt enligt docs,
    vilket gör att jag testar else satsen */
    public function testGetRound()
    {
        $controller = new YatzyGame(2, 0, 0);
        $round = 0;
        $whatround = $controller->getRound();
        $this->assertSame($whatround, $round);

        $whatround = $controller->setRound(1);
        $round = 1;
        $this->assertSame($whatround, null);
    }


    public function testsetRound()
    {
        $controller = new YatzyGame(5, 0, 0);
        $controller->setThrow(1);
        $controller->setThrow(1);
        $controller->setThrow(1);
        $controller->setRound(1);

        $round = 1;
        $whatRound = $controller->getRound();
        $this->assertSame($whatRound, $round);
    }



    /* samma som ovan fast throws */
    public function testGetThrow()
    {
        $controller = new YatzyGame(5, 0, 0);
        $whatThrow = $controller->setThrow(1);
        $whatThrow = $controller->setThrow(1);

        $throw = 2;
        $whatThrow = $controller->getThrow();
        $this->assertSame($whatThrow, $throw);
    }

    public function testSetThrow()
    {
        $controller = new YatzyGame(5, 0, 0);
        $whatThrow = $controller->setThrow(1);
        $whatThrow = $controller->setThrow(1);
        $whatThrow = $controller->setThrow(1);

        $throw = 0;
        $whatThrow = $controller->getThrow();
        $this->assertSame($whatThrow, $throw);
    }

    /* testar att metoden gör om och tar bort KASTA samt retunerar rätt värde */
    public function testSavedDices()
    {
        $controller = new YatzyGame(5, 0, 0);
        array_push($_POST, "KASTA", "1", "2", "5", "3");
        $arr = ["dice-1", "dice-2", "dice-5", "dice-3"];

        $value3 = $controller->savedDices();
        $this->assertSame($value3, $arr);
    }

    public function testGetSum()
    {
        $controller = new YatzyGame(5, 0, 0);
        $getsum = $controller->getSum();
        $this->assertSame($getsum, 0);
    }

    public function testReturnMess()
    {
        $controller = new YatzyGame(5, 0, 0);
        $controller->setThrow(0);
        $returnMess = $controller->returnMess();
        $this->assertSame($returnMess, '');
    }

    public function testCheckScore()
    {
        $controller = new YatzyGame(5, 0, 0);
        array_push($_SESSION["savedDices"], 1, 2, 5, 3);
        $controller->whatRound = 3;
        $controller->whatThrow = 2;
        $getcheckScore = $controller->checkScore();
        $this->assertSame($getcheckScore, 0);
    }

    public function testgetFirstRound()
    {
        $controller = new YatzyGame(5, 0, 0);
        $_SESSION["start"] = "start";
        $getcheckScore = $controller->getFirstRound();
        $this->assertTrue($getcheckScore);

        $_SESSION["start"] = "notstart";
        $getcheckScore = $controller->getFirstRound();
        $this->assertFalse($getcheckScore);
    }

    public function testcountNrOfDieToThrow()
    {
        $controller = new YatzyGame(5, 0, 0);
        $nrOfDie2ThrowNext = $controller->countNrOfDieToThrow();
        $this->assertSame($nrOfDie2ThrowNext, 1);
        $_POST = null;
        $nrOfDie2ThrowNext = $controller->countNrOfDieToThrow();
        $this->assertSame($nrOfDie2ThrowNext, 5);
    }
    public function testgetIfThrow()
    {
        $controller = new YatzyGame(5, 0, 0);
        $returnBool = $controller->getIfThrow();
        $this->assertFalse($returnBool);

        $_POST["kasta"] = "KASTA";
        $returnBool = $controller->getIfThrow();
        $this->assertTrue($returnBool);
    }

    public function testgetIfSave()
    {
        $controller = new YatzyGame(5, 0, 0);
        $returnBool = $controller->getIfSave();
        $this->assertFalse($returnBool);

        $_POST["save"] = "SPARA RESULTAT";
        $returnBool = $controller->getIfSave();
        $this->assertTrue($returnBool);
    }
}
