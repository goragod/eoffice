<?php
/**
 * @filesource modules/index/models/menu.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Menu;

use Gcms\Login;

/**
 * รายการเมนู
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model
{
    /**
     * รายการเมนู
     *
     * @param array $login
     *
     * @return array
     */
    public static function getMenus($login)
    {
        // เมนูตั้งค่า
        $settings = array();
        if (Login::checkPermission($login, 'can_config')) {
            // สามารถตั้งค่าระบบได้
            $settings['system'] = array(
                'text' => '{LNG_Site settings}',
                'url' => 'index.php?module=system',
            );
            $settings['mailserver'] = array(
                'text' => '{LNG_Email settings}',
                'url' => 'index.php?module=mailserver',
            );
            $settings['memberstatus'] = array(
                'text' => '{LNG_Member status}',
                'url' => 'index.php?module=memberstatus',
            );
            $settings['lines'] = array(
                'text' => '{LNG_LINE group account}',
                'url' => 'index.php?module=lines',
            );
            $settings['language'] = array(
                'text' => '{LNG_Language}',
                'url' => 'index.php?module=language',
            );
            $settings['position'] = array(
                'text' => '{LNG_Position}',
                'url' => 'index.php?module=index-categories&amp;type=position',
            );
            $settings['department'] = array(
                'text' => '{LNG_Department}',
                'url' => 'index.php?module=index-categories&amp;type=department',
            );
        }
        $members = array(
            array(
                'text' => '{LNG_Member list}',
                'url' => 'index.php?module=member',
            ),
            array(
                'text' => '{LNG_Register}',
                'url' => 'index.php?module=register',
            ),
        );
        // เมนูหลัก
        $menus = array(
            'home' => array(
                'text' => '{LNG_Home}',
                'url' => 'index.php?module=home',
            ),
            'module' => array(
                'text' => '{LNG_Module}',
                'submenus' => array(),
            ),
            'member' => array(
                'text' => '{LNG_Users}',
                'submenus' => $members,
            ),
            'report' => array(
                'text' => '{LNG_Report}',
                'submenus' => array(),
            ),
            'settings' => array(
                'text' => '{LNG_Settings}',
                'url' => 'index.php?module=settings',
                'submenus' => $settings,
            ),
        );
        if ($login) {
            $menus['signout'] = array(
                'text' => '{LNG_Logout}',
                'url' => 'index.php?action=logout',
            );
        } else {
            $menus['signin'] = array(
                'text' => '{LNG_Login}',
                'url' => 'index.php?module=welcome&amp;action=login',
            );
        }

        return $menus;
    }
}
