<div class="box1" style="padding:10 10; height:100%">
<div style="width:600px">
	<h3>Admin tools</h3>
	<a class="admin" href="clean.php">clean trasy files</a>
</div>

<h3>Random Photos</h3>
							<table>
								<!-- BEGIN thumb2 -->
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
								<!-- END thumb2 -->
							</table>


<h3>Most View Photos</h3>
							<table>
								<!-- BEGIN thumb -->
								<td valign="top" align="center">
									<table width="{thumbs_size}">
										<tr><td>
											<a class="me" href="{cell_link}">
												<img class="thmb" src="{thumb_path}"/>
											</a>
										</td></tr>
										<tr><td align="center">
											<a class="admin" href="{update_link}">update</a>
											<br>
											{image_name}
											<div class="gr">
												(views:{vt} comments:{cm})
											</div>
										</td></tr>
									</table>
								</td>
								<!-- END thumb -->
							</table>
</div>
