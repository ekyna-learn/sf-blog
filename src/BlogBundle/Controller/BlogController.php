<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

        return $this->render('BlogBundle:Blog:index.html.twig', [
            'posts' => $latestPosts,
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
        return new Response('Category action');
    }

    /**
     * Post detail action.
     *
     * @param string $categorySlug
     * @param string $postSlug
     *
     * @return Response
     */
    public function postAction($categorySlug, $postSlug)
    {
        return new Response('Post action');
    }
}
