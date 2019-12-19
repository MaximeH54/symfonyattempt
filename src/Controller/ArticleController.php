<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Article;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



/**
 * @Route("/article", name="article")
 */

class ArticleController extends AbstractController
{

    /**
     * @Route("/create", name="create")
     */

    public function create(Request $request)
    {
        $article = new Article;

        $form = $this->createFormBuilder($article)

            ->add('title', TextType::class)
            ->add('image', TextType::class)
            ->add('content', TextareaType::class)

            ->add('save', SubmitType::class, [
                'label' => 'Créer un article',
                'attr' => [
                    'class' => 'btn-success'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setDate(new \DateTime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
        }

        return $this->render('article/create.html.twig', [
            'form' => $form->createView()
        ]);


    }
}
?>
