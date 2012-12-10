<?php
class DateInfo {
	public $on_date = "";
	public $price = "";
	public $product_description = "";
	public $out_of_stock = "";
}

class HotelInfo {
	public $id_product = "";
	public $name = "";
	public $date_info = "";
	
	function __construct() {
		$this->date_info = new DateInfo;
	}
}



class Search {
	static public function findAllAccommodation($country, $destination, $start_date, $last_date) {
		$criteria = new CDbCriteria;
		/*	SELECT pro.* , pro_date.* , pro_lang.* 
			FROM gc_address AS addr
			INNER JOIN gc_user AS usr ON addr.id_address = usr.id_address_default
			INNER JOIN gc_supplier AS sup ON usr.id_user = sup.id_supplier
			INNER JOIN gc_product AS pro ON sup.id_supplier = pro.id_supplier
			INNER JOIN gc_product_date AS pro_date ON pro_date.id_product = pro.id_product
			LEFT JOIN gc_product_lang AS pro_lang ON pro_lang.id_product = pro.id_product
			WHERE addr.id_country =24
			AND addr.id_destination =2
			AND sup.id_service =1
			AND pro.active = 1
			AND pro_date.active = 1
			AND pro_lang.id_lang =1
			AND pro_date.on_date BETWEEN '2012-11-20' AND '2012-12-31'
			ORDER BY pro.id_product, pro_date.on_date
		*/
		$results = Yii::app()->db->createCommand()
				->select('pro.*, pro_date.*, pro_lang.*')
				->from('gc_address as addr')
				->join('gc_user as usr', 'addr.id_address = usr.id_address_default')
				->join('gc_supplier as sup', 'usr.id_user = sup.id_supplier')
				->join('gc_product as pro', 'sup.id_supplier = pro.id_supplier')
				->join('gc_product_date as pro_date', 'pro_date.id_product = pro.id_product')
				->leftJoin('gc_product_lang as pro_lang', 'pro_lang.id_product = pro.id_product')
				->where('addr.id_country = :id_country and addr.id_destination = :id_destination
						and sup.id_service = :id_service and pro.active = 1 and pro_date.active = 1 and pro_lang.id_lang = :id_lang
						and pro_date.on_date BETWEEN :id_startdate AND :id_lastdate',
						array(':id_country' => $country,
						':id_destination' => $destination,
						':id_service' => Service::HOTEL,
						':id_lang' => 1,
						':id_startdate'=> $start_date,
						':id_lastdate' => $last_date))
				->order(array('pro.id_product', 'pro_date.on_date'))
				->queryAll();

		$items = Array();
		$before_id_product = "";
		$hotel = "";
		foreach($results as $result) {
			if($before_id_product != $result['id_product']) {
				$hotel = new HotelInfo;
				$hotel->id_product = $result['id_product'];
				$hotel->name = $result['name'];
				$hotel->date_info = array();
				array_push($items, $hotel);
				
				$date_info = new DateInfo;
				$date_info->on_date = $result['on_date'];
				$date_info->price = $result['price'];
				$date_info->product_description = $result['description'];
				$date_info->out_of_stock = $result['out_of_stock'];
				
				$hotel->date_info[$date_info->on_date] = $date_info;
			} else {
				$date_info = new DateInfo;
				$date_info->on_date = $result['on_date'];
				$date_info->price = $result['price'];
				
				$hotel->date_info[$date_info->on_date] = $date_info;
			}
			
			$before_id_product = $result['id_product'];
		}
		
		if(count($items) == 0) {
			$hotel = new HotelInfo;
			$hotel->name = "There is no data.";
			$hotel->date_info = array();
			$date_info = new DateInfo;
			$hotel->date_info[] = $date_info;
			array_push($items, $hotel);
		}
		return $items;
	}
}