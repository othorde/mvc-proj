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

    public function getPlayerId(): int
    {
        return $this->playerId;
    }

    public function setPlayerId($playerId): void
    {
        $this->playerId = $playerId;
    }

    /* funktionen skickar värden vidare beroende på hur stort det är */
    public function defineWhereToSendValue(): array
    {
        $value = $this->getValue2SaveFromPost();
        echo($value);

        if ($value <= 6) {
            return $this->valueOneToSix($value);
        } else if ($value > 6 && $value <= 18 ) {
            return $this->valueSixToEnd($value);
        } 
    }

    /* ska fungera */
    public function valueOneToSix($value): array {
        $sumOfDie = 0;
        $diceHand = $this->getSavedAndOnHandDice();
        $res = [];
        echo("VALUE 1---------6");
        foreach($diceHand as $die) {
            if ($die === $value) {
                echo($value);
                $sumOfDie += $die;
            }
        }
        $res[0] = $sumOfDie;
        $res[1] = $this->getPlayerId();
        if ($value == 1) {
            $res[2] = 'UPDATE App\Entity\Yatzy y SET y.ettor = :score WHERE y.id = :id';
        } else if ($value == 2) {
            $res[2] = 'UPDATE App\Entity\Yatzy y SET y.tvaor = :score WHERE y.id = :id';
        } else if ($value == 3) {
            $res[2] = 'UPDATE App\Entity\Yatzy y SET y.treor = :score WHERE y.id = :id';
        } else if ($value == 4) {
            $res[2] = 'UPDATE App\Entity\Yatzy y SET y.fyror = :score WHERE y.id = :id';
        } else if ($value == 5) {
            $res[2] = 'UPDATE App\Entity\Yatzy y SET y.femmor = :score WHERE y.id = :id';
        } else {
            $res[2] = 'UPDATE App\Entity\Yatzy y SET y.sexor = :score WHERE y.id = :id';
        }
        return $res;
    }

    public function valueSixToEnd($value): array {
        echo("VALUE". $value);

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

    public function checkIfPair($diceHand) {
        echo("PAIR");
        $res = [];
        $countValues = array_count_values($diceHand);

        foreach ($countValues as $value => $count) {
            if ($count > 1) {
                $result = $value + $value;
            }
        }
        $res[0] = $result;
        $res[1] = $this->getPlayerId();
        $res[2] = 'UPDATE App\Entity\Yatzy y SET y.par = :score WHERE y.id = :id';

        return $res;
    }

    public function checkIfTwoPair($diceHand) {
        $res = [];

        if ($diceHand[0] == $diceHand[1] and $diceHand[2] == $diceHand[3]) {
            $result = ($diceHand[0] + $diceHand[1] + $diceHand[2] + $diceHand[3]);
        } else if ($diceHand[0] == $diceHand[1] and $diceHand[3] == $diceHand[4]) {
            $result = ($diceHand[0] + $diceHand[1] + $diceHand[2] + $diceHand[3]);
        } else if ($diceHand[1] == $diceHand[2] and $diceHand[3] == $diceHand[4]){
            $result = ($diceHand[1] == $diceHand[2] and $diceHand[3] == $diceHand[4]);
        } else {
            $result = 0;
        }
        $res[0] = $result;
        $res[1] = $this->getPlayerId();
        $res[2] = 'UPDATE App\Entity\Yatzy y SET y.parpar = :score WHERE y.id = :id';

        return $res;
    }

    
    public function checkIfThreeSame($diceHand) {
        echo("threeee");
        $res = [];
        if ($diceHand[0] == $diceHand[2]) {
            $result = $diceHand[0] + $diceHand[1] + $diceHand[2];
        } else if ($diceHand[1] == $diceHand[3])  {
            $result = $diceHand[1] + $diceHand[2] + $diceHand[3];
        } else if ($diceHand[2] == $diceHand[4]) {
            $result = $diceHand[2] + $diceHand[3] + $diceHand[4];
        } else {
            $result = null;
        }
        $res[0] = $result;
        $res[1] = $this->getPlayerId();
        $res[2] = 'UPDATE App\Entity\Yatzy y SET y.tretal = :score WHERE y.id = :id';

        return $res;
    }


    

    public function checkIfFourSame($diceHand) {
        echo("FOUR");

        $res = [];
        if ($diceHand[0] == $diceHand[3]) {
            $result = $diceHand[0] + $diceHand[1] + $diceHand[2] + $diceHand[3];
        } else if ($diceHand[1] == $diceHand[4])  {
            $result = $diceHand[1] + $diceHand[2] + $diceHand[3] + $diceHand[4];
        } else {
            $result = 0;
        }
        $res[0] = $result;
        $res[1] = $this->getPlayerId();
        $res[2] = 'UPDATE App\Entity\Yatzy y SET y.fyrtal = :score WHERE y.id = :id';

        return $res;
    }

    public function checkIfStraight($diceHand) {
        echo("STRAIGHT");
        $res = [];
        $i = 1;
        $result = 0;
        $x = 0;

        for ($i; $i < count($diceHand) + 1; $i++) {
            if ($i == $diceHand[$x]) {
                $result += $i; 
                echo($result);

            } else { 
                $result = 0;
            }
            $x += 1;
        } 

        $res[0] = $result;
        $res[1] = $this->getPlayerId();
        $res[2] = 'UPDATE App\Entity\Yatzy y SET y.straight = :score WHERE y.id = :id';

        return $res;
    }

    public function checkIfSStraight($diceHand) {
        echo("SSTRAIGHT");
        $res = [];
        $i = 2;
        $result = 0;
        $x = 0;
        for ($i; $i < count($diceHand) + 2; $i++) {
            if ($i == $diceHand[$x]) {
                $result += $i; 
            } else { 
                $result = 0;
            }
            $x += 1;
        } 
        $res[0] = $result;
        $res[1] = $this->getPlayerId();
        $res[2] = 'UPDATE App\Entity\Yatzy y SET y.sstraight = :score WHERE y.id = :id';

        return $res;    
    }

    public function checkIfKak($diceHand) {
        echo("KAAAAAAK");

        $res = 0;
        if ($diceHand[0] == $diceHand[1] and $diceHand[1] == $diceHand[2]) {
            if ($diceHand[3] == $diceHand[4]) {
                $result = array_sum($diceHand);
            }
        } else if ($diceHand[0] == $diceHand[1]) {
            if ($diceHand[2] == $diceHand[3] and $diceHand[3] == $diceHand[4]) {
                $result = array_sum($diceHand);
            }
        }
    
        $res[0] = $result;
        $res[1] = $this->getPlayerId();
        $res[2] = 'UPDATE App\Entity\Yatzy y SET y.kak = :score WHERE y.id = :id';

        return $res;       
    }

    public function checkIfChance($diceHand) {
        echo("CHANCE");
        $result = 0;
        $result = array_sum($diceHand);
    
        $res[0] = $result;
        $res[1] = $this->getPlayerId();
        $res[2] = 'UPDATE App\Entity\Yatzy y SET y.chans = :score WHERE y.id = :id';    
        return $res;
    }



    public function checkIfYatzy($diceHand) {
        echo("YATZY");
        if ($diceHand[0] == $diceHand[1] and $diceHand[2] == $diceHand[3]) {
            if ($diceHand[1] == $diceHand[2] && $diceHand[3] == $diceHand[4]) {
                $result = 100;
            } else {
                $result = 0;
            }
        } else {
            $result = 0;
        }
        $res[0] = $result;
        $res[1] = $this->getPlayerId();
        $res[2] = 'UPDATE App\Entity\Yatzy y SET y.yatzy = :score WHERE y.id = :id';    
        return $res;    
    }
}
