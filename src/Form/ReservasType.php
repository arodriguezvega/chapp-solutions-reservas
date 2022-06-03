<?php

namespace App\Form;

use App\Entity\Reservas;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReservasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['uso'] === 'disponibles') {
            $builder
                ->add('fecha_entrada', TextType::class, array('label' => 'Fecha de entrada', 'required' => true, 'attr' => ['class' => 'js-datepicker'], 'constraints' => [
                    new NotBlank()
                ]))
                ->add('fecha_salida', TextType::class, array('label' => 'Fecha de salida', 'required' => true, 'attr' => ['class' => 'js-datepicker'], 'constraints' => [
                    new NotBlank(),
                    new GreaterThan([
                        'message'      => 'La fecha de salida tiene que ser superior a la de entrada ({{ compared_value }})',
                        'propertyPath' => 'parent.all[fecha_entrada].data'
                    ]),
                ] ))
                ->add('num_huespedes', IntegerType::class, array('label' => 'Número de huéspedes', 'required' => true, 'attr' =>['min' => 1]))
                ->add('Buscar_disponibilidad', SubmitType::class, array('label' => 'Buscar Disponibilidad'))
            ;
        } else {
            $builder
                ->add('fecha_entrada', HiddenType::class, array('label' => 'Fecha de entrada', 'data' => $options['fecha_entrada']))
                ->add('fecha_salida', HiddenType::class, array('label' => 'Fecha de salida', 'data' => $options['fecha_salida']))
                ->add('num_huespedes', HiddenType::class, array('label' => 'Número de huéspedes', 'data' => $options['num_huespedes']))
                ->add('titular', TextType::class, array('label' => 'Titular'))
                ->add('email', EmailType::class, array('label' => 'Email'))
                ->add('telefono', IntegerType::class, array('label' => 'Teléfono'))
                ->add('precio_total', HiddenType::class, array('label' => 'Precio total', 'data' => $options['precio_total']))
                ->add('Crear', SubmitType::class)
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'    => Reservas::class,
            'uso'           => TextType::class,
            'fecha_entrada' => TextType::class,
            'fecha_salida'  => TextType::class,
            'num_huespedes' => IntegerType::class,
            'precio_total'  => IntegerType::class,
            'habitacion'    => EntityType::class
        ]);
    }
}
