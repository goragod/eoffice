<?php
/**
 * @filesource modules/inventory/controllers/index.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Inventory\Index;

use Gcms\Login;
use Kotchasan\Html;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=inventory/index.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Controller extends \Gcms\Controller
{
    /**
     * ตารางรายการ สินค้า.
     *
     * @param Request $request
     *
     * @return string
     */
    public function render(Request $request)
    {
        // ข้อความ title bar
        $this->title = Language::get('My device');
        // เลือกเมนู
        $this->menu = 'repair';
        // สมาชิก
        if ($login = Login::isMember()) {
            // แสดงผล
            $section = Html::create('section', array(
                'class' => 'content_bg',
            ));
            // breadcrumbs
            $breadcrumbs = $section->add('div', array(
                'class' => 'breadcrumbs',
            ));
            $ul = $breadcrumbs->add('ul');
            $ul->appendChild('<li><span class="icon-tools">{LNG_Repair jobs}</span></li>');
            $ul->appendChild('<li><span>{LNG_Equipment}</span></li>');
            $section->add('header', array(
                'innerHTML' => '<h2 class="icon-list">'.$this->title.'</h2>',
            ));
            // แสดงตาราง
            $section->appendChild(createClass('Inventory\Index\View')->render($request, $login));

            return $section->render();
        }
        // 404

        return \Index\Error\Controller::execute($this, $request->getUri());
    }
}
