<?php
/**
 * DesignBold design image button integration in TinyMCE.
 * Copyright (C) 2018  DesignBold.com
 *
 * This file is part of DesignBold/DesignBoldTinyMCE.
 *
 * DesignBold/DesignBoldTinyMCE is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * use magento 2 media api to add image in Magento2.
 * pass data with base64 image.
 * everything working
 */

namespace DesignBold\DesignBoldTinyMCE\Model;

use DesignBold\DesignBoldTinyMCE\Api\UploadImageManagementInterface;

class UploadImageManagement implements UploadImageManagementInterface
{
    protected $_storeManager;
    protected $_directoryList;
    protected $_file;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\Filesystem\Io\File $file
    )
    {
        $this->_storeManager = $storeManager;
        $this->_directoryList = $directoryList;
        $this->_file = $file;
    }

    /**
     * @param string $post_url
     * @return false|string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function postUploadImage($post_url)
    {
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl() . "pub/media/";
        $post_url = trim(addslashes($post_url));
        $file_name = basename(parse_url($post_url, PHP_URL_PATH));

        if (isset($post_url) && $post_url != '' && $file_name != '') {
            $obj_data = (object)[];
            $curYear = date("Y");
            $curMonth = date("m");
            $filePath = "/designbold/" . $curYear . "/" . $curMonth;
            $pdfPath = $this->_directoryList->getPath('media') . $filePath . "/";

            if (!is_dir($pdfPath)) {
                $ioAdapter = $this->_file;
                $ioAdapter->mkdir($pdfPath, 0777);
            }

            $opts = [
                "http" => [
                    "method" => "GET",
                    "header" => "Accept-language: en\r\n" .
                        "Cookie: foo=bar\r\n"
                ]
            ];

            $context = stream_context_create($opts);
            $contentFile = file_get_contents($post_url, false, $context);

            $newName = $this->renameDuplicates($pdfPath, $file_name);

            if (file_put_contents($pdfPath . $newName, $contentFile)) {
                $obj_data->image_info = array('url' => $baseUrl . $filePath . "/" . $newName);
            }

            header("Content-type: application/json; charset=utf-8");
            return json_encode($obj_data);
        } else {
            $obj_data = (object)[];
            header("Content-type: application/json; charset=utf-8");
            $obj_data->error = "The uploaded file is not a valid image";
            return json_encode($obj_data);
        }
    }

    public function renameDuplicates($path, $file)
    {
        $fileName = pathinfo($path . $file, PATHINFO_FILENAME);
        $fileExtension = "." . pathinfo($path . $file, PATHINFO_EXTENSION);

        $returnValue = $fileName . $fileExtension;

        $copy = 1;
        while (file_exists($path . $returnValue)) {
            $returnValue = $fileName . $copy . $fileExtension;
            $copy++;
        }
        return $returnValue;
    }
}
