<?php

namespace App\Admin;

use App\Entity\Knife\AbstractField;
use App\Entity\Knife\Service;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\Request;

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
        if ($this->getParent() instanceof AdminInterface) {
            $service = $this->getParent()->getSubject();
        } else {
            // When editing directly from list the parent and subject are null
            // Here we retrieve the service via the product (which always has a service)
            $request = Request::createFromGlobals();
            $product = $this->getProductRepository()->findOneBy(['id' => $request->query->get('objectId')]);
            $service = $product->getService();
        }

        /** @var AbstractField[] $fields */
        $fields = $service->getFields();

        $listMapper->addIdentifier('service');
        foreach ($fields as $field) {
            $field->addToListMapper($listMapper);
        }
    }

    private function getProductRepository(): EntityRepository
    {
        return $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('App\Entity\Knife\Product');
    }
}
