<!-- BEGIN index -->
<html>
	<body>
		<table border="1">
			<tr><td colspan="2">
				<a href="index.php">Header (return to Home page)</a>
			</td></tr>
			<tr>
				<td valign="top">
					<div style="border: medium solid green">
					 	<!-- BEGIN group -->
					 	<a href="{link_to_group}">{group_name}</a>({nb_photos_of_group})<br/>
						<!-- END group -->
					</div>
					
					<br>
					
					<!-- statistic: begin -->
					<table style="border: medium solid green; width:100%">
						<tr><td>Images:</td><td>{nb_photos}</td></tr>
						<tr><td>Groups:</td><td>{nb_groups}</td></tr>
						<tr><td>Comments:</td><td>{nb_comments}</td></tr>
						<tr><td>Album size:</td><td>{album_size} (MB)</td></tr>
					</table>
					<!-- statistic: end -->
					<br>
					
					<!-- change template: begin -->
					<div style="border: medium solid green">
						<a href="set_template.php?tpl=phpalbum&moveto={encurl}">PHP Album</a><br>
						<a href="set_template.php?tpl=family&moveto={encurl}">Family</a>
					</div>
					<!-- change template: end -->
					
				</td>
				<td>
					<!-- BEGIN main -->
					<table>
						<tr><td>
							<!--page number: begin-->
							<table width="100%">
								<tr>
									<td>
										<a class="me" href="index.php">home</a>
										| <a class="me" href="index.php?page={group_name}">{group_name}</a>
									</td>
									<td align="right">
										<a class="me" href="{first_link}">first</a>
										<a class="me" href="{prev_link}">prev</a>
										&nbsp;
										<b>{page_num}</b>/{page_count}
										&nbsp;
										<a class="me" href="{next_link}">next</a>
										<a class="me" href="{last_link}">last</a>
									</td>
								</tr>
							</table>
							<!--page number: end-->
						</td></tr>
						<tr><td>
							<table>
								<!-- BEGIN thumb -->
								<td valign="top" align="center">
									<table width="{thumbs_size}">
										<tr><td>
											<a href="{cell_link}">
												<img src="{thumb_path}"/>
											</a>
										</td></tr>
										<tr><td align="center">
											{image_name}
											<div style="color:#999999">
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