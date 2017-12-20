<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AdminBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use Endroid\Bundle\BehaviorBundle\Model\TraversableInterface;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BaseAdminController extends Controller
{
    const MOVE_DIRECTION_UP = 0;
    const MOVE_DIRECTION_DOWN = 1;

    /**
     * Moves an item up.
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function upAction($id)
    {
        return $this->move($id, self::MOVE_DIRECTION_UP);
    }

    /**
     * Moves an item down.
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function downAction($id)
    {
        return $this->move($id, self::MOVE_DIRECTION_DOWN);
    }

    /**
     * Moves an item in a specific direction.
     *
     * @param $id
     * @param $direction
     *
     * @return RedirectResponse
     */
    protected function move($id, $direction)
    {
        $manager = $this->getDoctrine()->getManager();
        $repository = $manager->getRepository($this->admin->getClass());

        $entity = $repository->findOneBy(['id' => $id]);
        $position = $entity->getPosition();

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $repository->createQueryBuilder('e');
        $queryBuilder
            ->andWhere('e.position '.(($direction == self::MOVE_DIRECTION_UP) ? '<' : '>').' :position')
            ->setParameter('position', $position)
            ->orderBy('e.position', ($direction == self::MOVE_DIRECTION_UP) ? 'DESC' : 'ASC')
            ->setMaxResults(1);

        if ($entity instanceof TraversableInterface) {
            $queryBuilder
                ->andWhere('e.parent = :parent')
                ->setParameter('parent', $this->getRequest()->query->get('parent'));
        }

        $query = $queryBuilder
            ->getQuery();

        $results = $query->execute();

        if (count($results) == 1) {
            $otherEntity = $results[0];
            $entity->setPosition($otherEntity->getPosition());
            $otherEntity->setPosition($position);
            $manager->persist($entity);
            $manager->persist($otherEntity);
            $manager->flush();
        }

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }
}
