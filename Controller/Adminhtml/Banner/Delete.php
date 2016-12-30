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

namespace Acx\Slider\Controller\Adminhtml\Banner;

/**
 * Delete Banner action
 * @category Acx
 * @package  Acx_Slider
 * @module   Slider
 * @author   Wasim haider Chowdhury
 */
class Delete extends \Acx\Slider\Controller\Adminhtml\Banner
{
    public function execute()
    {
        $bannerId = $this->getRequest()->getParam(static::PARAM_CRUD_ID);
        try {
            $banner = $this->_bannerFactory->create()->setId($bannerId);
            $banner->delete();
            $this->messageManager->addSuccess(
                __('Delete successfully !')
            );
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
