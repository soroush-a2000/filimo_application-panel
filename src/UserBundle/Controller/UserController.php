<?php

namespace UserBundle\Controller;

use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use UserBundle\Entity\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Form\Model\ChangePassword;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use UserBundle\Entity\verify;
use UserBundle\Form\UserType;
use MediaBundle\Entity\Media as Media;
use AppBundle\Entity\Transaction;

class UserController extends Controller
{


    function send_notificationToken($tokens, $message, $key)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $tokens,
            'data' => $message

        );
        $headers = array(
            'Authorization:key = ' . $key,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function commentAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("UserBundle:User")->find($id);
        if ($user == null) {
            throw new NotFoundHttpException("Page not found");
        }
        if ($user->hasRole("ROLE_ADMIN")) {
            throw new NotFoundHttpException("Page not found");
        }

        $dql = "SELECT c FROM AppBundle:Comment c  WHERE c.user = " . $user->getId();
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            7
        );

        return $this->render(
            'UserBundle:User:comment.html.twig', array(
                'pagination' => $pagination,
                'user' => $user
            )
        );
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("UserBundle:User")->find($id);
        if ($user == null) {
            throw new NotFoundHttpException("Page not found");
        }
        if ($user->hasRole("ROLE_ADMIN")) {
            throw new NotFoundHttpException("Page not found");
        }


        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('user_user_index'));
        }
        return $this->render(
            'UserBundle:User:edit.html.twig', array(
                "form" => $form->createView(),
                'user' => $user
            )
        );
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("UserBundle:User")->find($id);
        if ($user == null) {
            throw new NotFoundHttpException("Page not found");
        }

        $form = $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit', array("label" => "بله"))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $media_old = $user->getMedia();
            $em->remove($user);
            $em->flush();
            if ($media_old != null) {
                $media_old->delete($this->container->getParameter('files_directory'));
                $em->remove($media_old);
                $em->flush();
            }
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('user_user_index'));
        }
        return $this->render('UserBundle:User:delete.html.twig', array("form" => $form->createView()));
    }

    function number_format_short($n)
    {
        $precision = 1;
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }
        return $n_format . $suffix;
    }

    public function ratingsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("UserBundle:User")->find($id);
        if ($user == null) {
            throw new NotFoundHttpException("Page not found");
        }
        if ($user->hasRole("ROLE_ADMIN")) {
            throw new NotFoundHttpException("Page not found");
        }

        $dql = "SELECT c FROM AppBundle:Rate c  WHERE c.user = " . $user->getId();
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render(
            'UserBundle:User:ratings.html.twig', array(
                'user' => $user,
                "pagination" => $pagination,
            )
        );
    }

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("UserBundle:User")->findAll();

        $q = " AND ( 1=1 ) ";
        if ($request->query->has("q") and $request->query->get("q") != "") {
            $q .= " AND ( u.name like '%" . $request->query->get("q") . "%' or u.username like '%" . $request->query->get("q") . "%') ";
        }
        $dql = "SELECT u FROM UserBundle:User u  WHERE (NOT u.roles LIKE '%ROLE_ADMIN%')   " . $q . " ";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render("UserBundle:User:index.html.twig", array(
            'pagination' => $pagination,
            "users" => $users
        ));
    }

    public
    function commentsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("UserBundle:User")->find($id);
        if ($user == null) {
            throw new NotFoundHttpException("Page not found");
        }
        if ($user->hasRole("ROLE_ADMIN")) {
            throw new NotFoundHttpException("Page not found");
        }

        $dql = "SELECT c FROM AppBundle:Comment c  WHERE c.user = " . $user->getId();
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render(
            'UserBundle:User:comments.html.twig', array(
                'user' => $user,
                "pagination" => $pagination,
            )
        );
    }

    public function api_checkAction($id, $key, $token)
    {
        $code = "500";
        $message = "";
        $errors = array();
        if ($token != $this->container->getParameter('token_app')) {
            $code = 500;
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneBy(array("id" => $id));

        if ($user) {
            if ($user->isEnabled()) {
                if ($key == sha1($user->getPassword())) {
                    $code = 200;
                } else {
                    $code = 500;
                }
            } else {
                $code = 500;
            }
            if ($user->hasRole("ROLE_ADMIN")) {
                $code = 500;
            }
        }

        $error = array(
            "code" => $code,
            "message" => $message,
            "values" => $errors
        );
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($error, 'json');
        return new Response($jsonContent);
    }

    public
    function send($api, $amount, $redirect, $mobile = null, $factorNumber = null, $description = null)
    {
        return $this->curl_post('https://pay.ir/pg/send', [
            'api' => $api,
            'amount' => $amount,
            'redirect' => $redirect,
            'mobile' => $mobile,
            'factorNumber' => $factorNumber,
            'description' => $description,
        ]);
    }

    public
    function verify($api, $token)
    {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api' => $api,
            'token' => $token,
        ]);
    }

    public
    function curl_post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    public
    function api_pay_gatewayAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $user = $request->get("user");
        $key = $request->get("key");
        $amount = (int)$request->get("amount");

        $em = $this->getDoctrine()->getManager();
        $user_obj = $em->getRepository("UserBundle:User")->find($user);
        $settings = $em->getRepository("AppBundle:Settings")->findOneBy(array());

        $code = "200";
        $message = "";
        $errors = array();
        if ($user_obj != null) {
            if (sha1($user_obj->getPassword()) == $key) {

                $response_pay_url["name"] = "PAY_URL";
                $response_pay_url["value"] = "empty";

                $api = $settings->getPayApi();
                $mobile = $user_obj->getUsername();
                $factorNumber = "";
                $description = $settings->getPaymentDescription();
                $redirect = "flix://pay";
                $result = $this->send($api, $amount, $redirect, $mobile, $factorNumber, $description);
                $result = json_decode($result);
                if ($result->status) {
                    $user_obj->setPurchaseToken($result->token);
                    $em->flush();

                    $response_pay_url["value"] = "https://pay.ir/pg/$result->token";

                    $code = 200;
                    $message = "انتقال به صفحه پرداخت";
                } else {
                    $code = "500";
                    $message = "مشکلی پیش آمد!";
                }


                $errors[] = $response_pay_url;

            } else {
                $code = "500";
                $message = "مشکلی پیش آمد!";

            }
        } else {
            $code = "500";
            $message = "مشکلی پیش آمد!";
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

    public
    function api_buy_subscribeAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $user = $request->get("user");
        $key = $request->get("key");
        $days = $request->get("days");
        $extension = $request->get("extension");
        $pay_token = $request->get("pay_token");

        $em = $this->getDoctrine()->getManager();
        $user_obj = $em->getRepository("UserBundle:User")->find($user);
        $settings = $em->getRepository("AppBundle:Settings")->findOneBy(array());

        $code = "200";
        $message = "";
        $errors = array();
        if ($user_obj != null) {
            if (sha1($user_obj->getPassword()) == $key) {
                if ($pay_token=="0") {
                    if ($extension != "1") {
                        $user_obj->setPurchaseDate((new \DateTime('now')));
                        $user_obj->setSubDays($days);
                        $em->flush();

                        $response_subscribed_status["name"] = "SUBSCRIBED";
                        $response_subscribed_status["value"] = "TRUE";

                        $response_subscribe_days["name"] = "SUBSCRIBED_DAYS";
                        $response_subscribe_days["value"] = $days;

                        $errors[] = $response_subscribed_status;
                        $errors[] = $response_subscribe_days;

                        $code = 200;
                        $message = "باتشکر | اشتراک مورد نظر با موفقیت خریداری شد";
                    } else {
                        $collect = (int)$user_obj->getSubDays() + (int)$days;
                        $user_obj->setSubDays($collect);
                        $em->flush();
                        $myDays = $user_obj->getSubDays();
                        $oldDate = $user_obj->getPurchaseDate();
                        $date_add = $oldDate->add(new DateInterval('P' . $myDays . 'D'));
                        $ts1 = (new \DateTime('now'))->getTimestamp();
                        $ts2 = strtotime($date_add->format('Y-m-d H:i:s'));
                        $diff = $ts2 - $ts1;
                        $days_left = round($diff / (60 * 60 * 24));

                        $response_subscribed_status["name"] = "SUBSCRIBED";
                        $response_subscribed_status["value"] = "TRUE";

                        $response_subscribe_days["name"] = "SUBSCRIBED_DAYS";
                        $response_subscribe_days["value"] = $days_left;

                        $errors[] = $response_subscribed_status;
                        $errors[] = $response_subscribe_days;

                        $code = 200;
                        $message = "باتشکر | اشتراک شما با موفقیت تمدید شد";
                    }
                } else {
                    $result = $this->verify($settings->getPayApi(), $user_obj->getPurchaseToken());
                    $result = json_decode($result);
                    if (isset($result->status)) {
                        if ($result->status) {
                            $user_obj->setPurchaseToken($pay_token);
                            $em->flush();
                            if ($extension != "1") {
                                $user_obj->setPurchaseDate((new \DateTime('now')));
                                $user_obj->setSubDays($days);
                                $em->flush();

                                $response_subscribed_status["name"] = "SUBSCRIBED";
                                $response_subscribed_status["value"] = "TRUE";

                                $response_subscribe_days["name"] = "SUBSCRIBED_DAYS";
                                $response_subscribe_days["value"] = $days;

                                $errors[] = $response_subscribed_status;
                                $errors[] = $response_subscribe_days;

                                $code = 200;
                                $message = "باتشکر | اشتراک مورد نظر با موفقیت خریداری شد";
                            } else {
                                $collect = (int)$user_obj->getSubDays() + (int)$days;
                                $user_obj->setSubDays($collect);
                                $em->flush();
                                $myDays = $user_obj->getSubDays();
                                $oldDate = $user_obj->getPurchaseDate();
                                $date_add = $oldDate->add(new DateInterval('P' . $myDays . 'D'));
                                $ts1 = (new \DateTime('now'))->getTimestamp();
                                $ts2 = strtotime($date_add->format('Y-m-d H:i:s'));
                                $diff = $ts2 - $ts1;
                                $days_left = round($diff / (60 * 60 * 24));

                                $response_subscribed_status["name"] = "SUBSCRIBED";
                                $response_subscribed_status["value"] = "TRUE";

                                $response_subscribe_days["name"] = "SUBSCRIBED_DAYS";
                                $response_subscribe_days["value"] = $days_left;

                                $errors[] = $response_subscribed_status;
                                $errors[] = $response_subscribe_days;

                                $code = 200;
                                $message = "باتشکر | اشتراک شما با موفقیت تمدید شد";
                            }
                        } else {
                            $code = "500";
                            $message = "تراکنش با خطا مواجه شد!";
                        }
                    } else {
                        if ($_GET['status'] == 0) {
                            $code = "500";
                            $message = "تراکنش مجاز نیست!";
                        }
                    }
                }
            } else {
                $code = "500";
                $message = "مشکلی پیش آمد!";

            }
        } else {
            $code = "500";
            $message = "مشکلی پیش آمد!";
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

    public function api_editAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $name = str_replace('"', "", $request->get("name"));
        $id = $request->get("id");
        $key = str_replace('"', "", $request->get("key"));

        $code = "200";
        $message = "";
        $errors = array();

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('UserBundle:User')->find($id);

        if (!$user) {
            throw new NotFoundHttpException("Page not found");
        }
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');

        if (sha1($user->getPassword()) == $key) {

            if ($this->getRequest()->files->get('uploaded_file')) {
                $old_media = $user->getMedia();
                $media = new Media();
                $media->setFile($this->getRequest()->files->get('uploaded_file'));
                $media->upload($this->container->getParameter('files_directory'));
                $media->setEnabled(true);
                $em->persist($media);
                $em->flush();
                $user->setMedia($media);
                if ($old_media != null) {
                    $old_media->delete($this->container->getParameter('files_directory'));
                    $em->remove($old_media);
                    $em->flush();
                }
                $em->flush();

                if ($user->getMedia() == null) {
                    $errors[] = array("name" => "url", "value" => "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg");
                } else {
                    if ($user->getMedia()->getType() == "link") {
                        $errors[] = array("name" => "url", "value" => $user->getMedia()->getUrl());
                    } else {
                        $errors[] = array("name" => "url", "value" => $imagineCacheManager->getBrowserPath($user->getMedia()->getLink(), 'actor_thumb'));
                    }
                }
            }
            $user->setName($name);

            $em->flush();
            $errors[] = array("name" => "name", "value" => $user->getName());

            $code = 200;
            $message = "اطلاعات شما با موفقیت ویرایش شد";
        }
        $error = array(
            "code" => $code,
            "message" => $message,
            "values" => $errors
        );
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($error, 'json');
        return new Response($jsonContent);

    }

    public function api_registerAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $username = $request->get("username");
        $password = $request->get("password");
        $token_notif = $request->get("token_notif");
        $image = $request->get("image");
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');


        $code = "200";
        $message = "";
        $errors = array();
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $media = new Media();
        $media->setFile($this->getRequest()->files->get('uploaded_file'));
        $media->setUrl($image);
        $media->setType("link");
        $media->setExtension("jpeg");
        $media->setEnabled(true);
        $em->persist($media);
        $em->flush();

        $user->setUsername($username);
        $user->setPlainPassword($password);
        $user->setEmail($username);
        $user->setEnabled(true);
        $user->setResetPasswordsStatus(false);
        $random_num = rand(1000, 9999);
        $user->setType("phone");
        $user->setToken($token_notif);
        $user->setMedia($media);
        $em->persist($user);
        $em->flush();
        $user->setName("u_" . $user->getId() . $random_num);
        $em->flush();
        $code = 200;
        $message = "ثبت نام شما با موفقیت انجام شد";
        $errors[] = array("name" => "id", "value" => $user->getId());
        $errors[] = array("name" => "name", "value" => $user->getName());
        $errors[] = array("name" => "username", "value" => $user->getUsername());
        $errors[] = array("name" => "salt", "value" => $user->getSalt());
        if ($user->getMedia() == null) {
            $errors[] = array("name" => "url", "value" => "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg");
        } else {
            if ($user->getMedia()->getType() == "link") {
                $errors[] = array("name" => "url", "value" => $user->getMedia()->getUrl());
            } else {
                $errors[] = array("name" => "url", "value" => $imagineCacheManager->getBrowserPath($user->getMedia()->getLink(), 'actor_thumb'));
            }
        }
        $errors[] = array("name" => "type", "value" => $user->getType());
        $errors[] = array("name" => "token", "value" => sha1($user->getPassword()));
        $errors[] = array("name" => "enabled", "value" => $user->isEnabled());

        $error = array(
            "code" => $code,
            "message" => $message,
            "values" => $errors
        );
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($error, 'json');
        return new Response($jsonContent);
    }

    public function api_change_passwordAction($id, $password, $new_password, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }

        $code = "200";
        $message = "";
        $errors = array();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneBy(array("id" => $id));
        if ($user->hasRole("ROLE_ADMIN")) {
            throw new NotFoundHttpException("Page not found");
        }
        if ($user) {
            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {

                $newPasswordEncoded = $encoder->encodePassword($new_password, $user->getSalt());
                $user->setPassword($newPasswordEncoded);
                $em->persist($user);
                $em->flush();
                $code = 200;
                $message = "رمز عبور شما با موفقیت تغییر کرد";
                $errors[] = array("name" => "salt", "value" => $user->getSalt());
                $errors[] = array("name" => "token", "value" => sha1($user->getPassword()));

            } else {
                $code = 500;
                $message = "رمز عبور فعلی اشتباه است!";
            }
        }
        $error = array(
            "code" => $code,
            "message" => $message,
            "values" => $errors
        );
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($error, 'json');
        return new Response($jsonContent);
    }

    public function api_loginAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $mobile = $request->get("mobile");
        $password = $request->get("password");
        $token_notif = $request->get("token_notif");

        $code = "200";
        $message = "";
        $errors = array();
        $em = $this->getDoctrine()->getManager();
        $u = $em->getRepository('UserBundle:User')->findOneBy(array("username" => $mobile));
        if ($u) {
            if ($u->getResetPasswordStatus() == true) {
                if ($u->getResetPassword() == $password) {
                    if ($u->isEnabled() == true) {
                        $code = 200;
                        $message = "وارد شدید | رمز عبور خود را میتوانید تغییر دهید";
                        $u->setToken($token_notif);
                        $u->setResetPasswordsStatus(false);
                        $encoder_service = $this->get('security.encoder_factory');
                        $encoder = $encoder_service->getEncoder($u);
                        $newPasswordEncoded = $encoder->encodePassword($u->getResetPassword(), $u->getSalt());
                        $u->setPassword($newPasswordEncoded);
                        $em->flush();
                        $errors[] = array("name" => "id", "value" => $u->getId());
                        $errors[] = array("name" => "name", "value" => $u->getName());
                        $errors[] = array("name" => "username", "value" => $u->getUsername());
                        $errors[] = array("name" => "salt", "value" => $u->getSalt());
                        $errors[] = array("name" => "type", "value" => $u->getType());
                        $errors[] = array("name" => "token", "value" => sha1($u->getPassword()));
                        if ($u->getMedia() == null) {
                            $errors[] = array("name" => "url", "value" => "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg");
                        } else {
                            if ($u->getMedia()->getType() == "link") {
                                $errors[] = array("name" => "url", "value" => $u->getMedia()->getUrl());
                            } else {
                                $imagineCacheManager = $this->get('liip_imagine.cache.manager');
                                $errors[] = array("name" => "url", "value" => $imagineCacheManager->getBrowserPath($u->getMedia()->getLink(), 'actor_thumb'));
                            }
                        }
                        $errors[] = array("name" => "enabled", "value" => $u->isEnabled());
                    } else {
                        $message = "حساب شما مسدود شده است!";
                        $code = 500;
                    }

                } else {
                    $code = 500;
                    $message = "رمز عبور یا شماره موبایل وارد شده اشتباه است!";
                }
            } else {
                $encoder_service = $this->get('security.encoder_factory');
                $encoder = $encoder_service->getEncoder($u);
                if ($encoder->isPasswordValid($u->getPassword(), $password, $u->getSalt()) and !$u->hasRole("ROLE_ADMIN")) {
                    if ($u->isEnabled() == true) {
                        $code = 200;
                        $message = "شما با موفقیت وارد حساب خود شدید";
                        $u->setToken($token_notif);
                        $em->flush();
                        $errors[] = array("name" => "id", "value" => $u->getId());
                        $errors[] = array("name" => "name", "value" => $u->getName());
                        $errors[] = array("name" => "username", "value" => $u->getUsername());
                        $errors[] = array("name" => "salt", "value" => $u->getSalt());
                        $errors[] = array("name" => "type", "value" => $u->getType());
                        $errors[] = array("name" => "token", "value" => sha1($u->getPassword()));
                        if ($u->getMedia() == null) {
                            $errors[] = array("name" => "url", "value" => "https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg");
                        } else {
                            if ($u->getMedia()->getType() == "link") {
                                $errors[] = array("name" => "url", "value" => $u->getMedia()->getUrl());
                            } else {
                                $imagineCacheManager = $this->get('liip_imagine.cache.manager');
                                $errors[] = array("name" => "url", "value" => $imagineCacheManager->getBrowserPath($u->getMedia()->getLink(), 'actor_thumb'));
                            }
                        }
                        $errors[] = array("name" => "enabled", "value" => $u->isEnabled());
                    } else {
                        $message = "حساب شما مسدود شده است!";
                        $code = 500;
                    }

                } else {
                    $code = 500;
                    $message = "رمز عبور یا شماره موبایل وارد شده اشتباه است!";
                }
            }
        } else {
            $code = 500;
            $message = "رمز عبور یا شماره موبایل وارد شده اشتباه است!";
        }
        $error = array(
            "code" => $code,
            "message" => $message,
            "values" => $errors
        );
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($error, 'json');
        return new Response($jsonContent);
    }

    public function api_check_codeAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }

        $check_code = $request->get("check_code");

        $code = "200";
        $message = "";
        $errors = array();

        $em = $this->getDoctrine()->getManager();
        $verify = $em->getRepository('UserBundle:Verify')->findOneBy(array("code" => $check_code, "outdated" => false));
        if ($verify != null) {
            $date = $verify->getCreated();
            $now_date = (new \DateTime('now'))->getTimestamp();
            if ($now_date <= strtotime($date->format('Y-m-d H:i:s'))) {
                if ($verify->getCode() == $check_code) {
                    $code = 200;
                    $message = "کد تایید صحیح است";
                    $verify->setOutDated(true);
                    $em->flush();
                } else {
                    $code = 500;
                    $message = "کد تایید اشتباه است!";
                }
            } else {
                $verify->setOutDated(true);
                $em->flush();
                $code = 300;
                $message = "کد تایید منقضی شده است!";
            }

        } else {
            $code = 500;
            $message = "کد تایید اشتباه است!";

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

    public function api_reset_passwordAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }

        $phone_number = $request->get("mobile");
        $code = "200";
        $message = "";
        $errors = array();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneBy(array("username" => $phone_number));
        if (!$user) {
            $code = 500;
            $message = "شماره موبایل مورد نظر یافت نشد!";
        } else {
            if ($this->container->getParameter('sms_service_type') == "1") {

                $sms_server = $this->container->getParameter('sms_server');
                $username = $this->container->getParameter('sms_user_name');
                $password = $this->container->getParameter('sms_password');
                $from = $this->container->getParameter('sms_line');
                $reset_pcode = $this->container->getParameter('sms_reset_pcode');
                $to = array($phone_number);

                $rendom_password = $this->createRandomPassword();

                $input_data = array("code" => $rendom_password);
                $url = $sms_server . "/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$reset_pcode";
                $handler = curl_init($url);
                curl_setopt($handler, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                curl_setopt($handler, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);


                $result = curl_exec($handler);
                if ($result === FALSE) {
                    $code = "500";
                    $message = "با عرض پوزش مشکلی پیش آمد!";
                    die('Curl failed: ' . curl_error($handler));
                } else {
                    $user->setResetPasswordsStatus(true);
                    $user->setResetPassword($rendom_password);
                    $em->flush();
                    $code = 200;
                    $message = "رمز عبور جدید به شماره مورد نظر ارسال گردید";

                }
                curl_close($handler);

            } else {

                $kn_sms_server = $this->container->getParameter('kn_sms_server');
                $kn_sms_api_key = $this->container->getParameter('kn_sms_api_key');
                $kn_sms_reset_pcode = $this->container->getParameter('kn_sms_reset_pcode');

                $url = $kn_sms_server . $kn_sms_api_key . "/verify/lookup.json";
                $rendom_password = $this->createRandomPassword();
                $data = array(
                    "receptor" => $phone_number,
                    "token" => $rendom_password,
                    "token2" => "",
                    "token3" => "",
                    "template" => $kn_sms_reset_pcode,
                    "type" => null
                );
                $headers = array(
                    'Accept: application/json',
                    'Constent-Type: application/x-www-form-urlencoded',
                    'charset: utf-8'
                );
                $fields_string = "";
                if (!is_null($data)) {
                    $fields_string = http_build_query($data);
                }

                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $url);
                curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);

                $response = curl_exec($handle);
                $code_status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                $curl_errno = curl_errno($handle);

                if ($curl_errno) {
                    $code = 500;
                    $message = "با عرض پوزش مشکلی پیش آمد!";
                }
                $json_response = json_decode($response);
                if ($code_status != 200 && is_null($json_response)) {
                    $code = 500;
                    $message = "با عرض پوزش مشکلی پیش آمد!";
                } else {
                    $user->setResetPasswordsStatus(true);
                    $user->setResetPassword($rendom_password);
                    $em->flush();
                    $code = 200;
                    $message = "رمز عبور جدید به شماره مورد نظر ارسال گردید";
                }
                curl_close($handle);
            }
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

    function createRandomPassword()
    {
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double)microtime() * 1000000);
        $i = 0;
        $pass = '';
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }

    public function api_send_codeAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }

        $phone_number = $request->get("phone_number");
        $random_code = rand(10000, 99999);

        $code = "200";
        $message = "";
        $errors = array();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->findOneBy(array("username" => $phone_number));
        if ($user) {
            $code = 500;
            $message = "با این شماره موبایل قبلا ثبت نام شده است!";
        } else {
            if ($this->container->getParameter('sms_service_type') == "1") {

                $sms_server = $this->container->getParameter('sms_server');
                $username = $this->container->getParameter('sms_user_name');
                $password = $this->container->getParameter('sms_password');
                $from = $this->container->getParameter('sms_line');
                $pcode = $this->container->getParameter('sms_pcode');
                $to = array($phone_number);
                $input_data = array("code" => $random_code);

                $url = $sms_server . "/patterns/pattern?username=" . $username . "&password=" . urlencode($password) . "&from=$from&to=" . json_encode($to) . "&input_data=" . urlencode(json_encode($input_data)) . "&pattern_code=$pcode";

                $handler = curl_init($url);
                curl_setopt($handler, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                curl_setopt($handler, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);


                $result = curl_exec($handler);
                if ($result === FALSE) {
                    $code = "500";
                    $message = "با عرض پوزش مشکلی پیش آمد!";
                    die('Curl failed: ' . curl_error($handler));
                } else {
                    $em = $this->getDoctrine()->getManager();
                    $verify = $em->getRepository('UserBundle:Verify')->findOneBy(array("mobile" => $phone_number));
                    if ($verify == null) {
                        $verify = new Verify();
                        $verify->setMobile($phone_number);
                        $verify->setCode($random_code);
                        $verify->setOutDated(false);
                        $add_second = new \DateTime();
                        $add_second->add(new DateInterval('PT60S'));
                        $verify->setCreated($add_second);

                        $em->persist($verify);
                        $em->flush();

                    } else {
                        $verify->setMobile($phone_number);
                        $verify->setCode($random_code);
                        $verify->setOutDated(false);
                        $add_second = new \DateTime();
                        $add_second->add(new DateInterval('PT60S'));
                        $verify->setCreated($add_second);
                        $em->flush();

                    }


                    $code = 200;
                    $message = "کد تایید به شماره شما ارسال گردید!";

                }
                curl_close($handler);

            } else {

                $kn_sms_server = $this->container->getParameter('kn_sms_server');
                $kn_sms_api_key = $this->container->getParameter('kn_sms_api_key');
                $kn_sms_pcode = $this->container->getParameter('kn_sms_pcode');

                $url = $kn_sms_server . $kn_sms_api_key . "/verify/lookup.json";
                $data = array(
                    "receptor" => $phone_number,
                    "token" => $random_code,
                    "token2" => "",
                    "token3" => "",
                    "template" => $kn_sms_pcode,
                    "type" => null
                );
                $headers = array(
                    'Accept: application/json',
                    'Constent-Type: application/x-www-form-urlencoded',
                    'charset: utf-8'
                );
                $fields_string = "";
                if (!is_null($data)) {
                    $fields_string = http_build_query($data);
                }

                $handle = curl_init();
                curl_setopt($handle, CURLOPT_URL, $url);
                curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $fields_string);

                $response = curl_exec($handle);
                $code_status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                $curl_errno = curl_errno($handle);

                if ($curl_errno) {
                    $code = 500;
                    $message = "با عرض پوزش مشکلی پیش آمد!";
                }
                $json_response = json_decode($response);
                if ($code_status != 200 && is_null($json_response)) {
                    $code = 500;
                    $message = "با عرض پوزش مشکلی پیش آمد!";
                } else {
                    $em = $this->getDoctrine()->getManager();
                    $verify = $em->getRepository('UserBundle:Verify')->findOneBy(array("mobile" => $phone_number));
                    if ($verify == null) {
                        $verify = new Verify();
                        $verify->setMobile($phone_number);
                        $verify->setCode($random_code);
                        $verify->setOutDated(false);
                        $add_second = new \DateTime();
                        $add_second->add(new DateInterval('PT60S'));
                        $verify->setCreated($add_second);

                        $em->persist($verify);
                        $em->flush();

                    } else {
                        $verify->setMobile($phone_number);
                        $verify->setCode($random_code);
                        $verify->setOutDated(false);
                        $add_second = new \DateTime();
                        $add_second->add(new DateInterval('PT60S'));
                        $verify->setCreated($add_second);
                        $em->flush();

                    }

                    $code = 200;
                    $message = "کد تایید به شماره شما ارسال گردید!";
                }
                curl_close($handle);
            }
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
}
