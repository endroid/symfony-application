<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AdminBundle\Admin;

use ReflectionClass;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class BaseAdmin extends AbstractAdmin implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        unset($this->listModes['mosaic']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('export');
    }

    /**
     * {@inheritdoc}
     */
    public function getPersistentParameters()
    {
        $parameters = [];

        // If no request is made don't add behavioral parameters
        if (!$this->request) {
            return $parameters;
        }

        $reflectionClass = new ReflectionClass($this->getClass());

        // Add parent to traversable urls
        if ($reflectionClass->implementsInterface('Endroid\Bundle\BehaviorBundle\Model\TraversableInterface')) {
            $parameters['parent'] = $this->request->query->get('parent');
        }

        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $reflectionClass = new ReflectionClass($this->getClass());

        // Filter the traversable list by query string parent
        if ($reflectionClass->implementsInterface('Endroid\Bundle\BehaviorBundle\Model\TraversableInterface')) {
            $parentId = intval($this->request->query->get('parent', 0));
            $query->andWhere($query->getRootAlias().'.parent '.($parentId ? '= '.$parentId : 'IS NULL'));
        }

        return $query;
    }
}
