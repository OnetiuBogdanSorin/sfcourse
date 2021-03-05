<?php

namespace App\Controller;

use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/posts", name="post.")
 * Class PostController
 * @package App\Controller
 */

class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param PostRepository $postRep
     * @return Response
     */
    public function index(PostRepository $postRep): Response
    {
        $posts = $postRep->findAll();

        dump($posts);

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $post = new Post();

        $forms = $this->createForm(PostType::class, $post);

        $forms->handleRequest($request);

        if($forms->isSubmitted() && $forms->isValid())
        {
            //entity manager
            $em= $this->getDoctrine()->getManager();
            /** @var UploadedFile $file */
            $file = $request->files->get('post')['attachement'];
            if($file){
                $filename=md5(uniqid()) .'.'.$file->guessClientExtension();
                $file->move(
                    $this->getParameter('uploads_dir'),
                    $filename);
                $post->setImage($filename) ;
            }
            $em->persist($post);
            $em->flush();
            return $this->redirect($this->generateUrl('post.index'));
        }

        $this->addFlash('success','Post was created');

        return $this->render('post/create.html.twig',
        [
            'form' => $forms->createView()
        ]);
    }

    /**
     * @Route("/show/{id}", name="show")
     * @param $id
     * @param PostRepository $postRepo
     * @return Response
     */
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig',[
            'post' => $post
        ]);
    }


    /**
     * @Route("/delete/{id}", name="delete")
     * @param Post $post
     */
    public function delete(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        $this->addFlash('success','Post was removed');
        return $this->redirect($this->generateUrl('post.index'));

    }
}
