<?php

namespace App\Form;

use App\Entity\Game;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class GameType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){

         $builder
         ->add('title', TextType::class)
         ->add('originalprice', TextType::class)
         ->add('finalprice', TextType::class)
         ->add('genre', ChoiceType::class, array(
           'multiple' => true,
   'choices'  => array(
       'Acción' => 'Accion',
       'Aventura' => 'Aventura',
       'Carreras' => 'Carreras',
       'Casual' => 'Casual',
       'Deportes' => 'Deportes',
       'Estrategia' => 'Estrategia',
       'Terror' => 'Terror',
       'Multijugador' => 'Multijugador',
       'Simuladores' => 'Simuladores',
   ),

 ))



   ->add('status', ChoiceType::class, array(
     'choices' => array(
              'Nuevo' => 'new',
       'Normal' => 'normal',
     ),
   ))

->add('target', ChoiceType::class, array('label' => false,
'choices'  => array(

'Inicio' => array(
  'Destacados' => 'highlight',
  'Ofertas de la Semana' => 'weekendoffer'
),

'Tienda' => array(
  'PlayStation' => array(
             'Fornite' => 'store-fortnite',
             'PreOrden' => 'po_playstation',
             'Juegos PS3' => 'juegos_ps3',
             'Packs PS3' => 'pack_ps3',
             'Primarias PS4' => 'primarias_ps4',
             'Secundarias PS4' => 'secundarias_ps4',
             'Primarias Offline' => 'primarias_offline_ps',
             'Tarjetas' => 'cd_ps',
  ),

  'PC/XBOX' => array(
            'PreOrden' => 'po_windows',
            'Juegos Steam' => 'juegos_steam',
            'Juegos XBOX One' => 'juegos_xbox',
            'Tarjetas' => 'cd_windows',
  ),

  'GiftCard' => array(
           'iTunes' => 'gf_itunes',
           'Google Play' => 'gf_googleplay',
           'PSN' => 'gf_psn',
           'Amazon' => 'gf_amazon',
           'Paypal' => 'gf_paypal',
           'Steam' => 'gf_Steam',
           'XBOX' => 'gf_xbox',
           'Nintendo EShop' => 'gf_nintendoeshop',
  ),
),

'Ofertas' => array(
           'Ofertas del Día' => 'dailyoffer',
           'Ofertas PS4' => 'ps4offer',
           'Ofertas PS3' => 'ps3offer'
),

'Servicios' => array(
           'Netflix' => 'se_netflix',
           'Spotify' => 'se_spotify',
           'IPTV' => 'se_iptv',
           'Crunchyroll' => 'se_crunchyroll'
),

)))
         ->add('description', TextareaType::class)
         ->add('size', TextareaType::class)
         ->add('sizeinconsole', TextareaType::class)
         ->add('console', TextareaType::class)
         ->add('cover', FileType::class, array('label' => 'Portada (Imagen Jpg o Png)', 'required' => false))
         ->add('save', SubmitType::class, array('label'=> 'Guardar'));


     }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Game::class,
        ));
    }

}

 ?>
