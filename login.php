<?php
  require "db.php";

  $data = $_POST;

if (isset($data['do_login']) ) {
	$errors = array();
	$user = R::findOne('users','login = ?',array($data['login']) );
	if( $user ){
			//логин существует
		if(password_verify($data['password'], $user->password) ){
			//все хорошо,логиним пользователя
			//используем для входа сессии
			$_SESSION['logged_user'] = $user;
			echo '<div style="color: green;">Вы успешно авторизовались на сайте,можете перейти на <a href="/">главную</a> страницу</div><hr>';
		}else{
			$errors[]= 'Пароль введен неверно!';
		}

	}else
	{
		$errors[]= 'Пользователь с таким логином не найден';
	}
	    if (empty($errors)) {
  		echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
	}

	else 
  {
  	echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
  }
}
?>
<form action="login.php" method="POST">

<p>
	<p><strong>Логин</strong>:</p> <!-- логин пользователя -->
	<input type="text" name = "login" value="<?php echo @$data['login']; ?>">
</p>
	
<p>
	<p><strong>Пароль</strong>:</p> <!-- логин пользователя -->
	<input type="text" name = "password" value="<?php echo @$data['password']; ?>">
</p>

<p>
	<button type ="submit" name="do_login">Войти</button>
</p>

</form>