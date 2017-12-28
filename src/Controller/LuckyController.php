<?php
/**
 * Created by PhpStorm.
 * User: archi.parikh
 * Date: 12/27/2017
 * Time: 9:41 PM
 */
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LuckyController extends Controller
{
    public function number()
    {
        $number = mt_rand(0, 100);

        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
        ));
    }
}