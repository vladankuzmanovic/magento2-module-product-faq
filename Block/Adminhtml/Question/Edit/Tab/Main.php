<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Block\Adminhtml\Question\Edit\Tab;

/**
 * Product FAQ Question edit form main tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Kuzman\ProductFaq\Model\Question $model */
        $model = $this->_coreRegistry->registry('productfaq_question');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('question_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField('question_id', 'hidden', ['name' => 'question_id']);
        }

        $fieldset->addField(
            'email',
            'text',
            [
                'name' => 'email',
                'label' => __('Customer Email'),
                'title' => __('Customer Email'),
                'required' => true,
                'class' =>'validate-email']
        );

        $fieldset->addField(
            'nickname',
            'text',
            [
                'name' => 'nickname',
                'label' => __('Customer Nickname'),
                'title' => __('Customer Nickname'),
                'required' => true
            ]

        );
        $fieldset->addField(
            'question',
            'editor',
            [
                'name' => 'question',
                'label' => __('Question'),
                'title' => __('Question'),
                'style' => 'height:15em',
                'required' => true
            ]
        );

        $fieldset->addField(
            'answer',
            'editor',
            [
                'name' => 'answer',
                'label' => __('Answer'),
                'title' => __('Answer'),
                'style' => 'height:15em',
                'required' => true
            ]
        );

        $fieldset->addField(
            'product_id',
            'text',
            [
                'name' => 'product_id',
                'label' => __('Product Id'),
                'title' => __('Product Id'),
				'note' => __('Comma separated Product Ids')
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );

        $this->_eventManager->dispatch('adminhtml_cproductfaq_question_edit_tab_main_prepare_form', ['form' => $form]);

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('General Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('General Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}