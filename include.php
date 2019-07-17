<?

define('CUSTOM_MODULE', 'CUSTOM MODULE INCLUDED');
// register autoload classes
\Bitrix\Main\Loader::registerAutoLoadClasses(
    'custom.debugbar',
    array(
        '\Custom\DebugBar' => 'lib/DebugBar.php',
        'DebugBarTrait'    => 'lib/DebugBarTrait.php',
    )
);

require_once __DIR__.'/lib/kint/Kint.class.php';
require_once __DIR__.'/lib/nf_pp.php';
Kint::$theme = 'aante-light';

if (!function_exists('_dbm')) {
    function _dbm($message, $bar = 'default', $label = '')
    {
        \Custom\DebugBar::addMessage($message, $bar, $label);
    }
}
if (!function_exists('_dbe')) {
    function _dbe($message, $bar = 'default', $label = '')
    {
        \Custom\DebugBar::addMessage($message, $bar, $label);
    }
}
if (!function_exists('_dbc')) {
    function _dbc($component)
    {
        \Custom\DebugBar::addComponent($component);
    }
}