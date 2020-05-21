<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    /**
     * @Route("/", name="upload")
     */
    public function index()
    {
        $test = 1;
        $test2 = 2;

        $this->someMethod($test, $test2);

        return $this->render('upload/index.html.twig', [
            'controller_name' => 'UploadController',
        ]);
    }

    //xdebug test
    public function someMethod(int $one, int $two): int
    {
        $f = fn ($o, $t)
            => $o + $t;
        return  $one + $two + $f(1, 2);
    }
}
