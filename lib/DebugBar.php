<?php

namespace Custom;

/**
 * Class DebugBar
 * @package Custom
 */
class DebugBar
{
    /**
     * сообщения
     * @var array
     */
    public static $messages = [];

    /**
     * настройки
     * @var array
     */
    public static $settings = [];

    /**
     * таймеры
     * @var array
     */
    public static $timers = [];

    /**
     * панели
     * @var array
     */
    public static $bars = ['default'];

    /**
     * добавление сообщения
     * @param string|array|object $message
     * @param string              $bar
     * @param string              $label
     */
    public static function addMessage($message, $bar = 'default', $label = '')
    {
        if ($bar === '' && !$bar) {
            $bar = 'default';
        }
        self::$messages[$bar][] = [
            'text'      => $message,
            'label'     => $label,
            'type'      => 'info',
            'timestamp' => time(),
            'trace'     => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)
        ];
    }

    /**
     * добавление сообщения об ошибке
     * @param        $message
     * @param string $bar
     * @param        $label
     */
    public static function addError($message, $bar = 'default', $label)
    {
        if ($bar === '' && !$bar) {
            $bar = 'default';
        }
        self::$messages[$bar][] = [
            'text'      => $message,
            'label'     => $label,
            'type'      => 'danger',
            'timestamp' => time(),
            'trace'     => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)
        ];
    }

    /**
     * добавление панели с данными о компоненте
     *
     * @param $component
     */
    public static function addComponent($component)
    {
        $cp = $component->__component;
        $componentName = $cp->__name;

        self::$messages[$componentName][] = [
            'text'  => $cp->arResult,
            'label' => 'arResult'
        ];
        self::$messages[$componentName][] = [
            'text'  => $cp->arParams,
            'label' => 'arParams'
        ];
        self::$messages[$componentName][] = [
            'text'  => $cp->__path,
            'label' => 'component path'
        ];
        self::$messages[$componentName][] = [
            'text'  => $component->__folder,
            'label' => 'template path'
        ];

    }

    /**
     * проверка прав на показ панели
     * @return bool
     */
    public static function checkRights()
    {
        global $USER;
        if ($USER->IsAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * @param array $settings
     */
    public static function settings(array $settings)
    {
        self::$settings = $settings;
    }

    /**
     * добавление панели с глобальными массивами
     * @param $messagesArr
     *
     * @return mixed
     */
    public static function addRequestTab($messagesArr)
    {
        $messagesArr['request'][] = [
            'text'  => $_GET,
            'label' => 'GET'
        ];
        $messagesArr['request'][] = [
            'text'  => $_POST,
            'label' => 'POST'
        ];
        $messagesArr['request'][] = [
            'text'  => $_SERVER,
            'label' => 'SERVER'
        ];
        $messagesArr['request'][] = [
            'text'  => $_SESSION,
            'label' => 'SESSION'
        ];
        $messagesArr['request'][] = [
            'text'  => $_COOKIE,
            'label' => 'COOKIE'
        ];

        return $messagesArr;
    }

    /**
     * добавление панели с объектами битрикса
     * @param $messagesArr
     *
     * @return mixed
     */
    public static function addBxTab($messagesArr)
    {
        global $APPLICATION, $USER;

        $messagesArr['bx'][] = [
            'text'  => SITE_TEMPLATE_PATH,
            'label' => 'SITE_TEMPLATE_PATH'
        ];
        $messagesArr['bx'][] = [
            'text'  => LANGUAGE_ID,
            'label' => 'LANGUAGE_ID'
        ];
        $messagesArr['bx'][] = [
            'text'  => SITE_ID,
            'label' => 'SITE_ID'
        ];
        $messagesArr['bx'][] = [
            'text'  => SITE_DIR,
            'label' => 'SITE_DIR'
        ];
        $messagesArr['bx'][] = [
            'text' => $APPLICATION,
        ];
        $messagesArr['bx'][] = [
            'text' => $USER,
        ];

        return $messagesArr;
    }

    /**
     * добавление панели с инфой о странице
     * @param $messagesArr
     *
     * @return mixed
     */
    public static function addPageTab($messagesArr){
        global $APPLICATION, $USER;

        $messagesArr['page'][] = [
            'text'  => $APPLICATION->GetCurPage(),
            'label' => 'CurPage'
        ];
        $messagesArr['page'][] = [
            'text'  => $APPLICATION->LAST_ERROR,
            'label' => 'LAST_ERROR'
        ];
        $messagesArr['page'][] = [
            'text'  => $APPLICATION->arHeadScripts,
            'label' => 'arHeadScripts'
        ];
        $messagesArr['page'][] = [
            'text'  => $APPLICATION->sPath2css,
            'label' => 'sPath2css'
        ];
        $messagesArr['page'][] = [
            'text'  => $APPLICATION->arPageProperties,
            'label' => 'arPageProperties'
        ];
        $messagesArr['page'][] = [
            'text'  => $APPLICATION->sDocTitleChanger,
            'label' => 'sDocTitleChanger'
        ];
        $messagesArr['page'][] = [
            'text'  => $APPLICATION->arHeadAdditionalCSS,
            'label' => 'arHeadAdditionalCSS'
        ];

        return $messagesArr;
    }

    /**
     * получение сообщений
     * @param bool $formatted
     *
     * @return array|mixed
     */
    public static function getMessages($formatted = true)
    {
        $messagesArr = self::$messages;

        $messagesArr = self::addRequestTab($messagesArr);
        $messagesArr = self::addBxTab($messagesArr);
        $messagesArr = self::addPageTab($messagesArr);

        if ($formatted) {
            foreach ($messagesArr as $bar => &$messages) {
                foreach ($messages as &$message) {
                    if ($message['timestamp']) {
                        $message['date'] = date('H:i:s', $message['timestamp']);
                    }
                    if ($message['trace']) {
                        $trace = $message['trace'][0]['file'].' : '.$message['trace'][0]['line'];
                        $message['trace_last'] = $trace;
                    }
                }
            }
        }

        return $messagesArr;
    }

    /**
     * информация о битриксе на панели
     * @return array
     */
    public static function getBxInfo(){
        global $APPLICATION, $USER;
        return [
            'time'      => date('d.m H:i:s'),
            'php'       => 'php '.PHP_VERSION,
            'bx'        => 'bx '.SM_VERSION,
            'template'  => SITE_TEMPLATE_PATH,
            'user'      => $USER->GetLogin(),
            'error'     => $APPLICATION->LAST_ERROR
        ];
    }

    /**
     * добавление лога в журнал битрикса
     * @param $message
     */
    public static function addBxLog($message)
    {
        \CEventLog::Add(
            array(
                "SEVERITY"      => "WARNING",
                "AUDIT_TYPE_ID" => "CUSTOM_DEBUGBAR",
                "MODULE_ID"     => "custom.debugbar",
                "DESCRIPTION"   => $message,
            )
        );
    }


    /**
     * добавление обработчика событий
     * @param $event
     * @param $module
     */
    public static function addHandler($event, $module)
    {
        global $functionName;
        $functionName = $module."/".$event;
        AddEventHandler(
            $module,
            $event,
            function ($a, $b, $c, $d, $e) {
                global $functionName;
                self::addMessage($functionName.' Handler ', 'events');
                $arg_list = func_get_args();
                foreach ($arg_list as $arg) {
                    if ($arg && $arg !== '') {
                        \Custom\DebugBar::addMessage($arg, 'events');
                    }
                }
            }
        );
    }

    /**
     * стартуем таймер
     * @param $timer
     */
    public static function startTimer($timer)
    {
        self::$timers[$timer]['start'] = microtime();
    }

    /**
     * останавливаем таймер
     * @param $timer
     */
    public static function stopTimer($timer)
    {
        self::$timers[$timer]['stop'] = microtime();
        self::addMessage(self::$timers, 'timers');
    }

    /**
     * сохранение сообщений в файл
     * @param string $file
     */
    public static function saveMessages($file = 'dbb_log.txt')
    {
        $messagesArr = self::$messages;
        $result = [];
        foreach ($messagesArr as $bar => &$messages) {
            foreach ($messages as &$message) {
                $result[] = $message['text'];
            }
            unset($message);
        }
        unset($messages);

        $f = fopen($_SERVER['DOCUMENT_ROOT']."/".$file, "wb+");
        fwrite($f, json_encode($result));
        fclose($f);
    }

}