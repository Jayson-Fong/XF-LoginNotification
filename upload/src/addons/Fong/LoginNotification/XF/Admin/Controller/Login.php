<?php


namespace Fong\LoginNotification\XF\Admin\Controller;


class Login extends XFCP_Login
{

    protected function completeLogin(\XF\Entity\User $user)
    {
        // Make sure the user has an email. Else, rather pointless.
        if ($user->email === '') {
            return parent::completeLogin($user);
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