<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace TaskBundle\View;

use Endroid\State\View\AbstractView;

class TaskView extends AbstractView
{
    /**
     * @var string
     */
    protected $id;

    /**
     * Creates a new instance.
     *
     * @param $id
     */
    public function __construct($id)
    {
        parent::__construct();

        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function loadData()
    {
        $this->data['test'] = 'test2';
    }
}
