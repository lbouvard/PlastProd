<?php

// src/AppBundle/Controller/PlatformController.php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

class PlatformController extends Controller
{
	public function accueilAction()
	{
		return $this->render('AppBundle:Platform:accueil.html.twig');
	}
	
    public function menuAction(Request $request)
    {
	    return $this->render('AppBundle:Platform:menu.html.twig');
    }

	public function connexionAction(Request $request)
	{
	    // Si le visiteur est déjà identifié, on le redirige vers l'accueil
	    if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
	    	return $this->redirect($this->generateUrl('accueil'));
	    }

	    $session = $request->getSession();

	    // On vérifie s'il y a des erreurs d'une précédente soumission du formulaire
	    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
	    {
	      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
	    } 
	    else 
	    {
	      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
	      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
	    }

	    if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
    	{
        	return $this->redirect($this->generateUrl('accueil'));
    	}

		return $this->render('AppBundle:Platform:connexion.html.twig', array(
			'last_username' => $session->get(SecurityContext::LAST_USERNAME),
			'error' => $error,
		));
	}    
}