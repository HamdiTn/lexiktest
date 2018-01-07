<?php

namespace lexiktestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use lexiktestBundle\Entity\Users;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('lexiktestBundle:Users')->findAll();

        return $this->render('lexiktestBundle:Default:index.html.twig', array(
            'users' => $users,
        ));
    }
}
