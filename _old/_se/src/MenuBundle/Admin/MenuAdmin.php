<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MenuBundle\Admin;

use AdminBundle\Admin\BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class MenuAdmin extends BaseAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $datagridValues = [
        '_sort_by' => 'position',
        '_sort_order' => 'ASC',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $routes = $this->container->get('route.collector')->getRoutes();

        $routeChoices = [];
        foreach ($routes as $route) {
            $routeChoices[$route->getKey()] = $route->getLabel();
        }

        $formMapper
            ->with('General')
                ->add('routeKey', 'choice', ['choices' => $routeChoices, 'required' => false])
                ->add('tag')
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('edit', 'string', ['label' => 'Edit', 'template' => 'MenuBundle:MenuItemAdmin:list_field_edit.html.twig'])
            ->add('path', 'string', ['label' => 'Path', 'template' => 'MenuBundle:MenuItemAdmin:list_field_path.html.twig'])
        ;

        parent::configureListFields($listMapper);
    }
}
