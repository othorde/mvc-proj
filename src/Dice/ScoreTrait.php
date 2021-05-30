<?php

declare(strict_types=1);

namespace App\Dice;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity;

trait ScoreTrait
{

    public function getValue2SaveFromPost(): int
    {
        return $this->postValue;
    }

    public function setValue2SaveFromPost($postValue): void
    {
        $this->postValue = intval($postValue[1]);
    }

    public function getPlayerId(): int // denna hjälper bara till att ge ett id till varje funktion i detta tratit
    {
        $playerNumber = $this->getPlayerTurn(); // nummer på spelaren som spelar 0-4'
        $specificPlayerId = $this->getSpecificPlayer($playerNumber); // id på spelaren som spelar
        return $specificPlayerId;
    }

    /* funktionen skickar värden vidare beroende på hur stort det är */
    public function defineWhereToSendValue(): array
    {
        $value = $this->getValue2SaveFromPost();
        echo($value);

        if ($value <= 6) {
            return $this->valueOneToSix($value);
        } else if ($value > 6 && $value <= 18) {
            return $this->valueSixToEnd($value);
        }
    }

    /* ska fungera */
    public function valueOneToSix($value): array
    {
        $sumOfDie = 0;
        $diceHand = $this->getSavedAndOnHandDice();
        $ress = [3];
        foreach ($diceHand as $die) {
            if ($die === $value) {
                echo($value);
                $sumOfDie += $die;
            }
        }
        $ress[0] = $sumOfDie;
        $ress[1] = $this->getPlayerId();
        if ($value == 1) {
            $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.ettor = :score WHERE y.id = :id';
        } else if ($value == 2) {
            $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.tvaor = :score WHERE y.id = :id';
        } else if ($value == 3) {
            $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.treor = :score WHERE y.id = :id';
        } else if ($value == 4) {
            $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.fyror = :score WHERE y.id = :id';
        } else if ($value == 5) {
            $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.femmor = :score WHERE y.id = :id';
        } else {
            $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.sexor = :score WHERE y.id = :id';
        }
        return $ress;
    }

    public function valueSixToEnd($value): array
    {
        $diceHand = $this->getSavedAndOnHandDice();
        sort($diceHand);
        $result = [];

        switch ($value) {
            case "8":
                $result = $this->checkIfPair($diceHand);
                break;
            case "9":
                $result = $this->checkIfTwoPair($diceHand);
                break;
            case "10":
                $result = $this->checkIfThreeSame($diceHand);
                break;
            case "11":
                $result = $this->checkIfFourSame($diceHand);
                break;
            case "12":
                $result = $this->checkIfStraight($diceHand);
                break;
            case "13":
                $result = $this->checkIfSStraight($diceHand);
                break;
            case "14":
                $result = $this->checkIfKak($diceHand);
                break;
            case "15":
                $result = $this->checkIfChance($diceHand);
                break;
            case "16":
                $result = $this->checkIfYatzy($diceHand);
                break;
        }
        return $result;
    }

    public function checkIfPair($diceHand)
    {
        $ress = [3];
        $countValues = array_count_values($diceHand);

        foreach ($countValues as $value => $count) {
            if ($count > 1) {
                $result = $value + $value;
            }
        }
        $ress[0] = $result;
        $ress[1] = $this->getPlayerId();
        $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.par = :score WHERE y.id = :id';

        return $ress;
    }

    public function checkIfTwoPair($diceHand)
    {
        $ress = [3];
        $result = 0;
        if ($diceHand[0] == $diceHand[1] and $diceHand[2] == $diceHand[3]) {
            $result = ($diceHand[0] + $diceHand[1] + $diceHand[2] + $diceHand[3]);
        } else if ($diceHand[0] == $diceHand[1] and $diceHand[3] == $diceHand[4]) {
            $result = ($diceHand[0] + $diceHand[1] + $diceHand[2] + $diceHand[3]);
        } else if ($diceHand[1] == $diceHand[2] and $diceHand[3] == $diceHand[4]) {
            $result = ($diceHand[1] == $diceHand[2] and $diceHand[3] == $diceHand[4]);
        }
        $ress[0] = $result;
        $ress[1] = $this->getPlayerId();
        $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.parpar = :score WHERE y.id = :id';

        return $ress;
    }

