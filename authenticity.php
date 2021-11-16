<?php

class Authenticity
{
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

	/**
	 * Метод вызывающий CURL
	 *
	 * Парсим стороний закрытый API. Использую CURL,
	 * хотя можно еще проще через file_get_contents.
	 *
	 * @param $inn
	 * @return mixed
	 */
	private function getJson($inn)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://pb.nalog.ru/search-proc.json');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		//потребуется бороться с CaptchaToken в будущем, тогда нужно будет брать много всего: curl_setopt($ch, CURLOPT_POSTFIELDS, "page=1&pageSize=10&pbCaptchaToken=&token=&mode=search-all&queryAll=$inn&queryUl=&okvedUl=&statusUl=&regionUl=&isMspUl=&mspUl1=1&mspUl2=2&mspUl3=3&queryIp=&okvedIp=&statusIp=&regionIp=&isMspIp=&mspIp1=1&mspIp2=2&mspIp3=3&queryUpr=&uprType1=1&uprType0=1&queryRdl=&dateRdl=&queryAddr=&regionAddr=&queryOgr=&ogrFl=1&ogrUl=1&npTypeDoc=1&ogrnUlDoc=&ogrnIpDoc=&nameUlDoc=&nameIpDoc=&formUlDoc=&formIpDoc=&ifnsDoc=&dateFromDoc=&dateToDoc=");
		//пока используем минимальные параметры
		curl_setopt($ch, CURLOPT_POSTFIELDS, "page=1&pageSize=10&mode=search-all&queryAll=$inn");
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

		$headers = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
		$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return json_decode($result, true);
	}
}