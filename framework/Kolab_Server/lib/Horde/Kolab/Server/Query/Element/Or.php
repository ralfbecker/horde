<?php
/**
 * An element grouping by or.
 *
 * PHP version 5
 *
 * @category Kolab
 * @package  Kolab_Server
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @link     http://pear.horde.org/index.php?package=Kolab_Server
 */

/**
 * An element grouping by or.
 *
 * Copyright 2008-2015 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Kolab
 * @package  Kolab_Server
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 * @link     http://pear.horde.org/index.php?package=Kolab_Server
 */
class Horde_Kolab_Server_Query_Element_Or
extends Horde_Kolab_Server_Query_Element_Group
{
    /**
     * Convert this element to a query element.
     *
     * @return mixed The element as query.
     */
    public function convert(
        Horde_Kolab_Server_Query_Interface $writer
    ) {
        return $writer->convertOr($this);
    }
}