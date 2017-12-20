<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace NewsBundle\Security;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;

class ArticleVoter extends AbstractVoter
{
    const ATTRIBUTE_VIEW = 'VIEW';
    const ATTRIBUTE_EDIT = 'EDIT';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function __construct(ContainerInterface $container)
    {
        $this->containter = $container;
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedClasses()
    {
        return [
            'NewsBundle\Entity\Article',
            'NewsBundle\Entity\ArticleTranslatable',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getSupportedAttributes()
    {
        return [
            self::ATTRIBUTE_VIEW,
            self::ATTRIBUTE_EDIT,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function isGranted($attribute, $object, $user = null)
    {
        if (!is_object($user)) {
            return false;
        }

        $authorizationChecker = $this->container->get('security.authorization_checker');

        switch ($attribute) {
            case self::ATTRIBUTE_VIEW:

                break;
            case self::ATTRIBUTE_EDIT:

                break;
        }
        if ($authorizationChecker->isGranted('ROLE_NEWS_ADMIN')) {
            return true;
        }

        return false;
    }
}
