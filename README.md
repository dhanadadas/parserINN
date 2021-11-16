# parserINN
Задание на парсинг данных

## Задание
Разместить у себя на хостинге форму HTML с полем для проверки ИНН физического лица на наличие признака “ограничения в регистрационных действиях”.

Решение:
```php
		/**
	 * Метод обработки json ответа
	 *
	 * @param $inn
	 * @return mixed
	 */
	public function get($inn)
	{
		$json=$this->getJson($inn);
		if (isset($json["ERROR"])) return 'Ошибка сервера или ошибка капчи';
		$result["inn"]=$inn;
		$result["message"]=$inn;
		if ($json['ogrfl']['rowCount']===0) {
			$result["message"]='По заданным критериям поиска сведений не найдено.';
			$result["authenticity"]='true';
		}
		else {

			$result["message"]='Наличие ограничений';
			//$result["message"]=$json['ogrfl']['data'];//можно вывести массив ограничений
			$result["authenticity"]='false';
		}
		return $result;
	}
```

## Демонстрация
* [ссылка](https://moodle.rane-brf.ru/parser/index.php)


Клон данного репозитория:
```git
git clone https://github.com/dhanadadas/parserINN.git
```
