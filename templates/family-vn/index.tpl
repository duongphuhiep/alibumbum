<!-- BEGIN index -->
<HTML>
<HEAD>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<TITLE>Alibumbum</TITLE>
<link href="{tpl}res/styles.css" rel="stylesheet" type="text/css">
</HEAD>

<BODY LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>

<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR><TD COLSPAN=4 id="toparea"></TD></TR>
	<TR><TD COLSPAN=3 id="tabarea"></TD></TR>
	<TR>
		<TD id="leftarea"></TD>
		<TD id="thumbnailarea">
			<!-- BEGIN main -->
			<table border="0" width="100%" height="100%" cellpadding="20">
				<tr><td valign="top">
					<table align="center">
						<!-- BEGIN thumb -->
						<td valign="top" align="center">
							<table width="{thumbs_size}">
								<tr><td>
									<a href="{cell_link}">
										<img class="thmb" src="{thumb_path}"/>
									</a>
								</td></tr>
								<tr><td align="center">
									{image_name}
									<div class="comment">
										(xem:{vt}<br>chú thích:{cm})
									</div>
								</td></tr>
							</table>
						</td>
						<!-- END thumb -->
					</table>
				</td></tr>
				<tr><td valign="bottom">
					<!--page number: begin-->
					<table width="100%">
						<tr>
							<td>
								<a class="me" href="index.php">Trang chủ</a> | <a class="me" href="index.php?page={group_name}">{group_name}</a>
							</td>
							<td align="right">
								<a href="{prev_link}">&nbsp;<img border="0" src="{tpl}res/prev.gif">&nbsp;</a>
								<strong>{page_num}</strong>/{page_count}
								<a href="{next_link}">&nbsp;<img border="0" src="{tpl}res/next.gif">&nbsp;</a>
							</td>
						</tr>
					</table>
					<!--page number: end-->
				</td></tr>
			</table>
			<!-- END main -->
		</TD>
		<TD id="rightarea"></TD>
	</TR>
	<TR>
		<TD COLSPAN=3 id="bottomarea"></TD>
	</TR>
</TABLE>

<div class="rightpart"><table><tr><td>
	
	<!-- Group list: begin -->
	<table class="tab" cellpadding="4">
		<tr>
			<th class="thmb" style="font-weight:bold;font-style:italic">Nhóm</th>
		</tr>
		<tr><td style="padding:10">
			<!-- BEGIN group -->
			<a class="me" href="{link_to_group}" style="font-weight:bold">{group_name}</a> 
			({nb_photos_of_group})<br>
			<!-- END group -->
		</td></tr>
	</table>
	<!-- Group list: end -->
	
	<p>
	
	<!-- Statistics: begin -->
	<table class="tab" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<th class="thmb" style="font-weight:bold;font-style:italic; padding:4px 4px" colspan="2">Thống kê </th>
		</tr>
		<tr><td>Số lượng ảnh:</td><td>{nb_photos}</td></tr>
		<tr><td>Số nhóm:</td><td>{nb_groups}</td></tr>
		<tr><td>Số chú thích:</td><td>{nb_comments}</td></tr>
		<tr><td>Kích cỡ Album:</td><td>{album_size} (MB)</td></tr>
	</table>
	<!-- Statistics: end -->
	
	<p>
	
	<!-- links: begin -->
	<table class="tab" cellpadding="4" width="100%">
		<tr>
			<th class="thmb" style="font-weight:bold;font-style:italic;" colspan="2">Liên kết </th>
		</tr>
		<tr><td>
            <a class="me" href="http://duongphuhiep.free.fr/alibumbum/docs/index.php" target="_blank">Alibumbum project</a>
        </td></tr>
        <tr><td>
            <a class="me" href="http://duongphuhiep.free.fr/alibumbum" target="_blank">Gallery khác</a>
        </td></tr>
	</table>
	<!-- links: end -->
	
	<p>
	
	<!-- change template: begin -->
	<table class="tab" cellpadding="4" width="100%">
		<tr><th class="thmb" style="font-weight:bold;font-style:italic;" colspan="2">Giao diện </th></tr>
		<tr><td>
			<a class="me" href="set_template.php?tpl=phpalbum-vn&moveto={encurl}">PHP Album (tiếng Việt)</a><br>
			<a class="me" href="set_template.php?tpl=phpalbum&moveto={encurl}">PHP Album (english)</a><br>
			<a class="me" href="set_template.php?tpl=family&moveto={encurl}">Family</a>
		</td></tr>
	</table>
	<!-- change template: end -->
	
</td></tr></table></div>
</BODY>
</HTML>
<!-- END index -->
