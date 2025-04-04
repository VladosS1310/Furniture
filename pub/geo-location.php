<script src='https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js?ver=6.1.1' id='_geocentric_axios_cdn_script-js'></script>
<script src='https://cdn.jsdelivr.net/npm/uuid@latest/dist/umd/uuidv4.min.js?ver=6.1.1' id='_geocentric_uuid_cdn_script-js'></script>
<style>
.geocentric-thingstodo > .wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    gap: 20px;
}
.geocentric-thingstodo > .wrapper > div {
    width: 350px;
}
.geocentric-thingstodo > .wrapper > div > div {
    cursor: pointer;
    background: #f5f5f5;
    width: 100%;
    max-width: 350px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 5px;
    border: solid #ebebeb 0px;
    transition: .3s transform ease-in-out;
}
.geocentric-thingstodo > .wrapper > div > div img {
    height: 250px;
    width: 100%;
    border-radius: 5px;
    object-fit: cover;
    border: solid #ebebeb 0px;
    background: #f5f5f5;
}
.geocentric-thingstodo > .wrapper > div > div p {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
    margin-bottom: 0;
    text-align: center;
    color: #000000;
    font-size: 16px;
    font-weight: 400;
}
.geocentric-thingstodo > .wrapper > div > div a > div {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    padding-top: 20px;
}
.geocentric-busstops .busstops {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    gap: 20px;
}
.geocentric-busstops .bus-stop {
    margin-bottom: 10px;
    width: 350px;
}
.bus-stop iframe, .direction iframe {
    width: 100%;
}

