<?php


namespace Fong\LoginNotification\Service\User;


class Login extends \XF\Service\AbstractService
{

    /**
     * @var \XF\Entity\User
     */
    protected $user;

    public function __construct(\XF\App $app, \XF\Entity\User $user) {
        parent::__construct($app);
        $this->user = $user;
    }

    public function isKnown() : bool {
        /**
         * @var bool|int|string $binaryIp;
         */
        $binaryIp = \XF\Util\Ip::convertIpStringToBinary($this->app->request()->getIp());

        /**
         * @var \XF\Entity\Ip|null $ipEntity
         */
        $ipEntity = $this->finder('XF:Ip')
            ->where('ip', $binaryIp)
            ->where('user_id', $this->user->user_id)
            ->fetchOne();

        return !!$ipEntity;
    }

    public function isEnabled() : bool
    {
        return $this->user->Option->loginnotification_notification;
    }

    public function sendNotification() : void
    {
        $mail = $this->app->mailer()->newMail();
        $mail->setToUser($this->user)
            ->setTemplate($this->getEmailTemplateName(), $this->getEmailTemplateParams());
        $mail->send();
    }

    protected function getEmailTemplateName() : string
    {
        return 'loginnotification_user_login';
    }

    protected function getEmailTemplateParams() : array
    {
        $ip = $this->app->request()->getIp();
        $userAgent = $this->app->request()->getUserAgent();
        return [
            'user' => $this->user,
            'ip' => $ip,
            'userAgent' => $userAgent
        ];
    }

}