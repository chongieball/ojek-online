<?php 

namespace App\Extensions\Logs;

use Monolog\Handler\AbstractProcessingHandler;

abstract class DoctrineLogHandler extends AbstractProcessingHandler
{
	protected $table;
	protected $db;
	protected $query;

	public function __construct($db = null)
	{
		parent::__construct();
		$this->db = $db;
	}

	protected function write(array $record)
	{
		if (!$this->db) {
			$this->setDb();
		}

		$data = [
			'channel'	=> $record['channel'],
			'level'		=> $record['level_name'],
			'message'	=> $record['message'],
		];
		
		if (!empty($record['context'])) {
			foreach ($record['context'] as $key => $value) {
				$data[$key] = $value;
			}
		}

		$browser = get_browser(null, true);
		$data['browser'] = $browser['browser'].' '.$browser['platform'];

		$qb = $this->db->createQueryBuilder();
		foreach ($data as $key => $value) {
            $column[$key] = ':'.$key;
            $paramData[$key] = $value;
        }

        $qb->insert($this->table)
           ->values($column)
           ->setParameters($paramData)
           ->execute();
	}

	private function setDb()
	{
		global $container;

		$this->db = $container['db'];
	}
}