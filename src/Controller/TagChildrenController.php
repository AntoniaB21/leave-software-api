<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\TagChild;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Security;

class TagChildrenController extends AbstractController {
    
    private $security;
    private $params;

    public function __construct(ParameterBagInterface $params, Security $security){
        $this->security = $security;
        $this->params = $params;
    }

    public function __invoke(TagChild $data ,Request $request){
        // récupérer le tag
        var_dump("coucou");
        $tag = $data->getTag();
        dd($data->getTag());
        return $data;

    }
}