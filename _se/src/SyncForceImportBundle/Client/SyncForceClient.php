<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace SyncForceImportBundle\Client;

use SoapClient;
use stdClass;

class SyncForceClient
{
    const THEME_ID_MENU = 148;
    const THEME_ID_BEST_PRACTICE = 147;

    /**
     * @var string
     */
    protected $baseUrl = 'http://cde.syncforce.com/';

    /**
     * @var string
     */
    protected $productWebsiteCollectionId = 1;

    /**
     * @var string
     */
    protected $productCategoryInfoCollectionId = 2;

    /**
     * @var array
     */
    protected $defaultParameters = [
        'securityCode' => 'meUmXT-4L9YhP54B0r-MRLmGwJri9Uni0'
    ];

    /**
     * @var SoapClient[]
     */
    protected $clients = [];

    /**
     * Returns the product website collection data for a specific language.
     *
     * @param $language
     *
     * @return mixed
     */
    public function getProductWebsiteCollectionData($language)
    {
        return $this->getProductCollectionData($this->productWebsiteCollectionId, $language);
    }

    /**
     * Returns the product category info collection data for a specific language.
     *
     * @param $language
     *
     * @return mixed
     */
    public function getProductCategoryInfoCollectionData($language)
    {
        return $this->getProductCollectionData($this->productCategoryInfoCollectionId, $language);
    }

    /**
     * Returns the product collection data for a specific language.
     *
     * @param $collectionId
     * @param $language
     *
     * @return mixed
     */
    public function getProductCollectionData($collectionId, $language)
    {
        $parameters = $this->defaultParameters;
        $parameters['collectionId'] = $collectionId;
        $parameters['language'] = $language;

        $response = $this->getSoapResponse(
            'product_data',
            'Product',
            'GetCollection',
            $parameters
        );

        return $response;
    }

    /**
     * Returns the product data for a specific product in a specific language.
     *
     * @param $id
     * @param $language
     *
     * @return stdClass
     */
    public function getProductData($id, $language)
    {
        $parameters = $this->defaultParameters;
        $parameters['tradeItemId'] = $id;
        $parameters['language'] = $language;

        $response = $this->getSoapResponse(
            'product_data',
            'Product',
            'GetTradeItem',
            $parameters
        );

        $productData = $response->GetTradeItemResult->TradeItem;

        return $productData;
    }

    /**
     * Returns the menu collection data for a specific language.
     *
     * @param $language
     *
     * @return mixed
     */
    public function getMenuCollectionData($language)
    {
        $parameters = $this->defaultParameters;
        $parameters['segmentId'] = '';
        $parameters['themeId'] = 148;
        $parameters['regionId'] = '';
        $parameters['includeChildren'] = '';
        $parameters['language'] = $language;

        $response = $this->getSoapResponse(
            'menu_data',
            'SuccessStory',
            'GetProjectsExtended',
            $parameters
        );

        return $response;
    }

    /**
     * Returns the menu data for a specific menu in a specific language.
     *
     * @param $id
     * @param $language
     *
     * @return stdClass
     */
    public function getMenuData($id, $language)
    {
        $parameters = $this->defaultParameters;
        $parameters['projectId'] = $id;
        $parameters['language'] = $language;

        $response = $this->getSoapResponse(
            'menu_data',
            'SuccessStory',
            'GetProjectFull',
            $parameters
        );

        $menuData = $response->GetProjectFullResult->Project;

        return $menuData;
    }

    /**
     * Returns the best practice collection data for a specific language.
     *
     * @param $language
     *
     * @return mixed
     */
    public function getBestPracticeCollectionData($language)
    {
        $parameters = $this->defaultParameters;
        $parameters['segmentId'] = '';
        $parameters['themeId'] = 147;
        $parameters['regionId'] = '';
        $parameters['includeChildren'] = '';
        $parameters['language'] = $language;

        $response = $this->getSoapResponse(
            'best_practice',
            'SuccessStory',
            'GetProjectsExtended',
            $parameters
        );

        return $response;
    }

    /**
     * Returns the best practice data for a specific best practice in a specific language.
     *
     * @param $id
     * @param $language
     *
     * @return stdClass
     */
    public function getBestPracticeData($id, $language)
    {
        $parameters = $this->defaultParameters;
        $parameters['projectId'] = $id;
        $parameters['language'] = $language;

        $response = $this->getSoapResponse(
            'best_practice',
            'SuccessStory',
            'GetProjectFull',
            $parameters
        );

        $bestPracticeData = $response->GetProjectFullResult->Project;

        return $bestPracticeData;
    }

    /**
     * Returns the SOAP response for the given data type.
     *
     * @param $type
     * @param string $wsdlPath
     * @param $call
     * @param $parameters
     *
     * @return stdClass
     */
    protected function getSoapResponse($type, $wsdlPath, $call, array $parameters)
    {
        $client = $this->getClient($type, $wsdlPath);
        $response = $client->__soapCall($call, array($parameters));

        return $response;
    }

    /**
     * Returns a client of the given type.
     *
     * @param string $type
     * @param string $wsdlPath
     *
     * @return SoapClient
     */
    protected function getClient($type, $wsdlPath)
    {
        if (!isset($this->clients[$type])) {
            $this->clients[$type] = new SoapClient(
                $this->baseUrl.$wsdlPath.'.svc?singleWsdl',
                array(
                    'trace' => true,
                    'cache_wsdl' => WSDL_CACHE_BOTH,
                    'exceptions' => true,
                    'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
                    'encoding' => 'utf-8',
                    'soap_version' => SOAP_1_1
                )
            );
        }

        return $this->clients[$type];
    }
}
