<?php

declare(strict_types=1);

namespace OH\TopHeaderAlert\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class ConfigProvider
 * @package OH\TopHeaderAlert\Model
 */
class ConfigProvider
{
    /**
     * @var string
     */
    const XML_CONFIG_PATH_ENABLED = 'top_banner/settings/enabled';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_ELEMENTS = 'top_banner/settings/elements';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_CSS = 'top_banner/settings/css';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_ENABLED_PDP = 'top_banner/settings_pdp/enabled';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_ELEMENTS_PDP = 'top_banner/settings_pdp/elements';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_CSS_PDP = 'top_banner/settings_pdp/css';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_PRODUCTS = 'top_banner/settings_pdp/products';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_ENABLED_CAT = 'top_banner/settings_cat/enabled';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_ELEMENTS_CAT = 'top_banner/settings_cat/elements';

    /**
     * @var string
     */
    const XML_CONFIG_PATH_CSS_CAT = 'top_banner/settings_cat/css';

    /**
     * @var ScopeInterface
     */
    private $scopeInterface;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        SerializerInterface $serializer,
        ScopeConfigInterface $scopeInterface
    ) {
        $this->scopeInterface = $scopeInterface;
        $this->serializer = $serializer;
    }

    /**
     * Check if is enabled
     *
     * @return bool
     */
    public function isEnable($page = null): ?bool
    {
        switch ($page) {
            case 'pdp':
                $pageConfig = self::XML_CONFIG_PATH_ENABLED_PDP;
                break;
            case 'cat':
                $pageConfig = self::XML_CONFIG_PATH_ENABLED_CAT;
                break;
            default:
                $pageConfig = self::XML_CONFIG_PATH_ENABLED;
        }

        return $this->scopeInterface->isSetFlag($pageConfig, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get top bar elements
     *
     * @return array
     */
    public function getElements($page = null): ?array
    {
        switch ($page) {
            case 'pdp':
                $pageConfig = self::XML_CONFIG_PATH_ELEMENTS_PDP;
                break;
            case 'cat':
                $pageConfig = self::XML_CONFIG_PATH_ELEMENTS_CAT;
                break;
            default:
                $pageConfig = self::XML_CONFIG_PATH_ELEMENTS;
        }

        $res = [];

        if ($elements = $this->scopeInterface->getValue($pageConfig, ScopeInterface::SCOPE_STORE)) {
            foreach ($this->serializer->unserialize($elements) as $element) {
                $res[] = $element;
            }
        }

        return $res;
    }

    /**
     * Get custom css
     *
     * @return string
     */
    public function getCss($page = null): ?string
    {
        switch ($page) {
            case 'pdp':
                $pageConfig = self::XML_CONFIG_PATH_CSS_PDP;
                break;
            case 'cat':
                $pageConfig = self::XML_CONFIG_PATH_CSS_CAT;
                break;
            default:
                $pageConfig = self::XML_CONFIG_PATH_CSS;
        }

        return $this->scopeInterface->getValue($pageConfig, ScopeInterface::SCOPE_STORE);
    }

    public function getProducts()
    {
        return $this->scopeInterface->getValue(self::XML_CONFIG_PATH_PRODUCTS, ScopeInterface::SCOPE_STORE);
    }
}
