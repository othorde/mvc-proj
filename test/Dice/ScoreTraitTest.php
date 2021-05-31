<?php

declare(strict_types=1);

namespace App\Dice;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use App\Entity\Yatzy;

/**
 * Test cases for the controller Sample.
 */
class ScoreTraitTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new YatzyGame(5, 0, 0);
        $this->assertInstanceOf("\App\Dice\YatzyGame", $controller);
    }

    public function testsetValue2SaveFromPost()
    {
        $controller = new YatzyGame(5, 0, 0);
        $arr = ["3","5","2","1"];
        $hej = $controller->setValue2SaveFromPost($arr);
        $hej = $controller->getValue2SaveFromPost();
        $this->assertSame($hej, 5);
    }

    public function testcheckIfPair()
    {
        $controller = new YatzyGame(5, 0, 0);
        $arr = ["3","5","2","1","1"];
        $hej = $controller->checkIfPair($arr);
        $this->assertSame($hej[0], 2);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.par = :score WHERE y.id = :id');
    }

    public function testcheckIfPairPair()
    {
        $controller = new YatzyGame(5, 0, 0);
        $arr = ["3","2","2","1","1"];
        $hej = $controller->checkIfTwoPair($arr);
        $this->assertSame($hej[0], true);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.parpar = :score WHERE y.id = :id');

        $arr = ["1","1","2","2","3"];
        $hej = $controller->checkIfTwoPair($arr);
        $this->assertSame($hej[0], 6);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.parpar = :score WHERE y.id = :id');

        $arr = ["2","2","3","1","1"];
        $hej = $controller->checkIfTwoPair($arr);
        $this->assertSame($hej[0], 8);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.parpar = :score WHERE y.id = :id');
    }

    public function testcheckIfThreesame()
    {
        $controller = new YatzyGame(5, 0, 0);
        $arr = ["3","3","3","1","1"];
        $hej = $controller->checkIfThreeSame($arr);
        $this->assertSame($hej[0], 9);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.tretal = :score WHERE y.id = :id');

        $arr = ["1","1","2","2","2"];
        $hej = $controller->checkIfThreeSame($arr);
        $this->assertSame($hej[0], 6);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.tretal = :score WHERE y.id = :id');

        $arr = ["3","4","6","6","6"];
        $hej = $controller->checkIfThreeSame($arr);
        $this->assertSame($hej[0], 18);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.tretal = :score WHERE y.id = :id');

        $arr = ["3","1","1","1","6"];
        $hej = $controller->checkIfThreeSame($arr);
        $this->assertSame($hej[0], 3);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.tretal = :score WHERE y.id = :id');
    }


    public function testcheckIfFourSame()
    {
        $controller = new YatzyGame(5, 0, 0);
        $arr = ["1","1","1","1","2"];
        $hej = $controller->checkIfFourSame($arr);
        $this->assertSame($hej[0], 4);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.fyrtal = :score WHERE y.id = :id');

        $arr = ["1","3","3","3","3"];
        $hej = $controller->checkIfFourSame($arr);
        $this->assertSame($hej[0], 12);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.fyrtal = :score WHERE y.id = :id');
    }

    public function testcheckIfStraight()
    {
        $controller = new YatzyGame(5, 0, 0);
        $arr = ["1","2","3","4","5"];
        $hej = $controller->checkIfStraight($arr);
        $this->assertSame($hej[0], 15);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.straight = :score WHERE y.id = :id');

        $arr = ["2","3","4","5","6"];
        $hej = $controller->checkIfStraight($arr);
        $this->assertSame($hej[0], 0);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.straight = :score WHERE y.id = :id');
    }

    public function testcheckIfSStraight()
    {
        $controller = new YatzyGame(5, 0, 0);
        $arr = ["2","3","4","5","6"];
        $hej = $controller->checkIfSStraight($arr);
        $this->assertSame($hej[0], 20);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.sstraight = :score WHERE y.id = :id');

        $arr = ["1","2","3","4","5"];
        $hej = $controller->checkIfSStraight($arr);
        $this->assertSame($hej[0], 0);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.sstraight = :score WHERE y.id = :id');
    }

    public function testcheckIfKak()
    {
        $controller = new YatzyGame(5, 0, 0);
        $arr = ["2","2","2","5","5"];
        $hej = $controller->checkIfKak($arr);
        $this->assertSame($hej[0], 16);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.kak = :score WHERE y.id = :id');

        $arr = ["3","3","4","4","4"];
        $hej = $controller->checkIfKak($arr);
        $this->assertSame($hej[0], 18);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.kak = :score WHERE y.id = :id');

        $arr = ["3","2","3","2","4"];
        $hej = $controller->checkIfKak($arr);
        $this->assertSame($hej[0], 0);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.kak = :score WHERE y.id = :id');
    }

    public function testcheckIfChance()
    {
        $controller = new YatzyGame(5, 0, 0);
        $arr = ["2","2","2","5","5"];
        $hej = $controller->checkIfChance($arr);
        $this->assertSame($hej[0], 16);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.chans = :score WHERE y.id = :id');

        $arr = ["3","3","2","1","4"];
        $hej = $controller->checkIfChance($arr);
        $this->assertSame($hej[0], 13);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.chans = :score WHERE y.id = :id');

        $arr = ["6","2","6","2","4"];
        $hej = $controller->checkIfChance($arr);
        $this->assertSame($hej[0], 20);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.chans = :score WHERE y.id = :id');
    }

    public function testcheckIfYatzy()
    {
        $controller = new YatzyGame(5, 0, 0);
        $arr = ["2","2","2","2","2"];
        $hej = $controller->checkIfYatzy($arr);
        $this->assertSame($hej[0], 100);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.yatzy = :score WHERE y.id = :id');

        $arr = ["3","3","2","1","4"];
        $hej = $controller->checkIfYatzy($arr);
        $this->assertSame($hej[0], 0);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.yatzy = :score WHERE y.id = :id');

        $arr = ["4","4","4","4","4"];
        $hej = $controller->checkIfYatzy($arr);
        $this->assertSame($hej[0], 100);
        $this->assertSame($hej[2], 'UPDATE App\Entity\Yatzy y SET y.yatzy = :score WHERE y.id = :id');
    }
}
