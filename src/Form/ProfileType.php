<?php

namespace Bolt\Extension\Bolt\Members\Form;

use Bolt\Extension\Bolt\Members\Validator\Constraints\ValidUsername;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',    'text',   array(
                'label'       => __('User name:'),
                'data'        => $options['data']['username'],
                'read_only'   => true,
                'constraints' => array(
                    new ValidUsername(),
                    new Assert\NotBlank()
                )))
            ->add('displayname', 'text',   array(
                'label'       => __('Publicly visible name:'),
                'data'        => $options['data']['displayname'],
                'read_only'   => $options['data']['readonly'],
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Length(array('min' => 2))
                )))
            ->add('email',       'text',   array(
                'label'       => __('Email:'),
                'data'        => $options['data']['email'],
                'read_only'   => $options['data']['readonly'],
                'constraints' => new Assert\Email(array(
                    'message' => 'The address "{{ value }}" is not a valid email.',
                    'checkMX' => true)
                )));

        if (! $options['data']['readonly']) {
            $builder
                ->add('submit',      'submit', array(
                    'label'   => __('Save & continue')
                ));
        }
    }

    public function getName()
    {
        return 'topic';
    }

}
