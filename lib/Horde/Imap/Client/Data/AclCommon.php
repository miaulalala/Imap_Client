<?php
/**
 * Provides common methods shared in all ACL classes (see RFC 2086/4314).
 *
 * Copyright 2011 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author   Michael Slusarz <slusarz@horde.org>
 * @category Horde
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @package  Imap_Client
 */
class Horde_Imap_Client_Data_AclCommon
{
    /* Constants for getString(). */
    const RFC_2086 = 1;
    const RFC_4314 = 2;

    /**
     * List of virtual rights (RFC 4314 [2.1.1]).
     *
     * @var array
     */
    protected $_virtual = array(
        Horde_Imap_Client::ACL_CREATE => array(
            Horde_Imap_Client::ACL_CREATEMBOX,
            Horde_Imap_Client::ACL_DELETEMBOX
        ),
        Horde_Imap_Client::ACL_DELETE => array(
            Horde_Imap_Client::ACL_DELETEMBOX,
            Horde_Imap_Client::ACL_DELETEMSGS,
            Horde_Imap_Client::ACL_EXPUNGE
        )
    );

    /**
     * Returns the raw string to use in IMAP server calls.
     *
     * @param integer $type  The RFC type to use (RFC_* constant).
     *
     * @return string  The string representation of the ACL.
     */
    public function getString($type = self::RFC_4314)
    {
        $acl = strval($this);

        if ($type == self::RFC_2086) {
            foreach ($this->_virtual as $key => $val) {
                $acl = str_replace($val, '', $acl, $count);
                if ($count) {
                    $acl .= $key;
                }
            }
        }

        return $acl;
    }

}