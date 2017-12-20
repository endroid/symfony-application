<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace UserBundle\Admin;

use AdminBundle\Admin\BaseAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Symfony\Component\Intl\Intl;

class UserAdmin extends BaseAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'username',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('username')
                ->add('plainPassword', 'password', ['required' => (!$this->getSubject() || is_null($this->getSubject()->getId()))])
                ->add('email')
                ->add('groups')
                ->add('locale', 'locale', ['choices' => $this->getChoices()])
                ->add('enabled')
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('groups')
            ->add('locale')
            ->add('enabled')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
            ->add('email')
            ->add('groups')
            ->add('locale')
            ->add('enabled')
        ;
    }

    /**
     * Returns the choices.
     *
     * @return array
     */
    protected function getChoices()
    {
        $choices = [];

        $locales = $this->getConfigurationPool()->getContainer()->getParameter('locales');
        $names = Intl::getLocaleBundle()->getLocaleNames();

        foreach ($locales as $locale) {
            if (array_key_exists($locale, $names)) {
                $choices[$locale] = $names[$locale];
            }
        }

        return array_flip($choices);
    }
}
