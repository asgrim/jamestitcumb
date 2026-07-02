<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateWebmentionSyncStateTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('webmention_sync_state', ['id' => false, 'primary_key' => 'id'])
            ->addColumn('id', 'boolean', ['default' => true])
            ->addColumn('last_synced_at', 'timestamp', ['timezone' => true])
            ->addIndex(['id'], ['unique' => true, 'name' => 'webmention_sync_state_singleton'])
            ->create();

        $this->execute('ALTER TABLE webmention_sync_state ADD CONSTRAINT webmention_sync_state_id_true CHECK (id)');
    }
}