    public function checkIfThreeSame($diceHand)
    {
        $ress = [3];
        $result = 0;

        if ($diceHand[0] == $diceHand[2]) {
            $result = $diceHand[0] + $diceHand[1] + $diceHand[2];
        } else if ($diceHand[1] == $diceHand[3]) {
            $result = $diceHand[1] + $diceHand[2] + $diceHand[3];
        } else if ($diceHand[2] == $diceHand[4]) {
            $result = $diceHand[2] + $diceHand[3] + $diceHand[4];
        }
        $ress[0] = $result;
        $ress[1] = $this->getPlayerId();
        $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.tretal = :score WHERE y.id = :id';

        return $ress;
    }

    public function checkIfFourSame($diceHand)
    {
        $result = 0;
        $ress = [3];
        if ($diceHand[0] == $diceHand[3]) {
            $result = $diceHand[0] + $diceHand[1] + $diceHand[2] + $diceHand[3];
        } else if ($diceHand[1] == $diceHand[4]) {
            $result = $diceHand[1] + $diceHand[2] + $diceHand[3] + $diceHand[4];
        }
        $ress[0] = $result;
        $ress[1] = $this->getPlayerId();
        $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.fyrtal = :score WHERE y.id = :id';

        return $ress;
    }

    public function checkIfStraight($diceHand)
    {
        $ress = [3];
        $iii = 1;
        $result = 0;
        $xxx = 0;

        for ($iii; $iii < count($diceHand) + 1; $iii++) {
            if ($iii == $diceHand[$xxx]) {
                $result += $iii;
            }/*  else {
                $result = 0;
            } */
            $xxx += 1;
        }
        $ress[0] = $result;
        $ress[1] = $this->getPlayerId();
        $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.straight = :score WHERE y.id = :id';

        return $ress;
    }

    public function checkIfSStraight($diceHand)
    {
        $ress = [3];
        $iii = 2;
        $result = 0;
        $xxx = 0;
        for ($iii; $iii < count($diceHand) + 2; $iii++) {
            if ($iii == $diceHand[$xxx]) {
                $result += $iii;
            } /* else {
                $result = 0;
            } */
            $xxx += 1;
        }
        $ress[0] = $result;
        $ress[1] = $this->getPlayerId();
        $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.sstraight = :score WHERE y.id = :id';

        return $ress;
    }

    public function checkIfKak($diceHand)
    {
        $ress = [3];
        if ($diceHand[0] == $diceHand[1] and $diceHand[1] == $diceHand[2]) {
            if ($diceHand[3] == $diceHand[4]) {
                $result = array_sum($diceHand);
            }
        } else if ($diceHand[0] == $diceHand[1]) {
            if ($diceHand[2] == $diceHand[3] and $diceHand[3] == $diceHand[4]) {
                $result = array_sum($diceHand);
            }
        }
        $ress[0] = $result;
        $ress[1] = $this->getPlayerId();
        $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.kak = :score WHERE y.id = :id';
        return $ress;
    }

    public function checkIfChance($diceHand)
    {
        $ress = [3];
        $result = 0;
        $result = array_sum($diceHand);
        $ress[0] = $result;
        $ress[1] = $this->getPlayerId();
        $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.chans = :score WHERE y.id = :id';
        return $ress;
    }

    public function checkIfYatzy($diceHand)
    {
        $ress = [3];
        $result = 0;
        if ($diceHand[0] == $diceHand[1] and $diceHand[2] == $diceHand[3]) {
            if ($diceHand[1] == $diceHand[2] && $diceHand[3] == $diceHand[4]) {
                $result = 100;
            }/*  else {
                $result = 0;
            } */
        }
        $ress[0] = $result;
        $ress[1] = $this->getPlayerId();
        $ress[2] = 'UPDATE App\Entity\Yatzy y SET y.yatzy = :score WHERE y.id = :id';
        return $ress;
    }
}
