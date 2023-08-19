<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('description');
        $builder->add('year');
        $builder->add('enabled', 'checkbox', array(
            'label' => 'فعال باشد؟',
            'data' => false,
            "required" => false,
            'attr' => array('checked' => 'checked', 'value' => '1')
        ));
        $builder->add('comment', 'checkbox', array(
            'label' => 'نظرات فعال باشد؟',
            'data' => false,
            "required" => false,
            'attr' => array('checked' => 'checked', 'value' => '1')
        ));
        $builder->add('imdb');
        $builder->add('classification');
        $builder->add('playas', ChoiceType::class, array(
            'choices' => array(
                1 => "رایگان (بدون ثبت نام)",
                2 => "ویژه (نیازمند ثبت نام و تهیه اشتراک)",
                3 => "باز کردن با تماشای ویدئوی تبلیغاتی (نیازمند ثبت نام)"
            )));
        $builder->add('downloadas', ChoiceType::class, array(
            'choices' => array(
                1 => "رایگان (بدون ثبت نام)",
                2 => "ویژه (نیازمند ثبت نام و تهیه اشتراک)",
                3 => "باز کردن با تماشای ویدئوی تبلیغاتی (نیازمند ثبت نام)"
            )));
        $builder->add('duration');
        $builder->add('tags');
        $builder->add('country',
            'entity',
            array(
                'class' => 'AppBundle:Country',
                'property' => 'title',
                'placeholder' => '--- انتخاب کشور ---',
                "required" => false,
                'query_builder' => function (\AppBundle\Repository\CountryRepository $repository) {
                    return $repository->createQueryBuilder('c')->add('orderBy', 'c.title ASC');
                }
            )
        );
        $builder->add('sourcetype', ChoiceType::class, array(
            'choices' => array(
                1 => "Youtube Url",
                2 => "m3u8 Url",
                3 => "MOV Url",
                4 => "MP4 Url",
                6 => "MKV Url",
                7 => "WEBM Url",
                8 => "Embed source",
                5 => "File (MP4/MOV/MKV/WEBM)"
            )));
        $builder->add('sourcequality');
        $builder->add('sourceurl');
        $builder->add("sourcefile", null, array("label" => "", "required" => false));
        $builder->add('trailertype', ChoiceType::class, array(
            'choices' => array(
                1 => "Youtube Url",
                2 => "m3u8 Url",
                3 => "MOV Url",
                4 => "MP4 Url",
                6 => "MKV Url",
                7 => "WEBM Url",
                8 => "Embed source",
                5 => "File (MP4/MOV/MKV/WEBM)"
            )));
        $builder->add('trailerurl');
        $builder->add("trailerfile", null, array("label" => "", "required" => false));
        $builder->add("genres", 'entity',
            array(
                'class' => 'AppBundle:Genre',
                'expanded' => true,
                "multiple" => "true",
                'by_reference' => false
            )
        );
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $article = $event->getData();
            $form = $event->getForm();
            if ($article and null !== $article->getId()) {
                $form->add("fileposter", null, array("label" => "", "required" => false));
                $form->add("filecover", null, array("label" => "", "required" => false));
            } else {
                $form->add("fileposter", null, array("label" => "", "required" => false));
                $form->add("filecover", null, array("label" => "", "required" => false));
            }
        });
        $builder->add('save', 'submit', array("label" => "ذخیره"));

    }

    public function getName()
    {
        return 'Movie';
    }
}

?>