<?

require_once(__DIR__.'/vendor/autoload.php');

$config = require('config.php');

// connect to DB
global $DB;
$DB  = new fDatabase(
	'mysql', 
	$config['db']['db_name'], 
	$config['db']['user'], 
	$config['db']['pass'],
	$config['db']['host'],
	$config['db']['port']
);

// attach connect to ORM
fORMDatabase::attach($DB);

// это хук чтобы метод $news->listDatenow(); не ругался
// хорошо бы это писать в самой модели Datenow, но вот тот класс лоадится автозагрузкой уже поде того, как резолвится имя модели
\fGrammar::addSingularPluralRule('Datenow', 'Datenow');

/** 
 * красивая страничка php-ошибок для разработки
 */
if(getenv('ENV') == 'dev'){
	$whoops = new \Whoops\Run;
	$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
	$whoops->register();
}else{
	/** @todo: set own error page?? */
}


$containerBuilder = new DI\ContainerBuilder;
$containerBuilder->addDefinitions(__DIR__ . '/config_di.php');
$container = $containerBuilder->build();
return $container;