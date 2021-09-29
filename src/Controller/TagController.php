<?php

namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TagController extends AbstractController
{
    /**
     * @Route("/tags/tags.json", name="tags_list")
     */
    public function index(Request $request, TagRepository $repository)
    {
        $tags = $repository->findAll();

        return $this->json($tags, 200, [], ['groups' => ['public_json']]);
    }
}
