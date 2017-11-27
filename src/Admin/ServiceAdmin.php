<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Knp\Menu\ItemInterface as MenuItemInterface;

class ServiceAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        // Only allow management of fields when the form exists
        if (!$this->getSubject() || !$this->getSubject()->getId()) {
            return;
        }

        $menu->addChild(
            'Fields',
            ['uri' => $this->getChild('admin.field')->generateUrl('list', ['id' => $this->getSubject()->getId()])]
        );

        $menu->addChild(
            'Products',
            ['uri' => $this->getChild('admin.product')->generateUrl('list', ['id' => $this->getSubject()->getId()])]
        );
    }
}
