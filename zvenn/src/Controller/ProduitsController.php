<?php

namespace App\Controller;
use App\Entity\Produits;

use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class ProduitsController extends AbstractController
{
    /**
     * @Route("/produits", name="produits")
     */
    public function index()
    {
        return $this->render('produits/index.html.twig', [
            'controller_name' => 'ProduitsController',
        ]);
    }
    /**
     * @param ProduitsRepository $repository
     * @return Response
     * @Route ("/affiche", name="affiche")
     */
    function Affiche( ){
        $repo=$this->getDoctrine()->getRepository(Produits::class);

        $produits=$repo->findAll();

        return $this->render('index.html.twig',
            [
                'produits'=>$produits,
            ]);
    }
    /**
     * @param Request $request
     * @return Response
     * @Route ("/Ajout",name="Ajout")
     */
    function AjouterProduit(Request $request): Response{
        $produits=new Produits();
        $form=$this->createForm(ProduitsType::class,$produits);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get('image_produit')->getData();
            $uploads_directory = $this->getParameter('uploads_directory');

            $filename = $produits->getnomproduit() . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            // On stocke l'image dans la base de données (son nom)

            $produits->setNomimage($filename);

            $produits->setImageProduit($filename);
            $produits->setCreatedAt(new \DateTime());

            $em=$this->getDoctrine()->getManager();

            $em->persist($produits);
            $em->flush();
            return $this->redirectToRoute('affiche');

        }
        return $this->render('produits/ajout.html.twig',
            [
                'produits' => $produits,
                'form'=>$form->createView()]);

    }
    /**
     * @Route("produits/update/{id}",name="update")
     */
    function Update(ProduitsRepository $repository,$id,Request $request)
    {
        $produits = $repository->find($id);
        $form = $this->createForm(ProduitsType::class, $produits);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image_produit')->getData();
            $uploads_directory = $this->getParameter('uploads_directory');

            $filename = $produits->getnomproduit() . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            // On stocke l'image dans la base de données (son nom)

            $produits->setNomimage($filename);

            $produits->setImageProduit($filename);


            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("affiche");
        }
        return $this->render('produits/update.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
    /**
     * @param $id
     * @param ProduitsRepository $rep
     * @Route ("/Delete/{id}", name="delete")
     */
    function Delete($id,ProduitsRepository $rep){
        $produits=$rep->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($produits);
        $em->flush();
        return $this->redirectToRoute('affiche');

    }

}

