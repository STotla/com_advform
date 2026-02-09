<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_advform
 *
 * @copyright   Copyright (C) 2026 Sam Web Technologies. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Layout\LayoutHelper;

$app = Factory::getApplication();
$input = $app->input;

$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
    ->useScript('form.validate');

$this->useCoreUI = true;

// Get form fields if editing
$formFields = isset($this->item->form_fields) ? $this->item->form_fields : array();
$formFieldsJson = json_encode($formFields);
?>

<style>
.form-builder-container {
    display: flex;
    gap: 20px;
    margin-top: 20px;
}
.field-palette {
    flex: 0 0 200px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 15px;
}
.field-palette h4 {
    margin-top: 0;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 10px;
}
.field-type-item {
    padding: 8px 12px;
    margin-bottom: 8px;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    cursor: move;
    font-size: 13px;
}
.field-type-item:hover {
    background: #e9ecef;
}
.form-canvas {
    flex: 1;
    min-height: 400px;
    background: #fff;
    border: 2px dashed #dee2e6;
    border-radius: 4px;
    padding: 20px;
}
.form-canvas.drag-over {
    background: #e7f3ff;
    border-color: #0d6efd;
}
.form-field-item {
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    padding: 15px;
    margin-bottom: 15px;
    position: relative;
}
.form-field-item.dragging {
    opacity: 0.5;
}
.field-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.field-label {
    font-weight: 600;
    font-size: 14px;
}
.field-actions {
    display: flex;
    gap: 5px;
}
.field-actions button {
    padding: 4px 8px;
    font-size: 12px;
}
.field-details {
    display: none;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #dee2e6;
}
.field-details.active {
    display: block;
}
.field-input-group {
    margin-bottom: 10px;
}
.field-input-group label {
    display: block;
    font-size: 12px;
    font-weight: 500;
    margin-bottom: 4px;
}
.field-input-group input,
.field-input-group select,
.field-input-group textarea {
    width: 100%;
    padding: 6px 10px;
    font-size: 13px;
    border: 1px solid #ced4da;
    border-radius: 4px;
}
.option-item {
    display: flex;
    gap: 10px;
    margin-bottom: 8px;
}
.option-item input {
    flex: 1;
}
.option-item button {
    padding: 4px 8px;
    font-size: 12px;
}
</style>

