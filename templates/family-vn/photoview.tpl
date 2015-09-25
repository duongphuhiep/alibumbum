
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Alibumbum - {photo_name_no_ext}</title>
<link href="{tpl}res/styles.css" rel="stylesheet" type="text/css">
</HEAD>

<BODY LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>

<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR><TD COLSPAN=4 id="toparea"></TD></TR>
	<TR>
		<TD COLSPAN=3 id="tabarea"></TD>
	</TR>
	<TR>
		<TD id="leftarea"></TD>
		<TD id="thumbnailarea" width="566px" height="432px">
			<table width="100%" height="100%" cellpadding="5">
				<tr><td valign="middle" align="center">
					<table class="thmb" cellspacing="10" cellpadding="0" bgcolor="white"><tr><td>
						<a href="{original_photo_url}" target="_blank">
						<img class="bdr" src="{resized_photo_url}">
						</a>
					</td></tr></table>
					<div style="font-weight:bold; text-align:center">{photo_name_no_ext} </div>					<div class="comment" style="text-align:center">(xem:{vt}, chú thích:{cm})</div>
				</td></tr>
				<tr><td valign="bottom">
					<!--page number: begin-->
					<table width="100%">
						<tr>
							<td>
								<a class="me" href="index.php">Trang chủ</a>
								| <a class="me" href="index.php?page={group_name}">{group_name}</a>
							</td>
							<td align="right">
								<a href="{prev_link}">&nbsp;<img border="0" src="{tpl}res/prev.gif">&nbsp;</a>
								<b>{page_num}</b>/{page_count}
								<a href="{next_link}">&nbsp;<img border="0" src="{tpl}res/next.gif">&nbsp; </a>
							</td>
						</tr>
					</table>
					<!--page number: end-->
				</td></tr>
			</table>
		</TD>
		<TD id="rightarea"></TD>
	</TR>
	<TR><TD COLSPAN=3 id="bottomarea"></TD></TR>
	<tr><td height="40"></td></tr>
	<TR valign="middle"><TD COLSPAN=3 class="tab" style="padding:20 20">
		viết chú thích của bạn tại đây!<p>
		<form name="comment" method="POST" action="addcomment.php?page={photo_url}"><table align="center">
			<tr><td>Tên</td><td><input type="text" name="name"/></td></tr>
			<tr><td>Email</td><td><input type="text" name="email"/></td></tr>
			<tr><td colspan="2"><textarea rows="5" cols="40" name="message"></textarea></td></tr>
			<tr><td colspan="2" align="left"><input type="submit"></td></tr>
		</table></form>
	</TD></TR>
	<tr><td></td></tr>
</TABLE>
<p>
		<!-- BEGIN all_comment -->
		<div class="rightpart">
			<!-- BEGIN comment -->
			<table class="tab" width="100%" cellpadding="5" cellspacing="0">
				<tr>
					<td><a style="font-weight:bold" class="me" href="mailto:{email}">{name}</a></td>
					<td align="right" style="padding-left:50">{time}</td>
				</tr>
				<tr><td class="thmb" colspan="2">{message}</td></tr>
			</table>
			<p>
			<!-- END comment -->
		<div class="rightpart">
		<!-- END all_comment -->
</BODY>
</HTML>
