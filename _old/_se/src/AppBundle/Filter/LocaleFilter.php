<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Filter;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class LocaleFilter extends SQLFilter implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function addFilterConstraint(ClassMetadata $target, $alias)
    {
        if (!$target->reflClass->hasProperty('translatable') || !$target->reflClass->hasProperty('locale')) {
            return '';
        }

        return $alias.'.locale = '.$this->getParameter('locale');
    }

    /**
     * {@inheritdoc}
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $this->getEntityManager()->getConfiguration()->addFilter('locale_filter', 'AppBundle\\Filter\\LocaleFilter');

        if (strpos($this->getRequest()->getPathInfo(), '/admin') === 0) {
            return;
        }

        $filter = $this->getEntityManager()->getFilters()->enable('locale_filter');
        $filter->setParameter('locale', $this->getRequest()->getLocale());
    }

    /**
     * Returns the entity manager.
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->container->get('doctrine')->getManager();
    }

    /**
     * Returns the current request.
     *
     * @return Request
     */
    protected function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }
}
