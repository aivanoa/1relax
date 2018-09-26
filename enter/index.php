<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="windows-1251">
	<title>Авторизацитя</title>
	<style>
		*{
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		html,body{
			width: 100%;
			height: 100%;
			margin: 0;
			padding: 0;
		}
		.main-wrap{
			display: flex;
			height: 100%;
			justify-content: center;
			align-items: center;
		}
		.main{
			width: 250px;
		}
		form {
			padding: 8px;
		}
		input[type="text"] {
			padding: 10px 15px;
			font-weight: bold;
			font-size: 50px;
			display: block;
			max-width: 100%;
			margin: 0;
			outline: none;
			border-radius: 5px;
			border: 1px solid #000000;
		}
		input[type="submit"] {
			text-align: center;
			display: block;
			width: 100%;
			margin-top: 10px;
			background: linear-gradient(45deg, rgba(96,108,136,1) 0%,rgba(63,76,107,1) 100%);
			border: none;
			font-size: 18px;
			color: #fff;
			padding: 10px;
			cursor: pointer;
			border-radius: 5px;
		}
		a{
			text-align: center;
			display: block;
			width: 100%;
			margin-top: 8px;
			border: none;
			font-size: 17px;
			color: rgba(96,108,136,1);
			cursor: pointer;
			border-radius: 5px;
			text-decoration: none;
		}
		img{
			width: 100%;
			height: auto;
		}
	</style>
</head>
<body>
	<div class="main-wrap">
		<div class="main">
			<?/*<div class="QR"><img src="<?=$QR?>" alt=""></div>*/?>
			<form action="/2auth/" method="POST" name="anme">
				<input name="code" type="text" value="" >
				<input type="submit" value="Подтвердить">
				<a href="?exit2Auth">Отменить</a>
			</form>
		</div>
	</div>
</body>
</html>