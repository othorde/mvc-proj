<?php

declare(strict_types=1);

namespace App\Dice;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\{
    renderView,
    sendResponse
    };

class YatzyGame extends DiceHand
{
    use ScoreTrait;

    public ?int $sum;
    public ?int $whatRound = 0;
    public ?int $playerTurn = 0;
    public ?int $whatThrow = 0;

    public function __construct($nrOfDices, $sum, $roundValue, $nrOfPlayers)
    {
        $this->sum = $sum;
        $this->roundValue = $roundValue;
        $this->nrOfPlayers = $nrOfPlayers;

        parent::__construct($nrOfDices);
    }

    public function setThrow($number): void {
        
       
        if ($this->getThrow() === 3) {
            $this->whatThrow = 0;
        } else {
            $this->whatThrow = $this->whatThrow + 1;
        }
        if ($number == 0) {
            $this->whatThrow = 0;
        }
    }

    public function getThrow(): int {
        return $this->whatThrow;
    }

    public function setRound($changeRound): void {
        if ($this->whatThrow % 3 == 0 && $this->whatThrow != 0) {
            $this->whatRound = $this->whatRound + 1;
            

        } if ($changeRound == 1) {
            $this->whatRound = $this->whatRound + 1;
        }
    }

    public function getRound(): int {

        return $this->whatRound;
    }

    public function getPlayerTurn(): int {
        echo("GETPLAYERTURN");
        return $this->playerTurn;
    }

    public function setPlayerTurn($changeRound): void {
        if ($this->whatThrow == 3) {
            echo("HÄR 11");
            if ($this->playerTurn == $this->nrOfPlayers) {
                $this->playerTurn = 0;
                echo("HÄR 22");
            } else {
            $this->playerTurn += 1;
            }
        } else if ($changeRound == 1) {
            if ($this->playerTurn + 1 == $this->nrOfPlayers) {
                $this->playerTurn = 0;    
            } else {
                $this->playerTurn += 1;
            }
        }
    }

    public function getSavedAndOnHandDice(): array {
        if (isset($_SESSION["savedDices"])) {
            $savedDices = $_SESSION["savedDices"];
            $valueOnHandNotSaved = $this->getLastRollWithoutSum();

            foreach ($savedDices as $value){
                array_push($valueOnHandNotSaved, intval($value));
            }
        }
        return $valueOnHandNotSaved;
    }


    public function savedDices(): array
    {
        $savedDicesGraph = [];
        $savedDices = [];
        foreach ($_POST as $value) :
            if ($value != "KASTA") {
                array_push($savedDices, $value);
                array_push($savedDicesGraph, "dice-" . strval($value));
            }
        endforeach;
        $_SESSION["NrOfDicesToThrowNextRound"] = 5 - count($savedDices);
        $_SESSION["savedDices"] = $savedDices; //sparar undan arrayn i sessionen så att jag kan ta ut den i forloop i spelet

        return $savedDicesGraph;
    }

    public function checkScore(): int
    {
        $this->roundValue = 0;
        foreach ($_SESSION["savedDices"] as $value) :
            if ($this->whatRound == $value) {
/*                 $this->roundValue += $value;
 */            }
        endforeach;
        if ($this->whatThrow == 3) {
            $valueOnHandNotSaved = $this->getLastRollWithoutSum();

            foreach ($valueOnHandNotSaved as $value) {
                if ($this->whatRound == $value) {
                    $this->roundValue += $value;
                }
            }
            $this->sum += $this->roundValue;
        }
        return $this->roundValue;
    }

    public function getSum(): int
    {
        return $this->sum;
    }


    public function returnMess(): string
    {
        if ($this->getThrow() == 3) {
            $returnMess = "Nästa spelares tur, spara ditt resultat först. Låt sedan nästa spelare kasta.";
        } else {
            $returnMess = "";
        }
        return $returnMess;
    }

    public function getFirstRound(): bool{ /* startar spelet och lägger till i throws */

        if (isset($_SESSION) && $_SESSION["start"] == "start")
        {
            echo("START");
            $_SESSION["start"] = "";
            return true;
        }
        $_SESSION["savedDices"] = "";
        $_SESSION["NrOfDicesToThrowNextRound"] ="";
        return false;
    }

    public function countNrOfDieToThrow(): int { /*räknar hur många tärningar som ska kastas */

        if (empty($_POST)) {
            $this->nrOfDie2ThrowNext = 5;
        } else {
            $this->nrOfDie2ThrowNext = 6 - count($_POST); // 6 = 5 tärningar i arrayn plus "KASTA" därav 6
        }
        return $this->nrOfDie2ThrowNext;
    }

    public function getIfThrow(): bool { /* Om tärningarna kastas */

       if (isset($_POST["kasta"]) && $_POST["kasta"] == "KASTA") {
           return true;
       } else {
        return false;
       }
    }

    public function getIfSave(): bool { /*  Om tärningarna sparas */

        if (isset($_POST["save"]) && $_POST["save"] == "SPARA RESULTAT") {
            return true;
        } else {
         return false;
        }
    }
}
