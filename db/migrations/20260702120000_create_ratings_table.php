<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateRatingsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('ratings', ['id' => 'id'])
            ->addColumn('talk_url', 'text')
            ->addColumn('rating', 'smallinteger')
            ->addColumn('updated_at', 'timestamp', ['timezone' => true, 'default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['talk_url'], ['unique' => true, 'name' => 'ratings_talk_url_unique'])
            ->create();
    }
}
