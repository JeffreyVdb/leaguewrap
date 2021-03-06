<?php
namespace JeffreyVdb\LeagueWrap\Dto;

use JeffreyVdb\LeagueWrap\StaticOptimizer;

trait ImportStaticTrait {

	/**
	 * Sets all the static fields in the current dto in the fields
	 * and aggrigates it with the child dto fields.
	 *
	 * @return array
	 */
	protected function getStaticFields()
	{
		$splHash = spl_object_hash($this);
		$fields  = [
			$splHash => [],
		];

		foreach ($this->staticFields as $field => $data)
		{
			$fieldValue = isset($this->info[$field]) ? $this->info[$field] : null;
			if ( ! isset($fields[$splHash][$data]))
			{
				$fields[$splHash][$data] = [];
			}
			$fields[$splHash][$data][] = $fieldValue;
		}

		$fields += parent::getStaticFields();
		return $fields;
	}

	/**
	 * Takes a result array and attempts to fill in any needed
	 * static data.
	 *
	 * @param staticOptimizer $optimizer
	 * @return void
	 */
	protected function addStaticData(StaticOptimizer $optimizer)
	{
		$splHash = spl_object_hash($this);
		$info    = $optimizer->getDataFromHash($splHash);
		foreach ($this->staticFields as $field => $data)
		{
			$infoArray  = $info[$data];
			$fieldValue = $this->info[$field];
			$staticData = $infoArray[$fieldValue];

			$this->info[$data.'StaticData'] = $staticData;
		}
	}
}
