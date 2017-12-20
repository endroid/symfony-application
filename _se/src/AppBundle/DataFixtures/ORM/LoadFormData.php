<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Endroid\Bundle\FormBundle\Entity\Choice;
use Endroid\Bundle\FormBundle\Entity\ChoiceField;
use Endroid\Bundle\FormBundle\Entity\EmailField;
use Endroid\Bundle\FormBundle\Entity\Form;
use Endroid\Bundle\FormBundle\Entity\TextAreaField;
use Endroid\Bundle\FormBundle\Entity\TextField;

class LoadFormData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $form = new Form();
        $form->setTitle('Contact');
        $form->setSuccessAction(Form::SUCCESS_ACTION_MESSAGE);
        $form->setSuccessMessage('Thank you for filling out the form');

        $field = new ChoiceField();
        $field->setTitle('Salutation');
        $field->addChoice(new Choice('Mr.'));
        $field->addChoice(new Choice('Mrs.'));
        $field->setRequired(true);
        $form->addField($field);

        $field = new TextField();
        $field->setTitle('Name');
        $field->setRequired(true);
        $form->addField($field);

        $field = new EmailField();
        $field->setTitle('Email');
        $field->setRequired(true);
        $form->addField($field);

        $field = new TextAreaField();
        $field->setTitle('Message');
        $field->setRequired(true);
        $form->addField($field);

        $this->addReference('contact_form', $form);

        $manager->persist($form);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 10;
    }
}
