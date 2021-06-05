<?php


namespace Fong\LoginNotification\XF\ControllerPlugin;


class Login extends XFCP_Login
{

    public function completeLogin(\XF\Entity\User $user, $remember)
    {
        // Make sure the user has an email. Else, rather pointless.
        if ($user->email === '') {
            return parent::completeLogin($user, $remember);
        }

        /**
         * @var \Fong\LoginNotification\Service\User\Login $loginService
         */
        $loginService = $this->service('Fong\LoginNotification:User\Login', $user);

        // Check if the IP is already linked to the user or the visitor has it disabled.
        if (!$loginService->isEnabled() || $loginService->isKnown()) {
            return parent::completeLogin($user);
        }

        // If the IP is not already known
        $loginService->sendNotification();
        return parent::completeLogin($user);
    }

}