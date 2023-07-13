<!DOCTYPE html>
<html>
<head>
	<script src="jquery.min.js" type="text/javascript"></script>
	<title>Truy xuất SQLite từ PHP</title>
</head>
<body>
	<h1>temperature and humidity</h1>
    <div>
        <div>
            <!-- Subscribed to <input type='text' id='topic' disabled /> -->
        Status: <input type='text' id='status' size="80" disabled /></div>
        <div style="width: 900px;margin-top: 30px;">
            <div style="float: left;width: 50%;">
                <h4 style="text-align: center;">temperature</h4>
                <ul id='ws' style="font-family: 'Courier New', Courier, monospace;overflow-y: scroll;height: 500px;background-color: aqua;">
                </ul>
            </div>
            <div style="float: right;width: 50%;">
                <h4 style="text-align: center;">humidity</h4>
                <ul id='ts' style="font-family: 'Courier New', Courier, monospace;overflow-y: scroll;height: 500px;background-color: aqua;">
                </ul>
            </div>
        </div>
    </div>
</body>
	<?php
		// Kết nối đến cơ sở dữ liệu SQLite
		$db = new SQLite3('C:\xampp\htdocs\thanh\IoT.db');
		$count = 0;
		
			// Thực hiện truy vấn SELECT
			$results_h = $db->query('SELECT * FROM DHT22_Humidity_Data');
			$results_t = $db->query('SELECT * FROM DHT22_Temperature_Data');
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
	?>
</html>