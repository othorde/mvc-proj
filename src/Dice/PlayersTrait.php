<?php

declare(strict_types=1);

namespace App\Dice;

use App\Entity\Yatzy;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

trait PlayersTrait
{

    /* alla spelar namn och id  */
    public function setAllPlayers($yatzyArr)
    {
        $this->allPlayers = [];

        foreach ($yatzyArr as $nameAndId) {
            $this->allPlayers[$nameAndId->getId()] = $nameAndId->getName();
        }
        $this->setAllPlayersId($yatzyArr); /* sätter denna samtidigt så slipper jag kalla från router */
    }

    public function getAllPlayers(): array
    {
        return $this->allPlayers;
    }


    /* alla spelar endast id  */


    public function setAllPlayersId($yatzyArr): void
    {
        $this->allPlayersId = [];

        foreach ($yatzyArr as $nameAndId) {
            array_push($this->allPlayersId, $nameAndId->getId());
        }
    }

    public function getAllPlayersId(): array
    {
        return $this->allPlayers;
    }

    /* hämta en specifik spelare  */


    public function getSpecificPlayer($idd): int
    {
        return $this->allPlayersId[$idd];
    }
    /* hämta antal spelare  */

    public function getNumberOfPlayers(): int
    {
        return count($this->allPlayersId);
    }

    /* ändra vems tur det är, ändras av whatThrow == 3 */
    public function setPlayerTurn(): void
    {
        if (!isset($this->playersTurnId)) { // om ej satt sätt till 0
            $this->playersTurnId = 0;
        } if ($this->playersTurnId + 1 == ($this->getNumberOfPlayers())) {
            $this->playersTurnId = 0;
        } else {
            $this->playersTurnId += 1;
        }
    }

    public function getPlayerTurn(): int
    {
        if (!isset($this->playersTurnId)) {
            $this->playersTurnId = 0;
        }
        return $this->playersTurnId;
    }
}
