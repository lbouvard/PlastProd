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
use AppBundle\Entity\Nomenclature;
use AppBundle\Form\SocieteType;
use AppBundle\Form\ProduitsType;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

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
		
		$listefournisseur = $repository->getListeFournisseur2();
		
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

		$form = $this->createForm( new ProduitsType(), $produit, array('produit_fournisseur' => false) );
	
		if( $form->handleRequest($request)->isValid()) {

			$em = $this->getDoctrine()->getManager();
			$em->persist($produit);

			//on ajoute autant de ligne que de quantité demandé du produit
			for ($i = 0; $i < $produit->getQuantite(); $i++) 
			{
				$stock = new Stock();

				$stock->setDateEntree(new \DateTime());
				$stock->setProduit($produit);

				$em->persist($stock);
			}

			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Le(s) produit(s) a(ont) été ajouté(s) et le stock modifié.');
			if( $produit->getProducteur()->getTypeSociete() == 'M')
				$request->getSession()->getFlashBag()->add('info', 'Pensez à créer la nomenclature.');

			return $this->redirect($this->generateUrl('accueil_stock'));
		}				
				
		return $this->render('AppBundle:Stock:ajoutstock.html.twig', array('form' => $form->createView()));
	}

	public function supprimeMatiereAction(Request $request){
    	
    	$repository = $this
			->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Societe');

		$listefournisseur = $repository->getListeFournisseur2();

        if ($request->isMethod('POST') ){

        	$idproduit = $request->request->get('idtproduit');
        	
        	if( null !== $request->request->get('btnsupprimer') && $idproduit != '' ){  

                $em = $this->getDoctrine()->getManager();
                $matiere = $em->getRepository('AppBundle:Produits')->findOneByIdtProduit($idproduit);
                $matiere->setBitSup(1);
                $em->persist($matiere);
                        
          		$em->flush();

          		$request->getSession()->getFlashBag()->add('notice', 'La matière première a été supprimée.');
            }
            else{
            	$request->getSession()->getFlashBag()->add('info', 'Aucune matière n\'a été sélectionné. Aucune suppression faite.');
            }
        }

        return $this->render('AppBundle:Stock:supprimematiere.html.twig', array('listefournisseur' => $listefournisseur) );
	}

	public function modifieStockAction(){
    	
    	$em = $this->getDoctrine()->getManager();

		$query = $em->createQuery('SELECT p.idtProduit, s.nomSociete, p.codeProduit, p.nomProduit, p.categorieProduit, p.descriptionProduit, p.prixProduit, COUNT(t.produit) AS quantite FROM AppBundle:Produits p 
			LEFT JOIN AppBundle:Stock t WITH t.produit = p.idtProduit 
			INNER JOIN AppBundle:Societe s 
			WHERE p.producteur = s.idtSociete AND p.bitSup = 0 GROUP BY p.idtProduit'
		);
		
		$listestock = $query->getResult();

		return $this->render('AppBundle:Stock:modifiestock.html.twig', array('listestock' => $listestock) );
	}

	public function variationStockAction(Request $request){

		$id = $request->request->get('id');
		$quantite = $request->request->get('quantite');
		$prix = $request->request->get('prix');
		$operation = $request->request->get('operation');
		$valeur = $request->request->get('valeur');

		$em = $this->getDoctrine()->getManager();
    	$repository = $em->getRepository('AppBundle:Produits');
        $produit = $repository->getProduitParId($id);

		//cas de l'ajout de produits
		if( $operation == '+'){

			for ($i = 0; $i < $valeur; $i++) 
			{
				$stock = new Stock();

				$stock->setDateEntree(new \DateTime());
				$stock->setProduit($produit);

				$em->persist($stock);
			}
		}
		//cas de la suppression de produits
		else if( $operation == '-'){
			$repository = $em->getRepository('AppBundle:Stock');
			$lignes = $repository->getLigneASupprimer($valeur, $id);

			foreach ($lignes as $val){
				$val->setDateSortie(new \DateTime());
				$val->setBitSup(1);

				$em->persist($val);
			}
		}

		//pour le prix du produit
		$produit->setPrixProduit($prix);
		$em->persist($produit);

		$em->flush();

		$request->getSession()->getFlashBag()->add('notice', 'Le stock a été modifié.');

		return $this->render('AppBundle:Stock:flash.html.twig');
	}

	public function lignesProduitAction(Request $request){

		//si demande ajax
        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');

            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Stock');

            $lignes = $repository->getLignesParId($id);
            
        	return $this->render('AppBundle:Stock:lignesajax.html.twig', array('lignes' => $lignes));
        }
	}

	public function nomenclatureAction(Request $request){

        if ($request->isMethod('POST') ){

        	if( null !== $request->request->get('btnvalider') ){  

                $listematieres = $request->request->get('nomenclature');
                $codenomenclature = $request->request->get('codenomenclature');
                
                $em = $this->getDoctrine()->getManager();

                foreach($listematieres as $valeur){
                	
                	$produit = $em->getRepository('AppBundle:Produits')->findOneByIdtProduit($valeur['pid']);

                	$nomenclature = new Nomenclature();
                	$nomenclature->setQuantite($valeur['quantite']);
                	$nomenclature->setProduit($produit);
                	$nomenclature->setCodeProduit($codenomenclature);

                	$em->persist($nomenclature);
                }
                        
          		$em->flush();
          		$request->getSession()->getFlashBag()->add('notice', 'La nomenclature a été bien enregistrée.');

          		return $this->redirect($this->generateUrl('gerer_fournisseur'));
            }
        }

		$em = $this->getDoctrine()->getManager();
		
		//Récupération de la liste des produits plastprod qui n'ont pas encore de nomenclature
		$query = $em->createQuery(
		    'SELECT p.codeProduit FROM AppBundle:Produits p 
				INNER JOIN AppBundle:Societe s 
				WHERE p.producteur = s.idtSociete AND p.codeProduit NOT IN 
				(
   					SELECT n.codeProduit FROM AppBundle:Nomenclature n GROUP BY n.codeProduit 
   				) AND s.nomSociete = :nom')->setParameter('nom', 'PlastProd');
		
		$listenomenclature = $query->getResult();


        //Récupération de la liste des fournisseurs
        $repository = $em->getRepository('AppBundle:Societe');
        $listefournisseur = $repository->getListeFournisseur2();

        return $this->render('AppBundle:Stock:nomenclature.html.twig', array('listenomenclature' => $listenomenclature,
         	'listefournisseur' => $listefournisseur));
	}

	public function selmateriauAction(Request $request)
	{
		$encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

		$id = $request->request->get('id');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Produits');

        $listematiere = $repository->getMatierePremiereParFournisseur($id);

        $jslistematiere = $serializer->serialize($listematiere, 'json');

        return $this->render('AppBundle:Stock:selmateriau.html.twig', array('listematiere' => $listematiere, 'jslistematiere' => $jslistematiere)); 
	}

	public function selmatierepremiereAction(Request $request)
    {
        $id = $request->request->get('id');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Produits');

        $listematieres = $repository->getMatierePremiereParFournisseur($id);

        return $this->render('AppBundle:Stock:selmatierepremiere.html.twig', array('listematieres' => $listematieres));           
    }
}