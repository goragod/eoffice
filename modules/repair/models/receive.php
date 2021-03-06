<?php
/**
 * @filesource modules/repair/models/receive.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Repair\Receive;

use Gcms\Login;
use Kotchasan\File;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * เพิ่ม-แก้ไข ใบแจ้งซ่อม
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * อ่านข้อมูลรายการที่เลือก
     * ถ้า $id = 0 หมายถึงรายการใหม่
     * คืนค่าข้อมูล object ไม่พบคืนค่า null
     *
     * @param int $id ID
     *
     * @return object|null
     */
    public static function get($id)
    {
        if (empty($id)) {
            // ใหม่
            return (object) array(
                'id' => 0,
                'topic' => '',
                'product_no' => '',
                'inventory_id' => 0,
                'job_description' => '',
                'comment' => '',
                'status_id' => 0,
            );
        } else {
            // แก้ไข
            return static::createQuery()
                ->from('repair R')
                ->join('inventory V', 'LEFT', array('V.id', 'R.inventory_id'))
                ->join('inventory_stock T', 'LEFT', array('T.inventory_id', 'V.id'))
                ->where(array('R.id', $id))
                ->first('R.*', 'V.topic', 'T.product_no');
        }
    }

    /**
     * บันทึกค่าจากฟอร์ม (receive.php)
     *
     * @param Request $request
     */
    public function submit(Request $request)
    {
        $ret = array();
        // session, token, member
        if ($request->initSession() && $request->isSafe() && $login = Login::isMember()) {
            try {
                // รับค่าจากการ POST
                $repair = array(
                    'job_description' => $request->post('job_description')->textarea(),
                    'inventory_id' => $request->post('inventory_id')->toInt(),
                );
                $topic = $request->post('topic')->topic();
                $product_no = $request->post('product_no')->topic();
                // สามารถจัดการรายการซ่อมได้
                $can_manage_repair = Login::checkPermission($login, 'can_manage_repair');
                // ตรวจสอบรายการที่เลือก
                $index = self::get($request->post('id')->toInt());
                if (!$index || $index->id > 0 && ($login['id'] != $index->customer_id && !$can_manage_repair)) {
                    // ไม่พบรายการที่แก้ไข
                    $ret['alert'] = Language::get('Sorry, Item not found It&#39;s may be deleted');
                } elseif (empty($product_no)) {
                    // product_no
                    $ret['ret_product_no'] = 'Please fill in';
                } elseif (empty($topic)) {
                    // topic
                    $ret['ret_topic'] = 'Please fill in';
                } elseif (empty($repair['inventory_id'])) {
                    // ไม่พบรายการพัสดุที่เลือก
                    $ret['ret_topic'] = Language::get('Please select from the search results');
                } else {
                    // ตาราง
                    $repair_table = $this->getTableName('repair');
                    $repair_status_table = $this->getTableName('repair_status');
                    // Database
                    $db = $this->db();
                    if ($index->id > 0) {
                        $repair['id'] = $index->id;
                    } else {
                        $repair['id'] = $db->getNextId($repair_table);
                    }
                    // อัปโหลดไฟล์
                    $dir = ROOT_PATH.DATA_FOLDER.'repair/'.$repair['id'].'/';
                    // เวลาตอนนี้ สำหรับเป็นชื่อไฟล์
                    $mktime = time();
                    foreach ($request->getUploadedFiles() as $item => $file) {
                        /* @var $file \Kotchasan\Http\UploadedFile */
                        if ($file->hasUploadFile()) {
                            if (!File::makeDirectory(ROOT_PATH.DATA_FOLDER.'repair/') || !File::makeDirectory($dir)) {
                                // ไดเรคทอรี่ไม่สามารถสร้างได้
                                $ret['ret_files_tmp'] = sprintf(Language::get('Directory %s cannot be created or is read-only.'), DATA_FOLDER.'repair/'.$repair['id'].'/');
                            } elseif (!$file->validFileExt(self::$cfg->repair_file_typies)) {
                                // ชนิดของไฟล์ไม่ถูกต้อง
                                $ret['ret_files_tmp'] = Language::get('The type of file is invalid');
                            } else {
                                try {
                                    $ext = strtolower($file->getClientFileExt());
                                    while (file_exists($dir.$mktime.'.'.$ext)) {
                                        ++$mktime;
                                    }
                                    $file->moveTo($dir.$mktime.'.'.$ext);
                                } catch (\Exception $exc) {
                                    // ไม่สามารถอัปโหลดได้
                                    $ret['ret_files_tmp'] = Language::get($exc->getMessage());
                                }
                            }
                        } elseif ($file->hasError()) {
                            // ข้อผิดพลาดการอัปโหลด
                            $ret['ret_files_tmp'] = Language::get($file->getErrorMessage());
                        }
                    }
                    if ($index->id == 0) {
                        // ใหม่
                        $repair['customer_id'] = $login['id'];
                        $repair['create_date'] = date('Y-m-d H:i:s');
                        // บันทึกรายการแจ้งซ่อม
                        $db->insert($repair_table, $repair);
                        // บันทึกประวัติการทำรายการ แจ้งซ่อม
                        $db->insert($repair_status_table, array(
                            'repair_id' => $repair['id'],
                            'member_id' => $login['id'],
                            'comment' => $request->post('comment')->topic(),
                            'status' => isset(self::$cfg->repair_first_status) ? self::$cfg->repair_first_status : 1,
                            'create_date' => $repair['create_date'],
                            'operator_id' => 0,
                        ));
                        // ใหม่ ส่งอีเมลไปยังผู้ที่เกี่ยวข้อง
                        $ret['alert'] = \Repair\Email\Model::send($login['username'], $login['name'], $repair);
                    } else {
                        // แก้ไขรายการแจ้งซ่อม
                        $db->update($repair_table, $index->id, $repair);
                        // คืนค่า
                        $ret['alert'] = Language::get('Saved successfully');
                    }
                    if ($can_manage_repair && $index->id > 0) {
                        // สามารถจัดการรายการซ่อมได้
                        $ret['location'] = $request->getUri()->postBack('index.php', array('module' => 'repair-setup', 'id' => null));
                    } else {
                        // ใหม่
                        $ret['location'] = $request->getUri()->postBack('index.php', array('module' => 'repair-history', 'id' => null));
                    }
                    // clear
                    $request->removeToken();
                }
            } catch (\Kotchasan\InputItemException $e) {
                $ret['alert'] = $e->getMessage();
            }
        }
        if (empty($ret)) {
            $ret['alert'] = Language::get('Unable to complete the transaction');
        }
        // คืนค่าเป็น JSON
        echo json_encode($ret);
    }
}
