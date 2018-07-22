<?php

namespace App\Form;

use App\Entity\Voucher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class VoucherType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

         $builder
         ->add('orderid', TextType::class, array('attr' => array('readonly' => true)))
         ->add('name', TextType::class)
         ->add('mail', EmailType::class)
         ->add('phone', TelType::class)
         ->add('details', TextType::class, array('attr' => array('readonly' => true)))
         ->add('brochure', FileType::class, array('label' => 'Brochure (PDF file)'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Voucher::class,
        ));
    }

}

 ?>
