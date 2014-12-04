<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class fsControllerDP{

	function getProducts(){
		$db=& JFactory::getDBO();
		$time_start=microtime(true);
		
		$keyword=JRequest::getVar('q','');
		$page=intval(JRequest::getCmd('page',1));
		$skip=intval(JRequest::getCmd('skip',0));
		$showonpage=intval(JRequest::getCmd('showonpage',fsconf::getOption('default_numrows')));
		$cid=JRequest::getVar('cid', null);
		$ptid=JRequest::getVar('ptid', null);
		$ppid=JRequest::getVar('ppid', null); // product parent id
		$orderby=JRequest::getVar('orderby', 'cat');
		$sc=JRequest::getVar('sc', 'asc');
		
		$columns="p.`virtuemart_product_id` as pid, plan.`product_name`, `product_type_id` as pti, `published`";
		$tables="(`#__virtuemart_products` as p)";
		$joins="";
		$where="";
		
		if (($cid || $orderby=='cat') && !$ppid) {
			$joins.="LEFT JOIN `#__virtuemart_product_categories` as pc ON p.`virtuemart_product_id`=pc.`virtuemart_product_id` ";
			if($orderby=='cat'){
				$columns.=", pc.`virtuemart_category_id` as cid, `category_name`";
				$joins.="LEFT JOIN `#__virtuemart_categories_".VMLANG."` as clan ON pc.`virtuemart_category_id`=clan.`virtuemart_category_id` ";
			}
		}
		
		$joins.="LEFT JOIN `#__virtuemart_products_".VMLANG."` as plan ON p.`virtuemart_product_id`=plan.`virtuemart_product_id` ";
		
		if ($ppid) {
			$where.="AND (p.`virtuemart_product_id`=$ppid OR `product_parent_id`=$ppid) ";
		}
		else if ($cid) {
			$where.="AND pc.`virtuemart_category_id`=$cid ";
		}
		//if($ptid){
			$joins.="LEFT JOIN `#__vm_product_product_type_xref` as ptx ON p.`virtuemart_product_id`=ptx.`product_id` ";
			if ($ptid=='wopt') {$where.="AND ptx.`product_type_id` IS NULL ";}
			elseif ($ptid) {$where.="AND ptx.`product_type_id`=$ptid ";}
		//}
		//$tables.=")";
		if (!$ppid) $where.="AND `product_parent_id`=0 ";
		
		$query= "SELECT $columns FROM $tables $joins".
				" WHERE 1 $where";
		if ($keyword) {
			$sq= "`product_name` LIKE '%$keyword%'";
			if (is_numeric($keyword)) $sq.= " OR p.`virtuemart_product_id`=$keyword";
			$query.=" AND ($sq)";
		}
		if (fsconf::getOption('show_unpublished_products')!='Y') $query.=" AND `published`='1'";
		if($orderby){
			switch($orderby){
				case 'cat': if(!$ppid) {$ordercolumn='`cid`'; break; }
				case 'pid': $ordercolumn='`pid`'; break;
				case 'pname': $ordercolumn='`product_name`'; break;
				case 'ptid': $ordercolumn='`product_type_id`'; break;
			}
			//if(!$cid) 
			$query.=" GROUP BY p.`virtuemart_product_id`";
			$query.=" ORDER BY $ordercolumn ".strtoupper($sc);
		}
		$query.=" LIMIT $skip, $showonpage";
		$db->setQuery($query);
		$rows=$db->loadObjectList();
		
		//require_once('../views/dp.php');
		//require_once(JPATH_COMPONENT.'/view/index.html');
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::displayProducts($rows);
		//$view=new fsViewDP();
		//$view->getProducts($rows);
		
		$time_end=microtime(true);
		$elapsed=$time_end-$time_start;
		echo '<div style="margin-top:5px;color:#CCCCCC;font-size:11px;">Executed in: '.round($elapsed,5).' seconds</div>';
		
		//echo '<pre style="font-size:13px">';
		//echo $query;
		//var_dump($db);
		//var_dump($rows);
		
		//$uri = JFactory::getURI();
		//echo '<br/><br/>url='.$uri->toString(array('query'));
		//print_r($uri->_vars);
	}
	
	function getPTParameters($ptid){
		$db=& JFactory::getDBO();
		
		$q= "SELECT `parameter_name`,`parameter_label`,`parameter_type`,`parameter_values`,`parameter_multiselect`,`parameter_unit` ".
			"FROM `#__vm_product_type_parameter` as ptp ".
			"WHERE `product_type_id`=$ptid ".
			"ORDER BY `parameter_list_order`";
		$db->setQuery($q);
		$res=$db->loadObjectList();
		
		return $res;
		//print_r($res);
		//echo $ptid;
		//echo $this->displayTitle();
	}
	
	function getSearch(){
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::displaySearch();
	}
	
	function getRefinePane(){
		// this block will execute only when browser is reloaded, since by default <values> == null
		$cid=JRequest::getVar('cid', null);
		$ptid=JRequest::getVar('ptid', null);
		$cname=$ptname='';
		if ($cid || $ptid) {
			$db =& JFactory::getDBO();
		}
		if ($cid) {
			$query="SELECT `category_name` FROM `#__virtuemart_categories_".VMLANG."` WHERE `virtuemart_category_id`=$cid";
			$db->setQuery($query);
			$cname=$db->loadResult();
		}
		if ($ptid=='wopt') {$ptname='w/o Product Type';}
		elseif ($ptid) {
			$query="SELECT `product_type_name` FROM `#__vm_product_type` WHERE `product_type_id`=$ptid";
			$db->setQuery($query);
			$ptname=$db->loadResult();
		}
		
		
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::displayRefinePane($cname,$ptname);
	}
	
	function getCatTree(){
		$db =& JFactory::getDBO();
		$cid=JRequest::getVar('cid','');
		$query= "SELECT `category_child_id` as id, `category_name` as name, `published` ".
				"FROM `#__virtuemart_categories` as c, `#__virtuemart_category_categories` as cc, `#__virtuemart_categories_".VMLANG."` as c_en ".
				"WHERE c.`virtuemart_category_id`=cc.`category_child_id` ".
				"AND cc.`category_parent_id`=$cid ".
				"AND c.`virtuemart_category_id`=c_en.`virtuemart_category_id`".
				"ORDER BY c.`ordering`";
		$db->setQuery($query);
		$cat=$db->loadObjectList();
		
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::displayCatTree($cat);
	}
	
	function getPTTree(){
		$db =& JFactory::getDBO();
		
		$query= "SELECT `product_type_id` as id, `product_type_name` as name, `product_type_publish` as pub ".
				"FROM `#__vm_product_type` as pt ".
				"WHERE 1 ".
				"ORDER BY `product_type_list_order`";
		$db->setQuery($query);
		$pt=$db->loadObjectList();
		
		return $pt;
	}
	
	// build Product Types Tree for Refinment menu
	function buildPTTreeMenu(){
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::displayPTTreeMenu($this->getPTTree());
	}
	
	// build Menu with all Product Types for assigning to a Product
	function buildAllPTsMenu($row){
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::printProductTypes($this->getPTTree(),$row);
	}
	
	// get Product Types for pop-up assign Dialog
	function getPTSelectDialog(){
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::printPTSelectDialog($this->getPTTree());
	}
	
	function saveProduct() {
		$db =& JFactory::getDBO();
		$pid=JRequest::getVar('pid');
		$ptid=JRequest::getVar('thisptid');
		$row=JRequest::getVar('row');
		$adding=JRequest::getVar('adding');
		$urlptid=JRequest::getVar('urlptid','');
		if ($adding=='pt') {	// if we adding product a PT
			if ($ptid) {
				$q="INSERT INTO `#__vm_product_product_type_xref` VALUES(".$db->quote($pid).", ".$db->quote($ptid).")";
				$db->setQuery($q);
				if($db->query()){
					if($urlptid!='wopt'){
						echo $this->getProductParameters($pid, $ptid, $this->getPTParameters($ptid), $row);
					}
				}
			}
		} else {	// if we saving Parameters to product
			// prepare parameters
			$q="SELECT `parameter_name` FROM `#__vm_product_type_parameter` ".
			"WHERE `product_type_id`=$ptid ORDER BY `parameter_list_order`";
			$db->setQuery($q);
			$parameters=$db->loadResultArray();
			
			$table="`#__vm_product_type_$ptid`";
			$q="SELECT COUNT(`product_id`) FROM $table WHERE `product_id`=$pid";
			$db->setQuery($q);
			if ($db->loadResult()) { // if already in DB -> update
				$q='';
				foreach ($parameters as $p) {
					if ($q) $q.=", ";
					$q.="`$p`=";
					$value=JRequest::getVar($p, '');
					$q.=(!$value) ? "NULL" : $db->quote($value);
				}
				$q="UPDATE $table SET ".$q;
				$q.=" WHERE `product_id`=$pid";
				$db->setQuery($q);
				$db->query();
				//echo $q;
			}else{ // else -> insert
				$q="`product_id`=$pid";
				foreach($parameters as $p){
					$q .= ", ";
					//$q.="`$p`=";
					$value = JRequest::getVar($p,'');
					//$q .= (!$value) ? "NULL" : "'$value'";
					$q .= "`". $p ."`=";
					$q .= (!$value) ? "NULL" : "'$value'";
				}
				
				//$q="INSERT INTO $table VALUES($q)";
				$q="INSERT INTO $table SET $q";
				$db->setQuery($q);
				$db->query();
				//echo $q;
			}
			//var_dump($db);
		}
	}
	
	/*function getProductTypes(){
		global $vmpref;
		$db =& JFactory::getDBO();
		
		$query= "SELECT `product_type_id` as id, `product_type_name` as name, `product_type_publish` as pub ".
				"FROM `#__".$vmpref."_product_type` as pt ".
				"WHERE 1 ".
				"ORDER BY `product_type_list_order`";
		$db->setQuery($query);
		$pt=$db->loadObjectList();
		
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::displayProductTypes($pt);
		
	}*/
	
	function getProductParameters($pid, $ptid, $ptparams, $row){
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::printRemovePTDialog();
		fsViewDP::displayProductParameters($pid, $ptid, $ptparams, $row);
	}
	
	function removeProductTypeInfo(){
		$db =& JFactory::getDBO();
		
		$pid = (int)JRequest::getVar('pid', null);
		$ptid = (int)JRequest::getVar('ptid', null);
		$urlptid = JRequest::getVar('urlptid', null);
		$row = JRequest::getVar('row', null);
		
		if($pid && $ptid){
			$q="DELETE FROM `#__vm_product_product_type_xref` WHERE `product_id`=$pid LIMIT 1;";
			$db->setQuery($q);
			if($db->query()){
				$q="DELETE FROM `#__vm_product_type_$ptid` WHERE `product_id`=$pid LIMIT 1;";
				$db->setQuery($q);
				if($db->query()){
					if(!$urlptid){
						echo $this->buildAllPTsMenu($row);
					}
				}
			}
		}
	}
	
	function getProductDescription(){
		$db =& JFactory::getDBO();
		
		$pid=JRequest::getVar('pid',null);
		$q="SELECT `product_name`, `product_desc`, `product_s_desc` FROM `#__virtuemart_products_".VMLANG."` WHERE `virtuemart_product_id`=$pid";
		$db->setQuery($q);
		$res=$db->loadObject();
		
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::printProductDescription($res);
	}
	
	function getFilterDialog(){
		$db =& JFactory::getDBO();
		
		$pid=JRequest::getVar('pid', null);
		$ptid=JRequest::getVar('ptid', null);
		$parameter_name=JRequest::getVar('paramname', null);
		//$q="SELECT `product_name` FROM `#__{$vmpref}_product` WHERE `product_id`=$pid;";
		//$db->setQuery($q);
		//$name=$db->loadResult();
		$q="SELECT `parameter_label`, `parameter_values` FROM `#__vm_product_type_parameter` WHERE `product_type_id`=$ptid AND `parameter_name`='$parameter_name'";
		$db->setQuery($q);
		$res=$db->loadObject();
		
		$name=$this->getProductNameById($pid);
		
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::printFilterDialog($name, $res);
	}
	
	public function getProductNameById($id) {
		$db =& JFactory::getDBO();
		$q="SELECT `product_name` FROM `#__virtuemart_products_".VMLANG."` WHERE `virtuemart_product_id`=$id";
		$db->setQuery($q);
		$name=$db->loadResult();
		return $name;
	}
	
	function getPageNavigation() {
		$db =& JFactory::getDBO();
		
		$keyword=JRequest::getVar('q','');
		$cid=JRequest::getVar('cid','');
		$ptid=JRequest::getVar('ptid','');
		$ppid=JRequest::getVar('ppid',null); // product parent id
		//$page=intval(JRequest::getCmd('page',1));
		//$showonpage=intval(JRequest::getCmd('showonpage',30));
		//if($showonpage==0) $showonpage=1;
		//echo 'onpage='.$showonpage;
		
		
		$tables="(`#__virtuemart_products` as p)";
		$joins="";
		$where="";
		if ($ppid) {
			$where.="AND (p.`virtuemart_product_id`=$ppid OR `product_parent_id`=$ppid) ";
		}
		else if ($cid) {
			$joins.="LEFT JOIN `#__virtuemart_product_categories` as pc ON p.`virtuemart_product_id`=pc.`virtuemart_product_id` ";
			$where.="AND pc.`virtuemart_category_id`=$cid ";
		}
		if ($ptid) {
			$joins.="LEFT JOIN `#__vm_product_product_type_xref` as ptx ON p.`virtuemart_product_id`=ptx.`product_id` ";
			if ($ptid=='wopt') {$where.="AND ptx.`product_type_id` IS NULL ";}
			else {$where.="AND ptx.`product_type_id`=$ptid ";}
		}
		
		$joins.="LEFT JOIN `#__virtuemart_products_".VMLANG."` as p_en ON p.`virtuemart_product_id`=p_en.`virtuemart_product_id` ";
		
		//$tables.=")";
		if (!$ppid) $where.="AND `product_parent_id`=0 ";
		
		$query="SELECT COUNT(p.`virtuemart_product_id`) FROM $tables $joins WHERE 1 $where";
		if ($keyword) {
			$sq="`product_name` LIKE '%$keyword%'";
			if (is_numeric($keyword)) $sq.= " OR p.`virtuemart_product_id`=$keyword";
			$query.=" AND ($sq)";
		}
		if(fsconf::getOption('show_unpublished_products')!='Y') $query.=" AND `published`='1'";
		$db->setQuery($query);
		$count=$db->loadResult();
		
		//echo $query;
		//echo 'count:'.$count;
		
		require_once( dirname(__FILE__).'/../views/dp.php' );
		fsViewDP::printPageNavigation($count);
	}
	
	function product_has_children($pid){
		$db =& JFactory::getDBO();
		$q="SELECT COUNT(`product_id`) FROM `#__virtuemart_products` WHERE `product_parent_id`=$pid;";
		$db->setQuery($q);
		return ($db->loadResult())? true : false;
	}
	
	function displayDP(){
		$this->getSearch();
		$this->getRefinePane();
		echo '<div id="cmid"><div id="cproducts">';
		$this->getProducts();
		echo '</div><div id="cpages">';
		$this->getPageNavigation();
		echo '</div></div>';
	}
	
	function displayDPMB(){
		//sleep(6);
		echo '<div id="cproducts">';
		$this->getProducts();
		echo '</div><div id="cpages">';
		$this->getPageNavigation();
		echo '</div>';
	}
}