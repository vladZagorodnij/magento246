<?php
declare(strict_types=1);

namespace VladZahorodnii\HomeCategory\Block;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use VladZahorodnii\HomeCategory\Model\AllCategory;

class HomeCategories extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollection;

    /**
     * @var \VladZahorodnii\HomeCategory\Model\AllCategory
     */
    private \VladZahorodnii\HomeCategory\Model\AllCategory $allCategories;


    /**
     * @param StoreManagerInterface $storeManager
     * @param CollectionFactory $categoryCollection
     * @param AllCategory $allCategories
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollection,
        \VladZahorodnii\HomeCategory\Model\AllCategory $allCategories,
        Template\Context $context,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->storeManager = $storeManager;
        $this->categoryCollection = $categoryCollection;
        $this->allCategories = $allCategories;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Exception
     */
    public function getCategories(): array
    {
        $categories = $this->allCategories->getAllSystemCategory();
        $categoriesList = [];

        if ($categories->getTotalCount()) {
            foreach ($categories->getItems() as $category){
                $categoriesList[] = $category->getData();
            }
        }

        return $categoriesList;
    }
}
