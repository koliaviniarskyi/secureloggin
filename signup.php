<?php
  require "db.php";


  $data = $_POST;
  if (isset($data['do_signup'])) {
  	/*здесь регистрируем*/
  	$errors = array();
  	if (trim($data['login']) == '') {
  		$errors[] = "Введите логин!";
  	}
  		if (trim($data['email']) == '') {
  		$errors[] = "Введите ваш email!";
  }
  	if (($data['password']) == '') {
  		$errors[] = "Введите ваш пароль!";
  }
  	if (($data['password_2']) != $data['password']) {
  		$errors[] = "Повтроный пароль введен неверно!";
  }

 	if (R::count('users',"login = ?",array($data['login'],)) >0) {
  		$errors[] = "Польватель с таким логином уже зарегистрирован!";
  }
	if (R::count('users',"email = ?",array($data['email'],)) >0) {
  		$errors[] = "Польватель с таким email уже зарегистрирован!";
  }

     if (empty($errors)) {
  	//все хорошо можно зарегистрировать
  	$user = R::dispense('users');
  	$user->login = $data['login'];
  	$user->email = $data['email'];
  	$user->password = password_hash($data['password'],PASSWORD_DEFAULT); //не хранить пароль в открытом виде
	R::store($user);
	echo '<div style="color: green;">Вы успешно зарегистрировались на сайте</div><hr>';
	}else 
  {
  	echo '<div style="color: red;">'.array_shift($errors).'</div><hr>';
  }
}
?>

<form action="/signup.php" method="POST">
	
<p>
	<p><strong>Ваш логин</strong>:</p> <!-- логин пользователя -->
	<input type="text" name = "login" value="<?php echo @$data['login']; ?>">
</p>
	
<p>
	<p><strong>Ваш Email</strong>:</p>   <!--email пользователя -->
	<input type="email" name = "email" value="<?php echo @$data['email']; ?>">
</p>

<p>
	<p><strong>Ваш пароль</strong>:</p>   <!--email пользователя -->
	<input type="password" name = "password" value="<?php echo @$data['password']; ?>">
</p>

<p>
	<p><strong>Введите ваш пароль еще раз</strong>:</p>   <!--email пользователя -->
	<input type="password" name = "password_2" value="<?php echo @$data['password_2']; ?>">
</p>

<p>
	<button type ="submit" name="do_signup">Зарегистрироваться</button>
</p>
</form>