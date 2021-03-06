<?php
/**
 * @filesource modules/repair/models/email.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Repair\Email;

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
     * @param string $mailto อีเมล
     * @param string $name   ชื่อ
     * @param array  $order ข้อมูล
     */
    public static function send($mailto, $name, $order)
    {
        $ret = array();
        // อ่านข้อมูลพัสดุ
        $inventory = \Inventory\Write\Model::get($order['inventory_id']);
        // ข้อความ
        $content = array(
            '{LNG_Repair jobs}',
            '{LNG_Informer}: '.$name,
            '{LNG_Equipment}: '.$inventory->equipment,
            '{LNG_Serial/Registration number}: '.$inventory->serial,
            '{LNG_Date}: '.Date::format($order['create_date']),
            '{LNG_problems and repairs details}: '.$order['job_description'],
        );
        $msg = Language::trans(implode("\n", $content));
        $admin_msg = $msg."\nURL: ".WEB_URL.'index.php?module=repair-setup';
        // ส่งอีเมลไปยังผู้ที่เกี่ยวข้อง
        if (!empty(self::$cfg->repair_send_mail)) {
            // ส่งอีเมล
            $subject = '['.self::$cfg->web_title.'] '.Language::get('Repair jobs');
            // ส่งอีเมลไปยังผู้ทำรายการเสมอ
            $err = \Kotchasan\Email::send($name.'<'.$mailto.'>', self::$cfg->noreply_email, $subject, nl2br($msg));
            if ($err->error()) {
                // คืนค่า error
                $ret[] = strip_tags($err->getErrorMessage());
            }
            // อีเมลของมาชิกที่สามารถอนุมัติได้ทั้งหมด
            $query = \Kotchasan\Model::createQuery()
                ->select('username', 'name')
                ->from('user')
                ->where(array(
                    array('social', 0),
                    array('active', 1),
                ))
                ->andWhere(array(
                    array('status', 1),
                    array('permission', 'LIKE', '%,can_repair,%'),
                ), 'OR')
                ->cacheOn();
            foreach ($query->execute() as $item) {
                $err = \Kotchasan\Email::send($item->name.'<'.$item->username.'>', self::$cfg->noreply_email, $subject, nl2br($admin_msg));
                if ($err->error()) {
                    // คืนค่า error
                    $ret[] = strip_tags($err->getErrorMessage());
                }
            }
        }
        if (!empty(self::$cfg->repair_line_id)) {
            // อ่าน token
            $search = \Kotchasan\Model::createQuery()
                ->from('line')
                ->where(array('id', self::$cfg->repair_line_id))
                ->cacheOn()
                ->first('token');
            if ($search) {
                $err = \Gcms\Line::send($admin_msg, $search->token);
                if ($err != '') {
                    $ret[] = $err;
                }
            }
        }
        return empty($ret) ? Language::get('Your message was sent successfully') : implode("\n", $ret);
    }
}
