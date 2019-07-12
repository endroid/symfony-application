<?php

declare(strict_types=1);

namespace App\Admin;

use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'username',
    ];

    protected $translationDomain = 'admin';

    private $userManager;

    public function __construct(string $code, string $class, string $baseControllerName, UserManagerInterface $userManager)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->userManager = $userManager;
    }

    public function configure(): void
    {
        unset($this->listModes['mosaic']);
    }

    public function prePersist($user): void
    {
        $this->preUpdate($user);
    }

    public function preUpdate($user): void
    {
        $this->userManager->updateCanonicalFields($user);
        $this->userManager->updatePassword($user);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->tab('admin.general.label')
                ->with('admin.user.administration', ['class' => 'col-md-6'])
                    ->add('username', null, ['label' => 'admin.user.username'])
                    ->add('email', null, ['label' => 'admin.user.email'])
                    ->add('enabled', null, ['label' => 'admin.user.enabled'])
                ->end()
                ->with('admin.group.label', ['class' => 'col-md-6'])
                    ->add('groups', null, ['label' => 'admin.group.label'])
                ->end()
            ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('username', null, ['label' => 'admin.user.username'])
            ->add('email', null, ['label' => 'admin.user.email'])
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('username', null, ['label' => 'admin.user.username'])
            ->add('enabled', null, ['label' => 'admin.user.enabled'])
            ->add('groups', null, ['label' => 'admin.group.label'])
        ;
    }
}
