
<?php
		// Kết nối đến cơ sở dữ liệu SQLite
		$db = new SQLite3('C:\xampp\htdocs\thanh\IoT.db');
		
			// Thực hiện truy vấn SELECT
			$results_h = $db->query('SELECT * FROM DHT22_Humidity_Data');
			$results_t = $db->query('SELECT * FROM DHT22_Temperature_Data');
			$results_1 = $db->query('SELECT * FROM DHT22_Humidity_Data as LastID');
			$results_2 = $db->query('SELECT * FROM DHT22_Temperature_Data as LastID');
			// Lấy kết quả truy vấn
			while ($row = $results_h->fetchArray()) {
				// Xử lý dữ liệu
				// echo "humidity = ". $row['Humidity'] . "<br />";
				$str_h = "humidity = ". $row['Humidity'];
				// echo "<script>document.getElementById('ws').innerHTML = '$str';</script>";
				echo "<script>$('#ws').prepend('<li>$str_h</li>');</script>";
			}
			while ($row = $results_t->fetchArray()) {
				$str_t = "Temperature = ". $row['Temperature'];
				echo "<script>$('#ts').prepend('<li>$str_t</li>');</script>";
			}	
			while ($row = $results_1->fetchArray()) {
				$str_t = $row['Humidity'];
				echo "<script>document.getElementById('humidc').innerHTML = '$str_t&#37';</script>";
			}
			while ($row = $results_2->fetchArray()) {
				$str_t = $row['Temperature'];
				echo "<script>document.getElementById('tempc').innerHTML = '$str_t&#176;C';</script>";
			}
            $db->close();    	
	?>