<form action="<?php echo Route::_('index.php?option=com_advform&view=form&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">

    <div class="main-card">
        <?php echo HTMLHelper::_('uitab.startTabSet', 'myTab', ['active' => 'general', 'recall' => true, 'breakpoint' => 768]); ?>

        <?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'general', Text::_('COM_ADVFORM_FIELDSET_GENERAL')); ?>
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <?php echo $this->form->renderField('title'); ?>
                        <?php echo $this->form->renderField('description'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <?php echo $this->form->renderField('state'); ?>
                        <?php echo $this->form->renderField('id'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo HTMLHelper::_('uitab.endTab'); ?>

        <?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'builder', Text::_('COM_ADVFORM_FORM_BUILDER')); ?>
        <div class="form-builder-container">
            <div class="field-palette">
                <h4><?php echo Text::_('COM_ADVFORM_FIELD_TYPES'); ?></h4>
                <div class="field-type-item" draggable="true" data-type="text">
                    <span class="icon-text"></span> <?php echo Text::_('COM_ADVFORM_FIELD_TYPE_TEXT'); ?>
                </div>
                <div class="field-type-item" draggable="true" data-type="textarea">
                    <span class="icon-file-alt"></span> <?php echo Text::_('COM_ADVFORM_FIELD_TYPE_TEXTAREA'); ?>
                </div>
                <div class="field-type-item" draggable="true" data-type="email">
                    <span class="icon-envelope"></span> <?php echo Text::_('COM_ADVFORM_FIELD_TYPE_EMAIL'); ?>
                </div>
                <div class="field-type-item" draggable="true" data-type="select">
                    <span class="icon-list"></span> <?php echo Text::_('COM_ADVFORM_FIELD_TYPE_SELECT'); ?>
                </div>
                <div class="field-type-item" draggable="true" data-type="radio">
                    <span class="icon-radio"></span> <?php echo Text::_('COM_ADVFORM_FIELD_TYPE_RADIO'); ?>
                </div>
                <div class="field-type-item" draggable="true" data-type="checkbox">
                    <span class="icon-checkbox"></span> <?php echo Text::_('COM_ADVFORM_FIELD_TYPE_CHECKBOX'); ?>
                </div>
            </div>
            <div class="form-canvas" id="formCanvas">
                <p class="text-muted" id="emptyMessage"><?php echo Text::_('COM_ADVFORM_DRAG_FIELDS_HERE'); ?></p>
            </div>
        </div>
        <input type="hidden" name="form_fields_data" id="formFieldsData" value="">
        <?php echo HTMLHelper::_('uitab.endTab'); ?>

        <?php echo HTMLHelper::_('uitab.addTab', 'myTab', 'publishing', Text::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php echo $this->form->renderFieldset('publishing'); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo HTMLHelper::_('uitab.endTab'); ?>

        <?php echo HTMLHelper::_('uitab.endTabSet'); ?>
    </div>

    <input type="hidden" name="task" value="">
    <?php echo HTMLHelper::_('form.token'); ?>
</form>

<script>
(function() {
    'use strict';
    
    let fieldCounter = 0;
    let formFields = <?php echo $formFieldsJson; ?> || [];
    const defaultFieldColor = '#000000';
    
    // Initialize existing fields
    document.addEventListener('DOMContentLoaded', function() {
        if (formFields.length > 0) {
            formFields.forEach(function(field) {
                addFieldToCanvas(field.field_type, field);
            });
        }
        updateFormData();
    });
    
    // Drag and drop functionality
    const fieldTypes = document.querySelectorAll('.field-type-item');
    const formCanvas = document.getElementById('formCanvas');
    
    fieldTypes.forEach(function(item) {
        item.addEventListener('dragstart', handleDragStart);
    });
    
    formCanvas.addEventListener('dragover', handleDragOver);
    formCanvas.addEventListener('drop', handleDrop);
    formCanvas.addEventListener('dragleave', handleDragLeave);
    
    function handleDragStart(e) {
        e.dataTransfer.effectAllowed = 'copy';
        e.dataTransfer.setData('fieldType', this.dataset.type);
    }
    
    function handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
        formCanvas.classList.add('drag-over');
    }
    
    function handleDragLeave(e) {
        formCanvas.classList.remove('drag-over');
    }
    
    function handleDrop(e) {
        e.preventDefault();
        formCanvas.classList.remove('drag-over');
        
        const fieldType = e.dataTransfer.getData('fieldType');
        addFieldToCanvas(fieldType);
    }
    
    function addFieldToCanvas(fieldType, fieldData) {
        const emptyMessage = document.getElementById('emptyMessage');
        if (emptyMessage) {
            emptyMessage.style.display = 'none';
        }
        
        fieldCounter++;
        const fieldId = fieldData ? fieldData.id : 'field_' + fieldCounter;
        
        const fieldDiv = document.createElement('div');
        fieldDiv.className = 'form-field-item';
        fieldDiv.dataset.fieldId = fieldId;
        fieldDiv.dataset.fieldType = fieldType;
        
        const fieldLabel = fieldData ? fieldData.field_label : 'New ' + fieldType + ' field';
        const fieldName = fieldData ? fieldData.field_name : 'field_' + fieldCounter;
        const placeholder = fieldData ? fieldData.placeholder : '';
        const defaultValue = fieldData ? fieldData.default_value : '';
        const cssClass = fieldData ? fieldData.css_class : '';
        const color = fieldData ? fieldData.color : '';
        const required = fieldData ? fieldData.required : 0;
        const options = fieldData && fieldData.options ? JSON.parse(fieldData.options) : [];
        
        let optionsHtml = '';
        if (fieldType === 'select' || fieldType === 'radio' || fieldType === 'checkbox') {
            optionsHtml = '<div class="field-input-group"><label>Options:</label><div id="options_' + fieldId + '">';
            if (options.length > 0) {
                options.forEach(function(opt, idx) {
                    const escapedValue = String(opt.value).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
                    const escapedText = String(opt.text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
                    optionsHtml += '<div class="option-item"><input type="text" placeholder="Value" value="' + escapedValue + '" data-option-value><input type="text" placeholder="Text" value="' + escapedText + '" data-option-text><button type="button" class="btn btn-sm btn-danger remove-option-btn">Remove</button></div>';
                });
            }
            optionsHtml += '</div><button type="button" class="btn btn-sm btn-success mt-2 add-option-btn">Add Option</button></div>';
        }
        
        const fieldColor = color || defaultFieldColor;
        
        fieldDiv.innerHTML = `
            <div class="field-header">
                <span class="field-label">${fieldLabel} (${fieldType})</span>
                <div class="field-actions">
                    <button type="button" class="btn btn-sm btn-primary toggle-details-btn">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger remove-field-btn">Delete</button>
                </div>
            </div>
            <div class="field-details" id="details_${fieldId}">
                <div class="field-input-group">
                    <label>Field Label:</label>
                    <input type="text" value="${fieldLabel}" data-field-label>
                </div>
                <div class="field-input-group">
                    <label>Field Name:</label>
                    <input type="text" value="${fieldName}" data-field-name>
                </div>
                <div class="field-input-group">
                    <label>Placeholder:</label>
                    <input type="text" value="${placeholder}" data-placeholder>
                </div>
                <div class="field-input-group">
                    <label>Default Value:</label>
                    <input type="text" value="${defaultValue}" data-default-value>
                </div>
                <div class="field-input-group">
                    <label>CSS Class:</label>
                    <input type="text" value="${cssClass}" data-css-class>
                </div>
                <div class="field-input-group">
                    <label>Color:</label>
                    <input type="color" value="${fieldColor}" data-color>
                </div>
                <div class="field-input-group">
                    <label>
                        <input type="checkbox" ${required ? 'checked' : ''} data-required> Required
                    </label>
                </div>
                ${optionsHtml}
            </div>
        `;
        
        formCanvas.appendChild(fieldDiv);
        
        // Add event listeners for buttons
        const toggleBtn = fieldDiv.querySelector('.toggle-details-btn');
        const removeBtn = fieldDiv.querySelector('.remove-field-btn');
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const details = fieldDiv.querySelector('.field-details');
                if (details) {
                    details.classList.toggle('active');
                }
            });
        }
        
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove this field?')) {
                    fieldDiv.remove();
                    updateFormData();
                    
                    // Show empty message if no fields
                    const remainingFields = document.querySelectorAll('.form-field-item');
                    if (remainingFields.length === 0) {
                        const emptyMessage = document.getElementById('emptyMessage');
                        if (emptyMessage) {
                            emptyMessage.style.display = 'block';
                        }
                    }
                }
            });
        }
        
        // Add event listeners for option buttons
        const addOptionBtn = fieldDiv.querySelector('.add-option-btn');
        if (addOptionBtn) {
            addOptionBtn.addEventListener('click', function() {
                const optionsDiv = fieldDiv.querySelector('[id^="options_"]');
                if (optionsDiv) {
                    const optionItem = document.createElement('div');
                    optionItem.className = 'option-item';
                    optionItem.innerHTML = '<input type="text" placeholder="Value" data-option-value><input type="text" placeholder="Text" data-option-text><button type="button" class="btn btn-sm btn-danger remove-option-btn">Remove</button>';
                    optionsDiv.appendChild(optionItem);
                    
                    // Add event listeners for new option
                    const inputs = optionItem.querySelectorAll('input');
                    inputs.forEach(function(input) {
                        input.addEventListener('change', updateFormData);
                        input.addEventListener('input', updateFormData);
                    });
                    
                    const removeOptBtn = optionItem.querySelector('.remove-option-btn');
                    if (removeOptBtn) {
                        removeOptBtn.addEventListener('click', function() {
                            optionItem.remove();
                            updateFormData();
                        });
                    }
                    
                    updateFormData();
                }
            });
        }
        
        // Add event listeners for existing remove option buttons
        const removeOptBtns = fieldDiv.querySelectorAll('.remove-option-btn');
        removeOptBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                btn.closest('.option-item').remove();
                updateFormData();
            });
        });
        
        // Add event listeners for input changes
        const inputs = fieldDiv.querySelectorAll('input, select, textarea');
        inputs.forEach(function(input) {
            input.addEventListener('change', updateFormData);
            input.addEventListener('input', updateFormData);
        });
        
        updateFormData();
    }
    
    function updateFormData() {
        const fields = [];
        const fieldItems = document.querySelectorAll('.form-field-item');
        
        fieldItems.forEach(function(item, index) {
            const fieldData = {
                id: item.dataset.fieldId,
                field_type: item.dataset.fieldType,
                field_label: item.querySelector('[data-field-label]').value,
                field_name: item.querySelector('[data-field-name]').value,
                placeholder: item.querySelector('[data-placeholder]').value,
                default_value: item.querySelector('[data-default-value]').value,
                css_class: item.querySelector('[data-css-class]').value,
                color: item.querySelector('[data-color]').value,
                required: item.querySelector('[data-required]').checked ? 1 : 0,
                ordering: index + 1
            };
            
            // Get options if applicable
            const optionsDiv = item.querySelector('[id^="options_"]');
            if (optionsDiv) {
                const options = [];
                const optionItems = optionsDiv.querySelectorAll('.option-item');
                optionItems.forEach(function(opt) {
                    const value = opt.querySelector('[data-option-value]').value;
                    const text = opt.querySelector('[data-option-text]').value;
                    if (value || text) {
                        options.push({ value: value, text: text });
                    }
                });
                fieldData.options = options;
            }
            
            fields.push(fieldData);
        });
        
        document.getElementById('formFieldsData').value = JSON.stringify(fields);
    }
    
    // Before form submit, ensure data is updated
    const form = document.getElementById('item-form');
    form.addEventListener('submit', function(e) {
        updateFormData();
    });
})();
</script>
