<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
$countryList = Country::model()->findAllByAttributes(array('active'=>1), array('order' => 'name asc'));


const TOT_ROW_NUM = 12;
const DURATION = 14;	// show 14 days;

$country = isset($_REQUEST['country']) ? $_REQUEST['country'] : 0;
$destination = isset($_REQUEST['destination']) ? $_REQUEST['destination'] : 0;
$start_date = isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : date("m/d/Y");
$include_date = isset($_REQUEST['include_date']) ? $_REQUEST['include_date'] : $start_date;

//echo "include_date:".$include_date."<br>";
$recvDate = explode("/", $include_date);
$include_date_month = $recvDate[0];
$include_date_day = $recvDate[1];
$include_date_year = $recvDate[2];


$date1 = $start_date;
$date2 = $include_date;

$ts1 = strtotime($date1);
$ts2 = strtotime($date2);

$seconds_diff = $ts2 - $ts1;

//echo floor($seconds_diff/3600/24);

if(floor($seconds_diff/3600/24) > 5) {
	$start_date = date("m/d/Y",strtotime($include_date_month."/".$include_date_day."/".$include_date_year." -4 days"));
}

$recvStartDate = explode("/", $start_date);
$start_month = $recvStartDate[0];
$start_day = $recvStartDate[1];
$start_year = $recvStartDate[2];

$lastday = date("Y-m-d",strtotime($start_year."-".$start_month."-".$start_day." +".(DURATION-1)." days"));
//echo "lastday:".$lastday."<br>";

$date1 = date("m/d/Y");
$date2 = date("m/d/Y",strtotime($start_year."-".$start_month."-".$start_day." -6 days"));

$ts1 = strtotime($date1);
$ts2 = strtotime($date2);

$seconds_diff = $ts2 - $ts1;

$prev_alt_diff = floor($seconds_diff/3600/24);
//echo "prev_alt_diff:".$prev_alt_diff;
if(floor($seconds_diff/3600/24) <= 0) {
	$prev_alt_diff = -6 - $prev_alt_diff;
} else {
	$prev_alt_diff = -6;
}

$prev_alt = date("d M",strtotime($start_year."-".$start_month."-".$start_day." ".$prev_alt_diff." days"))." - ".date("d M",strtotime($start_year."-".$start_month."-".$start_day." +".(DURATION+$prev_alt_diff-1)." days"));
$next_alt = date("d M",strtotime($start_year."-".$start_month."-".$start_day." +6 days"))." - ".date("d M",strtotime($start_year."-".$start_month."-".$start_day." +".(DURATION-1+6)." days"));


$search = array(
			'country'=>$country,
			'destination'=>$destination,
			'start_date'=>$start_year."-".$start_month."-".$start_day,
			'last_date'=>$lastday,
			'search_text'=>$_REQUEST['search_text']
);
$items = Search::findAllHotel($search);


?>
<script type="text/javascript">

	var country = "<?php echo $_REQUEST['country']?>";
	var destination =  "<?php echo $_REQUEST['destination'] ?>";

	hotel.setBaseUrl("<?php echo Yii::app()->request->baseUrl ?>");
	$(function(){
		hotel.combine('#country', '#destination');

		if(country != "") {
			hotel.displayDestinationList(country , function () {
				if(destination) {
					$('#destination option[value='+destination+']').attr('selected', true);
				}
			});
		}
	});

	$(function(){
		$(".bubbletip").tipTip();
	});

