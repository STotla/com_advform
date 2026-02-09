<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_advform
 *
 * @copyright   Copyright (C) 2026 Sam Web Technologies. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace SamWebTechnologies\Component\Advform\Administrator\Table;

defined('_JEXEC') or die;

use Joomla\CMS\Table\Table;
use Joomla\CMS\Language\Text;
use Joomla\Database\DatabaseDriver;
use Joomla\CMS\Factory;
use Joomla\CMS\Application\ApplicationHelper;

/**
 * Field table
 *
 * @since  1.0.0
 */
class FieldTable extends Table
{
    /**
     * Constructor
     *
     * @param   DatabaseDriver  $db  Database connector object
     *
     * @since   1.0.0
     */
    public function __construct(DatabaseDriver $db)
    {
        parent::__construct('#__advform_fields', 'id', $db);
    }

    /**
     * Method to store a row in the database from the Table instance properties.
     *
     * @param   boolean  $updateNulls  True to update fields even if they are null.
     *
     * @return  boolean  True on success.
     *
     * @since   1.0.0
     */
    public function store($updateNulls = true)
    {
        $date = Factory::getDate()->toSql();
        $user = Factory::getApplication()->getIdentity();

        // Set created date if new
        if (empty($this->id)) {
            if (!(int) $this->created) {
                $this->created = $date;
            }
            if (empty($this->created_by)) {
                $this->created_by = $user->id;
            }
        }

        // Set modified date
        $this->modified = $date;
        $this->modified_by = $user->id;

        // Generate name from title if empty
        if (empty($this->name) && !empty($this->title)) {
            $this->name = ApplicationHelper::stringURLSafe($this->title);
        }

        return parent::store($updateNulls);
    }

    /**
     * Method to perform sanity checks on the Table instance properties to ensure
     * they are safe to store in the database.
     *
     * @return  boolean  True if the instance is sane and able to be stored in the database.
     *
     * @since   1.0.0
     */
    public function check()
    {
        // Check for valid name
        if (trim($this->title) == '') {
            $this->setError(Text::_('COM_ADVFORM_ERROR_TITLE_REQUIRED'));
            return false;
        }

        // Generate name from title if empty
        if (empty($this->name)) {
            $this->name = ApplicationHelper::stringURLSafe($this->title);
        }

        // Check for unique name
        $db = $this->getDbo();
        $query = $db->getQuery(true)
            ->select('COUNT(*)')
            ->from($db->quoteName('#__advform_fields'))
            ->where($db->quoteName('name') . ' = ' . $db->quote($this->name))
            ->where($db->quoteName('id') . ' != ' . (int) $this->id);

        $db->setQuery($query);
        $count = $db->loadResult();

        if ($count > 0) {
            $this->setError(Text::_('COM_ADVFORM_ERROR_NAME_NOT_UNIQUE'));
            return false;
        }

        return true;
    }
}
