<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
				content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
<form action="index.php" method="post">
	<input placeholder="введите ИНН" value="<?php echo $_POST['inn']?>" type="text" name="inn"  onkeyup="this.style.backgroundColor = is_valid_inn(this.value) ? '#dfd' : '#fdd'" />
	<button type="submit">Посчитать</button>
</form>
<?php
if (isset($_POST['inn'])) {
	include_once('authenticity.php');
	$authenticity = new Authenticity();
	echo '<p>Проверка ИНН=' . $_POST['inn'] . ':</p><pre>';
	print_r($authenticity->get($_POST['inn']));

	//проверка
	//	print_r($authenticity->get(77234550));
	//	print_r($authenticity->get(972100461600));
	//	print_r($authenticity->get(590318781607));
	//	print_r($authenticity->get(502727012207));
	//	print_r($authenticity->get(253402065152));
	//	print_r($authenticity->get(772739580300));

	echo '</pre>';
}
?>
</body>
</html>
<script type="text/javascript">
	/*
	 Функция для проверки правильности ИНН
	 */
	function is_valid_inn(i)
	{
		if ( i.match(/\D/) ) return false;

		var inn = i.match(/(\d)/g);

		if ( inn.length == 10 )
		{
			return inn[9] == String(((
				2*inn[0] + 4*inn[1] + 10*inn[2] +
				3*inn[3] + 5*inn[4] +  9*inn[5] +
				4*inn[6] + 6*inn[7] +  8*inn[8]
			) % 11) % 10);
		}
		else if ( inn.length == 12 )
		{
			return inn[10] == String(((
				7*inn[0] + 2*inn[1] + 4*inn[2] +
				10*inn[3] + 3*inn[4] + 5*inn[5] +
				9*inn[6] + 4*inn[7] + 6*inn[8] +
				8*inn[9]
			) % 11) % 10) && inn[11] == String(((
				3*inn[0] +  7*inn[1] + 2*inn[2] +
				4*inn[3] + 10*inn[4] + 3*inn[5] +
				5*inn[6] +  9*inn[7] + 4*inn[8] +
				6*inn[9] +  8*inn[10]
			) % 11) % 10);
		}

		return false;
	}
</script>
