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
    const XML_CONFIG_PATH = 'top_banner/settings/%s';

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
    public function isEnable(): ?bool
    {
        return $this->scopeInterface->isSetFlag(sprintf(self::XML_CONFIG_PATH, 'enabled'), ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get top bar elements
     *
     * @return array
     */
    public function getElements(): ?array
    {
        $res = [];

        if ($elements = $this->scopeInterface->getValue(sprintf(self::XML_CONFIG_PATH, 'elements'), ScopeInterface::SCOPE_STORE)) {
            foreach ($this->serializer->unserialize($elements) as $element) {
                $res[] = $element;
            }
        }

        return $res;
    }

    /**
     * Get background color
     *
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->scopeInterface->getValue(sprintf(self::XML_CONFIG_PATH, 'background_color'), ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get text color
     *
     * @return string
     */
    public function getTextColor()
    {
        return $this->scopeInterface->getValue(sprintf(self::XML_CONFIG_PATH, 'text_color'), ScopeInterface::SCOPE_STORE);
    }
}
