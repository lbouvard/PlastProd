<?php

// src/AppBundle/Controller/ClientController.php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Entity\CommandeProduits;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Produits;
use AppBundle\Entity\Societe;
use AppBundle\Entity\Utilisateur;

use AppBundle\Form\CommandeType;
use AppBundle\Form\SocieteType;
use AppBundle\Form\CommandeProduitsType;
use AppBundle\Form\ContactType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class ClientController extends Controller
{

    public function menuAction(Request $request)
    {
        return $this->render('AppBundle:Client:menu.html.twig');
    }

    public function accueilAction()
    {

        if( $this->get('security.context')->isGranted('ROLE_CLIENT') )
        {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Contact');

            $contact = $repository->getContactParUtilisateur($this->get('security.context')->getToken()->getUser()->getId());

            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Societe');

            $plastprod = $repository->getSocieteMere();

            return $this->render('AppBundle:Client:index.html.twig', array('contact' => $contact, "societemere" => $plastprod));
        }
        else
        {
            return $this->redirect($this->generateUrl('clients_client'));
        }
    }

    /*
     * @Security("has_role('ROLE_CLIENT')")
     */
    public function commandeAction(Request $request)
    {
        //si demande ajax
        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');

            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Commande');

            $listecommande = $repository->getCommandeParSociete($id);
            
        	return $this->render('AppBundle:Client:orderajax.html.twig', array('listecommande' => $listecommande));
        }
        //accès client (seulement ses commandes)
        elseif ( $this->get('security.context')->isGranted('ROLE_CLIENT') ) 
        {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Contact');

            $contact = $repository->getContactParUtilisateur($this->get('security.context')->getToken()->getUser()->getId());
            $id = $contact->getSociete()->getIdtSociete();

            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Commande');

            $listecommande = $repository->getCommandeParSociete($id);
            
            return $this->render('AppBundle:Client:order.html.twig', array('listecommande' => $listecommande));
        }
        //accès à toutes les commandes (direction, admin...)
        else
        {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Commande');

            
            $listecommande = $repository->getCommande();

            return $this->render('AppBundle:Client:order.html.twig', array('listecommande' => $listecommande));
        }
    }

    public function commandeDetailsAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $id = $request->request->get('id');

            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:CommandeProduits');

            $details = $repository->getDetailsCommande($id);
            
            return $this->render('AppBundle:Client:orderdetails.html.twig', array(
                'details' => $details
            ));
        }
    }

    public function ajoutCommandeAction(Request $request)
    {
        //Récupération de la liste des produits
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Produits');

        $listeproduits = $repository->getListeProduits();

        //Mise en forme pour utilisation de la liste de produits en javascript
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        /***************************************************************/

        // On crée un objet commande
        $commande = new Commande();

        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(new CommandeType(), $commande);

        if ($form->handleRequest($request)->isValid()) 
        {
            $data = $request->request->get('appbundle_commande');

            if( isset($data['produits']) ){
                // On enregistre notre objet $commande dans la base de données.
                $em = $this->getDoctrine()->getManager();
                $em->persist($commande);

                foreach ($commande->getProduits()->toArray() as $commandeproduits) {
                    $commandeproduits->setCommande($commande);
                    $em->persist($commandeproduits);
                }

                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Commande bien enregistrée.');
            }
            else{
                $request->getSession()->getFlashBag()->add('info', 'Vous devez avoir au moins un produit pour faire une commande.');
            }

            // On redirige vers le formulaire d'ajout de commande
            return $this->redirect($this->generateUrl('ajouter_commande'));
        }

        $jslisteproduits = $serializer->serialize($listeproduits, 'json');
        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('AppBundle:Client:addorder.html.twig', array(
          'form' => $form->createView(), 'listeproduits' => $listeproduits, 'jslisteproduits' => $jslisteproduits
        ));
    }

    public function clientAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Societe');

        $listeclient = $repository->findByTypeSociete('C');
        //$listclient = $repository->findAll();

        return $this->render('AppBundle:Client:client.html.twig', array('listeclient'  => $listeclient));
    }

    public function ajoutClientAction(Request $request)
    {
        // On crée un objet société
        $client = new Societe('C');

        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(new SocieteType(), $client);

        if ($form->handleRequest($request)->isValid()) {
          // On l'enregistre notre objet $commande dans la base de données, par exemple
          $em = $this->getDoctrine()->getManager();
          $em->persist($client);
          $em->flush();

          $request->getSession()->getFlashBag()->add('notice', 'Client bien enregistré.');

          // On redirige vers la page de visualisation de l'annonce nouvellement créée
          return $this->redirect($this->generateUrl('clients_client'));
        }

        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('AppBundle:Client:addclient.html.twig', array(
          'form' => $form->createView(),
        ));
    }

    //Permet d'ajouter un contact (mise en base + création d'un utilisateur par défaut en base également)
    public function ajoutContactAction(Request $request)
    {
        //Pour génération mot de passe automatique
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 5000);

        // On crée un objet contact
        $contact = new Contact();

        // On crée le FormBuilder grâce au service form factory
        $form = $this->createForm(new ContactType(), $contact);

        if ($form->handleRequest($request)->isValid()) 
        {
            //utilisateur lié au contact
            $mdp = $this->random_password(8);

            $user = new Utilisateur();
            $user->setUsername(strtolower($contact->getNomContact().".".$contact->getPrenomContact()));
            $user->setPassword( $encoder->encodePassword($mdp, $user->getSalt()) );
            $user->setEmail($contact->getEmail());

            //Par défaut, on rajoute le role client
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Role');

            $roleclient = $repository->getRoleClient();

            $user->addRole($roleclient[0]);

            //on rajoute l'utilisateur au contact
            $contact->setUtilisateur($user);
 
            $em = $this->getDoctrine()->getManager();
            // On enregistre notre utilisateur dans la base de données.
            $em->persist($user);
            // et notre contact
            $em->persist($contact);
            
            $em->flush();

            //envoi du mail contenant le mot de passe du compte
            $message = \Swift_Message::newInstance()
                ->setSubject('Votre compte PlastProd')
                ->setFrom('support@free.fr')
                //->setTo($contact->getEmail())
                ->setTo('lbouvard57@gmail.com')
                ->setBody("Bonjour ".$user->getUsername()."\r\nVotre mot de passe est le suivant : ".$mdp);
                //->setBody($this->renderView('HelloBundle:Hello:email.txt.twig', array('name' => $name)));

            $this->get('mailer')->send($message);

            //message de réussite
            $request->getSession()->getFlashBag()->add('notice', 'Contact bien enregistré ('.$mdp.').');

            // On redirige
            return $this->redirect($this->generateUrl('ajouter_contact'));
        }

        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('AppBundle:Client:addcontact.html.twig', array(
                'form' => $form->createView()));
    }

    //Permet de générer un mot de passe aléatoire pour la création d'un contact + utilisateur
    private function random_password( $length = 8 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }
}