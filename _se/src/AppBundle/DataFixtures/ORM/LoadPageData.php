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
use PageBundle\Entity\Page;
use PageBundle\Entity\PageTranslation;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LoadPageData extends AbstractFixture implements ContainerAwareInterface, FixtureInterface, OrderedFixtureInterface
{
    use ContainerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $page = $this->createPage();
            $manager->persist($page);
        }

        $manager->flush();
    }

    /**
     * Creates a page.
     *
     * @return Page
     */
    protected function createPage()
    {
        $page = new Page();

        foreach ($this->container->getParameter('locales') as $locale) {
            $faker = Factory::create($locale.'_'.strtoupper($locale));
            /** @var PageTranslation $translation */
            $translation = $page->translate($locale);
            $translation->setTitle(ucfirst($faker->words(10, true)));
            $translation->setContent(ucfirst($faker->words(100, true)).'.');

            if ($locale == 'en') {
                $translation->setForm($this->getReference('contact_form'));
            }
        }

        $page->mergeNewTranslations();

        return $page;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 20;
    }
}
