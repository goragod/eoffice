<?php
/**
 * @filesource modules/index/views/line.php
 *
 * @copyright 2016 Goragod.com
 * @license http://www.kotchasan.com/license/
 *
 * @see http://www.kotchasan.com/
 */

namespace Index\Line;

use Kotchasan\Html;
use Kotchasan\Http\Request;

/**
 * module=lines.
 *
 * @author Goragod Wiriya <admin@goragod.com>
 *
 * @since 1.0
 */
class View extends \Gcms\View
{
    /**
     * ฟอร์มเพิ่ม/แก้ไข ไลน์กลุ่ม
     *
     * @param Request $request
     * @param object  $index
     *
     * @return string
     */
    public function render(Request $request, $index)
    {
        $form = Html::create('form', array(
            'id' => 'setup_frm',
            'class' => 'setup_frm',
            'autocomplete' => 'off',
            'action' => 'index.php/index/model/line/submit',
            'onsubmit' => 'doFormSubmit',
            'ajax' => true,
            'token' => true,
        ));
        $fieldset = $form->add('fieldset', array(
            'title' => '{LNG_LINE group account}',
        ));
        // name
        $fieldset->add('text', array(
            'id' => 'line_name',
            'itemClass' => 'item',
            'labelClass' => 'g-input icon-comments',
            'label' => '{LNG_LINE group name}',
            'maxlength' => 50,
            'value' => isset($index->name) ? $index->name : '',
        ));
        // token
        $fieldset->add('text', array(
            'id' => 'line_token',
            'itemClass' => 'item',
            'labelClass' => 'g-input icon-password',
            'label' => '{LNG_Token}&nbsp;<a href="https://gcms.in.th/index.php?module=howto&id=367" target="_blank" class="icon-help notext"></a>',
            'maxlength' => 50,
            'value' => isset($index->token) ? $index->token : '',
        ));
        $fieldset = $form->add('fieldset', array(
            'class' => 'submit',
        ));
        // submit
        $fieldset->add('submit', array(
            'class' => 'button save large icon-save',
            'value' => '{LNG_Save}',
        ));
        // id
        $fieldset->add('hidden', array(
            'id' => 'line_id',
            'value' => $index->id,
        ));
        // คืนค่า HTML
        return $form->render();
    }
}
