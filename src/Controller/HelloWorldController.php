<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Highscore;
use App\Dice\YatzyGame;

class HelloWorldController extends AbstractController
{
    public function yatzy(): Response
    {

        return $this->render('yatzy.html.twig', [
            'message' => "Hello yatzy",
        ]);
    }
}
