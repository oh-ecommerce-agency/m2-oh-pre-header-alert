<?php
declare(strict_types=1);

namespace OH\TopHeaderAlert\Model\Source;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Product
 * @package OH\TopHeaderAlert\Model\Source
 */
class Product extends AbstractSource implements OptionSourceInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Get products
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function getAllOptions()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $products = $this->productRepository->getList(
            $this->searchCriteriaBuilder
                ->addFilter('entity_id', 0, 'neq')
                ->create()
        );

        foreach ($products->getItems() as $product) {
            $this->options[] = [
                'value' => $product->getId(),
                'label' => $product->getName()
            ];
        }

        return $this->options;
    }
}
