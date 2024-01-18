<?php

namespace App\Form;

use App\Entity\Raffle;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaffleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('dateTime')
            ->add('prize')
            ->add('pricePerTicket')
            ->add('numberOfTickets', null,["mapped"=>false])
//             ->add('winner', EntityType::class, [
//                 'class' => Ticket::class,
// 'choice_label' => 'id',
//             ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Raffle::class,
        ]);
    }
}
