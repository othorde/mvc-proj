<?php

declare(strict_types=1);

namespace App\Dice;

use App\Entity\Yatzy;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

trait PlayersTrait
{

    /* alla spelar namn och id  */
    public function setAllPlayers($yatzyArr) {
        
        $this->allPlayers = [];

        foreach ($yatzyArr as $nameAndId) {
            $this->allPlayers[$nameAndId->getId()] = $nameAndId->getName();
        }
        $this->setAllPlayersId($yatzyArr); /* sätter denna samtidigt så slipper jag kalla från router */
    }

    public function getAllPlayers(): array {
        return $this->allPlayers;
    }


    /* alla spelar endast id  */


    public function setAllPlayersId($yatzyArr): void {
        $this->allPlayersId = [];

        foreach ($yatzyArr as $nameAndId) {
            array_push($this->allPlayersId, $nameAndId->getId());
        }
    }

    public function getAllPlayersId(): array {
        return $this->allPlayers;
    }

    /* hämta en specifik spelare  */


    public function getSpecificPlayer($id): int {
        return $this->allPlayersId[$id];
    }
    /* hämta antal spelare  */

    public function getNumberOfPlayers(): int {
        return count($this->allPlayersId);
    }

    /* ändra vems tur det är, ändras av whatThrow == 3 */
    public function setPlayerTurn(): void {

        if (!isset($this->playersTurnId)) { // om ej satt sätt till 0
            $this->playersTurnId = 0;
            echo("HÄÄÄÄÄÄR1");

        }  if($this->playersTurnId + 1 == ($this->getNumberOfPlayers())) {
            echo("HÄÄÄÄÄÄR2");
            $this->playersTurnId = 0;
        } else {
            echo("HÄÄÄÄÄÄR3");

            $this->playersTurnId += 1;
        }
    }

    public function getPlayerTurn(): int {

        if (!isset($this->playersTurnId)) {
            $this->playersTurnId = 0;
        }
        return $this->playersTurnId;
    }



}


    /* public function __construct($arrOfId) // ändra från att ta $faces som inparameter till hårdkordat värde på 6
    {
        $this->players = $arrOfId;
    }

    public function getAllIdPlayers(): array
    {
        return $this->players;
    }

    public function getNextPlayer($nr): int
    {
        if (isset($this->players[$nr])) {
            return $this->players[$nr];
        } else {
            return $this->players[0];
        }
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
    } */
    

