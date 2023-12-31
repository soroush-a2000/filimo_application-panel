<?php

namespace AppBundle\Controller;

use DateInterval;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Version;
use AppBundle\Form\VersionType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class VersionController extends Controller
{

    public function addAction(Request $request)
    {
        $version = new Version();
        $form = $this->createForm(new VersionType(), $version);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($version);
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_version_index'));
        }
        return $this->render("AppBundle:Version:add.html.twig", array("form" => $form->createView()));
    }

    public function api_checkAction(Request $request, $code, $user, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $em = $this->getDoctrine()->getManager();
        $version = $em->getRepository("AppBundle:Version")->findOneBy(array("code" => $code, "enabled" => true));
        $response = array();
        $code = "200";
        $message = "";
        $errors = array();
        if ($version == null) {
            $versions = $em->getRepository("AppBundle:Version")->findBy(array("enabled" => true), array("code" => "asc"));
            $a = null;
            foreach ($versions as $key => $value) {
                $a = $value;
            }
            if ($a == null) {
                $code = "200";
                $response["name"] = "update";
                $response["value"] = "App on update";
            } else {
                $code = "202";
                $response["name"] = "update";
                if($a->getClearData() == false){
                    $response["value"] = "0";
                }else{
                    $response["value"] = "1";
                }
                $message = $a->getFeatures();
            }
        } else {
            $code = "200";
            $response["name"] = "update";
            $response["value"] = "App on update";
        }
        $response_user["name"] = "user";
        $response_user["value"] = "200";
        if ($user != 0) {
            $user_obj = $em->getRepository("UserBundle:User")->findOneBy(array("id" => $user, "enabled" => true));
            if ($user_obj == null) {
                $response_user["name"] = "user";
                $response_user["value"] = "403";
            } else {
                $response_user["name"] = "user";
                $response_user["value"] = "200";

            }
        }


        $errors[] = $response;
        $errors[] = $response_user;


        $user_obj = $em->getRepository("UserBundle:User")->findOneBy(array("id" => $user, "enabled" => true));
        $settings = $em->getRepository("AppBundle:Settings")->findOneBy(array());
        $u = $em->getRepository('UserBundle:User')->findOneBy(array("id" => $user));

        $myDayss = $user_obj->getToken();
        $tokenuser["name"] = "TOKEN";
        $tokenuser["value"] = $myDayss;

        if ($user != 0) {
            if ($user_obj != null) {
                if ($user_obj->getSubDays() != null) {

                    $myDays = $user_obj->getSubDays();
                    $oldDate = $user_obj->getPurchaseDate();
                    $date_add = $oldDate->add(new DateInterval('P' . $myDays . 'D'));
                    $ts1 = (new \DateTime('now'))->getTimestamp();
                    $ts2 = strtotime($date_add->format('Y-m-d H:i:s'));
                    $diff = $ts2 - $ts1;
                    $days_left = round($diff / (60 * 60 * 24));
                    $now_date = (new \DateTime('now'))->getTimestamp();

                    if ($now_date <= $ts2) {
                        $response_expire_date["name"] = "SUBSCRIBED";
                        $response_expire_date["value"] = "TRUE";

                        $response_subscribe_days["name"] = "SUBSCRIBED_DAYS";
                        $response_subscribe_days["value"] = $days_left;
                    } else {
                        $response_expire_date["name"] = "SUBSCRIBED";
                        $response_expire_date["value"] = "FALSE";

                        $response_subscribe_days["name"] = "SUBSCRIBED_DAYS";
                        $response_subscribe_days["value"] = "FINISH";
                    }

                } else {
                    $response_expire_date["name"] = "SUBSCRIBED";
                    $response_expire_date["value"] = "FALSE";

                    $response_subscribe_days["name"] = "SUBSCRIBED_DAYS";
                    $response_subscribe_days["value"] = "0";
                }
            } else {

                $response_expire_date["name"] = "SUBSCRIBED";
                $response_expire_date["value"] = "FALSE";

                $response_subscribe_days["name"] = "SUBSCRIBED_DAYS";
                $response_subscribe_days["value"] = "0";
            }
        } else {

            $response_expire_date["name"] = "SUBSCRIBED";
            $response_expire_date["value"] = "FALSE";

            $response_subscribe_days["name"] = "SUBSCRIBED_DAYS";
            $response_subscribe_days["value"] = "0";

        }

        $response_ads_rewarded["name"] = "ADMIN_REWARDED_ADMOB_ID";
        $response_ads_rewarded["value"] = $settings->getRewardedadmobid();

        $response_ads_interstitial_admob_id["name"] = "ADMIN_INTERSTITIAL_ADMOB_ID";
        $response_ads_interstitial_admob_id["value"] = $settings->getInterstitialadmobid();

        $response_ads_interstitial_facebook_id["name"] = "ADMIN_INTERSTITIAL_FACEBOOK_ID";
        $response_ads_interstitial_facebook_id["value"] = $settings->getInterstitialfacebookid();

        $response_ads_interstitial_type["name"] = "ADMIN_INTERSTITIAL_TYPE";
        $response_ads_interstitial_type["value"] = $settings->getInterstitialtype();

        $response_ads_interstitial_click["name"] = "ADMIN_INTERSTITIAL_CLICKS";
        $response_ads_interstitial_click["value"] = $settings->getInterstitialclick();

        $response_ads_banner_admob_id["name"] = "ADMIN_BANNER_ADMOB_ID";
        $response_ads_banner_admob_id["value"] = $settings->getBanneradmobid();

        $response_ads_banner_facebook_id["name"] = "ADMIN_BANNER_FACEBOOK_ID";
        $response_ads_banner_facebook_id["value"] = $settings->getBannerfacebookid();

        $response_ads_banner_type["name"] = "ADMIN_BANNER_TYPE";
        $response_ads_banner_type["value"] = $settings->getBannertype();

        $response_ads_native_facebook_id["name"] = "ADMIN_NATIVE_FACEBOOK_ID";
        $response_ads_native_facebook_id["value"] = $settings->getNativefacebookid();

        $response_ads_native_admob_id["name"] = "ADMIN_NATIVE_ADMOB_ID";
        $response_ads_native_admob_id["value"] = $settings->getNativeadmobid();

        $response_ads_native_item["name"] = "ADMIN_NATIVE_LINES";
        $response_ads_native_item["value"] = $settings->getNativeitem();

        $response_ads_native_type["name"] = "ADMIN_NATIVE_TYPE";
        $response_ads_native_type["value"] = $settings->getNativetype();

        $response_app_download_link["name"] = "APPLICATION_DOWNLOAD_LINK";
        $response_app_download_link["value"] = $settings->getDownloadLink();

        $response_auto_slider["name"] = "AUTO_SLIDER";
        $response_auto_slider["value"] = $settings->getAutoSlider();

        $response_time_slider["name"] = "TIME_SLIDER";
        $response_time_slider["value"] = $settings->getTimeSlider();

        $response_payment_gateway["name"] = "PAYMENT_GATEWAY";
        $response_payment_gateway["value"] = $settings->getPaymentGateway();

        $response_merchant_id["name"] = "MERCHANT_ID";
        $response_merchant_id["value"] = $settings->getMerchantId();

        $response_payment_description["name"] = "PAYMENT_DESCRIPTION";
        $response_payment_description["value"] = $settings->getPaymentDescription();


        $errors[] = $response_expire_date;
        $errors[] = $response_subscribe_days;
        $errors[] = $response_ads_rewarded;
        $errors[] = $response_ads_interstitial_admob_id;
        $errors[] = $response_ads_interstitial_facebook_id;
        $errors[] = $response_ads_interstitial_type;
        $errors[] = $response_ads_interstitial_click;
        $errors[] = $response_ads_banner_admob_id;
        $errors[] = $response_ads_banner_facebook_id;
        $errors[] = $response_ads_banner_type;
        $errors[] = $response_ads_native_facebook_id;
        $errors[] = $response_ads_native_admob_id;
        $errors[] = $response_ads_native_item;
        $errors[] = $response_ads_native_type;
        $errors[] = $response_app_download_link;
        $errors[] = $response_auto_slider;
        $errors[] = $response_time_slider;
        $errors[] = $response_payment_gateway;
        $errors[] = $response_merchant_id;
        $errors[] = $response_payment_description;
        $errors[] = $tokenuser;

        $error = array(
            "code" => $code,
            "message" => $message,
            "values" => $errors,
        );
        header('Content-Type: application/json');
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($error, 'json');
        return new Response($jsonContent);
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $versions = $em->getRepository('AppBundle:Version')->findBy(array(), array("code" => "asc"));
        return $this->render('AppBundle:Version:index.html.twig', array("versions" => $versions));
    }


    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $version = $em->getRepository("AppBundle:Version")->find($id);
        if ($version == null) {
            throw new NotFoundHttpException("Page not found");
        }

        $form = $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit', array("label" => "بله"))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //if (sizeof($version->getAlbums())==0) {
            $em->remove($version);
            $em->flush();


            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            //}else{
            //   $this->addFlash('danger', 'Operation has been cancelled ,Your album not empty');
            //}
            return $this->redirect($this->generateUrl('app_version_index'));
        }
        return $this->render('AppBundle:Version:delete.html.twig', array("form" => $form->createView()));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $version = $em->getRepository("AppBundle:Version")->find($id);
        if ($version == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $form = $this->createForm(new VersionType(), $version);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($version);
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_version_index'));

        }
        return $this->render("AppBundle:Version:edit.html.twig", array("form" => $form->createView()));
    }
}

?>