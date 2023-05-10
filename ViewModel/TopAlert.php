<?php

namespace OH\TopHeaderAlert\ViewModel;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject;
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
     * @var RequestInterface
     */
    private $requestInterface;

    public function __construct(
        RequestInterface $request,
        \OH\TopHeaderAlert\Model\ConfigProvider $configProvider,
        array $data = []
    ) {
        parent::__construct($data);
        $this->configProvider = $configProvider;
        $this->requestInterface = $request;
    }

    public function getIsEnabled($page)
    {
        return $this->configProvider->isEnable($page);
    }

    public function getElements($page = null)
    {
        switch ($page) {
            case 'category-page':
                return $this->configProvider->isEnable('cat') ? $this->configProvider->getElements('cat') : [];
            case 'product-page':
                //only show in products set by config
                $productId = $this->requestInterface->getParam('id');
                return $this->configProvider->isEnable('pdp') && in_array($productId,
                    explode(',', $this->configProvider->getProducts())) ? $this->configProvider->getElements('pdp') : [];
            default:
                return $this->configProvider->getElements();
        }
    }

    public function getCss()
    {
        return $this->configProvider->getCss($this->getPage());
    }

    public function getPage()
    {
        switch ($this->requestInterface->getFullActionName()) {
            case 'catalog_category_view':
                return 'cat';
            case 'catalog_product_view':
                return 'pdp';
            default:
                return null;
        }
    }
}