.geocentric-mapembed .iframe_wrapper {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.geocentric-mapembed .iframe_wrapper > div {
    width: 100%;
}
.geocentric-mapembed .iframe_wrapper > div > iframe {
    min-width: 100%;
}
.geocentric-drivingdirections .drivingdirections {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    gap: 20px;
}
.geocentric-drivingdirections .direction {
    margin-bottom: 10px;
    width: 350px;
}
</style>
<?php 
//surat: 24a77cf5-748b-48a6-b3c1-04f3fd6c1fba
//$id = '74730af2-a990-4b6a-a715-f814166d8368';
$api_data = array();
if (file_exists('locations/'.$_REQUEST['suburbinput'].'-'.'api_data.json')) {
	$api_data = json_decode(file_get_contents('locations/'.$_REQUEST['suburbinput'].'-'.'api_data.json'), true);
}

if($api_data){
	$suburbdata = null;
	foreach ($api_data as $data) {
		//if (isset($data['id']) && $data['id'] == $id) { 
			$suburbdata = $data;
			//break;
		//}
	}
}

?>
<div class="geocentric-about geocentric-components">
	<h2>About <?php echo $suburbdata['name'];?></h2>
	<p><?php echo $suburbdata['about'];?></p>
</div>
<div class="geocentric-thingstodo geocentric-component">
	<h2>Things To Do in <?php echo $suburbdata['name'];?></h2>
	<div class="wrapper">
		<?php
		foreach ($suburbdata['things_to_do'] as $thingstodo) {

			if (!isset($thingstodo['rating'])) {
				$thingstodo['rating'] = 0;
				$thingstodo['users_total_rating'] = 'No ratings yet';
			}

			$star = '';
			$whole = floor($thingstodo['rating']);
			$decimal = $thingstodo['rating'] - $whole;
			$diff = 5 - ceil($thingstodo['rating']);

			for ($i=0; $i < $whole; $i++) $star = $star . '<span class="material-icons-outlined checked">star</span>';
			if ($decimal > 0) $star = $star . '<span class="material-icons-outlined half-checked">star</span>';
			for ($i=0; $i < $diff; $i++) $star = $star . '<span class="material-icons-outlined">star</span>';
			if(isset($thingstodo['users_total_rating'])){
				$ratings =  "<div>
			<div class=\"rating-stars\">
				{$star}
			</div>
			<small>{$thingstodo['rating']} ({$thingstodo['users_total_rating']})</small></div>";
			}else{
				$ratings =  "<div>
				<div class=\"rating-stars\">
					{$star}
				</div>
				<small>{$thingstodo['rating']} </small></div>";
			}
			echo "<div><div><a href=\"https://www.google.com/maps/search/?api=1&query={$thingstodo['name']}&query_place_id={$thingstodo['place_id']}\" target=\"_blank\"><img src=\"{$thingstodo['photo_url']}\" />{$ratings}<p>{$thingstodo['name']}</p></a></div></div>";
		}
		?>
	</div>
</div>
<div class="geocentric-busstops geocentric-components">
	<h2>Bus Stops  in <?php echo $suburbdata['name'];?></h2>
	<div class="busstops">
		<?php
		foreach ($suburbdata['bus_stops'] as $busstop) {
			echo "<div class=\"bus-stop\">
				<iframe src=\"https://www.google.com/maps/embed/v1/place?key=AIzaSyB27s3VKMMMsTeQZ2ME-iww-xiwREqGPDk&q={$busstop['query']}\" width=\"300\" height=\"320\" style=\"border:0;\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>
				<h3>Bus Stop in {$busstop['name']} {$suburbdata['name']}</h3>
			</div>";
		}
		?>
	</div>
</div>
<div class="geocentric-mapembed geocentric-components">
	<h2>Map of <?php echo $suburbdata['name'];?></h2>
	<div class="iframe_wrapper">
		<?php
		$query = '';

		if (isset($suburbdata['meta']['place_id'])) {
			$query = "place_id:" . $api_data['meta']['place_id'];
		} else {
			$query = $suburbdata['name'] . " " . $suburbdata['meta']['country']['iso2'];
		}
		echo "<div class=\"iframe_wrapper\"><div>
            <iframe src=\"https://www.google.com/maps/embed/v1/place?key=AIzaSyB27s3VKMMMsTeQZ2ME-iww-xiwREqGPDk&q={$query}\" width=\"600\" height=\"300\" style=\"border:0;\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>
            </div></div>";	
		?>
	</div>
</div>
<div class="geocentric-drivingdirections geocentric-components">
	<h2>Driving Directions from <?php echo $suburbdata['name'];?></h2>
	<div class="drivingdirections">
		<?php
		$driving_directions = [];
		foreach ($suburbdata['directions']['origins'] as $origin) {

			if( isset($suburbdata['place_id']) ){
				$addressQuery = $suburbdata['directions']['destination']['query'];
				$addressName = $suburbdata['directions']['destination']['name'];
			
			} else if( isset($suburbdata['street']) && isset($suburbdata['zip_code']) ) {
				$addressName = $suburbdata['street'] . " " . $suburbdata['zip_code'];
				$addressQuery = $suburbdata['street'] . " " . $suburbdata['city']['name'] . " " . $suburbdata['state']['name'] . " " . $suburbdata['zip_code'] . " " . $suburbdata['country']['name'];
			} else if( isset($suburbdata['address']) ){
				$addressQuery = $suburbdata['address']['name'];
				$addressName = $suburbdata['address']['name'];
			} else {
				$addressQuery = $suburbdata['directions']['destination']['query'];
				$addressName = $suburbdata['directions']['destination']['name'];
			}

			echo "<div class=\"direction\">
				<iframe src=\"https://www.google.com/maps/embed/v1/directions?key=AIzaSyB27s3VKMMMsTeQZ2ME-iww-xiwREqGPDk&origin={$origin['query']}&destination={$addressQuery}\" width=\"600\" height=\"320\" style=\"border:0;\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>
				<h3>Driving Directions to {$origin['name']}</h3>
			</div>";
		}
		?>
	</div>
</div>
<?php /*
<div class="geocentric-reviews geocentric-components">
	<h2>Reviews for <?php echo $suburbdata['name'];?></h2>
	<div class="reviews">
		<?php
		if(isset($suburbdata['reviews'])){
			foreach ($suburbdata['reviews'] as $review) {
				$star = '';
				$whole = floor($review['rating']);
				$decimal = $review['rating'] - $whole;
				$diff = 5 - ceil($review['rating']);

				for ($i=0; $i < $whole; $i++) $star = $star . '<span class="material-icons-outlined checked">star</span>';
				if ($decimal > 0) $star = $star . '<span class="material-icons-outlined half-checked">star</span>';
				for ($i=0; $i < $diff; $i++) $star = $star . '<span class="material-icons-outlined">star</span>';
				
				echo "<div class=\"review\">
					<a href=\"{$review['author_url']}\" target=\"_blank\" class=\"head\">
						<img src=\"{$review['profile_photo_url']}\" alt=\"{$this->settings_data['business_name']} Reviews\">
						<div class=\"info\">
							<h3>{$review['author_name']}</h3>
							<div class=\"stars\">
								{$star} <span>({$review['rating']})</span>
							</div>
						</div>
					</a>
					<p>{$review['text']}</p>
				</div>";
			}
		}
		?>
	</div>
</div> */ ?>