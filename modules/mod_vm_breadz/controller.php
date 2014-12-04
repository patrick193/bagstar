<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class chpBreadzController {
	
	public $ptid = null;
	private $baseurl;
	private $parameters = array();
	private $applied_filters = array();
	
	function __construct() {
		$cid = JRequest::getVar('virtuemart_category_id', null);
		$pid = JRequest::getVar('virtuemart_product_id', null);
		$ptid = JRequest::getVar('ptid', null);
		$itemid = JRequest::getVar('Itemid', null);
		
		$this->baseurl = 'index.php?option=com_virtuemart&view=category&virtuemart_category_id='. $cid .'&Itemid='. $itemid;
		if ($ptid) $this->baseurl .= '&ptid='.$ptid;
		
		if (!$ptid) {
			require_once( JPATH_BASE . '/modules/mod_vm_cherry_picker/controller.php' );
			$chp = new chpController();
			$chp->apprehendPTID();
			$ptid = $chp->ptid();
			
			if ($ptid) {
				$this->ptid = $ptid;
				$this->getParameters($ptid);
				$this->getAppliedFilters();
			}
		} else {
			$this->ptid = $ptid;
			$this->getParameters($ptid);
			$this->getAppliedFilters();
		}
	}
	
	public function getCategoryList() {
	
		$cid = JRequest::getVar('virtuemart_category_id', null);
		if (!$cid) return;
	
		require_once( JPATH_BASE . '/administrator/components/com_virtuemart/models/category.php' );

		$category_model = new VirtueMartModelCategory();
		$categories = $category_model->getParentsList($cid);
		
		if (!$categories) return;
		
		$baseurl = 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=';
		$data = array();
		
		foreach ($categories as $category) {
			$d = array();
			$d['name'] = $category->category_name;
			$d['url'] = $baseurl . $category->virtuemart_category_id;
			$d['xurl'] = '';
			
			$data[] = $d;
		}
		
		//var_dump($data);
		
		return $data;
	}
	
	public function getPrices() {
		$view = JRequest::getVar('view', null);
		
		if ($view == 'productdetails' && isset($_SESSION['applied_prices'])) {
			return $_SESSION['applied_prices'];
		}
		
		$low_price = JRequest::getVar('low-price', null);
		$high_price = JRequest::getVar('high-price', null);
		
		if (!$low_price && !$high_price) {
			$_SESSION['applied_prices'] = array();
			return;
		}
		
		$url = '';
		if ($low_price && !$high_price) {
			$name = breadzConf::option('currency_sign') . $low_price . JText::_('BR_AND_ABOVE');
			$url = 'low-price='. $low_price;
		}
		else if (!$low_price && $high_price) {
			$name = breadzConf::option('currency_sign') . $high_price . JText::_('BR_AND_UNDER');
			$url = 'high-price='. $high_price;
		}
		else {
			$name = breadzConf::option('currency_sign') . $low_price . JText::_('BR_TO') . breadzConf::option('currency_sign') . $high_price;
			$url = 'low-price='. $low_price .'&high-price='. $high_price;
		}
		
		$data = array();
		$d = array();
		$d['name'] = '';
		if (breadzConf::option('add_label')) $d['name'] .= '<span class="breadz-label">Price:</span> ';
		$d['name'] .= $name;
		$d['url'] = $this->baseurl .'&'. $url;
		$d['xurl'] = $this->baseurl;
		$filters_url = $this->getAppliedFiltersUrl();
		if ($filters_url) $d['xurl'] .= '&'. $filters_url;
		
		$data[]=$d;
		
		if ($view == 'category') $_SESSION['applied_prices'] = $data;
		
		//var_dump($filters_url);
		//var_dump($data);
		
		return $data;
	}
	
	public function getFilterList() {
		
		if (!$this->ptid) return;
	
		$view = JRequest::getVar('view', null);
		$low_price = JRequest::getVar('low-price', null);
		$high_price = JRequest::getVar('high-price', null);
		
		if ($view == 'productdetails' && isset($_SESSION['applied_filters'])) {
			return $_SESSION['applied_filters'];
		}
		
		$data=array();
		
		foreach ($this->parameters as $i => $parameter) {
			$get = JRequest::getVar($parameter['parameter_name'], null);
			if ($get) {
				$d = array();
				$is_range = strpos($get, ':');
				if ($is_range !== false) {
					$v = explode(':', $get);
					if ($v[0] && !$v[1]) {
						$name = $v[0] . JText::_('BR_AND_ABOVE');
					} 
					else if (!$v[0] && $v[1]) {
						$name = $v[1] . JText::_('BR_AND_UNDER');
					}
					else {
						$name = $v[0] . JText::_('BR_TO') . $v[1];
					}
					
				} else {
					$f = explode('|', $get);
					$name = implode(', ', $f);
				}
				
				$d['name'] = '';
				if (breadzConf::option('add_label')) $d['name'] .= '<span class="breadz-label">'. $parameter['parameter_label'] . ':</span> ';
				$d['name'] .= $name;
				if ($parameter['parameter_unit']) $d['name'] .= ' '. $parameter['parameter_unit'];
				$d['url'] = '';
				$d['xurl'] = $this->baseurl;
				$xurl = $this->getFilterRemoveUrl($i);
				if ($xurl) $d['xurl'] .= '&'. $xurl;
				if ($low_price) $d['xurl'] .= '&low-price='. $low_price;
				if ($high_price) $d['xurl'] .= '&high-price='. $high_price;
				
				
				$data[] = $d;
			}
		}
		
		if ($view == 'category') $_SESSION['applied_filters'] = $data;
		
		//var_dump($this->parameters);
		//var_dump($data);
		
		return $data;
	}
	
	public function getProductData() {
		$pid = JRequest::getVar('virtuemart_product_id', null);
		if (!$pid) return;
		
		$d = array();
		$data = array();
		$d['name'] = $this->getProductName($pid);
		$d['url'] = '';
		$d['xurl'] = '';
		
		$data[] = $d;
		
		return $data;
	}
	
	private function getProductName($pid) {
		$db=& JFactory::getDBO();
		$q="SELECT `product_name` FROM `#__virtuemart_products_".VMLANG."` WHERE `virtuemart_product_id`=$pid";
		$db->setQuery($q);
		return $db->loadResult();
	}
	
	private function getAppliedFilters() {
		foreach ($this->parameters as $parameter) {
			$get = JRequest::getVar($parameter['parameter_name'], null);
			if ($get) {
				$this->applied_filters[] = $get;
			} else {
				$this->applied_filters[] = '';
			}
		}
	}
	
	private function getParameters($ptid) {
		$db=& JFactory::getDBO();
		$q="SELECT `parameter_name`, `parameter_label`, `parameter_unit` FROM `#__vm_product_type_parameter` WHERE `product_type_id`=$ptid ORDER BY `parameter_list_order`";
		$db->setQuery($q);
		
		$res = $db->loadAssocList();
		$this->parameters = $res;
		//var_dump($res);
		//return $res;
	}
	
	private function getFilterRemoveUrl($i) {
		$url = '';
		foreach ($this->applied_filters as $k => $f) {
			if ($f && $i != $k) {
				if ($url) $url .= '&';
				$url .= $this->parameters[$k]['parameter_name'] .'='. urlencode($f);
			}
		}
		return $url;
	}
	
	private function getAppliedFiltersUrl() {
		$url = '';
		foreach ($this->applied_filters as $k => $f) {
			if ($f) {
				if ($url) $url .= '&';
				$url .= $this->parameters[$k]['parameter_name'] .'='. urlencode($f);
			}
		}
		return $url;
	}

}


?>