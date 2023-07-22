<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => '1.0.0+no-version-set',
    'version' => '1.0.0.0',
    'aliases' => 
    array (
    ),
    'reference' => NULL,
    'name' => '__root__',
  ),
  'versions' => 
  array (
    '__root__' => 
    array (
      'pretty_version' => '1.0.0+no-version-set',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => NULL,
    ),
    'cboden/ratchet' => 
    array (
      'pretty_version' => 'v0.4.4',
      'version' => '0.4.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '5012dc954541b40c5599d286fd40653f5716a38f',
    ),
    'evenement/evenement' => 
    array (
      'pretty_version' => 'v3.0.1',
      'version' => '3.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '531bfb9d15f8aa57454f5f0285b18bec903b8fb7',
    ),
    'guzzlehttp/psr7' => 
    array (
      'pretty_version' => '2.5.0',
      'version' => '2.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b635f279edd83fc275f822a1188157ffea568ff6',
    ),
    'phpmailer/phpmailer' => 
    array (
      'pretty_version' => 'v6.8.0',
      'version' => '6.8.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'df16b615e371d81fb79e506277faea67a1be18f1',
    ),
    'psr/http-factory' => 
    array (
      'pretty_version' => '1.0.2',
      'version' => '1.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e616d01114759c4c489f93b099585439f795fe35',
    ),
    'psr/http-factory-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/http-message' => 
    array (
      'pretty_version' => '2.0',
      'version' => '2.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '402d35bcb92c70c026d1a6a9883f06b2ead23d71',
    ),
    'psr/http-message-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'ralouphie/getallheaders' => 
    array (
      'pretty_version' => '3.0.3',
      'version' => '3.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '120b605dfeb996808c31b6477290a714d356e822',
    ),
    'ratchet/rfc6455' => 
    array (
      'pretty_version' => 'v0.3.1',
      'version' => '0.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '7c964514e93456a52a99a20fcfa0de242a43ccdb',
    ),
    'react/cache' => 
    array (
      'pretty_version' => 'v1.2.0',
      'version' => '1.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd47c472b64aa5608225f47965a484b75c7817d5b',
    ),
    'react/dns' => 
    array (
      'pretty_version' => 'v1.11.0',
      'version' => '1.11.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '3be0fc8f1eb37d6875cd6f0c6c7d0be81435de9f',
    ),
    'react/event-loop' => 
    array (
      'pretty_version' => 'v1.4.0',
      'version' => '1.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '6e7e587714fff7a83dcc7025aee42ab3b265ae05',
    ),
    'react/promise' => 
    array (
      'pretty_version' => 'v2.10.0',
      'version' => '2.10.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f913fb8cceba1e6644b7b90c4bfb678ed8a3ef38',
    ),
    'react/socket' => 
    array (
      'pretty_version' => 'v1.13.0',
      'version' => '1.13.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cff482bbad5848ecbe8b57da57e4e213b03619aa',
    ),
    'react/stream' => 
    array (
      'pretty_version' => 'v1.3.0',
      'version' => '1.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '6fbc9672905c7d5a885f2da2fc696f65840f4a66',
    ),
    'symfony/deprecation-contracts' => 
    array (
      'pretty_version' => 'v2.5.2',
      'version' => '2.5.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e8b495ea28c1d97b5e0c121748d6f9b53d075c66',
    ),
    'symfony/http-foundation' => 
    array (
      'pretty_version' => 'v5.4.25',
      'version' => '5.4.25.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f66be2706075c5f6325d2fe2b743a57fb5d23f6b',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '8ad114f6b39e2c98a8b0e3bd907732c207c2b534',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '7a6ff3f1959bb01aefccb463a0f2cd3d3d2fd936',
    ),
    'symfony/routing' => 
    array (
      'pretty_version' => 'v5.4.25',
      'version' => '5.4.25.0',
      'aliases' => 
      array (
      ),
      'reference' => '56bfc1394f7011303eb2e22724f9b422d3f14649',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}


if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

$ranges = array();
if (isset($installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = $installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['version'])) {
return null;
}

return $installed['versions'][$packageName]['version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getPrettyVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return $installed['versions'][$packageName]['pretty_version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getReference($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['reference'])) {
return null;
}

return $installed['versions'][$packageName]['reference'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getRootPackage()
{
$installed = self::getInstalled();

return $installed[0]['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
self::$installedByVendor = array();
}




private static function getInstalled()
{
if (null === self::$canGetVendors) {
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {
foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
