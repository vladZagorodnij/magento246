<?php
declare(strict_types=1);

namespace VladZahorodnii\HomeCategory\Model;

use Exception;
use Magento\Catalog\Api\CategoryListInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Api\Data\CategorySearchResultsInterface;

class AllCategory
{
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var CategoryListInterface
     */
    private CategoryListInterface $categoryList;

    public function __construct(
        CategoryListInterface $categoryList,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->categoryList = $categoryList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return CategorySearchResultsInterface
     * @throws Exception
     */
    public function getAllSystemCategory():CategorySearchResultsInterface
    {
        $categoryList = [];
        try {
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $categoryList = $this->categoryList->getList($searchCriteria);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $categoryList;
    }
}
