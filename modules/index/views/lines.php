<?php
/**
 * @filesource modules/index/views/lines.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Lines;

use Kotchasan\DataTable;
use Kotchasan\Http\Request;

/**
 * module=lines
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
    /**
     * ตารางราย ไลน์กลุ่ม
     *
     * @param Request $request
     *
     * @return string
     */
    public function render(Request $request)
    {
        // URL สำหรับส่งให้ตาราง
        $uri = $request->createUriWithGlobals(WEB_URL.'index.php');
        // ตาราง
        $table = new DataTable(array(
            /* Uri */
            'uri' => $uri,
            /* Model */
            'model' => \Index\Lines\Model::toDataTable(),
            /* เรียงลำดับ */
            'sort' => 'id desc',
            /* คอลัมน์ที่ไม่ต้องแสดงผล */
            'hideColumns' => array('id'),
            /* ตั้งค่าการกระทำของของตัวเลือกต่างๆ ด้านล่างตาราง ซึ่งจะใช้ร่วมกับการขีดถูกเลือกแถว */
            'action' => 'index.php/index/model/lines/action',
            'actionCallback' => 'dataTableActionCallback',
            'actions' => array(
                array(
                    'id' => 'action',
                    'class' => 'ok',
                    'text' => '{LNG_With selected}',
                    'options' => array(
                        'delete' => '{LNG_Delete}',
                    ),
                ),
            ),
            /* ส่วนหัวของตาราง และการเรียงลำดับ (thead) */
            'headers' => array(
                'name' => array(
                    'text' => '{LNG_LINE group name}',
                ),
                'token' => array(
                    'text' => '{LNG_Token}',
                ),
            ),
            /* ปุ่มแสดงในแต่ละแถว */
            'buttons' => array(
                'send' => array(
                    'class' => 'icon-line button orange',
                    'id' => ':id',
                    'text' => '{LNG_Test}',
                ),
                'edit' => array(
                    'class' => 'icon-edit button green',
                    'id' => ':id',
                    'text' => '{LNG_Edit}',
                ),
            ),
            /* ปุ่มเพิ่ม */
            'addNew' => array(
                'class' => 'float_button icon-new',
                'id' => 'edit_0',
                'title' => '{LNG_Add New} {LNG_LINE group account}',
            ),
        ));
        // คืนค่า HTML
        return $table->render();
    }
}
