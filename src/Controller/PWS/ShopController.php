<?php
/**
 * Created by PhpStorm.
 * User: archi.parikh
 * Date: 12/27/2017
 * Time: 11:20 PM
 */
namespace App\Controller\PWS;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShopController extends Controller
{
    public function index()
    {
        $number = mt_rand(0, 100);

        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
        ));
    }
}