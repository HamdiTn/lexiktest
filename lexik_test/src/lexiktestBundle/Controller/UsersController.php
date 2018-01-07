<?php

namespace lexiktestBundle\Controller;

use lexiktestBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("users")
 */
class UsersController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="users_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('lexiktestBundle:Users')->findAllOrderByGroup();

        return $this->render('users/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="users_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new Users();
        $form = $this->createForm('lexiktestBundle\Form\UsersType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('users_show', array('id' => $user->getId()));
        }

        return $this->render('users/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="users_show")
     * @Method("GET")
     */
    public function showAction(Users $user)
    {

        return $this->render('users/show.html.twig', array(
            'user' => $user,
         ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="users_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Users $user)
    {
        $editForm = $this->createForm('lexiktestBundle\Form\UsersType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_index');
        }

        return $this->render('users/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
        ));
    }


    /**
     * @Route("usershow/{id}", name="usershow")
     */
    public function usershowAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('lexiktestBundle:Users')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find Eleve entity.');
        }
        return $this->render('users/showModal.html.twig', array(
            'user' => $user,
         ));
    }

    /**
     * @Route("/deleteuser/{id}", name="deleteuser")
     */
    public function deleteUserAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('lexiktestBundle:Users')->find($id);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('users_index');
    }

    /**
     * @Route("/deletelotuser/", name="deletelotuser")
     */
    public function deleteLotuserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $items = $request->request->get('deletecheck');
        foreach ($items as $idUser) {
            $user = $em->getRepository('lexiktestBundle:Users')->find($idUser);
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('users_index');
    }

    /**
     * @Route("/searchuser/", name="searchuser")
     */
    public function searchUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $name = $request->request->get('searchtext');
        $users = $em->getRepository('lexiktestBundle:Users')->findByName($name);

        return $this->render('users/index.html.twig', array(
            'users' => $users,
        ));
    }
}
