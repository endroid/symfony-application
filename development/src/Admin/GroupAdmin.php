<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GroupAdmin extends AbstractAdmin
{
    protected $translationDomain = 'admin';

    public function configure()
    {
        unset($this->listModes['mosaic']);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->with('admin.general.label', ['class' => 'col-md-6'])
                ->add('name', null, ['label' => 'admin.group.name'])
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name', null, ['label' => 'admin.group.name'])
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('name', null, ['label' => 'admin.group.name'])
        ;
    }
}
