<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Contact;
use App\Form\ContactType;


class VitrineController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */

    function accueil()
    {
        return $this->render('vitrine/index.html.twig');
    }

    /**
     * @Route("/ma-galerie", name="galerie")
     */

    function galerie()
    {
        return $this->render('vitrine/galerie.html.twig');
    }

       /**
     * @Route("/blog", name="blog")
     */

    function blog()
    {
        return $this->render('vitrine/blog.html.twig');
    }

    /**
     * @Route("/contactez-nous", name="contact")
     */

    function contact(Request $request): Response
    {
         // INJECTION DE DEPENDANCE
        // => SYMFONY NOUS FOURNIT L'OBJET $request
        // => $request BOITE QUI CONTIENT LES INFOS DE FORMULAIRE ($_GET, $_POST, $_REQUEST)

        // ON CREE UN OBJET POUR STOCKER LES INFOS DU FORMULAIRE
        $contact = new Contact();
        
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            //return $this->redirectToRoute('contact_index');
        }
        

        // LA METHODE render VIENT DE LA CLASSE PARENTE AbstractController
        // ON VA CHARGER LE CODE DU TEMPLATE
        // templates/vitrine/contact/html.twig
        return $this->render('vitrine/contact.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }
}
