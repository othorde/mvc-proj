<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dice\Players;
use App\Entity\Yatzy;
use App\Dice\YatzyGame;
use App\Entity\Highscore;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\TextUI\Help;
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

        if (isset($_SESSION)) {
            session_destroy();
            session_start();
        } else if (!isset($_SESSION)) {
            session_start();
        }

        foreach ($_POST as &$value) {
            $yatzy = new Yatzy();
            if (strlen($value) > 0) {
                $yatzy->setName($value);
                $yatzy->setEttor(0);
                $yatzy->setTvaor(0);
                $yatzy->setTreor(0);
                $yatzy->setFyror(0);
                $yatzy->setFemmor(0);
                $yatzy->setSexor(0);
                $yatzy->setSumma(0);
                $yatzy->setBonus(0);
                $yatzy->setPar(0);
                $yatzy->setParpar(0);
                $yatzy->setTretal(0);
                $yatzy->setFyrtal(0);
                $yatzy->setKak(0);
                $yatzy->setChans(0);
                $yatzy->setSstraight(0);
                $yatzy->setStraight(0);
                $yatzy->setYatzy(0);
                $yatzy->setTotalt(0);

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
        $repository = $this->getDoctrine()->getRepository(Yatzy::class);
        if (!isset($_SESSION)) { /* första rundan */
            $this->firstRound();
            session_start();    //startar session
            $nrOfDice = 5;
            $game = new YatzyGame($nrOfDice, 0, 0); //sätter antal tärningar till 5 och spelare till antal spelare
            $game->setAllPlayers($yatzy);
            $_SESSION["yatzygame"] = $game; //sparar spelet i session
            $game->setRound(0); //sätter första rundan till 0
            $graphDice = ""; //nedan är för att jag måste initiera variablerna
            $getLastRoll = 0;
            $nrOfDie2ThrowNext = "";
            $returnMess = "";
            $checkScore = "";
            $savedDicesGraphical = "";
            $getThrow = 0;
            $getRound = "";
            $playerNumber = $game->getPlayerTurn(); // nummer på spelaren som spelar 0-4'
            $specificPlayerId = $game->getSpecificPlayer($playerNumber); // id på spelaren som spelar
        }
        $game = $_SESSION["yatzygame"]; //SPARAR SPELET I GAME (OM DET ÄR RUNDA TVÅ ELLER MER)
        if ($game->getIfThrow()) {
            $game->roll();
            $game->setThrow(1);
            $game->setRound(0);
            $nrOfDie2ThrowNext = $game->countNrOfDieToThrow();
            $game->setNrOfDice($nrOfDie2ThrowNext);
            $getThrow = $game->getThrow();
            $getRound = $game->getRound();
            $returnMess = $game->returnMess();
            $getLastRoll = $game->getLastRollWithoutSum();
            $savedDicesGraphical = $game->savedDices();
            $graphDice = $game->getGraphicalDices(); // hämtar värden skriver ut
            $checkScore = $game->checkScore();
            $playerNumber = $game->getPlayerTurn(); // nummer på spelaren som spelar 0-4'
            $specificPlayerId = $game->getSpecificPlayer($playerNumber); // id på spelaren som spelar
        } else if ($game->getIfSave()) {
            $graphDice = "";
            $getLastRoll = 0;
            $nrOfDie2ThrowNext = "";
            $returnMess = "";
            $checkScore = "";
            $savedDicesGraphical = "";
            $getRound = "";
            $game->setThrow(0);
            $game->setRound(1);
            $getThrow = $game->getThrow();
            $playerNumber = $game->getPlayerTurn(); // nummer på spelaren som spelar 0-4'
            $specificPlayerId = $game->getSpecificPlayer($playerNumber); // id på spelaren som spelar
            //$nextPlayer = $game->getNextPlayer(0);
            if (!isset($_POST[1])) {
                $returnMess = "AJAJ, du måste fylla i var du vill spara";
            } else if (isset($_POST[1])) {
                $game->setValue2SaveFromPost($_POST);
                $res = $game->defineWhereToSendValue();
                $res[1] = $game->getPlayerId();// la till för testernas skull ta bort om ej fungerar
                $repository->setValue($res);
                $repository->checkSum($res[1]);
                $repository->checkTotal($res[1]);
                $score = $repository->checkBonus($res[1]);
                $repository->setBonus($res[1], $score);
                $game->setPlayerTurn();
            }
        }
        $endGame = $game->endGame();
        //$repositoryHighscore->setHighscore($resAndName);
        if (isset($_SESSION["endgame"])) {
            $resAndName = $repository->getEndGameResult();
            $entityManager = $this->getDoctrine()->getManager();
            $highscore = new Highscore();

            foreach ($resAndName as $value) {
                $highscore->setScore($value['totalt']);
                $highscore->setName($value['name']);
                $entityManager->persist($highscore);
                $entityManager->flush();
            }
        }
        return $this->render('yatzytable.html.twig', [
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
            'nextPlayer' => $specificPlayerId,
            'endGame' => $endGame,
        ]);
    }

    /**
     * @Route("/highscore", name="highscore")
     * @Method({"GET"})
     */
    public function highscore(): Response
    {
        $repositoryHighscore = $this->getDoctrine()->getRepository(Highscore::class);
        $highscore2 = $repositoryHighscore->findall();

        return $this->render('highscore.html.twig', [
            'highscore' => $highscore2
        ]);
    }

    public function yatzy(): Response
    {

        return $this->render('yatzy.html.twig', [
            'message' => "Hello yatzy",
        ]);
    }


    public function delete()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $yatzy = $entityManager->getRepository(Yatzy::class)->findAll();
        $countYatzy = count($yatzy);
        for ($x = 0; $x < $countYatzy; $x++) {
            $entityManager->remove($yatzy[$x]);
            $entityManager->flush();
        }
    }

    public function findAll(): array
    {
        $this->yatzy = $this->getDoctrine()
        ->getRepository(Yatzy::class)
        ->findAll();

        return $this->yatzy;
    }


    public function firstRound(): array
    {
        $this->yatzy = $this->getDoctrine()
        ->getRepository(Yatzy::class)
        ->findAll();

        return $this->yatzy;
    }
}
