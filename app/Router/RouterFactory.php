<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->addRoute('login', 'Login:login');
		$router->addRoute('register', 'Register:register');
		$router->addRoute('staj/<cislo_staje=0>', 'Staj:staj');
		$router->addRoute('refresh', 'Refresh:refresh');
		$router->addRoute('pocetZviratAStaji', 'Graf:PocetZviratAStaji');
		$router->addRoute('zastoupeniZvirat', 'Graf:ZastoupeniZvirat');
		$router->addRoute('dojeneZvirata', 'Graf:DojeneZvirata');
		$router->addRoute('pocetZviratStaje', 'Graf:PocetZviratStaje');
		$router->addRoute('vsechnaZvirataUzivatele', 'Graf:VratVsechnaZvirata');
		$router->addRoute('zvire/<cislo_staje=0>', 'Zvire:zvire');
		$router->addRoute('hmotnost/<id_zvire=0>/<id_hmotnost=0>', 'Hmotnost:hmotnost');
		$router->addRoute('editMajitel', 'Uzivatel:editUzivatel');
		$router->addRoute('uzivatel', 'Uzivatel:VratUzivatele');
		$router->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');

		return $router;
	}
}
