<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


class CustomDebugbarComponent extends \CBitrixComponent
{
    public function executeComponent()
    {
        try {
            $this->arParams['COMPONENT'] = 'custom.debugbar';

            if (!\Custom\DebugBar::checkRights()) {
                return false;
            }

            $this->arResult['messages'] = \Custom\DebugBar::getMessages();
            $this->arResult['info']     = \Custom\DebugBar::getBxInfo();
            $this->includeComponentTemplate();
        } catch (\Exception $e) {
            showError($e->getMessage());
        }
    }

}
