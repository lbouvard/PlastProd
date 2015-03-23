<?php

// src/AppBundle/Controller/StockController.php

namespace AppBundle\Controller;

//use AppBundle\Entity\Compte;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \AppBundle\Entity\Produits;
use \AppBundle\Entity\Stock;
use \AppBundle\Entity\Societe;

class StockController extends Controller
{
    public function indexAction()
    {
    	return $this->render('AppBundle:Stock:index.html.twig');
    }

    public function menuAction(Request $request)
    {
	    return $this->render('AppBundle:Stock:menu.html.twig');
    }
	public function afficher_stockAction()
	{
		/*$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Produits');
		
		$listestock = $repository->findAll();
		*/
		$listestock=$this->getDoctrine()->getEntityManager()->createQueryBuilder()
                ->add('from','AppBundle:Stock s')
                ->select('s')
                ->leftJoin('s.produit','p')
				->addSelect("p")
                ->getQuery()->getResult();
		
		return $this->render('AppBundle:Stock:index.html.twig', array('Liste_stock' => $listestock));
	}
	public function fournisseurAction(){
		
		$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Societe');
		
		$listefourn = $repository->findAll();
		
		return $this->render('AppBundle:Stock:fournisseur.html.twig', array('Liste_fourn' => $listefourn));
	}
	public function modiffournisseurAction($id){
		$fourns = $this
					->getDoctrine()
					->getManager()
					->getRepository('AppBundle:Societe')->findBy(array("idtSociete"=>$id));
					
				$fourn = $fourns[0];
				$form = $this->createFormBuilder($fourn)
                        ->add('nomSociete', 'text',array("label"=>"Nom"))
						->add('adresse1','text',array("label"=>"Adresse 1"))
						->add('adresse2','text',array("label"=>"Adresse 2","required"=>false))
						->add('codePostal','text',array("label"=>"Code Postal","max_length"=>5))
						->add('ville','text',array("label"=>"Ville"))
						->add('pays','text',array("label"=>"pays"))
						->add('typeSociete','choice',
								array("label"=>"Type",
										"empty_data"=>0,
										"multiple"=>false,
										'choices' => array("F"=>"F","M"=>"M","C"=>"C"))
								)
						->add('commentaire','textarea',array("label"=>"Commentaire","required"=>false))
						->getForm();
					$request = $this->getRequest();
					
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                return $this->redirect($this->generateUrl('modifier_fourn'));
            }
			return $this->render('AppBundle:Stock:modif_fourn.html.twig', array('form' => $form->createView(),"fourn"=>$fourn));
	}
	public function ajout_fournAction(){
		$fourn =new Societe();
					
					$form = $this->createFormBuilder($fourn)
                        ->add('nomSociete', 'text',array("label"=>"Nom"))
						->add('adresse1','text',array("label"=>"Adresse 1"))
						->add('adresse2','text',array("label"=>"Adresse 2","required"=>false))
						->add('codePostal','text',array("label"=>"Code Postal","max_length"=>5))
						->add('ville','text',array("label"=>"Ville"))
						->add('pays','text',array("label"=>"pays"))
						->add('typeSociete','choice',
								array("label"=>"Type",
										"empty_data"=>0,
										"multiple"=>false,
										'choices' => array("F"=>"F","M"=>"M","C"=>"C"))
								)
						->add('commentaire','textarea',array("label"=>"Commentaire","required"=>false))
						->getForm();
					$request = $this->getRequest();
					
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                $em = $this->getDoctrine()->getManager();
				$em -> persist($fourn);
                $em->flush();

                return $this->redirect($this->generateUrl('modifier_fourn'));
            }
			return $this->render('AppBundle:Stock:ajout_fourn.html.twig', array('form' => $form->createView()));
	}
	public function ajoutstockAction(){
		$em = $this->getDoctrine()->getEntityManager();

		$formajout = $this->createFormBuilder( new Produits())
					->add('nomProduit', 'text', array("label"=>"Nom"))
					->add('producteur', 'entity', array("label"=>"Fournisseur",
					'class'=>'AppBundle:Societe'))
					->add('descriptionProduit', 'text', array("label"=>"Description"))
					->add('categorieProduit', 'text', array("label"=>"Catégorie"))
					->add('codeProduit', 'text', array("label"=>"Code Produit"))
					->add('prixProduit', 'text', array("label"=>"Prix"))
					->getForm();
					 $formajout->handleRequest($this->getRequest());

					if ($formajout->isValid()) {
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
					}					
				
		return $this->render('AppBundle:Stock:ajoutstock.html.twig', array('formajout' => $formajout->createView()));
	}
	public function modif_stockAction(){
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