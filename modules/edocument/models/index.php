<?php
/**
 * @filesource modules/edocument/models/index.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Edocument\Index;

use Gcms\Login;
use Kotchasan\Http\Request;
use Kotchasan\Language;

/**
 * module=edocument
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * Query ข้อมูลสำหรับส่งให้กับ DataTable
     * เฉพาะรายการที่มีสิทธิ์รับ
     *
     * @param array $login
     *
     * @return \Kotchasan\Database\QueryBuilder
     */
    public static function toDataTable($login)
    {
        return static::createQuery()
            ->select('A.id', 'A.document_no', 'A.urgency', 'E.downloads', 'A.ext', 'A.topic', 'A.sender_id', 'A.size', 'A.last_update')
            ->from('edocument_download E')
            ->join('edocument A', 'INNER', array('A.id', 'E.id'))
            ->where(array('E.member_id', $login['id']))
            ->order('A.last_update DESC');
    }

    /**
     * รับค่าจาก action (index.php)
     *
     * @param Request $request
     */
    public function action(Request $request)
    {
        $ret = array();
        // session, referer, member
        if ($request->initSession() && $request->isReferer() && $login = Login::isMember()) {
            if ($request->post('action')->toString() == 'detail') {
                // แสดงรายละเอียดของเอกสาร
                $document = \Edocument\View\Model::get($request->post('id')->toInt(), $login);
                if ($document) {
                    $ret['modal'] = Language::trans(createClass('Edocument\View\View')->render($document, $login));
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
