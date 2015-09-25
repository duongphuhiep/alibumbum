<!-- BEGIN index -->
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>Alibumbum - index page</title>
		<LINK REL="stylesheet" HREF="{tpl}dark.css" TYPE="text/css">
	</head>
	<body>
		<table class="body" align="center" cellspacing="15">
			<tr><td colspan="2" align="center">
				<a class="logo" href="index.php">
				MY GALLERY
				</a>
			</td></tr>
			
			<tr>
				<td valign="top">
					<div class="box1">
						<div class="boxtitle">Categories</div>
						<!-- BEGIN group -->
						<div class="groupindex">
							<a class="me" href="{link_to_group}">{group_name}</a> 
							({nb_photos_of_group})
						</div>
						<!-- END group -->
					</div>
					
					<p />
					
					<!-- statistic: begin -->
					<div class="box1">
						<div class="boxtitle">Statistics</div>
						<table>
							<tr><td>Images:</td><td style="font-weight:bolder">{nb_photos}</td></tr>
							<tr><td>Groups:</td><td style="font-weight:bolder">{nb_groups}</td></tr>
							<tr><td>Comments:</td><td style="font-weight:bolder">{nb_comments}</td></tr>
							<tr><td>Album size:</td><td style="font-weight:bolder">{album_size} Mb</td></tr>
						</table>
					</div>
					<!-- statistic: begin -->
					<p />
					<!-- links: begin -->
					<div class="box1">
						<div class="boxtitle">Links</div>
						<div class="groupindex">
							<a class="me" href="http://duongphuhiep.free.fr/alibumbum/docs/index.php" target="_blank">Alibumbum project</a>
						</div>
                        <div class="groupindex">
							<a class="me" href="http://duongphuhiep.free.fr/alibumbum" target="_blank">Other gallery</a>
						</div>
					</div>
					<!-- links: end -->
					<p />
					<!-- change template: begin -->
					<div class="box1">
						<div class="boxtitle">Other templates</div>
						<div class="groupindex"><a class="me" href="set_template.php?tpl=family&moveto={encurl}">Family</a></div>
						<div class="groupindex"><a class="me" href="set_template.php?tpl=family-vn&moveto={encurl}">Gia đình</a></div>
						<div class="groupindex"><a class="me" href="set_template.php?tpl=phpalbum-vn&moveto={encurl}">PHP Album (vietnamese)</a></div>
					</div>
					<!-- change template: end -->
				</td>

				<td valign="top">
					<!-- BEGIN main -->
					<table>
						<tr><td>
							<!--page number-->
							<table class="box1" width="100%">
								<tr>
									<td>
										<a class="me" href="index.php">Home</a>
										| <a class="me" href="index.php?page={group_name}">{group_name}</a>
									</td>
									<td align="right">
										<a class="me" href="{first_link}">First</a>
										<a class="me" href="{prev_link}">Prev</a>
										&nbsp;
										<b>{page_num}</b>/{page_count}
										&nbsp;
										<a class="me" href="{next_link}">Next</a>
										<a class="me" href="{last_link}">Last</a>
									</td>
								</tr>
							</table>
						</td></tr>
						
						<tr><td>
							<table>
								<!-- BEGIN thumb -->
								<td valign="top" align="center">
									<table width="{thumbs_size}">
										<tr><td>
											<a class="me" href="{cell_link}">
												<img class="thmb" src="{thumb_path}" width="{img_width}" height="{img_height}" />
											</a>
										</td></tr>
										<tr><td align="center">
											{image_name}
											<div class="gr">
												(views:{vt} comments:{cm})
											</div>
										</td></tr>
									</table>
								</td>
								<!-- END thumb -->
							</table>
						</td></tr>
					</table>
					<!-- END main -->
				</td>
			</tr>
		</table>
	</body>
</html>
<!-- END index -->