<div class='wrap'>
	<h1>Add a Top Level Domain</h1>
	<?php if(!$is_multisite):?>
		<div class='error'>This is not a multisite yet... Please follow these 
		<a target='_blank' href='http://codex.wordpress.org/Create_A_Network'>direction to configure a network</a>.<br>
		<b>Please note</b>, Do not
		configure a network if you have already created content on this site. Only configure networks on fresh installs</div>
	<?php else: ?>
	<form method='post' action='<?php echo DOMAINPARKING_URL ?>create_site.php'>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="user_login">Domain Name</label></th>
					<td><input type="text" name="domain_name" id="domain_name" class="regular-text"> </td>
				</tr>
				<tr>
					<th><label for="first_name">Site</label></th>
					<td>
					<select name='old_site'>
					<?php foreach($blogs as $blog):?>
						<option value='<?php echo $blog->blog_id?>'><?php echo $blog->domain?></option>
					<?php endforeach;?>
					</select>
					<span class="description">Network site that will use the new domain name.</span></td>
				</tr>
			</tbody>
		</table>
		<input type="submit" name="submit" id="doaction2" class="button action" value="Apply">
	</form>
	<?php endif;?>
</div>
