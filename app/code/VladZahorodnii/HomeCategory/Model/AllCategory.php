<?php
declare(strict_types=1);

namespace VladZahorodnii\HomeCategory\Model;

use Exception;
use Magento\Framework\Exception\NoSuchEntityException;

class AllCategory
{
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var \Magento\Catalog\Api\CategoryListInterface
     */
    private \Magento\Catalog\Api\CategoryListInterface $categoryList;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private \Magento\Store\Model\StoreManagerInterface $storeManager;

    /**
     * @var \Magento\Catalog\Model\CategoryRepository
     */
    private \Magento\Catalog\Model\CategoryRepository $categoryRepository;

    /**
     * @param \Magento\Catalog\Api\CategoryListInterface $categoryList
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Catalog\Model\CategoryRepository $categoryRepository
     */
    public function __construct(
        \Magento\Catalog\Api\CategoryListInterface $categoryList,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
    ) {
        $this->categoryList = $categoryList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->storeManager = $storeManager;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getAllSystemCategory(): array
    {
        $categoriesList = [];

        try {
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $categoryList = $this->categoryList->getList($searchCriteria);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        if ($categoryList->getTotalCount()) {
            foreach ($categoryList->getItems() as $category){
                $categoriesList[] = $category->getData();
            }
        }

        return $this->getCategoryUrl($categoriesList);
    }

    /**
     * @throws NoSuchEntityException
     */
    public function getCategoryUrl($categoriesList): array
    {
        $categoriesListWithUrl = [];

        foreach ($categoriesList as $category) {
            $categoryId = $category['entity_id'];

            $categoryUrl = $this->categoryRepository->get($categoryId, $this->storeManager->getStore()->getId())->getUrl();

            if (str_ends_with($categoryUrl, 'html')) {
                $category['url'] = $categoryUrl;
                $categoriesListWithUrl[] = $category;
            }
        }

        return $categoriesListWithUrl;
    }
}
