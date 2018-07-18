<?php

namespace App\Form;

use App\Entity\FrequentQuestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FrequentQuestionType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

         $builder
         ->add('question', TextType::class)
         ->add('answer', TextareaType::class)
                  ->add('save', SubmitType::class, array('label'=> 'Guardar'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => FrequentQuestion::class,
        ));
    }

}

 ?>
