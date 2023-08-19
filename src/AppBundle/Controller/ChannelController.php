<?php
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Channel;
use AppBundle\Entity\Rate;
use AppBundle\Entity\Source;
use MediaBundle\Entity\Media;
use AppBundle\Form\ChannelType;
use AppBundle\Form\ChannelEditType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
class ChannelController extends Controller
{
    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $q = " 1 = 1 ";
        if ($request->query->has("q") and $request->query->get("q") != "") {
            $q .= " AND  p.title like '%" . $request->query->get("q") . "%'";
        }

        $dql = "SELECT p FROM AppBundle:Channel p  WHERE   " . $q . " ORDER BY p.created desc ";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $channels = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            15
        );
        $channels_count = $em->getRepository('AppBundle:Channel')->count();
        return $this->render('AppBundle:Channel:index.html.twig', array("channels_count" => $channels_count, "channels" => $channels));
    }
    public function api_by_idAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $channel=$em->getRepository("AppBundle:Channel")->find($id);
        if ($channel==null) {
            throw new NotFoundHttpException("Page not found");
        }
        return $this->render('AppBundle:Channel:api_one.html.php', array("channel" => $channel));
    }
    public function api_randomAction(Request $request, $categories, $token) {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $nombre = 30;
        $em = $this->getDoctrine()->getManager();
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $repository = $em->getRepository('AppBundle:Channel');
        $query = $repository->createQueryBuilder('p')
            ->leftJoin('p.categories', 'g')
            ->where("p.enabled = true",'g.id in (' . $categories . ')')
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults($nombre)
            ->getQuery();
        $channels = $query->getResult();
        return $this->render('AppBundle:Channel:api_all.html.php', array("channels" => $channels));
    }
    public function api_by_filtresAction(Request $request, $category,$country,$page, $token) {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $nombre = 30;
        $em = $this->getDoctrine()->getManager();
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $repository = $em->getRepository('AppBundle:Channel');
        if($category==0 and $country==0){
            $query = $repository->createQueryBuilder('p')
                ->where("p.enabled = true")
                ->addOrderBy('p.created', "desc")
                ->addOrderBy('p.id', 'ASC')
                ->setFirstResult($nombre * $page)
                ->setMaxResults($nombre)
                ->getQuery();
        } else if($category != 0 and $country == 0 ){
            $query = $repository->createQueryBuilder('p')
                ->leftJoin('p.categories', 'g')
                ->where("p.enabled = true",'g.id = ' . $category)
                ->addOrderBy('p.created', "desc")
                ->addOrderBy('p.id', 'ASC')
                ->setFirstResult($nombre * $page)
                ->setMaxResults($nombre)
                ->getQuery();
        }  else if($category == 0 and $country != 0 ){
            $query = $repository->createQueryBuilder('p')
                ->leftJoin('p.country', 'c')
                ->where("p.enabled = true",'c.id = ' . $country)
                ->addOrderBy('p.created', "desc")
                ->addOrderBy('p.id', 'ASC')
                ->setFirstResult($nombre * $page)
                ->setMaxResults($nombre)
                ->getQuery();
        } else if($category != 0 and $country != 0 ){
            $query = $repository->createQueryBuilder('p')
                ->leftJoin('p.categories', 'cat')
                ->leftJoin('p.country', 'cou')
                ->where("p.enabled = true",'cou.id = ' . $country,'cat.id = ' . $category)
                ->addOrderBy('p.created', "desc")
                ->addOrderBy('p.id', 'ASC')
                ->setFirstResult($nombre * $page)
                ->setMaxResults($nombre)
                ->getQuery();
        }
        $channels = $query->getResult();
        return $this->render('AppBundle:Channel:api_all.html.php', array("channels" => $channels));
    }

    public function ratingsAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $channel=$em->getRepository("AppBundle:Channel")->findOneBy(array("id"=>$id));
        if ($channel==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $rates_1 = $em->getRepository('AppBundle:Rate')->findBy(array("channel"=>$channel,"value"=>1));
        $rates_2 = $em->getRepository('AppBundle:Rate')->findBy(array("channel"=>$channel,"value"=>2));
        $rates_3 = $em->getRepository('AppBundle:Rate')->findBy(array("channel"=>$channel,"value"=>3));
        $rates_4 = $em->getRepository('AppBundle:Rate')->findBy(array("channel"=>$channel,"value"=>4));
        $rates_5 = $em->getRepository('AppBundle:Rate')->findBy(array("channel"=>$channel,"value"=>5));
        $rates = $em->getRepository('AppBundle:Rate')->findBy(array("channel"=>$channel));


        $ratings["rate_1"]=sizeof($rates_1);
        $ratings["rate_2"]=sizeof($rates_2);
        $ratings["rate_3"]=sizeof($rates_3);
        $ratings["rate_4"]=sizeof($rates_4);
        $ratings["rate_5"]=sizeof($rates_5);


        $t = sizeof($rates_1) + sizeof($rates_2) +sizeof($rates_3)+ sizeof($rates_4) + sizeof($rates_5);
        if ($t == 0) {
            $t=1;
        }
        $values["rate_1"]=(sizeof($rates_1)*100)/$t;
        $values["rate_2"]=(sizeof($rates_2)*100)/$t;
        $values["rate_3"]=(sizeof($rates_3)*100)/$t;
        $values["rate_4"]=(sizeof($rates_4)*100)/$t;
        $values["rate_5"]=(sizeof($rates_5)*100)/$t;

        $total=0;
        $count=0;
        foreach ($rates as $key => $r) {
           $total+=$r->getValue();
           $count++;
        }
        $v=0;
        if ($count != 0) {
            $v=$total/$count;
        }
        $rating=$v;
        $count=$em->getRepository('AppBundle:Rate')->countByChannel($channel->getId());

        $em= $this->getDoctrine()->getManager();
        $dql        = "SELECT c FROM AppBundle:Rate c  WHERE c.channel = ". $id ." ORDER BY c.created desc ";
        $query      = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1),
            10
        );
        return $this->render("AppBundle:Channel:ratings.html.twig", array("pagination"=>$pagination,"count"=>$count,"rating"=>$rating,"ratings"=>$ratings,"values"=>$values,"channel" => $channel));

    }
    public function commentsAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $channel=$em->getRepository("AppBundle:Channel")->findOneBy(array("id"=>$id));
        if ($channel==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $em= $this->getDoctrine()->getManager();
        $dql        = "SELECT c FROM AppBundle:Comment c  WHERE c.channel = ". $id ." ORDER BY c.created desc ";
        $query      = $em->createQuery($dql);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $query,
        $request->query->getInt('page', 1),
            10
        );
       $count=$em->getRepository('AppBundle:Comment')->countByChannel($channel->getId());

        return $this->render('AppBundle:Channel:comments.html.twig',
            array(
                'pagination' => $pagination,
                'channel' => $channel,
                'count' => $count,
            )
        );
    }
    public function api_add_rateAction(Request $request,$token) {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $user = $request->get("user");
        $channel = $request->get("channel");
        $key = $request->get("key");
        $value = $request->get("value");

        $em = $this->getDoctrine()->getManager();
        $channel_obj = $em->getRepository('AppBundle:Channel')->find($channel);
        $user_obj = $em->getRepository("UserBundle:User")->find($user);

        $code = "200";
        $message = "";
        $errors = array();
        if ($user_obj != null and $channel_obj != null) {
            if (sha1($user_obj->getPassword()) == $key) {
                $rate = $em->getRepository('AppBundle:Rate')->findOneBy(array("user" => $user_obj, "channel" => $channel_obj));
                if ($rate == null) {
                    $rate_obj = new Rate();
                    $rate_obj->setValue($value);
                    $rate_obj->setChannel($channel_obj);
                    $rate_obj->setUser($user_obj);
                    $em->persist($rate_obj);
                    $em->flush();
                    $message = "امتیاز شما با موفقیت اضافه شد";
                } else {
                    $rate->setValue($value);
                    $em->flush();
                    $message = "امتیاز شما با موفقیت ویرایش شد";
                }
                $rates = $em->getRepository('AppBundle:Rate')->findBy(array("channel" => $channel_obj));

                $total = 0;
                $count = 0;
                foreach ($rates as $key => $r) {
                    $total += $r->getValue();
                    $count++;
                }
                $v = 0;
                if ($count != 0) {
                    $v = $total / $count;
                }
                $v2 = number_format((float) $v, 1, '.', '');
                $errors[] = array("name" => "rate", "value" => $v2);

                $channel_obj->setRating($v2);
                $em->flush();
            }else {
                $code = "500";
                $message = "متاسفانه امتیاز شما در حال حاضر ثبت نشد";

            }
        } else {
            $code = "500";
            $message = "متاسفانه امتیاز شما در حال حاضر ثبت نشد";
        }
        $error = array(
            "code" => $code,
            "message" => $message,
            "values" => $errors,
        );
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($error, 'json');
        return new Response($jsonContent);
    }
    public function addAction(Request $request)
    {
        $channel= new Channel();
        $form = $this->createForm(new ChannelType(),$channel);
        $em=$this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                if( $channel->getFile()!=null ){
                    $media= new Media();
                    $media->setFile($channel->getFile());
                    $media->upload($this->container->getParameter('files_directory'));
                    $em->persist($media);
                    $em->flush();
                    $channel->setMedia($media);
                    $em->persist($channel);
                    $em->flush();
                    if(strlen($channel->getSourceurl())>1 ){
                       $choices = array(
                            1 => "youtube",
                            2 => "m3u8",
                            3 => "mov",
                            4 => "mp4",
                            6 => "mkv",
                            7 => "webm",
                            8 => "embed",
                        );

                        $source = new  Source();
                        $source->setType($choices[$channel->getSourcetype()]);

                        $source->setQuality($channel->getSourceQuality());
                        $source->setUrl($channel->getSourceurl());
                        $source->setChannel($channel);
                        $em->persist($source);
                        $em->flush();
                    }

                    $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                    return $this->redirect($this->generateUrl('app_channel_sources',array("id"=>$channel->getId())));
                }else{
                    $error = new FormError("باید یک تصویر انتخاب نمایید!");
                    $form->get('file')->addError($error);
                }
       }
       return $this->render("AppBundle:Channel:add.html.twig",array("form"=>$form->createView()));
    }

    public function deleteAction($id,Request $request){
        $em=$this->getDoctrine()->getManager();

        $channel = $em->getRepository("AppBundle:Channel")->find($id);
        if($channel==null){
            throw new NotFoundHttpException("Page not found");
        }
        $form=$this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit',array("label"=>"بله"))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            foreach ($channel->getSources() as $key => $source) {
                $media_source = $source->getMedia();
                $em->remove($source);
                $em->flush();
                if( $media_source!=null ){
                    $media_source->delete($this->container->getParameter('files_directory'));
                    $em->remove($media_source);
                    $em->flush();
                }
            }
            $slide = $em->getRepository("AppBundle:Slide")->findOneBy(array("channel"=>$channel));
            if ($slide!=null) {
                    $media_slide = $slide->getMedia();
                    $em->remove($slide);
                    $em->flush();
                    if( $media_slide!=null ){
                        $media_slide->delete($this->container->getParameter('files_directory'));
                        $em->remove($media_slide);
                        $em->flush();
                    }
            }

            $media_old = $channel->getMedia();
            $em->remove($channel);
            $em->flush();
            if( $media_old!=null ){
                $media_old->delete($this->container->getParameter('files_directory'));
                $em->remove($media_old);
                $em->flush();
            }
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_channel_index'));
        }
        return $this->render('AppBundle:Channel:delete.html.twig',array("form"=>$form->createView()));
    }
    public function editAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $channel=$em->getRepository("AppBundle:Channel")->find($id);
        if ($channel==null) {
            throw new NotFoundHttpException("Page not found");
        }
        $form = $this->createForm(new ChannelEditType(),$channel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if( $channel->getFile()!=null ){
                $media= new Media();
                $media_old=$channel->getMedia();
                $media->setFile($channel->getFile());
                $media->upload($this->container->getParameter('files_directory'));
                $em->persist($media);
                $em->flush();
                $channel->setMedia($media);
                $media_old->delete($this->container->getParameter('files_directory'));
                $em->remove($media_old);
                $em->flush();
            }
            $em->persist($channel);
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_channel_index'));

        }
        return $this->render("AppBundle:Channel:edit.html.twig",array("channel"=>$channel,"form"=>$form->createView()));
    }
    public function sourcesAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $channel=$em->getRepository("AppBundle:Channel")->find($id);
        if ($channel==null) {
            throw new NotFoundHttpException("Page not found");
        }

        return $this->render("AppBundle:Channel:sources.html.twig",array("channel"=>$channel));
    }
    public function api_add_shareAction(Request $request, $token) {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $channel = $em->getRepository("AppBundle:Channel")->findOneBy(array("id"=>$id,"enabled"=>true));
        if ($channel == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $channel->setShares($channel->getShares() + 1);
        $em->flush();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($channel->getShares(), 'json');
        return new Response($jsonContent);
    }
    public function api_add_viewAction(Request $request, $token) {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $channel = $em->getRepository("AppBundle:Channel")->findOneBy(array("id"=>$id,"enabled"=>true));
        if ($channel == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $channel->setViews($channel->getViews() + 1);
        $em->flush();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($channel->getViews(), 'json');
        return new Response($jsonContent);
    }
    public function shareAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $channel = $em->getRepository("AppBundle:Channel")->find($id);
        $setting = $em->getRepository("AppBundle:Settings")->findOneBy(array());
        if ($channel == null) {
            throw new NotFoundHttpException("Page not found");
        }
        return $this->render("AppBundle:Channel:share.html.twig", array("channel" => $channel, "setting" => $setting));
    }


    public function menuAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $ids = $request->request->get('ids');
        $val = $request->request->get('val');
        $type_work = $request->request->get('type');


        if ($type_work == "status") {
            if ($val == "active") {
                foreach ($ids as $key => $value) {
                    $channel_obj = $em->getRepository("AppBundle:Channel")->findOneBy(array( "id" => $value));

                    if (!$channel_obj->getEnabled()) {
                        $channel_obj->setEnabled(true);
                        $em->flush();
                    }
                }
            } else {
                foreach ($ids as $key => $value) {
                    $channel_obj = $em->getRepository("AppBundle:Channel")->findOneBy(array("id" => $value));

                    if ($channel_obj->getEnabled()) {
                        $channel_obj->setEnabled(false);
                        $em->flush();
                    }
                }
            }
        } else if ($type_work == "comment") {
            if ($val == "active") {
                foreach ($ids as $key => $value) {
                    $channel_obj = $em->getRepository("AppBundle:Channel")->findOneBy(array("id" => $value));

                    if (!$channel_obj->getComment()) {
                        $channel_obj->setComment(true);
                        $em->flush();
                    }
                }
            } else {
                foreach ($ids as $key => $value) {
                    $channel_obj = $em->getRepository("AppBundle:Channel")->findOneBy(array("id" => $value));

                    if ($channel_obj->getComment()) {
                        $channel_obj->setComment(false);
                        $em->flush();
                    }
                }
            }
        } else if ($type_work == "playas") {
            if ($val == "free") {
                foreach ($ids as $key => $value) {
                    $channel_obj = $em->getRepository("AppBundle:Channel")->findOneBy(array("id" => $value));

                    if ($channel_obj->getPlayas() != "1") {
                        $channel_obj->setPlayas("1");
                        $em->flush();
                    }
                }
            } else if ($val == "special") {
                foreach ($ids as $key => $value) {
                    $channel_obj = $em->getRepository("AppBundle:Channel")->findOneBy(array("id" => $value));

                    if ($channel_obj->getPlayas() != "2") {
                        $channel_obj->setPlayas("2");
                        $em->flush();
                    }
                }
            } else if ($val == "advertise") {
                foreach ($ids as $key => $value) {
                    $channel_obj = $em->getRepository("AppBundle:Channel")->findOneBy(array("id" => $value));

                    if ($channel_obj->getPlayas() != "3") {
                        $channel_obj->setPlayas("3");
                        $em->flush();
                    }
                }
            }
        }

        return new Response("عملیات با موفقیت انجام شد");

    }
}
?>