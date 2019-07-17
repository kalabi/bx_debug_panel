<?php

/**
 * Class DebugBarTrait
 */
trait DebugBarTrait
{
    /**
     * добавление сообщения
     *
     * @param        $message
     * @param string $bar
     * @param        $label
     */
    public function addMessage($message, $bar = 'default', $label)
    {
        \Custom\DebugBar::addMessage($message, $bar, $label);
    }

    /**
     * добавление сообщения в журнал битрикса
     * @param $message
     */
    public function addBxLog($message)
    {
        \Custom\DebugBar::addBxLog($message);
    }

    /**
     * добавление обработчика события
     * @param $event
     * @param $module
     */
    public static function addHandler($event, $module)
    {
        \Custom\DebugBar::addHandler($event, $module);
    }

    /**
     * стартуем таймер
     *
     * @param $timer
     */
    public static function startTimer($timer)
    {
        \Custom\DebugBar::$timers[$timer]['start'] = microtime();
    }

    /**
     * останавливаем таймер
     *
     * @param $timer
     */
    public static function stopTimer($timer)
    {
        \Custom\DebugBar::$timers[$timer]['stop'] = microtime();
        \Custom\DebugBar::addMessage(self::$timers, 'timers');
    }

    /**
     * добавить панель компонента
     *
     * @param $component
     */
    public static function addComponent($component)
    {
        \Custom\DebugBar::addComponent($component);
    }
}