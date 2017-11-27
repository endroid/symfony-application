<?php

namespace App\Admin;

use App\Entity\Knife\AbstractField;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProductAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    public function getParentAssociationMapping()
    {
        return 'service';
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var AbstractField[] $fields */
        $fields = $this->getParent()->getSubject()->getFields();

        foreach ($fields as $field) {
            $field->addToFormMapper($formMapper);
        }
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('id');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        /** @var AbstractField[] $fields */
        $fields = $this->getParent()->getSubject()->getFields();

        $listMapper->addIdentifier('id');
        foreach ($fields as $field) {
            $field->addToListMapper($listMapper);
        }
    }
}
