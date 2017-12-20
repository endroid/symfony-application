<?php

namespace AppBundle\Block\Service;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatsBlockService extends AbstractBlockService
{
    /**
     * {@inheritdoc}
     */
    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['template' => 'AppBundle:Block:stats.html.twig']);
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();

        // fetching data
        $stats = [];

        $stats['visitors'] = ['count' => rand(1, 100), 'goal' => rand(100, 200)];
        $stats['orders'] = ['count' => rand(1, 100), 'goal' => rand(100, 200)];

        return $this->renderResponse($blockContext->getTemplate(), [
            'block' => $blockContext->getBlock(),
            'settings' => $settings,
            'stats' => $stats,
        ], $response);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKeys(BlockInterface $block)
    {
        return [
            'block_id' => 'news_stats',
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'News stats admin block';
    }
}
