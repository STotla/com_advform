<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_advform
 *
 * @copyright   Copyright (C) 2026 Sam Web Technologies. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace SamWebTechnologies\Component\Advform\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Model\AdminModel;

/**
 * Field model.
 *
 * @since  1.0.0
 */
class FieldModel extends AdminModel
{
    /**
     * The type alias for this content type.
     *
     * @var    string
     * @since  1.0.0
     */
    public $typeAlias = 'com_advform.field';

    /**
     * Method to get the record form.
     *
     * @param   array    $data      Data for the form.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     *
     * @return  Form|boolean  A Form object on success, false on failure
     *
     * @since   1.0.0
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm(
            'com_advform.field',
            'field',
            array(
                'control' => 'jform',
                'load_data' => $loadData
            )
        );

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed  The data for the form.
     *
     * @since   1.0.0
     */
    protected function loadFormData()
    {
        $app = Factory::getApplication();

        // Check the session for previously entered form data.
        $data = $app->getUserState('com_advform.edit.field.data', array());

        if (empty($data)) {
            $data = $this->getItem();
        }

        $this->preprocessData('com_advform.field', $data);

        return $data;
    }

    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string  $name     The table name. Optional.
     * @param   string  $prefix   The class prefix. Optional.
     * @param   array   $options  Configuration array for model. Optional.
     *
     * @return  \Joomla\CMS\Table\Table  A Table object
     *
     * @since   1.0.0
     * @throws  \Exception
     */
    public function getTable($name = 'Field', $prefix = 'Administrator', $options = array())
    {
        return parent::getTable($name, $prefix, $options);
    }

    /**
     * Method to save the form data.
     *
     * @param   array  $data  The form data.
     *
     * @return  boolean  True on success.
     *
     * @since   1.0.0
     */
    public function save($data)
    {
        $app = Factory::getApplication();

        // Handle params - convert options array to JSON for list-type fields
        if (isset($data['options']) && is_array($data['options'])) {
            $params = new \Joomla\Registry\Registry();
            $params->set('options', $data['options']);
            $data['params'] = $params->toString();
            unset($data['options']);
        } elseif (!isset($data['params']) || empty($data['params'])) {
            $data['params'] = '{}';
        }

        // Ensure params is a string
        if (is_array($data['params'])) {
            $params = new \Joomla\Registry\Registry($data['params']);
            $data['params'] = $params->toString();
        }

        return parent::save($data);
    }
}
