<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Block\Adminhtml\Question\Edit;

/**
 * Admin Question left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('question_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Question Information'));
    }
}
