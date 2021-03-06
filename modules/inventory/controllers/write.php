<?php
/**
 * @filesource modules/inventory/controllers/write.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Inventory\Write;

use Gcms\Login;
use Kotchasan\Html;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=inventory-write
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Gcms\Controller
{
    /**
     * เพิ่ม-แก้ไข Inventory
     *
     * @param Request $request
     *
     * @return string
     */
    public function render(Request $request)
    {
        // สมาชิก
        $login = Login::isMember();
        // ตรวจสอบรายการที่เลือก
        $index = \Inventory\Write\Model::get($request->request('id')->toInt());
        // ข้อความ title bar
        $title = '{LNG_'.(empty($index->id) ? 'Add New' : 'Edit').'}';
        $this->title = Language::trans($title.' {LNG_Equipment}');
        // เลือกเมนู
        $this->menu = 'settings';
        // สามารถบริหารจัดการได้
        if ($index && Login::checkPermission($login, 'can_manage_inventory')) {
            // แสดงผล
            $section = Html::create('section', array(
                'class' => 'content_bg',
            ));
            // breadcrumbs
            $breadcrumbs = $section->add('div', array(
                'class' => 'breadcrumbs',
            ));
            $ul = $breadcrumbs->add('ul');
            $ul->appendChild('<li><span class="icon-product">{LNG_Settings}</span></li>');
            $ul->appendChild('<li><a href="{BACKURL?module=inventory-setup&id=0}">{LNG_Inventory}</a></li>');
            $ul->appendChild('<li><span>'.$title.'</span></li>');
            $section->add('header', array(
                'innerHTML' => '<h2 class="icon-write">'.$this->title.'</h2>',
            ));
            // menu
            $section->appendChild(\Index\Tabmenus\View::render($request, 'settings', 'inventory'));
            // แสดงฟอร์ม
            $section->appendChild(createClass('Inventory\Write\View')->render($request, $index));
            // คืนค่า HTML
            return $section->render();
        }
        // 404
        return \Index\Error\Controller::execute($this, $request->getUri());
    }
}
