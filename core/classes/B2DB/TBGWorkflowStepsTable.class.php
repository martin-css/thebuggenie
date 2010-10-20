<?php

	/**
	 * Workflow steps table
	 *
	 * @author Daniel Andre Eikeland <zegenie@zegeniestudios.net>
	 ** @version 3.0
	 * @license http://www.opensource.org/licenses/mozilla1.1.php Mozilla Public License 1.1 (MPL 1.1)
	 * @package thebuggenie
	 * @subpackage tables
	 */

	/**
	 * Workflow steps table
	 *
	 * @package thebuggenie
	 * @subpackage tables
	 */
	class TBGWorkflowStepsTable extends B2DBTable
	{

		const B2DBNAME = 'workflow_steps';
		const ID = 'workflow_steps.id';
		const SCOPE = 'workflow_steps.scope';
		const NAME = 'workflow_steps.name';
		const STATUS_ID = 'workflow_steps.status_id';
		const WORKFLOW_ID = 'workflow_steps.workflow_id';
		const IS_CLOSED = 'workflow_steps.is_closed';
		const DESCRIPTION = 'workflow_steps.description';
		const EDITABLE = 'workflow_steps.editable';

		/**
		 * Return an instance of this table
		 *
		 * @return TBGWorkflowStepsTable
		 */
		public static function getTable()
		{
			return B2DB::getTable('TBGWorkflowStepsTable');
		}

		public function __construct()
		{
			parent::__construct(self::B2DBNAME, self::ID);
			parent::_addForeignKeyColumn(self::SCOPE, TBGScopesTable::getTable(), TBGScopesTable::ID);
			parent::_addForeignKeyColumn(self::STATUS_ID, TBGListTypesTable::getTable(), TBGListTypesTable::ID);
			parent::_addForeignKeyColumn(self::WORKFLOW_ID, TBGWorkflowsTable::getTable(), TBGWorkflowsTable::ID);
			parent::_addVarchar(self::NAME, 200);
			parent::_addText(self::DESCRIPTION, false);
			parent::_addBoolean(self::EDITABLE);
			parent::_addBoolean(self::IS_CLOSED);
		}

		public function loadFixtures($scope)
		{
			$steps = array();
			$steps[] = array('name' => 'New', 'description' => 'A new issue, not yet handled', 'status_id' => 20, 'editable' => true, 'is_closed' => false);
			$steps[] = array('name' => 'Investigating', 'description' => 'An issue that is being investigated, looked into or is by other means between new and unconfirmed state', 'status_id' => 21, 'editable' => false, 'is_closed' => false);
			$steps[] = array('name' => 'Confirmed', 'description' => 'An issue that has been confirmed', 'status_id' => 22, 'editable' => false, 'is_closed' => false);
			$steps[] = array('name' => 'In progress', 'description' => 'An issue that is being adressed', 'status_id' => 24, 'editable' => false, 'is_closed' => false);
			$steps[] = array('name' => 'Testing', 'description' => 'An issue where the proposed or implemented solution is currently being tested or approved', 'status_id' => 27, 'editable' => false, 'is_closed' => false);
			$steps[] = array('name' => 'Ready for testing', 'description' => 'An issue that has been marked fixed and is ready for testing', 'status_id' => 26, 'editable' => true, 'is_closed' => false);
			$steps[] = array('name' => 'Rejected', 'description' => 'A closed issue that has been rejected', 'status_id' => 23, 'editable' => false, 'is_closed' => true);
			$steps[] = array('name' => 'Closed', 'description' => 'A closed issue', 'status_id' => null, 'editable' => false, 'is_closed' => true);

			foreach ($steps as $step)
			{
				$crit = $this->getCriteria();
				$crit->addInsert(self::WORKFLOW_ID, 1);
				$crit->addInsert(self::SCOPE, $scope);
				$crit->addInsert(self::NAME, $step['name']);
				$crit->addInsert(self::DESCRIPTION, $step['description']);
				$crit->addInsert(self::STATUS_ID, $step['status_id']);
				$crit->addInsert(self::IS_CLOSED, $step['is_closed']);
				$crit->addInsert(self::EDITABLE, $step['editable']);
				$this->doInsert($crit);
			}
		}

		public function countByWorkflowID($workflow_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere(self::WORKFLOW_ID, $workflow_id);
			$crit->addWhere(self::SCOPE, TBGContext::getScope()->getID());

			return $this->doCount($crit);
		}

		public function getByWorkflowID($workflow_id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere(self::WORKFLOW_ID, $workflow_id);
			$crit->addWhere(self::SCOPE, TBGContext::getScope()->getID());

			$return_array = array();
			if ($res = $this->doSelect($crit))
			{
				while ($row = $res->getNextRow())
				{
					$return_array[$row->get(self::ID)] = TBGContext::factory()->TBGWorkflowStep($row->get(self::ID), $row);
				}
			}

			return $return_array;
		}

		public function getByID($id)
		{
			$crit = $this->getCriteria();
			$crit->addWhere(self::SCOPE, TBGContext::getScope()->getID());
			$row = $this->doSelectById($id, $crit, false);
			return $row;
		}

	}