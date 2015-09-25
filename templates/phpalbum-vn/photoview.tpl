<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>Alibumbum - {photo_name_no_ext}</title>
		<LINK REL="stylesheet" HREF="{tpl}dark.css" TYPE="text/css">
	</head>
	<body>
		<table class="body" width="80%" align="center" cellspacing="15">
			<tr><td>
				<!--page number: begin-->
				<table class="box1" width="100%">
					<tr>
						<td>
							<a class="me" href="index.php">Trang chủ</a>
							| <a class="me" href="index.php?page={group_name}">{group_name}</a>
							&gt; {photo_name_with_ext}
						</td>
						<td align="right">
							<a class="me" href="{first_link}">Đầu</a>
							<a class="me" href="{prev_link}">Trước</a>
							&nbsp;
							<b>{page_num}</b>/{page_count}
							&nbsp;
							<a class="me" href="{next_link}">Sau</a>
							<a class="me" href="{last_link}">Cuối</a>
						</td>
					</tr>
				</table>
				<!--page number: end-->
			</td></tr>
			
			<tr><td align="center">
				<table cellspacing="25" cellpadding="0" bgcolor="white"><tr><td>
					<a href="{original_photo_url}" target="_blank">
					<img class="bdr" src="{resized_photo_url}">
					</a>
				</td></tr></table>
				<br><div class="te"> {photo_name_no_ext} </div>
				<div class="gr">(xem:{vt}, chú thích:{cm})</div>
			</td></tr>
			
			<!-- BEGIN all_comment -->
			<tr><td>
					<!-- BEGIN comment -->
					<table width="100%" class="box1" cellpadding="5" cellspacing="0">
						<tr class="smallboxtitle">
							<td><a class="me" href="mailto:{email}">{name}</a></td>
							<td align="right">{time}</td>
						</tr>
						<tr><td colspan="2">{message}</td></tr>
					</table>
					<p>
					<!-- END comment -->
				
			</td></tr>
			<!-- END all_comment -->
			
			<tr><td>
				<form name="comment" method="POST" action="addcomment.php?page={photo_url}"><table>
					<tr>
						<td>Tên</td>
						<td><input type="text" name="name"/></td></tr>
					<tr><td>Email</td><td><input type="text" name="email"/></td></tr>
					<tr><td colspan="2"><textarea rows="5" cols="40" name="message"></textarea></td></tr>
					
					<tr><td colspan="2" align="left"><input type="submit"></td></tr>
				</table></form>
			</td></tr>
		</table>
	</body>
</html>