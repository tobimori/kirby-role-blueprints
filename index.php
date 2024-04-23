<?php

use Kirby\Cms\App;
use Kirby\Data\Yaml;
use Kirby\Toolkit\A;
use Kirby\Toolkit\Str;

$kirby = App::instance();
$cache = $kirby->cache('tobimori.role-blueprints');
$registry = $kirby->option('debug') ? [] : $cache->get('registry', []);

if (empty($registry)) {
	$root = $kirby->root('blueprints');
	$files = glob("{$root}/{,**/}*.*.yml", GLOB_BRACE);

	foreach ($files as $file) {
		[$_, $blueprint, $role] = Str::match($file, "/" . Str::replace($root, '/', '\/') . "\/(\S+)\.(\S+)\.yml/");
		$registry[$blueprint][$role] = $file;
	}

	$cache->set('registry', $registry);
}

App::plugin('tobimori/role-blueprints', [
	'options' => [
		'cache' => true,
	],
	'blueprints' => A::map($registry, function ($roles) {
		return function () use ($roles) {
			foreach ($roles as $role => $file) {
				if (App::instance()?->user()?->role()->name() === $role) {
					return Yaml::read($file);
				}
			}

			if (isset($roles['default'])) {
				return Yaml::read($roles['default']);
			}

			return false;
		};
	})
]);
