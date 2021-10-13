<h1 class="header"><?php echo $this->header ?></h1>



<body>

<div><?php if(isset($message)) { echo $message; } ?></div>
<form method="post" action="/passwd/api/changepw" align="center">
Current Password:<br>
<input type="password" name="currentPassword"><span id="currentPassword" class="required"></span>
<br>
New Password:<br>
<input type="password" name="newPassword"><span id="newPassword" class="required"></span>
<br>
Confirm Password:<br>
<input type="password" name="confirmPassword"><span id="confirmPassword" class="required"></span>
<br><br>
<input type="submit" name="submit">
</form>
<br>
<br>
</body>



<div id="react-root"></div>