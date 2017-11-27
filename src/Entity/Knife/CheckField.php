<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\Knife;

use Doctrine\ORM\Mapping as ORM;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * @ORM\Entity
 */
class CheckField extends AbstractField
{
    public function addToFormMapper(FormMapper $formMapper)
    {
        $formMapper->add($this->getName(), 'checkbox');
    }

    public function addToListMapper(ListMapper $listMapper)
    {
        $listMapper->add($this->getName(), 'checkbox');
    }
}