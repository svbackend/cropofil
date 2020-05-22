<?php

namespace App\Controller;

use League\Flysystem\AdapterInterface;
use League\Flysystem\FilesystemInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends BaseController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(FilesystemInterface $awsStorage): Response
    {
        $result = $awsStorage->write('hello.txt', 'Hello World!', [
            'visibility' => AdapterInterface::VISIBILITY_PUBLIC
        ]);

        return $this->render('home/index.html.twig');
    }

    public function upload(Request $request, FilesystemInterface $awsStorage)
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('photo');

        if ($file->isValid()) {
            $stream = fopen($file->getRealPath(), 'r+');
            $awsStorage->writeStream('uploads/'.$file->getClientOriginalName(), $stream);
            fclose($stream);
        }
    }
}