</script>
<div>
	<form action="<?php echo Yii::app()->request->baseUrl ?>/frontCarRental/suppliers" method="get" class="form-inline" id="advanced_search">
	<input type="hidden" id="id_country" name="id_country" value="" />
	<input type="hidden" id="id_destination" name="id_destination" value="" />
	<div class="control-group">
		<label class="control-label" for="keyword">Search Keyword</label>
		<input type="text" id="keyword" name="search_text" value="<?php echo $_REQUEST['search_text']?>" class="span2"/>
		<label class="control-label" for="country">Country</label>
		<select id="country" name="country" class="span2">
			<option value="">Country</option>
			<?php foreach($countryList as $country): ?>
			<option value="<?php echo $country->id_country ?>" <?php echo ($_REQUEST['country'] == $country->id_country) ? 'selected':'' ?> ><?php echo $country->name ?></option>
			<?php endforeach; ?>
		</select>
		<label class="control-label" for="destination">Destination</label>
		<select id="destination" name="destination" class="span2">
			<option value="">Destination</option>
		</select>
		<label class="control-label" for="include_date">Check-In</label>
		<input type="text" id="include_date" name="include_date" value="<?php echo $_REQUEST['include_date']?>" class="span2 date_input"/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-primary" type="submit" onclick="return hotel.submit();">Search</button>
	</div>
	
	</form>
	
	<div class="map">
	<img class="map-icon" src="<?php echo Yii::app()->request->baseUrl?>/images/map-icon2.png" />
	</div>
	
	<div class="google-map" style="display:;">
	<script>
	$(function() {
		$('.map-icon').on('click', function() {
			$('.google-map').toggle();
		});
	
		//$('.google-map').toggle();
	});
	</script>
		<?php 
			Yii::import('ext.EGMap.*');
			 
			$gMap = new EGMap();
			$gMap->setWidth('100%');
			$gMap->setHeight(500);
			$gMap->zoom = 11;
			
			//print_r($items);
			
			foreach($items as $item) {
				if(empty($item->id_supplier)) continue;
				$supplier = Supplier::model()->findByPk($item->id_supplier);

				$address_str = $supplier->user->addressDefault->toString();
				// Create geocoded address
				$geocoded_address = new EGMapGeocodedAddress($address_str);
				$geocoded_address->geocode($gMap->getGMapClient());
				 
				// Center the map on geocoded address
				$gMap->setCenter($geocoded_address->getLat(), $geocoded_address->getLng());
				
				
				$info_box = new EGMapInfoBox('<div style="color:#fff;border: 1px solid black; margin-top: 8px; background: #000; padding: 5px;">
				<img src="'.$supplier->getCoverImage()->getLink('Small').'" />
				<a href="'.Yii::app()->request->baseUrl.'/frontCarRental/products/id_supplier='.$supplier->id_supplier.'&start_date='.$start_date.'">'. $supplier->title  . ' </a>
				</div>');
 
				// set the properties
				$info_box->pixelOffset = new EGMapSize('0','-140');
				$info_box->maxWidth = 0;
				$info_box->boxStyle = array(
				    'width'=>'"280px"',
				    'height'=>'"120px"',
				    'background'=>'"url(http://google-maps-utility-library-v3.googlecode.com/svn/tags/infobox/1.1.9/examples/tipbox.gif) no-repeat"'
				);
				$info_box->closeBoxMargin = '"10px 2px 2px 2px"';
				$info_box->infoBoxClearance = new EGMapSize(1,1);
				$info_box->enableEventPropagation ='"floatPane"';
				 
				// Create Icon
				$icon = new EGMapMarkerImage("http://google-maps-icons.googlecode.com/files/gazstation.png");
				$icon->setSize(32, 37);
				$icon->setAnchor(16, 16.5);
				$icon->setOrigin(0, 0);
				// Create marker
				$marker = new EGMapMarker($geocoded_address->getLat(), $geocoded_address->getLng(), array('title' => 'Marker With Info Box'));
				$marker->addHtmlInfoBox($info_box);

				$gMap->addMarker($marker);
			}
			
			$gMap->renderMap();
		?>	
		</div>
		
	
	<?php
		
		$country = isset($_REQUEST['country']) ? $_REQUEST['country'] : 0;
	
		echo CHtml::beginForm(Yii::app()->request->baseUrl."/frontCarRental/suppliers", "get", array("id"=>"prev_navi", "name"=>"prev_navi"));
		echo CHtml::hiddenField("country", $country);
		echo CHtml::hiddenField("destination", $destination);
		echo CHtml::hiddenField("start_date", date("m/d/Y",strtotime($start_year."-".$start_month."-".$start_day." ".$prev_alt_diff." days")));
		echo CHtml::hiddenField("search_text", $_REQUEST['search_text']);
		echo CHtml::endForm();

		echo CHtml::beginForm(Yii::app()->request->baseUrl."/frontCarRental/suppliers", "get", array("id"=>"next_navi", "name"=>"next_navi"));
		echo CHtml::hiddenField("country", $country);
		echo CHtml::hiddenField("destination", $destination);
		echo CHtml::hiddenField("start_date", date("m/d/Y",strtotime($start_year."-".$start_month."-".$start_day." +6 days")));
		echo CHtml::hiddenField("search_text", $_REQUEST['search_text']);
		echo CHtml::endForm();
		
		//$items = array("1", "2", "3", "4", "2", "3", "4", "2", "3", "4", "2", "3", "4", "2", "3", "4", "2", "3", "4", "2", "3", "4", "2", "3", "4", "2", "3", "4", "2", "3", "4", "2", "3", "4", "2", "3", "4", "2", "3", "4");
		

		//print_r($items);
		$rowCount = 0;
		foreach($items as $item) {
			if($rowCount % TOT_ROW_NUM == 0) {
	?>
	<div id="accommodation_list">
		<table class="table table-bordered">
			<thead>
				<tr class="date">
					<td colspan="2">&nbsp;</td>
					<?php
						$month = $start_month;
						$day = $start_day;
						$year = $start_year;
	
						$date = "";
						
						for($i = 1; $i <= DURATION; $i++) {
							$date = date('D', mktime(0, 0, 0, $month, $day, $year));
							if($date == "Sat" || $date == "Sun") {
								if($i == 1) {
									echo "<th class=\"weekend\"><a id=\"a_prev\" class=\"prev\" title=\"".$prev_alt."\">Prev</a>".$date."<b>".($day)."</b><span>".date("M", mktime(0, 0, 0, $month, $day, $year))."</span></th>";
								} else if($i == DURATION) {
									echo "<th class=\"weekend\">".$date."<b>".($day)."</b><span>".date("M", mktime(0, 0, 0, $month, $day, $year))."</span><a id=\"a_next\" class=\"next\" title=\"".$next_alt."\">Next</a></th>";
								} else {
									echo "<th class=\"weekend\">".$date."<b>".($day)."</b><span>".date("M", mktime(0, 0, 0, $month, $day, $year))."</span></th>";
								}
							} else {
								if($i == 1) {
									echo "<th><a id=\"a_prev\" class=\"prev\" title=\"".$prev_alt."\">Prev</a>".$date."<b>".($day)."</b><span>".date("M", mktime(0, 0, 0, $month, $day, $year))."</span></th>";
								} else if($i == DURATION) {
									echo "<th>".$date."<b>".($day)."</b><span>".date("M", mktime(0, 0, 0, $month, $day, $year))."</span><a id=\"a_next\" class=\"next\" title=\"".$next_alt."\">Next</a></th>";
								} else {
									echo "<th>".$date."<b>".($day)."</b><span>".date("M", mktime(0, 0, 0, $month, $day, $year))."</span></th>";
								}
							}
							
							$nextday = date("d",strtotime($year."-".$month."-".$day." +1 days"));
							$nextmonth = date("m",strtotime($year."-".$month."-".$day." +1 days"));
							$nextyear = date("Y",strtotime($year."-".$month."-".$day." +1 days"));
							$day = $nextday;
							$month = $nextmonth;
							$year = $nextyear;
						}
					?>
				</tr>
			</thead>
			<tbody>
			<?php
			}
			?>
			<?php
				//var_dump($items);
				$month = $start_month;
				$day = $start_day;
				$year = $start_year;
			?>
				<tr>
					<td class="hotel span4">
					<?php
						if($item->id_supplier != "") {

							//echo CHtml::link($item->title, array("view", "id_supplier"=>$item->id_supplier, "start_date"=>$start_date, "country"=>$country, "destination"=>$destination)); 

							//$start_date = date('Y-m-d 00:00:00', mktime(0, 0, 0, $month, $day, $year));
							echo CHtml::link($item->title, array("products", "id_supplier"=>$item->id_supplier, "start_date"=>$start_date, "country"=>$country, "destination"=>$destination));
						} else {
					?>
					<?php 
							echo $item->title;
						}
					?>
					</td>
					<td class="book"><?php echo CHtml::link("Book", array("products", "id_supplier"=>$item->id_supplier, "start_date"=>$start_date, "country"=>$country, "destination"=>$destination)); ?></td>
					<?php
						for($i = 1; $i <= DURATION; $i++) {
							$date = date('D', mktime(0, 0, 0, $month, $day, $year));
							$curr_date = date('Y-m-d 00:00:00', mktime(0, 0, 0, $month, $day, $year));
							$bubbletip = "";
							
							if($date == "Sat" || $date == "Sun") {
								echo "<td class=\"weekend\">";
								if($item->date_info[$curr_date]->price != "") {
									$price = number_format($item->date_info[$curr_date]->price, 0);
									if(Yii::app()->user->isAgent()) {
										$agent_price = number_format($item->date_info[$curr_date]->agent_price, 0);
										$price = $price . "<br><span class='agent-price'>(".$agent_price.")</span>";
									}
									
									$bubbletip .= '$'. $price . " | " . $item->title . "<br>" . "";
									echo "<div class='bubbletip' title='".$bubbletip."'>";
									
									echo "<span class='price' >";
									echo CHtml::link($price, array("products", "id_supplier"=>$item->id_supplier, "start_date"=>$start_date, "country"=>$country, "destination"=>$destination));
									echo "</span>";									
									echo "<div>";
								}
								echo "</td>";
							} else {
								echo "<td class=\"weekday\">";
								if($item->date_info[$curr_date]->price != "") {
									$price = number_format($item->date_info[$curr_date]->price, 0);
									if(Yii::app()->user->isAgent()) {
										$agent_price = number_format($item->date_info[$curr_date]->agent_price, 0);
										$price = $price . "<br><span class='agent-price'>(".$agent_price.")</span>";
									}
									
									$bubbletip .= '$'. $price . " | " . $item->title . "<br>" . "";
									echo "<div class='bubbletip' title='".$bubbletip."'>";
									
									echo "<span class='price' >";
									echo CHtml::link($price, array("products", "id_supplier"=>$item->id_supplier, "start_date"=>$start_date, "country"=>$country, "destination"=>$destination));
									echo "</span>";
									echo "<div>";
								}
								echo "</td>";
							}

							$nextday = date("d",strtotime($year."-".$month."-".$day." +1 days"));
							$nextmonth = date("m",strtotime($year."-".$month."-".$day." +1 days"));
							$nextyear = date("Y",strtotime($year."-".$month."-".$day." +1 days"));
							$day = $nextday;
							$month = $nextmonth;
							$year = $nextyear;
						} 
					?>
				</tr>
		<?php
			if($rowCount == TOT_ROW_NUM-1) {
				$rowCount = 0;
		?>
			</tbody>
		</table>
	</div>
	<?php
			} else {
				$rowCount++;
			}
		}
		
		if($rowCount != TOT_ROW_NUM-1) {
			echo "</tbody></table></div>";
		}
	?>
</div>
<script type="text/javascript">
	$('#a_prev').on('click', function(){
		$('#prev_navi').submit();
	});

	$('#a_next').on('click', function(){
		$('#next_navi').submit();
	});
</script>