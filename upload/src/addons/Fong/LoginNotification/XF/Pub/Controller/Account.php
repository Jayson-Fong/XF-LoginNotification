<?php


namespace Fong\LoginNotification\XF\Pub\Controller;


use XF\Entity\UserOption;

class Account extends XFCP_Account
{

    public function actionNotifications() : \XF\Mvc\Reply\View
    {
        $this->assertTwoStepPasswordVerified();

        $view = $this->view('Fong\LoginNotification:Account\Notifications', 'loginnotification_notifications', []);
        return $this->addAccountWrapperParams($view, 'security');
    }

    public function actionNotificationsEnable() : \XF\Mvc\Reply\Redirect
    {
        $this->assertTwoStepPasswordVerified();
        $this->assertPostOnly();

        $this->updateNotificationPreference(true);

        return $this->redirect($this->buildLink('account/notifications'));
    }

    public function actionNotificationsDisable() : \XF\Mvc\Reply\Redirect
    {
        $this->assertTwoStepPasswordVerified();
        $this->assertPostOnly();

        $this->updateNotificationPreference(false);

        return $this->redirect($this->buildLink('account/notifications'));
    }

    protected function updateNotificationPreference(bool $enable) : void {
        $visitor = \XF::visitor();
        $userOption = $visitor->Option;
        $userOption->loginnotification_notification = $enable;
        $userOption->save();
    }

}