<?php

namespace DesignBold\DesignBoldTinyMCE\Model\Wysiwyg;

use Magento\Framework\DataObject;

class DesignButton
{
    const PLUGIN_NAME = 'DesignBold_DesignButton';

    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $assetRepo;

    /**
     * DesignButton constructor.
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     */
    public function __construct(
        \Magento\Framework\View\Asset\Repository $assetRepo
    )
    {
        $this->assetRepo = $assetRepo;
    }

    public function getPluginSettings(DataObject $config): array
    {
        $plugins = $config->getData('plugins');
        $plugins[] = [
            'name' => self::PLUGIN_NAME,
            'src' => $this->getPluginJsSrc(),
            'options' => [
                'title' => __('Image design'),
                'class' => 'designbold-designbutton plugin',
                'css' => $this->getPluginCssSrc(),
                'js' => $this->getPluginButtonJsSrc()
            ],
        ];

        return ['plugins' => $plugins];
    }

    private function getPluginJsSrc(): string
    {
        return $this->assetRepo->getUrl(
            sprintf('DesignBold_DesignBoldTinyMCE::js/editor_plugin.js')
        );
    }

    private function getPluginButtonJsSrc(): string
    {
        return $this->assetRepo->getUrl(
            sprintf('DesignBold_DesignBoldTinyMCE::js/button.js')
        );
    }

    private function getPluginCssSrc(): string
    {
        return $this->assetRepo->getUrl(
            sprintf('DesignBold_DesignBoldTinyMCE::css/style.css')
        );
    }
}
