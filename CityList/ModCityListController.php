<?php

// use model and view
use Mod\CityList\Model\City;
use Mod\CityList\View\ModCityListView.php;

// calls
require_once __DIR__ . "/Model/ModCityList.php";
require_once __DIR__ . "/View/ModCityListView.php";
require_once __DIR__ . "/../../core2/inc/classes/Panel.php";


class ModCityListController extends Common
{
    public function action_index()
    {
        $moduleUrl = "index.php?module=cityList&action=index";
        $view = new CityView();
		$panel = new Panel();

        try {
            if (isset($_GET['edit'])) {
                if (empty($_GET['edit'])) {
                    $panel->setTitle($this->_("Добавить город"), '', $moduleUrl);
                    echo $view->getEdit($moduleUrl);

                } else {
                    $city = new City();
                    $panel->setTitle($city->getRbcityById($_GET['edit']) ? $city->getRbcityById($_GET['edit'])['city_name'] : '', $this->_('Редактировать город'), $moduleUrl);
                    echo $view->getEdit($moduleUrl, $_GET['edit']);
                }
            } else {
                $panel->setTitle($this->_("Список городов"));
                echo $view->getList($moduleUrl);
            }

        } 
			catch (Exception $e) {
            echo Alert::danger($e->getMessage(), 'Ошибка');
        }

        $panel->setContent(ob_get_clean());
        return $panel->render();
    }
}
