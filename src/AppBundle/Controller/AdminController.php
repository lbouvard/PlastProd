<?php

// src/AppBundle/Controller/AdminController.php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use AppBundle\Entity\Utilisateur;
use AppBundle\Form\UtilisateurType;
use AppBundle\Entity\Role;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    //Page d'acceuil, on affiche les sociétés clientes et plastprod
    public function indexAction()
    {
    	$repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Societe');

        //$listeclient = $repository->findByTypeSociete('C');
        $listesociete = $repository->getListeAccesCompte();

    	return $this->render('AppBundle:Admin:index.html.twig', array('listesociete' => $listesociete));
    }

    //Permet de récuperer les contacts d'une société
    public function selcontactAction(Request $request)
    {
        $id = $request->request->get('id');

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Contact');

        $listecontact = $repository->getContactsParSociete($id);

        return $this->render('AppBundle:Admin:selcontact.html.twig', array('listecontact' => $listecontact));           
    }

    //Affichage du menu
    public function menuAction(Request $request)
    {
	    return $this->render('AppBundle:Admin:menu.html.twig');
    }

    //Permet d'afficher les contacts d'une société
    public function contactAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
	        $id = $request->request->get('id');

	    	$repository = $this
	    		->getDoctrine()
	    		->getManager()
	    		->getRepository('AppBundle:Contact');

	    	$listecontact = $repository->getContactsParSociete($id);

	    	return $this->render('AppBundle:Admin:contact.html.twig', array('listecontact' => $listecontact));
	    }
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
            return $this->redirect($this->generateUrl('accueil_admin'));
        }

        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('AppBundle:Admin:addcontact.html.twig', array(
                'form' => $form->createView()));
    }

    //Permet de donner les détails d'un contact dans un formulaire pré-rempli (consultation et modification)
    public function detailsAction($id, Request $request)
    {
        $contact = $this->getDoctrine()
          ->getManager()
          ->getRepository('AppBundle:Contact')
          ->getContactsDetails($id)
        ;

        // Et on construit le formBuilder avec cette instance de contact
        $form = $this->createForm(new ContactType(), $contact);

        if ($form->handleRequest($request)->isValid()) 
        {

            $em = $this->getDoctrine()->getManager();
            //On persiste notre contact
            $em->persist($contact);
            
            $em->flush();

            //message de réussite
            $request->getSession()->getFlashBag()->add('notice', 'Contact modifié avec succès.');

            // On redirige
            return $this->redirect($this->generateUrl('accueil_admin'));
        }

        // On passe la méthode createView() du formulaire à la vue
        // afin qu'elle puisse afficher le formulaire toute seule
        return $this->render('AppBundle:Admin:details.html.twig', array(
            'form' => $form->createView(), 'id' => $id));
    }

    public function compteAction()
    {
        //récupération des clients (société)
        $listesociete = $this->recupererSociete();
        //affichage de la page
        return $this->render('AppBundle:Admin:compte.html.twig', array('listesociete' => $listesociete ));
    }

    public function droitsAction()
    {
        $listesociete = $this->recupererSociete();
        return $this->render('AppBundle:Admin:droits.html.twig', array('listesociete' => $listesociete ));
    }

    //Permet d'afficher le formulaire d'un utilisateur pré rempli
    public function form_compteAction($id, Request $request)
    {
        if( $id == -1 )
            $id = $request->request->get('id');

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:Utilisateur')
                    ->getUtilisateurParId($id)
        ;

        // Et on construit le formBuilder avec cette instance de contact
        $form = $this->createForm(new UtilisateurType(), $user, array(
            'action' => $this->generateUrl('form_compte', array('id' => $id)),
        ));

        if ($form->handleRequest($request)->isValid()) 
        {
            if( $form->get('modifier')->isClicked() )
            {
                //sauvegarde en base
                $em->flush();

                //message de réussite
                $request->getSession()->getFlashBag()->add('notice', 'Utilisateur modifié avec succès.');

                // On redirige
                return $this->redirect($this->generateUrl('utilisateur', array('id' => $id, 'type' => 'compte')) );
            }
            //Modification des droits du compte
            elseif( $form->get('droit')->isClicked() )
            {
                
            }
            //annuler
            else
            {
                // On redirige sur l'accueil
                return $this->redirect($this->generateUrl('accueil_admin'));
            }
        }

        // Pour afficher le formulaire
        return $this->render('AppBundle:Admin:form_compte.html.twig', array(
            'form' => $form->createView(), 'isdroit' => false)
        );
    }

    //Permet d'afficher le formulaire des droits pré rempli d'un utilisateur
    public function form_droitsAction($id, Request $request)
    {

        if( $id == -1 )
        {
            $id = $request->request->get('id');
        }

        $em = $this->getDoctrine()->getManager();

        //utilisateur en question
        $user = $em->getRepository('AppBundle:Utilisateur')->getUtilisateurEtDroitsParId($id);
        //droits
        $roles = $em->getRepository('AppBundle:Role')->getRoles();

        //si réception du formulaire
        if ($request->isMethod('POST') ) 
        {
            if( null !== $request->request->get('btnvalider') )
            {   
                //on récupère les roles cochés
                $rolerecu = $request->request->get('appbundle_droits');
                $tab_roles = array();
                
                //tableau donnant les indices des roles
                foreach( $rolerecu as $cle => $valeur)
                    $tab_roles[] = $cle; 
                
                //suppresion des droits de l'utilisateur actuel
                $user->clearRoles();
                
                //parcours de tout les roles et ajout à l'utilisateur des roles demandés 
                foreach( $roles as $droit )
                {
                    if( count($tab_roles) > 0 )
                    {
                        if( false !== ($index = array_search($droit->getId(), $tab_roles)) )
                        {
                            //ajout du role
                            $user->addRole($droit);
                            //on retire du tableau
                            unset($tab_roles[$index]);
                        }
                    }
                    else
                    {
                        break;
                    }
                }

                //sauvegarde en base
                $em->flush();

                //message de réussite
                $request->getSession()->getFlashBag()->add('notice', 'Les droits ont été modifiés avec succès.');

                //On redirige
                return $this->redirect($this->generateUrl('utilisateur', array('id' => $id, 'type' => 'droits') ));
            }
            //annuler
            else
            {
                if( null !== $request->request->get('btnannuler') )
                {
                    // On redirige sur l'accueil
                    return $this->redirect($this->generateUrl('accueil_admin'));
                }
            }
        }
        // Pour afficher le formulaire
        return $this->render('AppBundle:Admin:form_droits.html.twig', array(
            'utilisateur' => $user, 'droits' => $roles)
        );
    }

    public function utilisateurAction($id, $type, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
          
        //utilisateur
        $user = $em->getRepository('AppBundle:Utilisateur')->getUtilisateurParId($id);
        //droits
        $roles = $em->getRepository('AppBundle:Role')->getRoles();

        if( $type == 'compte' )
        {
            $form = $this->createForm(new UtilisateurType(), $user, array('utilise_droit' => true) );

            if ($form->handleRequest($request)->isValid()) 
            {
                if( $form->get('modifier')->isClicked() )
                {
                    $em->flush();

                    $request->getSession()->getFlashBag()->add('notice', 'Utilisateur modifié avec succès.');

                    // On redirige sur le même formulaire si on veut modifier les droits
                    return $this->redirect($this->generateUrl('utilisateur', array('id' => $id, 'type' => $type) ));
                }
                //modifier les droits de l'utilisteur
                elseif( $form->get('droit')->isClicked() )
                {
                    return $this->redirect($this->generateUrl('utilisateur', array('id' => $id, 'type' => 'droits') ));
                }
                //annuler
                else
                    return $this->redirect($this->generateUrl('accueil_admin'));
            }

            return $this->render('AppBundle:Admin:utilisateur.html.twig', array('form' => $form->createView(), 'type' => $type) );
        }
        else if( $type == 'droits')
        {
            //si réception du formulaire
            if ($request->isMethod('POST') ) 
            {
                if( null !== $request->request->get('btnvalider') )
                {   
                    $rolerecu = $request->request->get('appbundle_droits');
                    
                    $tab_roles = array();
                    foreach( $rolerecu as $cle => $valeur)
                        $tab_roles[] = $cle; 

                    //suppresion des droits de l'utilisateur actuel
                    $user->clearRoles();
                    
                    foreach( $roles as $droit )
                    {
                        if( count($tab_roles) > 0 )
                        {
                            if( false !== ($index = array_search($droit->getId(), $tab_roles)) )
                            {
                                //ajout du role
                                $user->addRole($droit);
                                //on retire du tableau
                                unset($tab_roles[$index]);
                            }
                        }
                        else
                            break;
                    }

                    //sauvegarde en base
                    $em->flush();

                    //message de réussite
                    $request->getSession()->getFlashBag()->add('notice', 'Les droits ont été modifiés avec succès.');

                    //On redirige
                    return $this->redirect($this->generateUrl('utilisateur', array('id' => $id, 'type' => 'droits') ));
                }
                //annuler
                else
                {
                    if( null !== $request->request->get('btnannuler') )
                    {
                        // On redirige sur l'accueil
                        return $this->redirect($this->generateUrl('accueil_admin'));
                    }
                }
            }

            return $this->render('AppBundle:Admin:utilisateur.html.twig', array('utilisateur' => $user, 'droits' => $roles, 'type' => $type ) );
        }
    }

    //Permet de générer un mot de passe aléatoire pour la création d'un contact + utilisateur
    private function random_password( $length = 8 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }

    private function recupererSociete()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Societe');

        return $repository->getListeAccesCompte();       
    }
}