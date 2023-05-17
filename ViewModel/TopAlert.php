<?php

namespace OH\TopHeaderAlert\ViewModel;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class TopAlert
 * @package OH\TopHeaderAlert\ViewModel
 */
class TopAlert extends DataObject implements ArgumentInterface
{
    /**
     * @var \OH\TopHeaderAlert\Model\ConfigProvider
     */
    private $configProvider;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        SerializerInterface $serializer,
        \OH\TopHeaderAlert\Model\ConfigProvider $configProvider,
        array $data = []
    ) {
        parent::__construct($data);
        $this->configProvider = $configProvider;
        $this->serializer = $serializer;
    }

    public function getIsEnabled()
    {
        return $this->configProvider->isEnable();
    }

    public function getElements($page = null)
    {
        return $this->configProvider->getElements();
    }

    public function getBackgroundColor()
    {
        return $this->configProvider->getBackgroundColor();
    }

    public function getTextColor()
    {
        return $this->configProvider->getTextColor();
    }

    public function getSlickProps()
    {
        return $this->serializer->serialize([
            'infinite' => true,
            'autoplay' => true,
            'autoplaySpeed' => 5000,
            'arrows' => false,
            'slidesToShow' => 1,
            'speed' => 400,
            'slidesToScroll' => 1
        ]);
    }
}
