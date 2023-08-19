<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Poster;
use AppBundle\Entity\Rate;
use AppBundle\Entity\Role;
use AppBundle\Entity\Source;
use AppBundle\Entity\Subtitle;
use MediaBundle\Entity\Media;
use AppBundle\Form\MovieType;
use AppBundle\Form\SubtitleType;
use AppBundle\Form\RoleType;
use AppBundle\Form\SourceType;
use AppBundle\Form\EditMovieType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;

class MovieController extends Controller
{
    public function api_by_idAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $poster = $em->getRepository("AppBundle:Poster")->find($id);
        if ($poster == null) {
            throw new NotFoundHttpException("Page not found");
        }
        return $this->render('AppBundle:Movie:api_one.html.php', array("poster" => $poster));
    }

    public function api_add_viewAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $poster = $em->getRepository("AppBundle:Poster")->findOneBy(array("id" => $id, "enabled" => true));
        if ($poster == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $poster->setViews($poster->getViews() + 1);
        $em->flush();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($poster->getViews(), 'json');
        return new Response($jsonContent);
    }

    public function api_add_shareAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $poster = $em->getRepository("AppBundle:Poster")->findOneBy(array("id" => $id, "enabled" => true));
        if ($poster == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $poster->setShares($poster->getShares() + 1);
        $em->flush();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($poster->getShares(), 'json');
        return new Response($jsonContent);
    }

    public function api_add_downloadAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $poster = $em->getRepository("AppBundle:Poster")->findOneBy(array("id" => $id, "enabled" => true));
        if ($poster == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $poster->setDownloads($poster->getDownloads() + 1);
        $em->flush();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($poster->getDownloads(), 'json');
        return new Response($jsonContent);
    }

    public function api_poster_by_filtresAction(Request $request, $genre, $country, $order, $page, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $nombre = 30;
        $em = $this->getDoctrine()->getManager();
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $repository = $em->getRepository('AppBundle:Poster');
        $dir = "DESC";
        if ("title" == $order) {
            $dir = "ASC";
        }

        if ($genre == 0 and $country == 0) {
            $query = $repository->createQueryBuilder('p')
                ->where("p.enabled = true")
                ->addOrderBy('p.' . $order, $dir)
                ->addOrderBy('p.id', 'ASC')
                ->setFirstResult($nombre * $page)
                ->setMaxResults($nombre)
                ->getQuery();
        } else if ($genre != 0 and $country == 0) {
            $query = $repository->createQueryBuilder('p')
                ->leftJoin('p.genres', 'g')
                ->where("p.enabled = true", 'g.id = ' . $genre)
                ->addOrderBy('p.' . $order, $dir)
                ->addOrderBy('p.id', 'ASC')
                ->setFirstResult($nombre * $page)
                ->setMaxResults($nombre)
                ->getQuery();
        } else if ($genre == 0 and $country != 0) {
            $query = $repository->createQueryBuilder('p')
                ->where("p.enabled = true", 'p.country = ' . $country)
                ->addOrderBy('p.' . $order, $dir)
                ->addOrderBy('p.id', 'ASC')
                ->setFirstResult($nombre * $page)
                ->setMaxResults($nombre)
                ->getQuery();
        } else if ($genre != 0 and $country != 0) {
            $query = $repository->createQueryBuilder('p')
                ->leftJoin('p.genres', 'g')
                ->where("p.enabled = true", 'g.id = ' . $genre, 'p.country = ' . $country)
                ->addOrderBy('p.' . $order, $dir)
                ->addOrderBy('p.id', 'ASC')
                ->setFirstResult($nombre * $page)
                ->setMaxResults($nombre)
                ->getQuery();
        }

        $posters_list = $query->getResult();
        return $this->render('AppBundle:Movie:api_all.html.php', array("posters_list" => $posters_list));
    }

    public function api_by_filtresAction(Request $request, $genre, $order, $page, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $nombre = 30;
        $em = $this->getDoctrine()->getManager();
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $repository = $em->getRepository('AppBundle:Poster');
        $dir = "DESC";
        if ("title" == $order) {
            $dir = "ASC";
        }
        if ($genre == 0) {
            $query = $repository->createQueryBuilder('p')
                ->where("p.enabled = true", "p.type like 'movie' ")
                ->addOrderBy('p.' . $order, $dir)
                ->addOrderBy('p.id', 'ASC')
                ->setFirstResult($nombre * $page)
                ->setMaxResults($nombre)
                ->getQuery();
        } else {
            $query = $repository->createQueryBuilder('p')
                ->leftJoin('p.genres', 'g')
                ->where("p.enabled = true", "p.type like 'movie' ", 'g.id = ' . $genre)
                ->addOrderBy('p.' . $order, $dir)
                ->addOrderBy('p.id', 'ASC')
                ->setFirstResult($nombre * $page)
                ->setMaxResults($nombre)
                ->getQuery();
        }
        $posters_list = $query->getResult();
        return $this->render('AppBundle:Movie:api_all.html.php', array("posters_list" => $posters_list));
    }

    public function api_randomAction(Request $request, $genres, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $nombre = 30;
        $em = $this->getDoctrine()->getManager();
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $repository = $em->getRepository('AppBundle:Poster');
        $query = $repository->createQueryBuilder('p')
            ->leftJoin('p.genres', 'g')
            ->where("p.enabled = true", "p.type like 'movie' ", 'g.id in (' . $genres . ')')
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->setMaxResults($nombre)
            ->getQuery();
        $posters_list = $query->getResult();
        return $this->render('AppBundle:Movie:api_all.html.php', array("posters_list" => $posters_list));
    }

    public function api_by_actorAction(Request $request, $id, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $nombre = 30;
        $em = $this->getDoctrine()->getManager();
        $imagineCacheManager = $this->get('liip_imagine.cache.manager');
        $repository = $em->getRepository('AppBundle:Poster');
        $query = $repository->createQueryBuilder('p')
            ->leftJoin('p.roles', 'r')
            ->leftJoin('r.actor', 'u')
            ->where("p.enabled = true", "u.id  = " . $id)
            ->addOrderBy('p.created', 'DESC')
            ->addOrderBy('p.id', 'ASC')
            ->setMaxResults($nombre)
            ->getQuery();
        $posters_list = $query->getResult();
        return $this->render('AppBundle:Movie:api_all.html.php', array("posters_list" => $posters_list));
    }

    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $q = " ";
        if ($request->query->has("q") and $request->query->get("q") != "") {
            $q .= " AND  p.title like '%" . $request->query->get("q") . "%'";
        }

        $dql = "SELECT p FROM AppBundle:Poster p  WHERE  p.type  like 'movie' " . $q . " ORDER BY p.created desc ";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $movies = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            16
        );
        $movies_count = $em->getRepository('AppBundle:Poster')->countMovies();
        return $this->render('AppBundle:Movie:index.html.twig', array("movies_count" => $movies_count, "movies" => $movies));
    }

    function get_image_mime_type($image_path)
    {
        $mimes = array(
            IMAGETYPE_GIF => "image/gif",
            IMAGETYPE_JPEG => "image/jpg",
            IMAGETYPE_PNG => "image/png",
            IMAGETYPE_SWF => "image/swf",
            IMAGETYPE_PSD => "image/psd",
            IMAGETYPE_BMP => "image/bmp",
            IMAGETYPE_TIFF_II => "image/tiff",
            IMAGETYPE_TIFF_MM => "image/tiff",
            IMAGETYPE_JPC => "image/jpc",
            IMAGETYPE_JP2 => "image/jp2",
            IMAGETYPE_JPX => "image/jpx",
            IMAGETYPE_JB2 => "image/jb2",
            IMAGETYPE_SWC => "image/swc",
            IMAGETYPE_IFF => "image/iff",
            IMAGETYPE_WBMP => "image/wbmp",
            IMAGETYPE_XBM => "image/xbm",
            IMAGETYPE_ICO => "image/ico");

        if (($image_type = exif_imagetype($image_path))
            && (array_key_exists($image_type, $mimes))) {
            return $mimes[$image_type];
        } else {
            return FALSE;
        }
    }

    function get_image_ext_type($image_path)
    {
        $mimes = array(
            IMAGETYPE_GIF => "gif",
            IMAGETYPE_JPEG => "jpg",
            IMAGETYPE_PNG => "png",
            IMAGETYPE_SWF => "swf",
            IMAGETYPE_PSD => "psd",
            IMAGETYPE_BMP => "bmp",
            IMAGETYPE_TIFF_II => "tiff",
            IMAGETYPE_TIFF_MM => "tiff",
            IMAGETYPE_JPC => "jpc",
            IMAGETYPE_JP2 => "jp2",
            IMAGETYPE_JPX => "jpx",
            IMAGETYPE_JB2 => "jb2",
            IMAGETYPE_SWC => "swc",
            IMAGETYPE_IFF => "iff",
            IMAGETYPE_WBMP => "wbmp",
            IMAGETYPE_XBM => "xbm",
            IMAGETYPE_ICO => "ico");

        if (($image_type = exif_imagetype($image_path))
            && (array_key_exists($image_type, $mimes))) {
            return $mimes[$image_type];
        } else {
            return FALSE;
        }
    }

    public function addAction(Request $request)
    {
        $trailer_select = 1;
        $source_select = 1;
        $movie = new Poster();
        $form = $this->createForm(new MovieType(), $movie);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($movie->getFileposter() != null or (isset($_POST["image_url"]) and $_POST["image_url"] != null and $_POST["image_url"] != "" and strpos($_POST["image_url"], 'http') === 0)) {
                $choices = array(
                    1 => "youtube",
                    2 => "m3u8",
                    3 => "mov",
                    4 => "mp4",
                    6 => "mkv",
                    7 => "webm",
                    8 => "embed",
                    5 => "file"
                );

                $movie->setType("movie");
                $movie->setRating("0");
                if ($movie->getFileposter() != null) {
                    $media = new Media();
                    $media->setFile($movie->getFileposter());
                    $media->upload($this->container->getParameter('files_directory'));
                    $em->persist($media);
                    $em->flush();
                    $movie->setPoster($media);
                } else {
                    if (isset($_POST["image_url"]) and $_POST["image_url"] != null and $_POST["image_url"] != "" and strpos($_POST["image_url"], 'http') === 0) {
                        $url = $_POST["image_url"];
                        $fileName = md5(uniqid());
                        $fileType = $this->get_image_mime_type($url);
                        $fileExt = $this->get_image_ext_type($url);
                        $fullName = $fileName . "." . $fileExt;

                        $uploadTo = $this->container->getParameter('files_directory') . $fileExt . "/" . $fullName;

                        file_put_contents($uploadTo, file_get_contents($url));

                        $moviemedia = new Media();
                        $moviemedia->setType($fileType);
                        $moviemedia->setExtension($fileExt);
                        $moviemedia->setUrl($fullName);
                        $moviemedia->setTitre($movie->getTitle());
                        $em->persist($moviemedia);
                        $em->flush();
                        $movie->setPoster($moviemedia);
                    }
                }
                if ($movie->getFilecover() != null) {
                    $mediacover = new Media();
                    $mediacover->setFile($movie->getFilecover());
                    $mediacover->upload($this->container->getParameter('files_directory'));
                    $em->persist($mediacover);
                    $em->flush();
                    $movie->setCover($mediacover);
                }
                if ($movie->getTrailertype() == 5) {
                    if ($movie->getTrailerfile() != null) {
                        $mediatrailer = new Media();
                        $mediatrailer->setFile($movie->getTrailerfile());
                        $mediatrailer->upload($this->container->getParameter('files_directory'));
                        $em->persist($mediatrailer);
                        $em->flush();

                        $trailer = new  Source();
                        $trailer->setType($choices[$movie->getTrailertype()]);
                        $trailer->setMedia($mediatrailer);
                        $em->persist($trailer);
                        $em->flush();

                        $movie->setTrailer($trailer);
                    }
                } else {
                    if (strlen($movie->getTrailerurl()) > 1) {
                        $trailer = new  Source();
                        $trailer->setType($choices[$movie->getTrailertype()]);
                        $trailer->setUrl($movie->getTrailerurl());
                        $em->persist($trailer);
                        $em->flush();

                        $movie->setTrailer($trailer);

                    }
                }


                $em->persist($movie);
                $em->flush();

                if ($movie->getSourcetype() == 5) {
                    if ($movie->getSourcefile() != null) {
                        $mediasource = new Media();
                        $mediasource->setFile($movie->getSourcefile());
                        $mediasource->upload($this->container->getParameter('files_directory'));
                        $em->persist($mediasource);
                        $em->flush();

                        $source = new  Source();
                        $source->setType($choices[$movie->getSourcetype()]);
                        $source->setQuality($movie->getSourceQuality());
                        $source->setMedia($mediasource);
                        $source->setPoster($movie);
                        $em->persist($source);
                        $em->flush();
                    }
                } else {
                    if (strlen($movie->getSourceurl()) > 1) {
                        $source = new  Source();
                        $source->setType($choices[$movie->getSourcetype()]);
                        $source->setQuality($movie->getSourceQuality());
                        $source->setUrl($movie->getSourceurl());
                        $source->setPoster($movie);
                        $em->persist($source);
                        $em->flush();
                    }
                }
                $this->addFlash('success', 'عملیات با موفقیت انجام شد');
                return $this->redirect($this->generateUrl('app_movie_index'));
            } else {
                $error = new FormError("باید یک تصویر انتخاب نمایید!");
                $form->get('fileposter')->addError($error);
            }
        }
        return $this->render("AppBundle:Movie:add.html.twig", array("trailer_select" => $trailer_select, "source_select" => $source_select, "form" => $form->createView()));
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $movie = $em->getRepository("AppBundle:Poster")->findOneBy(array("id" => $id, "type" => "movie"));
        if ($movie == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $form = $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('Yes', 'submit', array("label" => "بله"))
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $slide = $em->getRepository("AppBundle:Slide")->findOneBy(array("poster" => $movie));

            if ($slide != null) {
                $media_slide = $slide->getMedia();
                $em->remove($slide);
                $em->flush();

                if ($media_slide != null) {
                    $media_slide->delete($this->container->getParameter('files_directory'));
                    $em->remove($media_slide);
                    $em->flush();
                }
                $slides = $em->getRepository('AppBundle:Slide')->findBy(array(), array("position" => "asc"));

                $p = 1;
                foreach ($slides as $key => $value) {
                    $value->setPosition($p);
                    $p++;
                }
                $em->flush();
            }
            foreach ($movie->getSources() as $key => $source) {
                $media_source = $source->getMedia();

                $em->remove($source);
                $em->flush();

                if ($media_source != null) {
                    $media_source->delete($this->container->getParameter('files_directory'));
                    $em->remove($media_source);
                    $em->flush();
                }
            }
            foreach ($movie->getSubtitles() as $key => $subtitle) {
                $media_subtitle = $subtitle->getMedia();

                $em->remove($subtitle);
                $em->flush();

                if ($media_subtitle != null) {
                    $media_subtitle->delete($this->container->getParameter('files_directory'));
                    $em->remove($media_subtitle);
                    $em->flush();
                }
            }

            $media_cover = $movie->getCover();
            $media_poster = $movie->getPoster();

            $em->remove($movie);
            $em->flush();

            if ($media_cover != null) {
                $media_cover->delete($this->container->getParameter('files_directory'));
                $em->remove($media_cover);
                $em->flush();
            }

            if ($media_poster != null) {
                $media_poster->delete($this->container->getParameter('files_directory'));
                $em->remove($media_poster);
                $em->flush();
            }

            $trailer = $movie->getTrailer();

            if ($trailer != null) {

                $media_trailer = $trailer->getMedia();

                $em->remove($trailer);
                $em->flush();

                if ($media_trailer != null) {
                    $media_trailer->delete($this->container->getParameter('files_directory'));
                    $em->remove($media_trailer);
                    $em->flush();
                }
            }

            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_movie_index'));
        }
        return $this->render('AppBundle:Movie:delete.html.twig', array("form" => $form->createView()));
    }

    public function subtitlesAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository("AppBundle:Poster")->findOneBy(array("id" => $id, "type" => "movie"));
        if ($movie == null) {
            throw new NotFoundHttpException("Page not found");
        }
        return $this->render("AppBundle:Movie:subtitles.html.twig", array("movie" => $movie));
    }

    public function trailerAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository("AppBundle:Poster")->findOneBy(array("id" => $id, "type" => "movie"));
        if ($movie == null) {
            throw new NotFoundHttpException("Page not found");
        }

        $source = new Source();
        $trailer_form = $this->createForm(new SourceType(), $source);
        $trailer_form->handleRequest($request);
        if ($trailer_form->isSubmitted() && $trailer_form->isValid()) {
            $choices = array(
                1 => "youtube",
                2 => "m3u8",
                3 => "mov",
                4 => "mp4",
                6 => "mkv",
                7 => "webm",
                8 => "embed",
                5 => "file"
            );
            if ($source->getType() == 5) {
                if ($source->getFile() != null) {
                    $sourcemedia = new Media();
                    $sourcemedia->setFile($source->getFile());
                    $sourcemedia->upload($this->container->getParameter('files_directory'));
                    $em->persist($sourcemedia);
                    $em->flush();

                    $source->setType($choices[$source->getType()]);
                    $source->setMedia($sourcemedia);
                    $em->persist($source);
                    $em->flush();
                    $movie->setTrailer($source);
                    $em->flush();
                }
            } else {
                if (strlen($source->getUrl()) > 1) {
                    $source->setType($choices[$source->getType()]);
                    $em->persist($source);
                    $em->flush();
                    $movie->setTrailer($source);
                    $em->flush();
                }
            }
        }
        return $this->render("AppBundle:Movie:trailer.html.twig", array("trailer_form" => $trailer_form->createView(), "movie" => $movie));
    }

    public function castAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository("AppBundle:Poster")->findOneBy(array("id" => $id, "type" => "movie"));
        if ($movie == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $role = new Role();
        $role_form = $this->createForm(new RoleType(), $role);
        $role_form->handleRequest($request);
        if ($role_form->isSubmitted() && $role_form->isValid()) {
            $max = 0;
            $roles = $em->getRepository('AppBundle:Role')->findBy(array("poster" => $movie));
            foreach ($roles as $key => $value) {
                if ($value->getPosition() > $max) {
                    $max = $value->getPosition();
                }
            }
            $role->setPosition($max + 1);
            $role->setPoster($movie);
            $em->persist($role);
            $em->flush();
        }
        return $this->render("AppBundle:Movie:cast.html.twig", array("role_form" => $role_form->createView(), "movie" => $movie));
    }

    public function sourcesAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository("AppBundle:Poster")->findOneBy(array("id" => $id, "type" => "movie"));
        if ($movie == null) {
            throw new NotFoundHttpException("Page not found");
        }

        return $this->render("AppBundle:Movie:sources.html.twig", array("movie" => $movie));
    }

    public function commentsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository("AppBundle:Poster")->findOneBy(array("id" => $id, "type" => "movie"));
        if ($movie == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT c FROM AppBundle:Comment c  WHERE c.poster = " . $id . " ORDER BY c.created desc ";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        $count = $em->getRepository('AppBundle:Comment')->countByPoster($movie->getId());

        return $this->render('AppBundle:Movie:comments.html.twig',
            array(
                'pagination' => $pagination,
                'movie' => $movie,
                'count' => $count,
            )
        );
    }

    public function ratingsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository("AppBundle:Poster")->findOneBy(array("id" => $id, "type" => "movie"));
        if ($movie == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $rates_1 = $em->getRepository('AppBundle:Rate')->findBy(array("poster" => $movie, "value" => 1));
        $rates_2 = $em->getRepository('AppBundle:Rate')->findBy(array("poster" => $movie, "value" => 2));
        $rates_3 = $em->getRepository('AppBundle:Rate')->findBy(array("poster" => $movie, "value" => 3));
        $rates_4 = $em->getRepository('AppBundle:Rate')->findBy(array("poster" => $movie, "value" => 4));
        $rates_5 = $em->getRepository('AppBundle:Rate')->findBy(array("poster" => $movie, "value" => 5));
        $rates = $em->getRepository('AppBundle:Rate')->findBy(array("poster" => $movie));


        $ratings["rate_1"] = sizeof($rates_1);
        $ratings["rate_2"] = sizeof($rates_2);
        $ratings["rate_3"] = sizeof($rates_3);
        $ratings["rate_4"] = sizeof($rates_4);
        $ratings["rate_5"] = sizeof($rates_5);


        $t = sizeof($rates_1) + sizeof($rates_2) + sizeof($rates_3) + sizeof($rates_4) + sizeof($rates_5);
        if ($t == 0) {
            $t = 1;
        }
        $values["rate_1"] = (sizeof($rates_1) * 100) / $t;
        $values["rate_2"] = (sizeof($rates_2) * 100) / $t;
        $values["rate_3"] = (sizeof($rates_3) * 100) / $t;
        $values["rate_4"] = (sizeof($rates_4) * 100) / $t;
        $values["rate_5"] = (sizeof($rates_5) * 100) / $t;

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
        $rating = $v;
        $count = $em->getRepository('AppBundle:Rate')->countByPoster($movie->getId());

        $em = $this->getDoctrine()->getManager();
        $dql = "SELECT c FROM AppBundle:Rate c  WHERE c.poster = " . $id . " ORDER BY c.created desc ";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render("AppBundle:Movie:ratings.html.twig", array("pagination" => $pagination, "count" => $count, "rating" => $rating, "ratings" => $ratings, "values" => $values, "movie" => $movie));

    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository("AppBundle:Poster")->findOneBy(array("id" => $id, "type" => "movie"));
        if ($movie == null) {
            throw new NotFoundHttpException("Page not found");
        }
        $form = $this->createForm(new EditMovieType(), $movie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($movie->getFilecover() != null) {
                $media_cover = new Media();
                $media_cover_old = $movie->getCover();
                $media_cover->setFile($movie->getFilecover());
                $media_cover->upload($this->container->getParameter('files_directory'));
                $em->persist($media_cover);
                $em->flush();

                $movie->setCover($media_cover);
                if ($media_cover_old != null) {
                    $media_cover_old->delete($this->container->getParameter('files_directory'));
                    $em->remove($media_cover_old);
                    $em->flush();
                }
            }
            if ($movie->getFileposter() != null) {
                $media_poster = new Media();
                $media_poster_old = $movie->getPoster();
                $media_poster->setFile($movie->getFileposter());
                $media_poster->upload($this->container->getParameter('files_directory'));
                $em->persist($media_poster);
                $em->flush();

                $movie->setPoster($media_poster);
                $media_poster_old->delete($this->container->getParameter('files_directory'));
                $em->remove($media_poster_old);
                $em->flush();
            }
            $em->flush();
            $this->addFlash('success', 'عملیات با موفقیت انجام شد');
            return $this->redirect($this->generateUrl('app_movie_index'));
        }
        return $this->render("AppBundle:Movie:edit.html.twig", array("movie" => $movie, "form" => $form->createView()));
    }

    public function api_add_rateAction(Request $request, $token)
    {
        if ($token != $this->container->getParameter('token_app')) {
            throw new NotFoundHttpException("Page not found");
        }
        $user = $request->get("user");
        $poster = $request->get("poster");
        $key = $request->get("key");
        $value = $request->get("value");

        $em = $this->getDoctrine()->getManager();
        $poster_obj = $em->getRepository('AppBundle:Poster')->find($poster);
        $user_obj = $em->getRepository("UserBundle:User")->find($user);

        $code = "200";
        $message = "";
        $errors = array();
        if ($user_obj != null and $poster_obj != null) {
            if (sha1($user_obj->getPassword()) == $key) {
                $rate = $em->getRepository('AppBundle:Rate')->findOneBy(array("user" => $user_obj, "poster" => $poster_obj));
                if ($rate == null) {
                    $rate_obj = new Rate();
                    $rate_obj->setValue($value);
                    $rate_obj->setPoster($poster_obj);
                    $rate_obj->setUser($user_obj);
                    $em->persist($rate_obj);
                    $em->flush();
                    $message = "امتیاز شما با موفقیت ثبت شد";
                } else {
                    $rate->setValue($value);
                    $em->flush();
                    $message = "امتیاز شما با موفقیت ویرایش شد";
                }
                $rates = $em->getRepository('AppBundle:Rate')->findBy(array("poster" => $poster_obj));

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
                $v2 = number_format((float)$v, 1, '.', '');
                $errors[] = array("name" => "rate", "value" => $v2);

                $poster_obj->setRating($v2);
                $em->flush();
            } else {
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

    public function shareAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $poster = $em->getRepository("AppBundle:Poster")->find($id);
        $setting = $em->getRepository("AppBundle:Settings")->findOneBy(array());
        if ($poster == null) {
            throw new NotFoundHttpException("Page not found");
        }
        return $this->render("AppBundle:Movie:share.html.twig", array("poster" => $poster, "setting" => $setting));
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
                    $poster_obj = $em->getRepository("AppBundle:Poster")->findOneBy(array("type" => "movie", "id" => $value));

                    if (!$poster_obj->getEnabled()) {
                        $poster_obj->setEnabled(true);
                        $em->flush();
                    }
                }
            } else {
                foreach ($ids as $key => $value) {
                    $poster_obj = $em->getRepository("AppBundle:Poster")->findOneBy(array("type" => "movie", "id" => $value));

                    if ($poster_obj->getEnabled()) {
                        $poster_obj->setEnabled(false);
                        $em->flush();
                    }
                }
            }
        } else if ($type_work == "comment") {
            if ($val == "active") {
                foreach ($ids as $key => $value) {
                    $poster_obj = $em->getRepository("AppBundle:Poster")->findOneBy(array("type" => "movie", "id" => $value));

                    if (!$poster_obj->getComment()) {
                        $poster_obj->setComment(true);
                        $em->flush();
                    }
                }
            } else {
                foreach ($ids as $key => $value) {
                    $poster_obj = $em->getRepository("AppBundle:Poster")->findOneBy(array("type" => "movie", "id" => $value));

                    if ($poster_obj->getComment()) {
                        $poster_obj->setComment(false);
                        $em->flush();
                    }
                }
            }
        } else if ($type_work == "downloadas") {
            if ($val == "free") {
                foreach ($ids as $key => $value) {
                    $poster_obj = $em->getRepository("AppBundle:Poster")->findOneBy(array("type" => "movie", "id" => $value));

                    if ($poster_obj->getDownloadas() != "1") {
                        $poster_obj->setDownloadas("1");
                        $em->flush();
                    }
                }
            } else if ($val == "special") {
                foreach ($ids as $key => $value) {
                    $poster_obj = $em->getRepository("AppBundle:Poster")->findOneBy(array("type" => "movie", "id" => $value));

                    if ($poster_obj->getDownloadas() != "2") {
                        $poster_obj->setDownloadas("2");
                        $em->flush();
                    }
                }
            } else if ($val == "advertise") {
                foreach ($ids as $key => $value) {
                    $poster_obj = $em->getRepository("AppBundle:Poster")->findOneBy(array("type" => "movie", "id" => $value));

                    if ($poster_obj->getDownloadas() != "3") {
                        $poster_obj->setDownloadas("3");
                        $em->flush();
                    }
                }
            }
        } else if ($type_work == "playas") {
            if ($val == "free") {
                foreach ($ids as $key => $value) {
                    $poster_obj = $em->getRepository("AppBundle:Poster")->findOneBy(array("type" => "movie", "id" => $value));

                    if ($poster_obj->getPlayas() != "1") {
                        $poster_obj->setPlayas("1");
                        $em->flush();
                    }
                }
            } else if ($val == "special") {
                foreach ($ids as $key => $value) {
                    $poster_obj = $em->getRepository("AppBundle:Poster")->findOneBy(array("type" => "movie", "id" => $value));

                    if ($poster_obj->getPlayas() != "2") {
                        $poster_obj->setPlayas("2");
                        $em->flush();
                    }
                }
            } else if ($val == "advertise") {
                foreach ($ids as $key => $value) {
                    $poster_obj = $em->getRepository("AppBundle:Poster")->findOneBy(array("type" => "movie", "id" => $value));

                    if ($poster_obj->getPlayas() != "3") {
                        $poster_obj->setPlayas("3");
                        $em->flush();
                    }
                }
            }
        }

        return new Response("عملیات با موفقیت انجام شد");

    }

}

?>