<?php

namespace Mod\cityList\Model;

use Common;
use editTable;
use listTable;

require_once DOC_ROOT . 'core2/inc/classes/class.list.php';
require_once DOC_ROOT . 'core2/inc/classes/class.edit.php';
require_once DOC_ROOT . 'core2/inc/classes/class.tab.php';
require_once DOC_ROOT . 'core2/inc/classes/Common.php';


class CityView extends Common
{

    private $app = "index.php?module=cityList&action=index";


    /**
     * таблица с городами
     * @param string $app
     */
    public function getList($app)
    {

        $list = new listTable('module_city');


        $list->addSearch($this->_("Название"), "m.name", "TEXT");
        $list->addSearch("Код", "m.code", "TEXT");
        $list->SQL = "SELECT id, name, code FROM module_city AS m WHERE id > 0 /*ADD_SEARCH*/";

        $list->addColumn($this->_("Название"), "100", "TEXT");
        $list->addColumn($this->_("Код"), "130", "TEXT");

        $list->addURL = $app . "&edit=0";
        $list->editURL = $app . "&edit=TCOL_00";
        $list->deleteKey = "module_city.id";

        $list->getData();
        //var_dump($list->getSearchSql());

        ob_start();
        $list->showTable();
        return ob_get_clean();
    }


    /**
     * @param string $app
     * @param int|null $id
     */
    public function getEdit(string $app, int $id = null)
    {

        $edit = new editTable('module_city');

        $fields = [
            'id',
            'name',
            'code'
        ];


        $implode_fields = implode(",\n", $fields);

        $edit->SQL = $this->db->quoteInto("
           SELECT {$implode_fields}
           FROM
                module_city
           WHERE id = ?
        ", $id ? $id : 0);


        $edit->addControl("Наименование", "TEXT", "maxlength=\"60\" style=\"width:385px\"", "", "");
        $edit->addControl($this->_("Код"), "TEXT", "maxlength=\"20\" style=\"width:385px\"", "", "");

        $edit->back = $app;
        $edit->firstColWidth = '200px';
        $edit->addButton($this->_("Вернуться к списку городов"), "load('$app')");
        $edit->save("xajax_saveCity(xajax.getFormValues(this.id))");

        return $edit->render();
    }


}