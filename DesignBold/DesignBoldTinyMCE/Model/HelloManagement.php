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
 */

namespace DesignBold\DesignBoldTinyMCE\Model;

class HelloManagement implements \Designbold\DesignBoldTinyMCE\Api\HelloManagementInterface
{

    /**
     * {@inheritdoc}
     */
    public function getHello($param)
    {
        return 'hello api GET return the $param ' . $param;
    }
}
