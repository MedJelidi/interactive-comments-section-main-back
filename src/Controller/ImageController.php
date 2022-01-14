<?php

namespace App\Controller;

use App\Entity\Image;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    #[Route('/image', name: 'image')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $images = $doctrine->getRepository(Image::class)->findAll();
        if (!$images) {
            throw $this->createNotFoundException('No images found');
        }
        $arrayImages = array();
        foreach($images as $image) {
            $arrayImages[] = array(
                'png' => $image->getPng(),
                'webp' => $image->getWebp()
            );
        }
        return new JsonResponse($arrayImages);
    }
}
