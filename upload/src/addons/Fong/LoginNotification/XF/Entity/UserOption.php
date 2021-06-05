<?php


namespace Fong\LoginNotification\XF\Entity;


class UserOption extends XFCP_UserOption
{

    public static function getStructure(\XF\Mvc\Entity\Structure $structure) : \XF\Mvc\Entity\Structure
    {
        $parent = parent::getStructure($structure);
        $parent->columns['loginnotification_notification'] = ['type' => self::BOOL, 'default' => false];
        return $parent;
    }

}