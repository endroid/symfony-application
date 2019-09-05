<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace MenuBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;

class Builder
{
    use ContainerAwareTrait;

    protected $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Returns the menu with the given tag.
     *
     * @param $tag
     * @param Request $request
     *
     * @return ItemInterface
     */
    public function createMenu($tag, Request $request)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->setCurrent($request->getRequestUri());

        $menuItem = $this->container->get('doctrine')->getRepository('MenuBundle:MenuItem')->findOneByTag($tag);

        foreach ($menuItem->getChildren() as $child) {
            $childRoute = $this->container->get('route.collector')->getRouteByKey($child->getRouteKey());
            if ($childRoute === null) {
                $item = $menu->addChild($child->getTag());
                $item->setAttribute('class', 'dropdown');
                $item->setChildrenAttribute('class', 'dropdown-menu');
            } else {
                $item = $menu->addChild($childRoute->getLabel(), [
                    'route' => $childRoute->getName(),
                    'routeParameters' => $childRoute->getParameters() + ['_locale' => $this->container->get('request_stack')->getLocale()],
                ]);
            }
            if ($child->getRouteKey() == null) {
                foreach ($child->getChildren() as $sub) {
                    $childRoute = $this->container->get('route.collector')->getRouteByKey($sub->getRouteKey());
                    $item->addChild($childRoute->getLabel(), [
                        'route' => $childRoute->getName(),
                        'routeParameters' => $childRoute->getParameters() + ['_locale' => $this->container->get('request_stack')->getLocale()],
                    ]);
                }
            }
        }

        return $menu;
    }

    /**
     * Returns the main menu.
     *
     * @param Request $request
     *
     * @return ItemInterface
     */
    public function createMenuMain(Request $request)
    {
        $locale = $this->container->get('request_stack')->getLocale();

        $tags = [
            'nl' => 'Hoofdmenu',
            'en' => 'Main menu',
        ];

        if (!isset($tags[$locale])) {
            return $this->factory->createItem('root');
        }

        return $this->createMenu($tags[$locale], $request);
    }

    /**
     * Returns the footer menu.
     *
     * @param Request $request
     *
     * @return ItemInterface
     */
    public function createMenuFooter(Request $request)
    {
        $locale = $this->container->get('request_stack')->getLocale();

        $tags = [
            'nl' => 'Footermenu',
            'en' => 'Footer menu',
        ];

        if (!isset($tags[$locale])) {
            return $this->factory->createItem('root');
        }

        return $this->createMenu($tags[$locale], $request);
    }
}
