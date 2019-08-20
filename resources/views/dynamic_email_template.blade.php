<b>Tin nhắn cảnh báo: Hợp đồng <?php if($data[2]) echo "đã"; else echo "sắp"; ?> hết hạn !!</b><br>
<b style="color: red">Snipe-IT</b> trân trọng gửi thông báo đến bạn, có hợp đồng trong danh sách <?php if($data[2]) echo "đã"; else echo "sắp"; ?> hết hạn<br>
<p>Tên hợp đồng <?php if($data[2]) echo "đã"; else echo "sắp"; ?> hết hạn:</p>
<ul>
<?php
	if($data[2])
	{
		echo "<li style=color:'red'>".$data[0]." (đã hết hạn cách đây ".$data[1]." ngày)."."</li>";
	}
	else
	{
		echo "<li style=color:'red'>".$data[0]." (còn ".$data[1]." ngày)."."</li>";
	}
?>
</ul>
<p>Bạn hãy gia hạn thêm cho hợp đồng này hoặc hủy hợp đồng bằng cách xóa nó khỏi danh sách</p>