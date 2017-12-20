<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use NewsBundle\Entity\Article;
use NewsBundle\Entity\ArticleTranslation;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadNewsData extends AbstractFixture implements ContainerAwareInterface, FixtureInterface, OrderedFixtureInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $article = $this->createArticle();
            $manager->persist($article);
        }

        $manager->flush();
    }

    /**
     * Creates an article.
     *
     * @return Article
     */
    protected function createArticle()
    {
        $article = new Article();

        $faker = Factory::create();
        $article->setDate($faker->dateTime);

        foreach ($this->container->getParameter('locales') as $locale) {
            $faker = Factory::create($locale.'_'.strtoupper($locale));
            /** @var ArticleTranslation $translation */
            $translation = $article->translate($locale);
            $translation->setTitle(ucfirst($faker->words(10, true)));
            $translation->setContent(ucfirst($faker->words(100, true)).'.');
        }

        $article->mergeNewTranslations();

        return $article;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 30;
    }
}
