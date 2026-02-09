<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_advform
 *
 * @copyright   Copyright (C) 2026 Sam Web Technologies. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace SamWebTechnologies\Component\Advform\Administrator\View\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * View to edit a field.
 *
 * @since  1.0.0
 */
class HtmlView extends BaseHtmlView
{
    /**
     * The \Joomla\CMS\Form\Form object
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
     * Display the view.
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
            throw new \Exception(implode("\n", $errors), 500);
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
        $canDo = ContentHelper::getActions('com_advform');

        ToolbarHelper::title(
            Text::_('COM_ADVFORM_MANAGER_FIELD') . ': ' .
            ($isNew ? Text::_('JNEW') : Text::_('JEDIT')),
            'pencil-alt'
        );

        // If not checked out, can save the item.
        if ($canDo->get('core.edit') || ($canDo->get('core.create'))) {
            ToolbarHelper::apply('field.apply');
            ToolbarHelper::save('field.save');
        }

        if ($canDo->get('core.create')) {
            ToolbarHelper::save2new('field.save2new');
        }

        if (!$isNew && $canDo->get('core.create')) {
            ToolbarHelper::save2copy('field.save2copy');
        }

        ToolbarHelper::cancel('field.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');

        ToolbarHelper::help('', false, 'https://samwebtechnologies.com/docs/com-advform');
    }
}
