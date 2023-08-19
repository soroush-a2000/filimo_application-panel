<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class SettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('appname', null, array("label" => "نام اپلیکیشن"));
        $builder->add('appdescription', null, array("label" => "توضیحات اپلیکیشن"));

        $builder->add('notifkey', null, array("label" => "کلید API  اپلیکیشن در سایت چشمک"));
        $builder->add('notifappid', null, array("label" => "شناسه اپلیکیشن در سایت چشمک"));

        $builder->add('autoslider', ChoiceType::class, array(
            'choices' => array(
                "TRUE" => "فعال",
                "FALSE" => "غیر فعال"
            )));
        $builder->add('timeslider', null, array("label" => "زمان تغییر اسلایدر"));

        $builder->add('paymentgateway', ChoiceType::class, array(
            'choices' => array(
                "zarinpal" => "زرین پال",
                "pay" => "پی (pay)"
            )));
        $builder->add('merchantid', null, array("label" => "مرچند ای دی زرین پال"));
        $builder->add('payapi', null, array("label" => "api سایت pay"));
        $builder->add('paymentdescription', null, array("label" => "توضیحات پرداخت"));

        $builder->add('privacypolicy', CKEditorType::class,
            array(
                'config_name' => 'user_config'
            )
        );
        $builder->add('downloadlink', null, array("label" => "لینک دانلود اپلیکیشن"));
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $article = $event->getData();
            $form = $event->getForm();
            if ($article and null !== $article->getId()) {
                $form->add("file", null, array("label" => "", "required" => false));
            } else {
                $form->add("file", null, array("label" => "", "required" => true));
            }
        });
        $builder->add('save', 'submit', array("label" => "ذخیره"));
    }

    public function getName()
    {
        return 'Settings';
    }
}

?>