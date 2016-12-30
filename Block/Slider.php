<?php

/**
 * Acx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the agilecodex.com license that is
 * available through the world-wide-web at this URL:
 * http://www.agilecodex.com/license-agreement
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Acx
 * @package     Acx_Slider
 * @copyright   Copyright (c) 2016 Acx (http://www.agilecodex.com/)
 * @license     http://www.agilecodex.com/license-agreement
 */

namespace Acx\Slider\Block;
use Acx\Slider\Model\Status;

/**
 * Slider Block
 * @category Acx
 * @package  Acx_Slider
 * @module   Slider
 * @author   Wasim haider Chowdhury
 */
class Slider extends \Magento\Framework\View\Element\Template
{
    /**
     * template for evolution slider.
     */
    const TEMPLATE = 'Acx_Slider::slider/slider.phtml';
    const XML_CONFIG_SLIDER = 'slider/general/enable_frontend';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Acx Slider helper.
     *
     * @var \Acx\Slider\Helper\Data
     */
    protected $_sliderHelper;

    /**
     * @var \Acx\Slider\Model\ResourceModel\Banner\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * scope config.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    
    public $_widget;
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Acx\Slider\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,
        \Acx\Slider\Helper\Data $sliderHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_sliderHelper = $sliderHelper;
        $this->_storeManager = $context->getStoreManager();
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        $this->_scopeConfig = $context->getScopeConfig();
    }
    
    /**
     * @return
     */
    protected function _toHtml()
    {
        $store = $this->_storeManager->getStore()->getId();
        $configEnable = $this->_scopeConfig->getValue(
            self::XML_CONFIG_SLIDER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
        
        if ($configEnable && $this->getBannerCollection()->getSize()) {
            $this->setTemplate(self::TEMPLATE);
        }
        
        return parent::_toHtml();
    }
    
    /**
     * get banner collection of slider.
     *
     * @return \Acx\Slider\Model\ResourceModel\Banner\Collection
     */
    public function getBannerCollection()
    {
        $storeViewId = $this->_storeManager->getStore()->getId();

        /** @var \Acx\Slider\Model\ResourceModel\Banner\Collection $bannerCollection */
        $bannerCollection = $this->_bannerCollectionFactory->create()
            ->setStoreViewId($storeViewId)
            ->addFieldToFilter('status', Status::STATUS_ENABLED)
            ->setOrder('sort_order', 'ASC');
        
        return $bannerCollection;
    }
    
    /**
     * get banner image url.
     *
     * @param \Acx\Slider\Model\Banner $banner
     *
     * @return string
     */
    public function getBannerImageUrl(\Acx\Slider\Model\Banner $banner)
    {
        return $this->_sliderHelper->getBaseUrlMedia($banner->getImage());
    }

    /**
     * get flexslider html id.
     *
     * @return string
     */
    public function getFlexsliderHtmlId()
    {
        return 'acx-slider-slider';
    }
}