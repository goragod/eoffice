<?php
/**
 * @filesource modules/personnel/models/write.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Personnel\Write;

use Gcms\Login;
use Kotchasan\File;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * เพิ่ม/แก้ไข ข้อมูลบุคลากร.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * อ่านข้อมูลสมาชิกที่ $id
     * คืนค่าข้อมูล object ไม่พบคืนค่า false.
     *
     * @param int $id
     *
     * @return object|bool
     */
    public static function get($id)
    {
        if (!empty($id)) {
            $query = static::createQuery()
                ->from('user U')
                ->where(array(
                    array('U.id', $id),
                    array('U.active', 1),
                ));
            $select = array('U.*');
            $n = 1;
            foreach (Language::get('PERSONNEL_DETAILS') as $key => $label) {
                $query->join('user_category M'.$n, 'LEFT', array(array('M'.$n.'.member_id', 'U.id'), array('M'.$n.'.name', $key)));
                $select[] = 'M'.$n.'.value '.$key;
                ++$n;
            }

            return $query->first($select);
        }

        return false;
    }

    /**
     * บันทึกข้อมูลที่ส่งมาจากฟอร์ม write.php.
     *
     * @param Request $request
     */
    public function submit(Request $request)
    {
        $ret = array();
        // session, token, สมาชิก
        if ($request->initSession() && $request->isSafe() && $login = Login::isMember()) {
            // ตรวจสอบค่าที่ส่งมา
            $index = \Personnel\Write\Model::get($request->post('personnel_id')->toInt());
            if (!$index) {
                // ไม่พบรายการที่แก้ไข
                $ret['alert'] = Language::get('Sorry, Item not found It&#39;s may be deleted');
            } else {
                // สามารถจัดการบุคลากรได้
                if (!Login::checkPermission($login, 'can_manage_personnel')) {
                    // ตัวเอง
                    $login = $login['id'] == $index->id ? $login : false;
                }
                if ($login && $login['active'] == 1) {
                    // ค่าที่ส่งมา
                    $user = array(
                        'name' => $request->post('personnel_name')->topic(),
                        'phone' => $request->post('personnel_phone')->topic(),
                        'department' => $request->post('personnel_department')->topic(),
                        'position' => $request->post('personnel_position')->topic(),
                    );
                    $personnel = array();
                    $urls = array();
                    // custom item
                    foreach (Language::get('PERSONNEL_DETAILS') as $key => $label) {
                        $value = $request->post('personnel_'.$key)->topic();
                        if ($value != '') {
                            $personnel[$key] = $value;
                        }
                    }
                    if ($user['name'] == '') {
                        // ไม่ได้กรอก name
                        $ret['ret_personnel_name'] = 'Please fill in';
                    } else {
                        $dir = ROOT_PATH.DATA_FOLDER.'personnel/';
                        // อัปโหลดรูปภาพพร้อมปรับขนาด
                        foreach ($request->getUploadedFiles() as $item => $file) {
                            /* @var $file UploadedFile */
                            if ($file->hasUploadFile()) {
                                if (!File::makeDirectory($dir)) {
                                    // ไดเรคทอรี่ไม่สามารถสร้างได้
                                    $ret['ret_'.$item] = sprintf(Language::get('Directory %s cannot be created or is read-only.'), DATA_FOLDER.'personnel/');
                                } elseif ($item == 'personnel_picture') {
                                    try {
                                        $file->cropImage(array('jpg', 'jpeg', 'png'), $dir.$index->id.'.jpg', self::$cfg->personnel_w, self::$cfg->personnel_h);
                                    } catch (\Exception $exc) {
                                        // ไม่สามารถอัปโหลดได้
                                        $ret['ret_'.$item] = Language::get($exc->getMessage());
                                    }
                                }
                            } elseif ($file->hasError()) {
                                // upload Error
                                $ret['ret_'.$item] = $file->getErrorMessage();
                            }
                        }
                        if (empty($ret)) {
                            // user
                            $this->db()->update($this->getTableName('user'), $index->id, $user);
                            // user_category
                            $table = $this->getTableName('user_category');
                            $this->db()->delete($table, array('member_id', $index->id), 0);
                            foreach ($personnel as $name => $value) {
                                $this->db()->insert($table, array(
                                    'member_id' => $index->id,
                                    'name' => $name,
                                    'value' => $value,
                                ));
                            }
                            // ส่งค่ากลับ
                            if ($index->id == 0) {
                                // แสดงรายการใหม่
                                $urls['sort'] = 'id desc';
                                $urls['page'] = 1;
                            } else {
                                $urls = array();
                            }
                            $urls['module'] = 'personnel-setup';
                            $urls['id'] = 0;
                            $ret['location'] = $request->getUri()->postBack('index.php', $urls);
                            $ret['alert'] = Language::get('Saved successfully');
                        }
                    }
                }
            }
        }
        if (empty($ret)) {
            $ret['alert'] = Language::get('Unable to complete the transaction');
        }
        // คืนค่าเป็น JSON
        echo json_encode($ret);
    }
}
