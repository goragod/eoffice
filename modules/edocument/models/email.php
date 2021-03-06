<?php
/**
 * @filesource modules/edocument/models/email.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Edocument\Email;

use Gcms\Login;
use Kotchasan\Date;
use Kotchasan\Language;

/**
 * ส่งอีเมลไปยังผู้ที่เกี่ยวข้อง
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\KBase
{
    /**
     * ส่งอีเมลแจ้งการทำรายการ
     *
     * @param string $recievers  ID ผู้รับ
     * @param array $department แผนกผู้รับ
     * @param array  $edocument  ข้อมูล
     */
    public static function send($recievers, $department, $edocument)
    {
        $ret = array();
        // ข้อความ
        $msg = array(
            '{LNG_E-Document}',
            '{LNG_Document number}: '.$edocument['document_no'],
            '{LNG_Topic}: '.$edocument['topic'],
            '{LNG_Date}: '.Date::format($edocument['last_update']),
            '{LNG_A new document has been sent to you. Please check back}',
            'URL: '.WEB_URL.'index.php?module=edocument-received',
        );
        $msg = Language::trans(implode("\n", $msg));
        // Model
        $model = new \Kotchasan\Model();
        // ส่งอีเมลไปยังผู้ที่เกี่ยวข้อง
        $emails = array();
        if (!empty(self::$cfg->edocument_send_mail) && (!empty($department) || !empty($recievers))) {
            // query อีเมลผู้รับ
            $query = $model->db()->createQuery()
                ->select('name', 'username')
                ->from('user');
            if (!empty($department)) {
                // สมาชิก
                $login = Login::isMember();
                // ผู้รับในแผนก
                $query->where(array(
                    array('status', $department),
                    array('username', '!=', ''),
                    array('id', '!=', (int) $login['id']),
                    array('active', 1),
                ));
            } elseif (!empty($recievers)) {
                // ผู้รับที่เลือก
                $query->where(array('id', $recievers));
            }
            foreach ($query->execute() as $item) {
                $emails[$item->username] = $item->name.'<'.$item->username.'>';
            }
            if (!empty($emails)) {
                // ส่งอีเมล
                $subject = '['.self::$cfg->web_title.'] '.Language::get('There are new documents sent to you');
                $err = \Kotchasan\Email::send(implode(',', $emails), self::$cfg->noreply_email, $subject, nl2br($msg));
                if ($err->error()) {
                    // คืนค่า error
                    $ret[] = strip_tags($err->getErrorMessage());
                }
            }
        }
        // ส่งใลน์
        if (!empty(self::$cfg->edocument_line_id)) {
            // บัญชีไลน์ที่ต้องส่ง
            $lines = array();
            foreach ($department as $s) {
                if (!empty(self::$cfg->edocument_line_id[$s])) {
                    $lines[] = self::$cfg->edocument_line_id[$s];
                }
            }
            if (!empty($lines)) {
                // อ่าน token
                $query = $model->db()->createQuery()
                    ->select('token')
                    ->from('line')
                    ->where(array('id', $lines))
                    ->groupBy('token')
                    ->cacheOn();
                foreach ($query->execute() as $item) {
                    $err = \Gcms\Line::send($msg, $item->token);
                    if ($err != '') {
                        $ret['alert'] = $err;
                    }
                }
            }
        }
        return empty($ret) ? Language::get('Your message was sent successfully') : implode("\n", $ret);
    }
}
