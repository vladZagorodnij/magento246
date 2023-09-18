<?php
declare(strict_types=1);

namespace VladZahorodnii\HomeCategory\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use VladZahorodnii\HomeCategory\Model\AllCategory;

class HomeCategories extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \VladZahorodnii\HomeCategory\Model\AllCategory
     */
    private \VladZahorodnii\HomeCategory\Model\AllCategory $allCategories;


    /**
     * @param AllCategory $allCategories
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        \VladZahorodnii\HomeCategory\Model\AllCategory $allCategories,
        Template\Context $context,
        array $data = []
    ){
        parent::__construct($context, $data);
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
        return $this->allCategories->getAllSystemCategory();
    }
}
