<?php

namespace DesignBold\DesignBoldTinyMCE\Plugin\Wysiwyg;

use Magento\Cms\Model\Wysiwyg\Config as Subject;
use Magento\Framework\DataObject;
use DesignBold\DesignBoldTinyMCE\Model\Wysiwyg\DesignButton;

class ConfigPlugin
{
    /**
     * @var DesignButton
     */
    private $designButton;

    /**
     * ConfigPlugin constructor.
     * @param DesignButton $designButton
     */
    public function __construct(
        DesignButton $designButton
    )
    {
        $this->designButton = $designButton;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetConfig(Subject $subject, DataObject $config): DataObject
    {
        $designButtonPluginSettings = $this->designButton->getPluginSettings($config);
        $config->addData($designButtonPluginSettings);
        return $config;
    }
}
