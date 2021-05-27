<?php

declare(strict_types=1);

namespace App\Dice;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

class Players
{

    public function __construct($arrOfId) // ändra från att ta $faces som inparameter till hårdkordat värde på 6
    {
        $this->players = $arrOfId;
    }

    public function getAllIdPlayers(): array
    {
        return $this->players;
    }

    public function getNextPlayer($nr): int
    {
        
        return $this->players[$nr];
    }

    
}
