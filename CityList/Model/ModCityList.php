<?php

namespace Mod\cityList\Model;

include "../../../core2/vendor/zf1/zend-loader/library/Zend/Loader.php";
Zend_Loader::loadClass('Zend_Db_Table_Abstract');

use Zend_Db_Table_Abstract;

class cityListInstall extends Zend_Db_Table_Abstract
{
	protected $_name = 'module_citylist';

    public function CityListinit()
    {
        $result = $this->_db->fetchRow("CREATE TABLE `module_citylist` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT, `city_id` int(11) unsigned NOT NULL, `city_name` varchar(60) NOT NULL DEFAULT '', PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        return $result;
    }

    public function CityListTestValues()
    {
        $result = $this->_db->fetchRow("INSERT INTO `module_citylist` (`city_id`, `city_name`) VALUES ('012', 'New York');");
        return $result;
    }
	
    public function getCityList($id)
    {
        $result = $this->_db->fetchRow("SELECT id, city_id, city_name FROM module_citylist where id  = ? LIMIT 1", $id);
        return $result;
    }
}