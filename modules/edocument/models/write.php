<?php
/**
 * @filesource modules/edocument/models/write.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Edocument\Write;

use Gcms\Login;
use Kotchasan\Database\Sql;
use Kotchasan\File;
use Kotchasan\Http\Request;
use Kotchasan\Language;
use Kotchasan\Number;

/**
 * module=edocument-write
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
     *
     * @param int   $id    ID
     * @param array $login
     *
     * @return object|null คืนค่าข้อมูล object ไม่พบคืนค่า null
     */
    public static function get($id, $login)
    {
        // Model
        $model = new static();
        if (empty($id)) {
            // ใหม่
            $id = $model->db()->getNextId($model->getTableName('edocument'));
            return (object) array(
                'id' => 0,
                'document_no' => Number::printf(self::$cfg->edocument_format_no, $id),
                'sender_id' => (int) $login['id'],
                'reciever' => array(),
                'department' => array(),
                'urgency' => 2,
                'topic' => '',
                'detail' => '',
            );
        } else {
            // แก้ไข อ่านรายการที่เลือก
            $result = $model->db()->createQuery()
                ->from('edocument E')
                ->join('edocument_download D', 'LEFT', array('D.id', 'E.id'))
                ->join('user U', 'LEFT', array('U.id', 'D.member_id'))
                ->where(array('E.id', $id))
                ->groupBy('E.id')
                ->first('E.*', Sql::create("GROUP_CONCAT(CONCAT(U.`id`,':',U.`name`) SEPARATOR ',') AS `reciever`"));
            if ($result) {
                $result->department = explode(',', trim($result->department, ','));
                $reciever = array();
                if ($result->reciever != '') {
                    foreach (explode(',', $result->reciever) as $item) {
                        $ds = explode(':', $item);
                        $reciever[$ds[0]] = isset($ds[1]) ? $ds[1] : $ds[0];
                    }
                }
                $result->reciever = $reciever;
            }
            return $result;
        }
    }

    /**
     * บันทึกข้อมูลที่ส่งมาจากฟอร์ม (write.php)
     *
     * @param Request $request
     */
    public function submit(Request $request)
    {
        $ret = array();
        // session, token, member, ไม่ใช่สมาชิกตัวอย่าง
        if ($request->initSession() && $request->isSafe() && $login = Login::isMember()) {
            if (Login::notDemoMode($login)) {
                try {
                    // ค่าที่ส่งมา
                    $save = array(
                        'document_no' => $request->post('document_no')->topic(),
                        // ผู้รับตามแผนก
                        'department' => $request->post('department', array())->toInt(),
                        'urgency' => $request->post('urgency')->toInt(),
                        'topic' => $request->post('topic')->topic(),
                        'detail' => $request->post('detail')->textarea(),
                    );
                    // ตรวจสอบรายการที่เลือก
                    $index = self::get($request->post('id')->toInt(), $login);
                    if (!$index) {
                        // ไม่พบ
                        $ret['alert'] = Language::get('Sorry, Item not found It&#39;s may be deleted');
                    } elseif ($index->id > 0 && !($login['id'] == $index->sender_id || Login::checkPermission($login, 'can_upload_edocument'))) {
                        // แก้ไข ไม่ใช่เจ้าของ หรือ ไม่มีสิทธิ์
                        $ret['alert'] = Language::get('Can not be performed this request. Because they do not find the information you need or you are not allowed');
                    } else {
                        if ($save['document_no'] == '') {
                            // ไม่ได้กรอกเลขที่เอกสาร
                            $ret['ret_document_no'] = 'Please fill in';
                        } else {
                            // ค้นหาเลขที่เอกสารซ้ำ
                            $search = $this->db()->first($this->getTableName('edocument'), array('document_no', $save['document_no']));
                            if ($search && ($index->id == 0 || $index->id != $search->id)) {
                                $ret['ret_document_no'] = Language::replace('This :name already exist', array(':name' => Language::get('Document number')));
                            }
                        }
                        if ($save['detail'] == '') {
                            // ไม่ได้กรอก detail
                            $ret['ret_detail'] = 'Please fill in';
                        }
                        if (empty($save['department'])) {
                            // รายชื่อผู้รับที่เลือก
                            $reciever = $request->post('reciever', array())->toInt();
                        } else {
                            // ผู้รับตามแผนกที่เลือก
                            $reciever = array();
                            // query สมาชิกตามแผนกที่เลือก
                            $query = $this->db()->createQuery()
                                ->select('id')
                                ->from('user')
                                ->where(array(
                                    array('department', $save['department']),
                                    array('id', '!=', $login['id']),
                                    array('active', 1),
                                ));
                            foreach ($query->execute() as $item) {
                                $reciever[] = $item->id;
                            }
                        }
                        if (empty($ret)) {
                            if (empty($reciever)) {
                                // ไม่ได้ระบุผู้รับ ทั้ง department และ reciever
                                $ret['ret_department'] = 'Please select at least one item';
                            } else {
                                // อัปโหลดไฟล์
                                $dir = ROOT_PATH.DATA_FOLDER.'edocument/';
                                foreach ($request->getUploadedFiles() as $item => $file) {
                                    /* @var $file \Kotchasan\Http\UploadedFile */
                                    if ($file->hasUploadFile()) {
                                        if (!File::makeDirectory($dir)) {
                                            // ไดเรคทอรี่ไม่สามารถสร้างได้
                                            $ret['ret_'.$item] = sprintf(Language::get('Directory %s cannot be created or is read-only.'), DATA_FOLDER.'edocument/');
                                        } elseif (!$file->validFileExt(self::$cfg->edocument_file_typies)) {
                                            // ชนิดของไฟล์ไม่ถูกต้อง
                                            $ret['ret_'.$item] = Language::get('The type of file is invalid');
                                        } elseif ($file->getSize() > self::$cfg->edocument_upload_size) {
                                            // ขนาดของไฟล์ใหญ่เกินไป
                                            $ret['ret_'.$item] = Language::get('The file size larger than the limit');
                                        } else {
                                            $save['ext'] = $file->getClientFileExt();
                                            $file_name = str_replace('.'.$save['ext'], '', $file->getClientFilename());
                                            if ($file_name == '' && $save['topic'] == '') {
                                                $ret['ret_topic'] = 'Please fill in';
                                            } else {
                                                // อัปโหลด
                                                $mktime = time();
                                                $save['file'] = $mktime.'.'.$save['ext'];
                                                while (file_exists($dir.$save['file'])) {
                                                    ++$mktime;
                                                    $save['file'] = $mktime.'.'.$save['ext'];
                                                }
                                                try {
                                                    $file->moveTo($dir.$save['file']);
                                                    $save['size'] = $file->getSize();
                                                    if ($save['topic'] == '') {
                                                        $save['topic'] = $file_name;
                                                    }
                                                    if (!empty($index->file) && $save['file'] != $index->file) {
                                                        @unlink($dir.$index->file);
                                                    }
                                                } catch (\Exception $exc) {
                                                    // ไม่สามารถอัปโหลดได้
                                                    $ret['ret_'.$item] = Language::get($exc->getMessage());
                                                }
                                            }
                                        }
                                    } elseif ($file->hasError()) {
                                        // ข้อผิดพลาดการอัปโหลด
                                        $ret['ret_'.$item] = Language::get($file->getErrorMessage());
                                    } elseif ($index->id == 0) {
                                        // ใหม่ ต้องมีไฟล์
                                        $ret['ret_'.$item] = 'Please browse file';
                                    }
                                }
                            }
                            if (empty($ret)) {
                                $save['last_update'] = time();
                                $department = $save['department'];
                                $save['department'] = ','.implode(',', $department).',';
                                $save['ip'] = $request->getClientIp();
                                $save['topic'] = preg_replace('/[,;:_]{1,}/', '_', $save['topic']);
                                if ($index->id == 0) {
                                    // ใหม่
                                    $save['sender_id'] = $login['id'];
                                    $index->id = $this->db()->insert($this->getTableName('edocument'), $save);
                                } else {
                                    // แก้ไข
                                    $this->db()->update($this->getTableName('edocument'), $index->id, $save);
                                }
                                // แอเรย์เก็บรายชื่อผู้รับ
                                $recievers = array();
                                // รายชื่อผู้รับที่เลือก
                                foreach ($reciever as $r) {
                                    if ($r != $login['id']) {
                                        $recievers[$r] = array(
                                            'id' => $index->id,
                                            'member_id' => $r,
                                            'downloads' => 0,
                                            'last_update' => 0,
                                        );
                                    }
                                }
                                // ตาราง
                                $table = $this->getTableName('edocument_download');
                                // query ผู้รับเดิม
                                foreach ($this->db()->select($table, array('id', $index->id)) as $item) {
                                    if (isset($recievers[$item['member_id']])) {
                                        $recievers[$item['member_id']] = $item;
                                    }
                                }
                                // ลบ ผู้รับเดิม
                                $this->db()->delete($table, array('id', $index->id), 0);
                                // บันทึกผู้รับใหม่ลงในตาราง
                                foreach ($recievers as $item) {
                                    $this->db()->insert($table, $item);
                                }
                                // คืนค่า
                                $ret['alert'] = Language::get('Saved successfully');
                                if ($request->post('send_mail')->toInt() == 1) {
                                    $ret['alert'] = \Edocument\Email\Model::send(array_keys($recievers), $department, $save);
                                }
                                $ret['location'] = $request->getUri()->postBack('index.php', array('module' => 'edocument-sent'));
                            }
                        }
                    }
                } catch (\Kotchasan\InputItemException $e) {
                    $ret['alert'] = $e->getMessage();
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
