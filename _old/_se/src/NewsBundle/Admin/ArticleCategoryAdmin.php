<?php

namespace NewsBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AdminBundle\Admin\BaseAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ArticleCategoryAdmin extends BaseAdmin
{
    /**
     * {@inheritdoc}
     */
    protected $datagridValues = [
        '_sort_order' => 'DESC',
        '_sort_by' => 'title',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Content', ['class' => 'col-md-12', 'box_class' => 'box box-solid'])
                ->add('translations', TranslationsType::class, [
                    'label' => false,
                    'fields' => [
                        'title' => ['field_type' => 'text'],
                    ],
                ])
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('translations.title', null, ['label' => 'Title'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('translations', null, ['label' => 'Title', 'associated_property' => 'getTitle'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $query
            ->addSelect('nct')
            ->leftJoin('o.translations', 'nct')
        ;

        return $query;
    }
}
