<?php
/**
 * @filesource modules/edocument/models/home.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Edocument\Home;

use Kotchasan\Database\Sql;

/**
 * โมเดลสำหรับอ่านข้อมูลแสดงในหน้า  Home.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * อ่านเอกสารใหม่
     *
     * @param array $login
     *
     * @return object
     */
    public static function getNew($login)
    {
        $search = static::createQuery()
            ->from('edocument_download')
            ->where(array(
                array('member_id', $login['id']),
                array('downloads', 0),
            ))
            ->first(Sql::COUNT('id', 'count'));
        if ($search) {
            return $search->count;
        }
        return 0;
    }
}
