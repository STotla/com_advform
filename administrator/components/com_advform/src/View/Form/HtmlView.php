<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_advform
 *
 * @copyright   Copyright (C) 2026 Sam Web Technologies. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace SamWebTechnologies\Component\Advform\Administrator\View\Form;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * View to edit a form.
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
    /**
     * The \JForm object
     *
     * @var  \Joomla\CMS\Form\Form
     */
    protected $form;

    /**
     * The active item
     *
     * @var  object
     */
    protected $item;

    /**
     * The model state
     *
     * @var  \Joomla\CMS\Object\CMSObject
     */
    protected $state;

    /**
     * Display the view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function display($tpl = null)
    {
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');
        $this->state = $this->get('State');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new GenericDataException(implode("\n", $errors), 500);
        }

        $this->addToolbar();

        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    protected function addToolbar()
    {
        Factory::getApplication()->input->set('hidemainmenu', true);

        $user = Factory::getApplication()->getIdentity();
        $isNew = ($this->item->id == 0);
        $canDo = \Joomla\CMS\Helper\ContentHelper::getActions('com_advform');

        ToolbarHelper::title(
            $isNew ? Text::_('COM_ADVFORM_FORM_NEW') : Text::_('COM_ADVFORM_FORM_EDIT'),
            'pencil-2 article-add'
        );

        // Since it's a new record, check the create permission.
        if ($isNew && $canDo->get('core.create')) {
            ToolbarHelper::apply('form.apply');
            ToolbarHelper::save('form.save');
            ToolbarHelper::save2new('form.save2new');
        } else {
            // Since it's an existing record, check the edit permission.
            if ($canDo->get('core.edit')) {
                ToolbarHelper::apply('form.apply');
                ToolbarHelper::save('form.save');

                if ($canDo->get('core.create')) {
                    ToolbarHelper::save2new('form.save2new');
                }
            }
        }

        if ($isNew) {
            ToolbarHelper::cancel('form.cancel');
        } else {
            ToolbarHelper::cancel('form.cancel', 'JTOOLBAR_CLOSE');
        }

        ToolbarHelper::divider();
        ToolbarHelper::help('', false, 'https://samwebtechnologies.com/docs/com-advform');
    }
}
