<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateWebmentionsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('webmentions', ['id' => 'id'])
            ->addColumn('target_url', 'text')
            ->addColumn('source_url', 'text')
            ->addColumn('wm_property', 'text')
            ->addColumn('published_at', 'timestamp', ['timezone' => true, 'null' => true])
            ->addColumn('payload', 'jsonb')
            ->addColumn('fetched_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['target_url', 'source_url'], ['unique' => true, 'name' => 'webmentions_target_source_unique'])
            ->create();
    }
}
