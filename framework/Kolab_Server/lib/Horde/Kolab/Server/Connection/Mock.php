<?php
/**
 * A driver for simulating a Kolab user database stored in LDAP.
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
 * This class provides a class for testing the Kolab Server DB.
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
class Horde_Kolab_Server_Connection_Mock
implements Horde_Kolab_Server_Connection_Interface
{
    /**
     * The LDAP connection handle.
     *
     * @var Horde_Ldap
     */
    private $_ldap;

    /**
     * Constructor
     *
     * @param Horde_Ldap $ldap The ldap connection.
     */
    public function __construct(Horde_Kolab_Server_Connection_Mock_Ldap $ldap)
    {
        $this->_ldap = $ldap;
    }

    /**
     * Get the server read connection.
     *
     * @return mixed The connection for reading data.
     */
    public function getRead()
    {
        return $this->_ldap;
    }

    /**
     * Get the server write connection.
     *
     * @return mixed The connection for writing data.
     */
    public function getWrite()
    {
        return $this->_ldap;
    }
}