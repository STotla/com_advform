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
 * Form model.
 *
 * @since  1.0.0
 */
class FormModel extends AdminModel
{
    /**
     * The type alias for this content type.
     *
     * @var    string
     * @since  1.0.0
     */
    public $typeAlias = 'com_advform.form';

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
            'com_advform.form',
            'form',
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
        $data = $app->getUserState('com_advform.edit.form.data', array());

        if (empty($data)) {
            $data = $this->getItem();
            
            // Load form fields if we have an ID
            if ($data->id) {
                $data->form_fields = $this->getFormFields($data->id);
            }
        }

        $this->preprocessData('com_advform.form', $data);

        return $data;
    }

    /**
     * Method to get form fields for a form
     *
     * @param   int  $formId  The form ID
     *
     * @return  array  Array of form fields
     *
     * @since   1.0.0
     */
    public function getFormFields($formId)
    {
        $db = $this->getDatabase();
        $query = $db->getQuery(true)
            ->select('*')
            ->from($db->quoteName('#__advform_form_fields'))
            ->where($db->quoteName('form_id') . ' = ' . (int) $formId)
            ->order($db->quoteName('ordering') . ' ASC');

        $db->setQuery($query);
        return $db->loadObjectList();
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
    public function getTable($name = 'Form', $prefix = 'Administrator', $options = array())
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
        $db = $this->getDatabase();

        // Handle params
        if (!isset($data['params']) || empty($data['params'])) {
            $data['params'] = '{}';
        }

        // Ensure params is a string
        if (is_array($data['params'])) {
            $params = new \Joomla\Registry\Registry($data['params']);
            $data['params'] = $params->toString();
        }

        // Extract form fields data from JSON
        $formFieldsJson = isset($data['form_fields_data']) ? $data['form_fields_data'] : '';
        $formFields = !empty($formFieldsJson) ? json_decode($formFieldsJson, true) : array();
        unset($data['form_fields_data']);
        unset($data['form_fields']);

        // Save the form
        if (!parent::save($data)) {
            return false;
        }

        $formId = $this->getState($this->getName() . '.id');

        // Delete existing form fields
        $query = $db->getQuery(true)
            ->delete($db->quoteName('#__advform_form_fields'))
            ->where($db->quoteName('form_id') . ' = ' . (int) $formId);
        $db->setQuery($query);
        $db->execute();

        // Save new form fields
        if (!empty($formFields)) {
            foreach ($formFields as $index => $field) {
                $fieldData = new \stdClass();
                $fieldData->form_id = $formId;
                $fieldData->field_type = isset($field['field_type']) ? $field['field_type'] : 'text';
                $fieldData->field_label = isset($field['field_label']) ? $field['field_label'] : '';
                $fieldData->field_name = isset($field['field_name']) ? $field['field_name'] : '';
                $fieldData->placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
                $fieldData->default_value = isset($field['default_value']) ? $field['default_value'] : '';
                $fieldData->css_class = isset($field['css_class']) ? $field['css_class'] : '';
                $fieldData->color = isset($field['color']) ? $field['color'] : '';
                $fieldData->required = isset($field['required']) ? (int) $field['required'] : 0;
                $fieldData->options = isset($field['options']) ? json_encode($field['options']) : '';
                $fieldData->ordering = isset($field['ordering']) ? (int) $field['ordering'] : ($index + 1);
                $fieldData->params = isset($field['params']) ? json_encode($field['params']) : '{}';

                $db->insertObject('#__advform_form_fields', $fieldData);
            }
        }

        return true;
    }
}
