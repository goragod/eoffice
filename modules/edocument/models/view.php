<?php
/**
 * @filesource modules/edocument/models/view.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Edocument\View;

/**
 * module=edocument-view
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class Model extends \Kotchasan\Model
{
    /**
     * อ่านเอกสารที่ $id
     * ไม่พบ คืนค่า null
     *
     * @param int   $id
     * @param array $login
     *
     * @return object
     */
    public static function get($id, $login)
    {
        return static::createQuery()
            ->from('edocument A')
            ->join('edocument_download E', 'INNER', array(array('E.id', 'A.id'), array('E.member_id', $login['id'])))
            ->where(array('A.id', $id))
            ->first('A.id', 'A.document_no', 'A.urgency', 'E.downloads', 'A.topic', 'A.ext', 'A.sender_id', 'A.size', 'A.last_update', 'A.detail');
    }
}
