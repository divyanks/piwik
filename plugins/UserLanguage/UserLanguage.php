<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\UserLanguage;

use Piwik\Container\StaticContainer;
use Piwik\Piwik;
use Piwik\FrontController;

/**
 *
 */
class UserLanguage extends \Piwik\Plugin
{
    /**
     * @see Piwik\Plugin::getListHooksRegistered
     */
    public function getListHooksRegistered()
    {
        return array(
            'Live.getAllVisitorDetails' => 'extendVisitorDetails',
            'Template.footerUserCountry' => 'footerUserCountry',
        );
    }

    public function extendVisitorDetails(&$visitor, $details)
    {
        $instance = new Visitor($details);

        $visitor['languageCode'] = $instance->getLanguageCode();
        $visitor['language']     = $instance->getLanguage();
    }

    public function footerUserCountry(&$out)
    {
        /** @var FrontController $frontController */
        $frontController = StaticContainer::get('Piwik\FrontController');

        $out .= '<h2 piwik-enriched-headline>' . Piwik::translate('UserLanguage_BrowserLanguage') . '</h2>';
        $out .= $frontController->fetchDispatch('UserLanguage', 'getLanguage');
    }
}