<?php
/**
 * @filesource modules/repair/models/export.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Repair\Export;

/**
 * รับงานซ่อม
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * อ่านรายละเอียดการทำรายการจาก $id
     * สำหรับการออกใบรับซ่อม
     *
     * @param int $id
     *
     * @return object
     */
    public static function get($id)
    {
        $sql = static::createQuery()
            ->select('R.*', 'U.name', 'U.phone', 'U.address', 'U.zipcode', 'U.provinceID', 'V.topic', 'T.product_no', 'S.status', 'S.comment', 'S.operator_id')
            ->from('repair R')
            ->join('repair_status S', 'LEFT', array('S.repair_id', 'R.id'))
            ->join('inventory V', 'LEFT', array('V.id', 'R.inventory_id'))
            ->join('inventory_stock T', 'LEFT', array('T.inventory_id', 'V.id'))
            ->join('user U', 'LEFT', array('U.id', 'R.customer_id'))
            ->where(array('R.id', $id))
            ->order('S.id ASC');
        return static::createQuery()
            ->from(array($sql, 'Q'))
            ->groupBy('Q.id')
            ->first();
    }
}
