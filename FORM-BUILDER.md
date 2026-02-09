# Form Builder Feature Documentation

## Overview

The Advanced Form component now includes a comprehensive form builder that allows you to create customized forms with drag-and-drop functionality. This feature enables you to:

- Create custom forms with multiple field types
- Drag and drop fields onto the form canvas
- Customize each field with various properties
- Define options for select, radio, and checkbox fields
- Save and manage forms

## Features

### Form Management

1. **Create Forms**: Navigate to Components → Advanced Form → Forms → New
2. **Edit Forms**: Click on any form title in the forms list
3. **Publish/Unpublish**: Control form visibility

### Form Builder Interface

The form builder includes two main sections:

#### Field Palette

Available field types to drag onto your form:
- **Text** - Single-line text input
- **Textarea** - Multi-line text input
- **Email** - Email address with validation
- **Select (Dropdown)** - Dropdown selection list
- **Radio** - Radio button group
- **Checkbox** - Single or multiple checkboxes

#### Form Canvas

The drag-and-drop area where you build your form by dragging field types from the palette.

### Field Customization

Each field can be customized with the following properties:

#### Basic Properties
- **Field Label**: Display label for the field
- **Field Name**: Unique identifier (used as form field name)
- **Placeholder**: Hint text shown in empty fields
- **Default Value**: Pre-filled value
- **Required**: Make field mandatory

#### Styling Properties
- **CSS Class**: Custom CSS classes for styling
- **Color**: Color picker for field customization

#### Options (for Select, Radio, Checkbox)
- **Value**: The value sent when option is selected
- **Text**: Display text for the option
- Add multiple options using the "Add Option" button

## Usage Guide

### Creating a Form

1. Go to **Components** → **Advanced Form** → **Forms**
2. Click **New** button
3. Fill in the form details:
   - **Title**: Name of your form (required)
   - **Description**: Brief description
   - **State**: Published/Unpublished

### Building the Form

1. Switch to the **Form Builder** tab
2. Drag field types from the palette to the canvas
3. Click **Edit** on each field to customize:
   - Set the field label
   - Configure field name
   - Add placeholder text
   - Set default values
   - Add CSS classes
   - Choose colors
   - Mark as required if needed
4. For Select/Radio/Checkbox fields, add options:
   - Click "Add Option"
   - Enter value and display text
   - Add multiple options as needed
   - Remove unwanted options

### Saving the Form

1. Click **Save** or **Save & Close**
2. The form and all its fields are saved
3. Form appears in the forms list

## Database Structure

### Forms Table (`#__advform_forms`)

Stores form definitions:
- id, title, description
- state (published/unpublished)
- created, created_by, modified, modified_by
- params (JSON for additional settings)

### Form Fields Table (`#__advform_form_fields`)

Stores individual fields for each form:
- form_id (links to forms table)
- field_type, field_label, field_name
- placeholder, default_value
- css_class, color
- required flag
- options (JSON for select/radio/checkbox)
- ordering, params

## Technical Details

### Field Data Storage

Field configurations are stored as JSON and include:
```json
{
  "field_type": "text",
  "field_label": "Your Name",
  "field_name": "user_name",
  "placeholder": "Enter your name",
  "default_value": "",
  "css_class": "form-control",
  "color": "#000000",
  "required": 1,
  "options": []
}
```

### Options Format

For select, radio, and checkbox fields:
```json
{
  "options": [
    {"value": "option1", "text": "Option 1"},
    {"value": "option2", "text": "Option 2"}
  ]
}
```

## Best Practices

1. **Unique Field Names**: Ensure each field has a unique name within the form
2. **Clear Labels**: Use descriptive labels for better user experience
3. **Placeholders**: Add helpful placeholder text for input fields
4. **Required Fields**: Mark essential fields as required
5. **Options**: Provide clear, distinct options for select/radio/checkbox fields
6. **CSS Classes**: Use consistent CSS classes for uniform styling

## Limitations

- Only one form can be created/edited at a time (per session)
- Field reordering is based on the order they appear in the canvas
- Options for select/radio/checkbox must be defined during form building

## Future Enhancements

Planned features for future versions:
- Frontend form rendering
- Form submissions storage
- Email notifications on form submission
- Conditional field visibility
- Field validation rules
- Form templates
- Export/Import forms
