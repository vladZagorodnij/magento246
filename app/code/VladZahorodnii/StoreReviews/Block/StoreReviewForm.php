<?php
declare(strict_types=1);

namespace VladZahorodnii\StoreReviews\Block;

class StoreReviewForm extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected \Magento\Customer\Model\Session $customer;

    /**
     * @param \Magento\Customer\Model\Session $customer
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Customer\Model\Session $customer,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ){
        $this->customer = $customer;
        parent::__construct($context, $data);
    }

    public function getCustomerId()
    {
        $customer = $this->customer;

        return $customer->getId();
    }

}
