<!DOCTYPE html>
<html>
	<body>
		<table height="100%" cellspacing="0" cellpadding="0" width="100%" border="0" bgcolor="#f5f5f5">
			<tbody>
				<tr>
					<td valign="top" align="center" height="auto" width="100%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f5f5f5" style="max-width:620px; border-left: 1px solid #dddddd; border-right: 1px solid #dddddd; border-top: 1px solid #dddddd;">
							<tbody>
								<tr>
									<td><a href="<?php echo base_url(); ?>" target="_blank" style="display:block;text-align: center;"><img src="<?php echo FILEPATH; ?>images/logo.png" width="20%" alt=""/></a></td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" align="center" height="100%" width="100%">
						<table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width:620px; border-left: 1px solid #dddddd; border-right: 1px solid #dddddd; border-bottom: 1px solid #dddddd;">
							<tbody>
								<tr>
									<td align="center" style="padding:20px 30px 0px 30px;font-size:24px;line-height:28px"> <span style="font-family:'Open Sans',sans-serif;font-size:24px;line-height:28px;color:#016e92;font-weight:400">
									Resource contact us page.</span> </td>
								</tr>
								<tr>
									<td align="left" style="padding:20px 20px 0px 20px; "><span style="border-bottom:1px solid #016e92; width: 100%; display: block; height: 1px;">&nbsp;</span></td>
								</tr>
								<tr>
									<td align="left" style="padding:20px 20px 40px 20px;font-size:16px;line-height:22px">
										<span style="font-family:'Open Sans',sans-serif;font-size:16px;line-height:22px;color:#063a7b;font-weight:400">
											<span style="font-family:Arial,sans-serif;font-size:20px;line-height:24px">Hello <?php echo ucwords($admin->first_name . ' ' . $admin->last_name); ?>,<br><br></span>
											<span style="color:#000000;font-style:normal;font-variant-caps:normal;font-weight:normal;letter-spacing:normal;text-align:-webkit-left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;font-family:Arial,sans-serif;font-size:16px;line-height:18px">Please check the below contact details:</span><br/><br/>
											<span style="color:#000000;font-style:normal;font-variant-caps:normal;font-weight:normal;letter-spacing:normal;text-align:-webkit-left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;font-family:Arial,sans-serif;font-size:16px;line-height:18px">
												Name: <em><?php echo $name; ?></em>
											</span><br/>
											<span style="color:#000000;font-style:normal;font-variant-caps:normal;font-weight:normal;letter-spacing:normal;text-align:-webkit-left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;font-family:Arial,sans-serif;font-size:16px;line-height:18px">
												Email: <em><?php echo $email; ?></em>
											</span><br/>
											<span style="color:#000000;font-style:normal;font-variant-caps:normal;font-weight:normal;letter-spacing:normal;text-align:-webkit-left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;font-family:Arial,sans-serif;font-size:16px;line-height:18px">
												Phone: <em><?php echo $phone; ?></em>
											</span><br/>
											<span style="color:#000000;font-style:normal;font-variant-caps:normal;font-weight:normal;letter-spacing:normal;text-align:-webkit-left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;font-family:Arial,sans-serif;font-size:16px;line-height:18px">
												Subject <em><?php echo $subject; ?></em>
											</span><br/>
											<span style="color:#000000;font-style:normal;font-variant-caps:normal;font-weight:normal;letter-spacing:normal;text-align:-webkit-left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;font-family:Arial,sans-serif;font-size:16px;line-height:18px">
												Message: <em><?php echo $message; ?></em>
											</span><br/><br/>
											<span style="color:#000000;font-style:normal;font-variant-caps:normal;font-weight:normal;letter-spacing:normal;text-align:-webkit-left;text-indent:0px;text-transform:none;white-space:normal;word-spacing:0px;font-family:Arial,sans-serif;font-size:16px;line-height:18px">Thanks</span>
										</span>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</body>
</html>