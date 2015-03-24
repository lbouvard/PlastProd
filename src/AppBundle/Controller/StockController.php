<?php

// src/AppBundle/Controller/StockController.php

namespace AppBundle\Controller;

//use AppBundle\Entity\Compte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Produits;
use AppBundle\Entity\Stock;
use AppBundle\Entity\Societe;
use AppBundle\Form\SocieteType;

class StockController extends Controller
{
    public function indexAction(){

    	$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Stock');

		$listestock = $repository->getListeStock();

    	return $this->render('AppBundle:Stock:index.html.twig', array('listestock' => $listestock));
    }

    public function menuAction(Request $request)
    {
	    return $this->render('AppBundle:Stock:menu.html.twig');
    }

	public function fournisseurAction(){
		
		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Societe');
		
		$listefournisseur = $repository->getListeFournisseur();
		
		return $this->render('AppBundle:Stock:fournisseur.html.twig', array('listefournisseur' => $listefournisseur) );
	}

	public function ajoutFournisseurAction(Request $request){

        $fournisseur = new Societe('F');

        $form = $this->createForm(new SocieteType(), $fournisseur);

        if ($form->handleRequest($request)->isValid()) {

        	$em = $this->getDoctrine()->getManager();
        	$em->persist($fournisseur);
        	$em->flush();

        	$request->getSession()->getFlashBag()->add('notice', 'Le fournisseur a été créé avec succès.');

          	// On redirige vers la page de visualisation de l'annonce nouvellement créée
          	return $this->redirect($this->generateUrl('gerer_fournisseur'));
        }

        return $this->render('AppBundle:Stock:addfournisseur.html.twig', array(
          	'form' => $form->createView(),
        ));
	}

	public function modifieFournisseurAction($id, Request $request){

    	$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Societe');
        
        $fournisseur = $repository->getSocieteParId($id);

        $form = $this->createForm(new SocieteType(), $fournisseur);

        if ($form->handleRequest($request)->isValid()) {

        	$em = $this->getDoctrine()->getManager();
        	$em->persist($fournisseur);
        	$em->flush();

        	$request->getSession()->getFlashBag()->add('notice', 'Le fournisseur a été modifié avec succès.');

          	// On redirige vers la page de visualisation de l'annonce nouvellement créée
          	return $this->redirect($this->generateUrl('gerer_fournisseur'));
        }

        return $this->render('AppBundle:Stock:modifiefournisseur.html.twig', array(
          	'form' => $form->createView(),
        ));
	}


	public function ajoutStockAction(Request $request){

		$produit = new Produits();

		$form = $this->createForm( new Produits(), $produit, array('produit_fournisseur' => false) )
	
		if( $form->handleRequest($request)->isValid()) {

			$em = $this->getDoctrine()->getManager();
			$em->persist($produit);

			$stock = new Stock();
			$stock->setQuantite
		}

			/*if ($formajout->isValid()) {
				$registration = $formajout->getData();
				$registration -> setBitModif (False);
				$registration -> setBitSup(False);
				$registration -> setNomFournisseur($registration->getProducteur() ->getNomSociete());
				$stock = new Stock();
				$em->persist($registration);
				$stock -> setQuantite(0);
				$stock -> setProduit($registration);
				
				$em->persist($stock);
				$em->flush();

				return $this->redirect($this->generateUrl('gerer_stock'));
			}*/					
				
		return $this->render('AppBundle:Stock:ajoutstock.html.twig', array('formajout' => $formajout->createView()));
	}
	public function modifieStockAction(){
		$listestock=$this->getDoctrine()->getEntityManager()->createQueryBuilder()
                ->add('from','AppBundle:Stock s')
                ->select('s')
                ->leftJoin('s.produit','p')
				->addSelect("p")
                ->getQuery()->getResult();		
		
		return $this->render('AppBundle:Stock:Modif_stock.html.twig', array('Liste_stock' => $listestock));
	}
	public function modifQuantiteStockAction(){
		if(isset($_POST) & !empty($_POST)){
			extract($_POST);
			$em = $this->getDoctrine()->getEntityManager();
			$stock = $em->getRepository("AppBundle:Stock")->findBy(array("idtEntree" =>$id))[0];
			
				$stock ->setQuantite($qte);
				$stock -> getProduit() ->setPrixProduit($prix);
				$em -> flush();
				$message=json_encode(array("success"=>"Mis à jour avec succès"));
		}
		else {
			$message=json_encode(array("error"=>"Aucune donnée envoyée"));
		}
		return $this->render('AppBundle:Stock:vide.html.twig', array('message' => $message));
	}
}