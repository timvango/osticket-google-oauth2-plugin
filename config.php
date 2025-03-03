<?php

require_once INCLUDE_DIR . 'class.plugin.php';

class OauthPluginConfig extends PluginConfig {

    // Provide compatibility function for versions of osTicket prior to
    // translation support (v1.9.4)
    function translate() {
        if (!method_exists('Plugin', 'translate')) {
            return array(
                function($x) { return $x; },
                function($x, $y, $n) { return $n != 1 ? $y : $x; },
            );
        }
        return Plugin::translate('auth-oauth');
    }

    function getOptions() {
        list($__, $_N) = self::translate();
        $modes = new ChoiceField(array(
            'label' => $__('Authentication'),
            'choices' => array(
                '0' => $__('Disabled'),
                'staff' => $__('Agents Only'),
                'client' => $__('Clients Only'),
                'all' => $__('Agents and Clients'),
            ),
        ));
        return array(
            'finefriends' => new SectionBreakField(array(
                'label' => $__('FineFriends Authentication'),
            )),
            'g-client-id' => new TextboxField(array(
                'label' => $__('Client ID'),
                'configuration' => array('size'=>60, 'length'=>100),
            )),
            'g-client-secret' => new TextboxField(array(
                'label' => $__('Client Secret'),
                'configuration' => array('size'=>60, 'length'=>100),
            )),
            /*auth-oauth: FineFriends: Allow domain whitelisting #122*/
            'g-allowed-domains-agents' => new TextboxField(array(
                'label' => $__('Allowed Domains for Agents'),
                'configuration' => array('size'=>60, 'length'=>100),
            )),
            'g-agents-button-url' => new TextboxField(array(
                'label' => $__('Button Image for Agents'),
                'configuration' => array('size'=>60, 'length'=>10000),
            )),
            'g-allowed-domains-clients' => new TextboxField(array(
                'label' => $__('Allowed Domains for Clients'),
                'configuration' => array('size'=>60, 'length'=>100),
            )),
            'g-clients-button-url' => new TextboxField(array(
                'label' => $__('Button Image for Clients'),
                'configuration' => array('size'=>60, 'length'=>10000),
            )),
            'g-enabled' => clone $modes,
        );
    }
}
