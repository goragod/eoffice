<?php
/**
 * @filesource modules/booking/views/report.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Booking\Report;

use Kotchasan\DataTable;
use Kotchasan\Date;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=booking-report
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
    /**
     * @var array
     */
    private $status;
    /**
     * @var object
     */
    private $category;

    /**
     * รายงานการจอง (แอดมิน)
     *
     * @param Request $request
     * @param array  $params
     *
     * @return string
     */
    public function render(Request $request, $params)
    {
        $this->category = \Booking\Category\Model::init();
        $this->status = $params['booking_status'];
        unset($params['booking_status']);
        // filter
        $filters = array(
            array(
                'name' => 'from',
                'type' => 'date',
                'text' => '{LNG_Date}',
                'value' => $params['from'],
            ),
            array(
                'name' => 'room_id',
                'default' => 0,
                'text' => '{LNG_Room}',
                'options' => array(0 => '{LNG_all items}')+\Booking\Rooms\Model::toSelect(),
                'value' => $params['room_id'],
            ),
        );
        foreach (Language::get('BOOKING_SELECT', array()) as $key => $label) {
            $params[$key] = $request->request($key)->toInt();
            $filters[] = array(
                'name' => $key,
                'text' => $label,
                'options' => array(0 => '{LNG_all items}') + $this->category->toSelect($key),
                'value' => $params[$key],
            );
        }
        $filters[] = array(
            'name' => 'status',
            'text' => '{LNG_Status}',
            'options' => array(-1 => '{LNG_all items}') + $this->status,
            'value' => $params['status'],
        );
        // URL สำหรับส่งให้ตาราง
        $uri = $request->createUriWithGlobals(WEB_URL.'index.php');
        // ตาราง
        $table = new DataTable(array(
            /* Uri */
            'uri' => $uri,
            /* Model */
            'model' => \Booking\Report\Model::toDataTable($params),
            /* รายการต่อหน้า */
            'perPage' => $request->cookie('bookingReport_perPage', 30)->toInt(),
            /* เรียงลำดับ */
            'sort' => $request->cookie('bookingReport_sort', 'create_date')->toString(),
            /* ฟังก์ชั่นจัดรูปแบบการแสดงผลแถวของตาราง */
            'onRow' => array($this, 'onRow'),
            /* คอลัมน์ที่ไม่ต้องแสดงผล */
            'hideColumns' => array('id', 'today', 'end', 'remain'),
            /* คอลัมน์ที่สามารถค้นหาได้ */
            'searchColumns' => array('topic', 'name', 'contact', 'phone'),
            /* ตั้งค่าการกระทำของของตัวเลือกต่างๆ ด้านล่างตาราง ซึ่งจะใช้ร่วมกับการขีดถูกเลือกแถว */
            'action' => 'index.php/booking/model/report/action',
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
            /* ตัวเลือกด้านบนของตาราง ใช้จำกัดผลลัพท์การ query */
            'filters' => $filters,
            /* ส่วนหัวของตาราง และการเรียงลำดับ (thead) */
            'headers' => array(
                'topic' => array(
                    'text' => '{LNG_Topic}',
                ),
                'room_id' => array(
                    'text' => '{LNG_Image}',
                    'class' => 'center',
                ),
                'name' => array(
                    'text' => '{LNG_Room name}',
                    'sort' => 'name',
                ),
                'contact' => array(
                    'text' => '{LNG_Contact name}',
                ),
                'phone' => array(
                    'text' => '{LNG_Phone}',
                    'class' => 'center',
                ),
                'begin' => array(
                    'text' => '{LNG_Date}',
                    'class' => 'center',
                    'sort' => 'begin',
                ),
                'end' => array(
                    'text' => '{LNG_End date}',
                    'class' => 'center',
                ),
                'create_date' => array(
                    'text' => '{LNG_Created}',
                    'class' => 'center',
                    'sort' => 'create_date',
                ),
                'reason' => array(
                    'text' => '{LNG_Reason}',
                ),
                'status' => array(
                    'text' => '{LNG_Status}',
                    'class' => 'center',
                ),
            ),
            /* รูปแบบการแสดงผลของคอลัมน์ (tbody) */
            'cols' => array(
                'room_id' => array(
                    'class' => 'center',
                ),
                'phone' => array(
                    'class' => 'center',
                ),
                'begin' => array(
                    'class' => 'center',
                ),
                'end' => array(
                    'class' => 'center',
                ),
                'create_date' => array(
                    'class' => 'center',
                ),
                'status' => array(
                    'class' => 'center',
                ),
            ),
            /* ฟังก์ชั่นตรวจสอบการแสดงผลปุ่มในแถว */
            'onCreateButton' => array($this, 'onCreateButton'),
            /* ปุ่มแสดงในแต่ละแถว */
            'buttons' => array(
                'edit' => array(
                    'class' => 'icon-edit button green',
                    'href' => $uri->createBackUri(array('module' => 'booking-order', 'id' => ':id')),
                    'text' => '{LNG_Edit}',
                ),
            ),
        ));
        // save cookie
        setcookie('bookingReport_perPage', $table->perPage, time() + 2592000, '/', HOST, HTTPS, true);
        setcookie('bookingReport_sort', $table->sort, time() + 2592000, '/', HOST, HTTPS, true);
        // คืนค่า HTML
        return $table->render();
    }

    /**
     * จัดรูปแบบการแสดงผลในแต่ละแถว
     *
     * @param array  $item ข้อมูลแถว
     * @param int    $o    ID ของข้อมูล
     * @param object $prop กำหนด properties ของ TR
     *
     * @return array
     */
    public function onRow($item, $o, $prop)
    {
        if ($item['today'] == 1) {
            $prop->class = 'bg3';
        }
        $thumb = is_file(ROOT_PATH.DATA_FOLDER.'booking/'.$item['room_id'].'.jpg') ? WEB_URL.DATA_FOLDER.'booking/'.$item['room_id'].'.jpg' : WEB_URL.'modules/booking/img/noimage.png';
        $item['room_id'] = '<img src="'.$thumb.'" style="max-height:50px;max-width:50px" alt=thumbnail>';
        $item['phone'] = '<a href="tel:'.$item['phone'].'">'.$item['phone'].'</a>';
        $item['begin'] = Date::format($item['begin']).' - '.Date::format($item['end']);
        $item['create_date'] = Date::format($item['create_date']);
        foreach ($this->category->items() as $k => $v) {
            if (isset($item[$v])) {
                $item[$v] = $this->category->get($k, $item[$v]);
            }
        }
        $item['status'] = '<span class="term'.$item['status'].'">'.$this->status[$item['status']].'</span>';
        return $item;
    }

    /**
     * ฟังกชั่นตรวจสอบว่าสามารถสร้างปุ่มได้หรือไม่
     *
     * @param array $item
     *
     * @return array
     */
    public function onCreateButton($btn, $attributes, $item)
    {
        if ($btn == 'edit') {
            if (empty(self::$cfg->booking_approving) && $item['today'] == 2) {
                return false;
            } elseif (self::$cfg->booking_approving == 1 && $item['remain'] < 0) {
                return false;
            } else {
                return $attributes;
            }
        } else {
            return $attributes;
        }
    }
}
