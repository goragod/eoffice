<?php
/**
 * @filesource modules/personnel/models/setup.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Personnel\Setup;

use Gcms\Login;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * โมเดลสำหรับแสดงรายการบุคลากร (setup.php).
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * Query ข้อมูลสำหรับส่งให้กับ DataTable.
     *
     * @return \Kotchasan\Database\QueryBuilder
     */
    public static function toDataTable()
    {
        return static::createQuery()
            ->select('U.name', 'U.phone', 'U.department', 'U.position', 'U.id')
            ->from('user U')
            ->where(array(
                array('U.active', 1),
                array('U.status', self::$cfg->personnel_status),
            ));
    }

    /**
     * รับค่าจาก action
     *
     * @param Request $request
     */
    public function action(Request $request)
    {
        $ret = array();
        // session, referer, member
        if ($request->initSession() && $request->isReferer() && $login = Login::isMember()) {
            // รับค่าจากการ POST
            $action = $request->post('action')->toString();
            if (preg_match_all('/,?([0-9]+),?/', $request->post('id')->toString(), $match)) {
                if ($action == 'view') {
                    // ดูรายละเอียดบุคลากร
                    $search = \Personnel\Write\Model::get((int) $match[1][0]);
                    if ($search) {
                        $ret['modal'] = Language::trans(createClass('Personnel\Personnelinfo\View')->render($search, $login));
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
