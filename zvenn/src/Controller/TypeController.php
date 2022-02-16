<?php

namespace App\Controller;

use App\Form\typeType;

use App\Entity\Type;
use App\Repository\TypeRepository;
use Doctrine\DBAL\Types\TypeRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TypeController extends AbstractController
{
    /**
     * @Route("/type", name="type")
     */
    public function index(): Response
    {
        return $this->render('type/index.html.twig', [
            'controller_name' => 'TypeController',
        ]);
    }
    /**
     * @param TypeRepository $repository
     * @return Response
     * @Route ("/affichetype", name="affichetype")
     */
    function Affiche( ){
        $repo=$this->getDoctrine()->getRepository(Type::class);

        $type=$repo->findAll();

        return $this->render('index.html.twig',
            [
                'type'=>$type,
            ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/Ajouttype",name="Ajouttype")
     */
    function Ajoutertype(Request $request): Response{
        $type=new type();
        $form=$this->createForm(typeType::class,$type);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();

            $em->persist($type);
            $em->flush();
            return $this->redirectToRoute('affiche');

        }
        return $this->render('type/ajouttype.html.twig',
            [
                'type' => $type,
                'form'=>$form->createView()]);

    }

/**
 * @Route("/updatetype/{id}",name="updatetype")
 */
function Update(TypeRepository $repository,$id,Request $request)
{
    $type = $repository->find($id);
    $form = $this->createForm(typeType::class, $type);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {


        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("affiche");
    }
    return $this->render('type/update.html.twig',
        [
            'form' => $form->createView()
        ]);
}
/**
 * @param $id
 * @param \App\Repository\TypeRepository $rep
 * @Route ("/Deletetype/{id}", name="deletetype")
 */
function Delete($id,TypeRepository $rep){
    $type=$rep->find($id);
    $em=$this->getDoctrine()->getManager();
    $em->remove($type);
    $em->flush();
    return $this->redirectToRoute('affiche');

}


}