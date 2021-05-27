<?php

namespace App\Controller;

use App\Dice\Players;
use App\Entity\Yatzy;
use App\Dice\YatzyGame;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class YatzyController extends AbstractController
{
    /**
    * @Route("/")
    */

    public function index(): Response
    {
        return $this->render('/index.html.twig', [
            'message' => "Home",
            'title' => "Home",
        ]);
    }

   /**
     * @Route("/players")
    */
    public function players(): Response
    {
        return $this->render('/players.html.twig', [
            'message' => "Home",
            'title' => "Home",
        ]);
    }
    /**
    * @Route("/create/yatzy", name="create_yatzy")
    * @Method({"GET", "POST"})
    */
    public function createYatzyTable(): Response
    {
    
        $this->delete();
        $entityManager = $this->getDoctrine()->getManager();

        if(isset($_SESSION)) {
            session_destroy();
            session_start();
        } else {
            session_start();
        }

        foreach ($_POST as &$value) {
            $yatzy = new Yatzy();
            if (strlen($value) > 0) {
                $yatzy->setName($value);
                $entityManager->persist($yatzy);
                $entityManager->flush();
            }
        }
        return $this->redirectToRoute('yatzy_show');
    }

    /**
     * @Route("show/yatzy", name="yatzy_show")
     */
    public function show(): Response
    {
        $yatzy = $this->findAll();  //SPARAR DB VÄRDENA I YATZY
        $arrOfId = [];

        foreach ($yatzy as $nameAndId) {
            array_push($arrOfId, $nameAndId->getId());  //SPARAR NER ID I ARRAY
        }

        $players = new Players($arrOfId); //SKAPAR SPELARE
        $getAllId = $players->getAllIdPlayers(); // RETUNERAR ALLA SPELARE (ID)
        $nrOfPlayers = count($getAllId); // räknar ut hur många spelare som ska spela


        if (!isset($_SESSION)) { /* första rundan */
            session_start();    //startar session
            echo("FÖRSTA RUNDAN");
            $nrOfDice = 5; 
            $game = new YatzyGame($nrOfDice, 0, 0, 0, $nrOfPlayers); //sätter antal tärningar till 5 och spelare till antal spelare
            $_SESSION["yatzygame"] = $game; //sparar spelet i session
            $game->setRound(0); //sätter första rundan till 0
            $graphDice = ""; //nedan är för att jag måste initiera variablerna
            $getLastRoll = 0;
            $nrOfDie2ThrowNext = "";
            $returnMess ="";
            $checkScore = "";
            $savedDicesGraphical = "";
            $getThrow = 0;
            $getRound = "";
            $nextPlayer = $players->getNextPlayer(0); // första rundan måste det vara spelare 0 tur
        }

        $game = $_SESSION["yatzygame"]; //SPARAR SPELET I GAME (OM DET ÄR RUNDA TVÅ ELLER MER)


        if ($game->getIfThrow()) {
            $game->roll();
            $game->setThrow(1);

            $game->setPlayerTurn(0);
            $game->setRound(0);

            $nrOfDie2ThrowNext= $game->countNrOfDieToThrow();
            $game->setNrOfDice($nrOfDie2ThrowNext);


            $getThrow = $game->getThrow();
            $playerTurn = $game->getPlayerTurn();
            $getRound = $game->getRound();

            echo("KASTA");
            echo($getThrow);

            echo("SPELARE". $game->getPlayerTurn());

            $returnMess = $game->returnMess();

            $nextPlayer = $players->getNextPlayer($playerTurn);
            $getLastRoll = $game->getLastRollWithoutSum();
            $savedDicesGraphical = $game->savedDices();
            $graphDice = $game->getGraphicalDices(); // hämtar värden skriver ut
            $checkScore = $game->checkScore();

        } else if ($game->getIfSave()) {
            echo("SAVE");
            $graphDice = "";
            $getLastRoll = 0;
            $nrOfDie2ThrowNext = "";
            $returnMess ="";
            $checkScore = "";
            $savedDicesGraphical = "";
            $getRound = "";
            $game->setThrow(0);
            $game->setPlayerTurn(1);
            $game->setRound(1);
            $getThrow = $game->getThrow();
            $playerTurn = $game->getPlayerTurn();
            $nextPlayer = $players->getNextPlayer($playerTurn);
        }

        var_dump($_SESSION);
        var_dump($_POST);
        var_dump("ARRAT", $game->getSavedAndOnHandDice());

        return $this->render('yatzyTable.html.twig', [
            'yatzy' => $yatzy,
            'nrOfDie2ThrowNext' => $nrOfDie2ThrowNext,
            'whatThrow' => $getThrow ,
            'newRoundOrNot' => $getRound,
            'graphDice' => $graphDice,
            'getLastRoll' => $getLastRoll,
            'savedDicesGraphical' => $savedDicesGraphical,
            'returnMess' => $returnMess,
            'checkScore' => $checkScore,
            '_SESSION' => $_SESSION,
            '_POST' => $_POST,
            'nextPlayer' => $nextPlayer,
        ]);
    }


    public function delete()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $yatzy = $entityManager->getRepository(yatzy::class)->findAll();

        for ($x = 0; $x < count($yatzy); $x++) {
            $entityManager->remove($yatzy[$x]);
            $entityManager->flush();
        }
    }

    public function findAll(): array {
        $this->yatzy = $this->getDoctrine()
        ->getRepository(Yatzy::class)
        ->findAll();

        return $this->yatzy;
    }

    public function update(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $product->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $product->getId()
        ]);
    }
}
