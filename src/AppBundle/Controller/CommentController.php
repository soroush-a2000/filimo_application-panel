<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $status = " ";
        if ($request->query->get("status") == "enable" ) {
            $status .= " WHERE  c.enabled = true ";
        }else if ($request->query->get("status") == "disable" ) {
            $status .= " WHERE  c.enabled = false ";
        }
        $dql        = "SELECT c FROM AppBundle:Comment c " . $status . " ORDER BY c.created desc";
        $query      = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1),
            10
        );
        $comments_all=$em->getRepository('AppBundle:Comment')->findAll();
        $comments_disable=$em->getRepository('AppBundle:Comment')->findBy(array("enabled"=>false));
        $comments_enable=$em->getRepository('AppBundle:Comment')->findBy(array("enabled"=>true));

        return $this->render('AppBundle:Comment:index.html.twig',
            array(
                'pagination' => $pagination,
                'comments_all' => $comments_all,
                'comments_disable' => $comments_disable,
                'comments_enable' => $comments_enable
            )
        );
    }
    public function api_by_posterAction($id,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }
        $em=$this->getDoctrine()->getManager();

        $poster=$em->getRepository('AppBundle:Poster')->find($id);
        $comments=array();
        if ($poster!=null) {
            $comments=$em->getRepository('AppBundle:Comment')->findBy(array("poster"=>$poster ,"enabled"=>true));
        }

        return $this->render('AppBundle:Comment:api_by.html.php',
            array('comments' => $comments)
        );  
    }
    public function api_add_posterAction(Request $request,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }

        $user=$request->get("user");
        $comment=$request->get("comment");
        $id=$request->get("id");
        $key=$request->get("key");

        $em=$this->getDoctrine()->getManager();
        $user_obj=$em->getRepository("UserBundle:User")->find($user);
        $poster_obj=$em->getRepository('AppBundle:Poster')->find($id);

        $imagineCacheManager = $this->get('liip_imagine.cache.manager');


        $code = "200";
        $message = "";
        $errors = array();
        if ($user_obj != null and $poster_obj != null) {
            if (sha1($user_obj->getPassword()) == $key and $user_obj->isEnabled()) {
                $code="200";
                $message="";
                $errors=array();
                    $comment_obj = new Comment();
                    $comment_obj->setContent($comment);
                    $comment_obj->setEnabled(false);
                    $comment_obj->setUser($user_obj);

                    $em=$this->getDoctrine()->getManager();
                    $comment_obj->setPoster($poster_obj);
                    
                    $em->persist($comment_obj);
                    $em->flush();  
                    $errors[]=array("name"=>"id","value"=>$comment_obj->getId());
                    $errors[]=array("name"=>"content","value"=>$comment_obj->getContent());
                    $errors[]=array("name"=>"user","value"=>$comment_obj->getUser()->getName());
                    $errors[]=array("name"=>"enabled","value"=>$comment_obj->getEnabled());
                    if($comment_obj->getUser()->getMedia() ==  null ){
                        $errors[]=array("name"=>"image","value"=>"https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg");   
                    }else{
                        if ($comment_obj->getUser()->getMedia()->getType()=="link") {
                            $errors[]=array("name"=>"image","value"=>$comment_obj->getUser()->getMedia()->getUrl());   
                        }else{
                            $errors[]=array("name"=>"image","value"=>$imagineCacheManager->getBrowserPath($comment_obj->getUser()->getMedia()->getLink(), 'actor_thumb')) ;   
                        }
                    }
                    $errors[]=array("name"=>"created","value"=>"now");
                    $message="نظر شما ثبت شد و بعد از تایید نمایش داده میشود!";
                
            }else {
                $code = "500";
                $message = "متاسفیم نظر شما در حال حاضر ثبت نشد";

            }
        } else {
            $code = "500";
            $message = "متاسفیم نظر شما در حال حاضر ثبت نشد";
        }

        $error=array(
            "code"=>$code,
            "message"=>$message,
            "values"=>$errors
        );
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent=$serializer->serialize($error, 'json');
        return new Response($jsonContent);
    }
    public function api_by_channelAction($id,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $em=$this->getDoctrine()->getManager();

        $channel=$em->getRepository('AppBundle:Channel')->find($id);
        $comments=array();
        if ($channel!=null) {
            $comments=$em->getRepository('AppBundle:Comment')->findBy(array("channel"=>$channel , "enabled"=>true));
        }

        return $this->render('AppBundle:Comment:api_by.html.php',
            array('comments' => $comments)
        );
    }
    public function api_add_channelAction(Request $request,$token)
    {
        if ($token!=$this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");  
        }

        $user=$request->get("user");
        $comment=$request->get("comment");
        $id=$request->get("id");
        $key=$request->get("key");

        $em=$this->getDoctrine()->getManager();
        $user_obj=$em->getRepository("UserBundle:User")->find($user);
        $channel_obj=$em->getRepository('AppBundle:Channel')->find($id);


        $imagineCacheManager = $this->get('liip_imagine.cache.manager');

        $code = "200";
        $message = "";
        $errors = array();
        if ($user_obj != null and $channel_obj != null) {
            if (sha1($user_obj->getPassword()) == $key and $user_obj->isEnabled()) {
                $code="200";
                $message="";
                $errors=array();
                    $comment_obj = new Comment();
                    $comment_obj->setContent($comment);
                    $comment_obj->setEnabled(false);
                    $comment_obj->setUser($user_obj);

                    $em=$this->getDoctrine()->getManager();
                    $comment_obj->setChannel($channel_obj);
                    
                    $em->persist($comment_obj);
                    $em->flush();  
                    $errors[]=array("name"=>"id","value"=>$comment_obj->getId());
                    $errors[]=array("name"=>"content","value"=>$comment_obj->getContent());
                    $errors[]=array("name"=>"user","value"=>$comment_obj->getUser()->getName());
                    $errors[]=array("name"=>"enabled","value"=>$comment_obj->getEnabled());
                    if($comment_obj->getUser()->getMedia() ==  null ){
                        $errors[]=array("name"=>"image","value"=>"https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg");
                    }else{
                        if ($comment_obj->getUser()->getMedia()->getType()=="link") {
                            $errors[]=array("name"=>"image","value"=>$comment_obj->getUser()->getMedia()->getUrl());
                        }else{
                            $errors[]=array("name"=>"image","value"=>$imagineCacheManager->getBrowserPath($comment_obj->getUser()->getMedia()->getLink(), 'actor_thumb')) ;
                        }
                    }
                    $errors[]=array("name"=>"created","value"=>"now");
                    $message="نظر شما ثبت شد و بعد از تایید نمایش داده میشود!";
                
            }else {
                $code = "500";
                $message = "متاسفیم نظر شما در حال حاضر ثبت نشد";

            }
        } else {
            $code = "500";
            $message = "متاسفیم نظر شما در حال حاضر ثبت نشد";
        }

        $error=array(
            "code"=>$code,
            "message"=>$message,
            "values"=>$errors
        );
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent=$serializer->serialize($error, 'json');
        return new Response($jsonContent);
    }
    public function hideAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();
        $comment = $em->getRepository("AppBundle:Comment")->find($id);
        if($comment==null){
            throw new NotFoundHttpException("Page not found");
        }
        $user=$comment->getUser();
    	if ($comment->getEnabled()==true) {
    		$comment->setEnabled(false);
    	}else{
    		$comment->setEnabled(true);
    	}
        $em->flush();
        $this->addFlash('success', 'عملیات با موفقیت انجام شد');
        return  $this->redirect($request->server->get('HTTP_REFERER'));
    }


    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();

        $comment = $em->getRepository("AppBundle:Comment")->find($id);
        if($comment==null){
            throw new NotFoundHttpException("Page not found");
        }
        $poster=$comment->getPoster();
        $channel=$comment->getChannel();
        $user=$comment->getUser();
        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();
        if ($request->query->has("user")) {
            $url = $this->generateUrl('user_user_edit',array("id"=>$user->getId()));
        }
        else if ($request->query->has("channel")) {
                 if ($channel==null) {
                    $url = $this->generateUrl('app_comment_index');
                }else{
                    $url = $this->generateUrl('app_channel_comments',array("id"=>$channel->getId()));
                }
        }
        else if ($request->query->has("poster")) {
            if ($poster==null) {
                $url = $this->generateUrl('app_comment_index');
            }else{
                if ($poster->getType() == "movie") {
                    $url = $this->generateUrl('app_movie_comments',array("id"=>$poster->getId()));
                }else{
                    $url = $this->generateUrl('app_serie_comments',array("id"=>$poster->getId()));
                }     
            }
        }
        else {
          if ($request->query->has("status")) {
            if ($request->query->get("status") == "enable") {
                $url = $this->generateUrl('app_comment_index', array('status' => 'enable'));
            } else if ($request->query->get("status") == "disable") {
                $url = $this->generateUrl('app_comment_index', array('status' => 'disable'));
            }
           }else{
                $url = $this->generateUrl('app_comment_index');
            }
        }
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->remove($comment);
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($url);
        }
        return $this->render('AppBundle:Comment:delete.html.twig',array("url"=>$url,"form"=>$form->createView()));
    }
}
