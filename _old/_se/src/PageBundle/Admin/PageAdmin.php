<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PageBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AdminBundle\Admin\BaseAdmin;
use Endroid\Bundle\FormBundle\Entity\Form;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class PageAdmin extends BaseAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('translations', TranslationsType::class, [
                    'label' => false,
                    'fields' => [
                        'title' => ['field_type' => 'text'],
                        'content' => ['field_type' => CKEditorType::class, 'required' => false],
//                        'form' => ['field_type' => 'entity', 'class' => Form::class, 'required' => false],
                    ],
                ])
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('translate', null, ['label' => 'Title', 'associated_property' => 'getTitle'])
            ->add('form', null, ['label' => 'Form'])
        ;
    }
}
