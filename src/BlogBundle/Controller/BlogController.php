<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Comment;
use BlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BlogController
 * @package BlogBundle\Controller
 */
class BlogController extends Controller
{
    /**
     * Blog index action.
     *
     * @return Response
     */
    public function indexAction()
    {
        $latestPosts = $this->getDoctrine()
            ->getRepository('BlogBundle:Post')
            ->findBy([], ['publishedAt' => 'DESC'], 3);

        $categories = $this
            ->getDoctrine()
            ->getRepository('BlogBundle:Category')
            ->findAll();

        return $this->render('BlogBundle:Blog:index.html.twig', [
            'posts'      => $latestPosts,
            'categories' => $categories,
        ]);
    }

    /**
     * Category detail action.
     *
     * @param string $categorySlug
     *
     * @return Response
     */
    public function categoryAction($categorySlug)
    {
        $category = $this
            ->getDoctrine()
            ->getRepository('BlogBundle:Category')
            ->findOneBy(['slug' => $categorySlug]);

        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        $posts = $this
            ->getDoctrine()
            ->getRepository('BlogBundle:Post')
            ->findBy(['category' => $category]);

        return $this->render('BlogBundle:Blog:category.html.twig', [
            'category' => $category,
            'posts'    => $posts,
        ]);
    }

    /**
     * Post detail action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request)
    {
        $categorySlug = $request->attributes->get('categorySlug');
        $postSlug = $request->attributes->get('postSlug');
        
        $em = $this->getDoctrine()->getManager();

        /** @var \BlogBundle\Entity\Category $category */
        $category = $em
            ->getRepository('BlogBundle:Category')
            ->findOneBy(['slug' => $categorySlug]);
        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        /** @var \BlogBundle\Entity\Post $post */
        $post = $em
            ->getRepository('BlogBundle:Post')
            ->findOneBy([
                'category' => $category,
                'slug'     => $postSlug,
            ]);
        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        /** @var Comment[] $comments */
        $comments = $em
            ->getRepository('BlogBundle:Comment')
            ->findBy(['post' => $post]);

        // use BlogBundle\Entity\Comment;
        $comment = new Comment();
        $comment->setPost($post);

        // use BlogBundle\Form\CommentType;
        $form = $this
            ->createForm(new CommentType(), $comment)
            ->add('submit', 'submit');

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($comment);
                $em->flush();

                $this->addFlash('success', 'Votre commentaire a bien été enregistré !');

                return $this->redirectToRoute('blog_post', [
                    'categorySlug' => $categorySlug,
                    'postSlug' => $postSlug,
                ]);
            } else {
                $this->addFlash('danger', 'Le formulaire n\'est pas valide.');
            }
        }
        
        return $this->render('BlogBundle:Blog:post.html.twig', [
            'post'     => $post,
            'comments' => $comments,
            'form'     => $form->createView(),
        ]);
    }
}
