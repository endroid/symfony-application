<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Exception\InvalidTypeException;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;

class LanguageController extends Controller
{
    /**
     * @Route("/switch")
     * @Template()
     *
     * @param Request $request
     * @param $route
     * @param array          $params
     * @param Translatable[] $translatables
     *
     * @return array
     */
    public function switchAction(Request $request, $route, array $params = [], array $translatables = [])
    {
        $translatableFilterDisabled = false;
        if (array_key_exists('translatable_filter', $this->getDoctrine()->getManager()->getFilters()->getEnabledFilters())) {
            $this->getDoctrine()->getManager()->getFilters()->disable('translatable_filter');
            $translatableFilterDisabled = true;
        }

        $translatables = $this->replaceTranslations($translatables);

        $this->validateTranslatables($translatables);

        $urls = [];

        foreach ($this->container->getParameter('locales') as $locale) {
            if ($locale == $request->getLocale()) {
                continue;
            }
            $routeParams = $this->translateParameters($locale, $params, $translatables);
            $urls[$locale] = $this->generateUrl($route, $routeParams);
        }

        if ($translatableFilterDisabled) {
            $this->getDoctrine()->getManager()->getFilters()->enable('translatable_filter');
        }

        return [
            'urls' => $urls,
        ];
    }

    /**
     * Allow for both translations and translatables to be passed as argument.
     *
     * @param array $translatables
     *
     * @return array
     */
    protected function replaceTranslations(array $translatables)
    {
        foreach ($translatables as $key => $translatable) {
            if ($translatable instanceof TranslationInterface) {
                $translatables[$key] = $translatable->getTranslatable();
            }
        }

        return $translatables;
    }

    /**
     * Make sure that the array contains translatables only.
     *
     * @param array $translatables
     *
     * @throws InvalidTypeException
     */
    protected function validateTranslatables(array $translatables)
    {
        foreach ($translatables as $translatable) {
            if (!$translatable instanceof TranslatableInterface) {
                throw new InvalidTypeException('Endroid\\Bundle\\BehaviorBundle\\Model\\TranslatableInterface', get_class($translatable));
            }
        }
    }

    /**
     * Translates the translatable parameters defined as a property path.
     *
     * @param string         $locale
     * @param array          $params
     * @param Translatable[] $translatables
     *
     * @return array
     */
    protected function translateParameters($locale, array $params = [], array $translatables = [])
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $routeParams = $params;
        $routeParams['_locale'] = $locale;

        foreach ($translatables as $name => $translatable) {
            $translation = $translatable->getTranslation($locale);
            if ($translation === null) {
                // todo: what to do when a translation for a specific language does not exist
                // 1. fallback to parent (i.e. article => news)
                // 2. fallback to home
                continue;
            }
            foreach ($routeParams as $key => $value) {
                if (strpos($value, $name.'.') === 0) {
                    $routeParams[$key] = $accessor->getValue($translation, substr($value, strlen($name) + 1));
                }
            }
        }

        return $routeParams;
    }
}
