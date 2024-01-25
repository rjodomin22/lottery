<?php

namespace App\Form;

use App\Entity\Raffle;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
class RaffleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('dateTime')
            ->add('prize', null, [
                'constraints' => [
                    new NotBlank(['message' => 'The price per ticket cannot be blank.']),
                    new Type([
                        'type' => 'numeric',
                        'message' => 'The price per ticket must be a numeric value.',
                    ]),
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'The number of tickets must be at least 1.',
                    ]),
                ],
            ])
            ->add('pricePerTicket', null, [
                'constraints' => [
                    new NotBlank(['message' => 'The price per ticket cannot be blank.']),
                    new Type([
                        'type' => 'numeric',
                        'message' => 'The price per ticket must be a numeric value.',
                    ]),
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'The number of tickets must be at least 1.',
                    ]),
                ],
            ])
            ->add('numberOfTickets', null,["mapped"=>false,'constraints' => [
                new GreaterThan([
                    'value' => 0,
                    'message' => 'The number of tickets must be at least 1.',
                ]),
            ],])
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
