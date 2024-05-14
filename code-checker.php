<?php

return function (JP\CodeChecker\CheckerConfig $config) {
	$config->setPhpVersion(new JP\CodeChecker\Version('7.4.0'));
	$config->setParameters([
		'php' => [
			'strictTypes' => FALSE,
		],
	]);
	$config->addPath('./src');
	$config->addPath('./tests');
	JP\CodeChecker\Sets\CzProjectMinimum::configure($config);
};
