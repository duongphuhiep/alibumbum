<html>
	<body>
		<table>
			<tr><td>
				<!--page number: begin-->
				<table class="box1" width="100%">
					<tr>
						<td>
							<a class="me" href="index.php">home</a>
							| <a class="me" href="index.php?page={group_name}">{group_name}</a>
							&gt; {photo_name_with_ext}
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
				<a href="{original_photo_url}" target="_blank">
					<img src="{resized_photo_url}"/>
				</a>
				<div style="text-align:center; font-weight:bold"> {photo_name_no_ext} </div>
			</td></tr>
			
			<tr><td>
				<span style="color:#999999;txt-align:center">
					(views:{vt} comments:{cm})
				</span>
			</td></tr>
			
			<!-- BEGIN all_comment -->
			<tr><td>
				<table border="1" width="100%">
					<!-- BEGIN comment -->
					<tr>
						<td><a href="mailto:{email}">{name}</a> {time}</td>
						<td align="right"><a href="delcomment.php?id={comment_id}">delete</a></td>
					</tr>
					<tr><td colspan="2">{message}</td></tr>
					<tr><td></td></tr>
					<!-- END comment -->
				</table>
			</td></tr>
			<!-- END all_comment -->
			
			<tr><td>
				<form name="comment" method="POST" action="addcomment.php?page={photo_url}"><table>
					<tr><td>Name</td><td><input type="text" name="name"/></td></tr>
					<tr><td>Email</td><td><input type="text" name="email"/></td></tr>
					<tr><td colspan="2"><textarea rows="5" cols="40" name="message"></textarea></td></tr>
					
					<tr><td colspan="2" align="left"><input type="submit"></td></tr>
				</table></form>
			</td></tr>
			
		</table>
	</body>
</html>