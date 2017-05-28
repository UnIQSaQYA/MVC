<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
</head>
<body>
	<h1>Welcome</h1>
	<p>Hello <?php echo htmlSpecialChars($name)?></p>
	<ul>
		<?php foreach ($colours as $colour): ?>
			<li><?php echo htmlSpecialChars($colour); ?></li>
		<?php endforeach; ?>
	</ul>
</body>
</html>