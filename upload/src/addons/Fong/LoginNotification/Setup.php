<?php

namespace Fong\LoginNotification;

use XF\AddOn\AbstractSetup;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{
	public function install(array $stepParams = [])
	{
        $this->schemaManager()->alterTable('xf_user_option', function(Alter $table) {
            $table->addColumn('loginnotification_notification', 'tinyint')->setDefault(0)->after('user_id');
        });
	}

	public function upgrade(array $stepParams = [])
	{
		// TODO: Implement upgrade() method.
	}

	public function uninstall(array $stepParams = [])
	{
        $this->schemaManager()->alterTable('xf_user_option', function(Alter $table) {
            $table->dropColumns('loginnotification_notificaton');
        });
	}
}