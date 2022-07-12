<?php
namespace App\Form;

use App\Entity\Employee;
use App\Entity\YouweTeam;
use App\Form\EventSubscriber\AddIdentifierSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EmployeeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('firstName',TextType::class,[
                'required' => true,
                'empty_data' => ''
            ])
            ->add('lastName',TextType::class,[
                'required' => true,
                'empty_data' => ''
            ])
            ->add('email',TextType::class,[
                'required' => true,
                'empty_data' => ''
            ])
            ->add('youweTeams', EntityType::class, array(
                'class'     => YouweTeam::class,
                'expanded'  => true,
                'multiple'  => true,
                'choice_label' => false,
                'by_reference' => false,
                'choice_value' => function (?YouweTeam $youweTeam) {
                    return $youweTeam ? $youweTeam->getIdentifier() : '';
                },
            ))
            ->add('save', SubmitType::class)
            ->addEventSubscriber(new AddIdentifierSubscriber());

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Employee::class,
            'csrf_protection' => false,
            'validation_groups' => ['save']
        ));
    }
}