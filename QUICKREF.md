# Quick Reference Guide - com_advform

A quick reference for developers working with the Advanced Form component.

## Component Overview

**Name:** com_advform  
**Version:** 1.0.0  
**Namespace:** `SamWebTechnologies\Component\Advform`  
**Joomla:** 5.0+  
**PHP:** 8.1+

## Directory Structure

```
com_advform/
├── administrator/components/com_advform/
│   ├── access.xml                    # ACL permissions
│   ├── advform.xml                   # Component manifest
│   ├── config.xml                    # Component options
│   ├── forms/
│   │   ├── field.xml                 # Field edit form
│   │   ├── option.xml                # Option subform
│   │   └── filter_fields.xml         # List filters
│   ├── language/en-GB/
│   │   ├── com_advform.ini           # Admin language
│   │   └── com_advform.sys.ini       # System language
│   ├── services/
│   │   └── provider.php              # DI container
│   ├── sql/
│   │   ├── install.mysql.utf8.sql    # Installation
│   │   └── uninstall.mysql.utf8.sql  # Uninstallation
│   ├── src/
│   │   ├── Controller/
│   │   │   ├── FieldController.php   # Single item
│   │   │   └── FieldsController.php  # List
│   │   ├── Extension/
│   │   │   └── AdvformComponent.php  # Component class
│   │   ├── Model/
│   │   │   ├── FieldModel.php        # Admin model
│   │   │   └── FieldsModel.php       # List model
│   │   ├── Table/
│   │   │   └── FieldTable.php        # Database table
│   │   └── View/
│   │       ├── Field/HtmlView.php    # Edit view
│   │       └── Fields/HtmlView.php   # List view
│   └── tmpl/
│       ├── field/edit.php            # Edit template
│       └── fields/default.php        # List template
└── components/com_advform/
    └── src/                          # Frontend (Phase 2)
```

## Database Schema

### Table: #__advform_fields

| Column | Type | Description |
|--------|------|-------------|
| id | INT(10) UNSIGNED | Primary key |
| title | VARCHAR(255) | Field title |
| name | VARCHAR(255) | Unique identifier |
| type | VARCHAR(50) | Field type |
| label | VARCHAR(255) | Display label |
| description | TEXT | Help text |
| required | TINYINT(1) | Required flag |
| default_value | TEXT | Default value |
| state | TINYINT(3) | Published state |
| ordering | INT(11) | Display order |
| params | TEXT | JSON parameters |
| show_on_profile | TINYINT(1) | Profile visibility |
| show_on_registration | TINYINT(1) | Registration visibility |
| user_editable | TINYINT(1) | User edit permission |
| show_in_admin | TINYINT(1) | Admin visibility |
| created | DATETIME | Creation timestamp |
| created_by | INT(10) UNSIGNED | Creator user ID |
| modified | DATETIME | Modification timestamp |
| modified_by | INT(10) UNSIGNED | Modifier user ID |
| checked_out | INT(10) UNSIGNED | Checkout user ID |
| checked_out_time | DATETIME | Checkout timestamp |

## Field Types

| Type | Description |
|------|-------------|
| text | Single line text |
| textarea | Multi-line text |
| email | Email with validation |
| url | URL with validation |
| telephone | Phone number |
| number | Numeric input |
| calendar | Date picker |
| list | Dropdown select |
| radio | Radio buttons |
| checkbox | Single checkbox |
| checkboxes | Multiple checkboxes |
| editor | WYSIWYG editor |

## Common Tasks

### Add a New Field Type

1. **Update form**: `administrator/components/com_advform/forms/field.xml`
   ```xml
   <option value="newtype">COM_ADVFORM_FIELD_TYPE_NEWTYPE</option>
   ```

2. **Add language string**: `language/en-GB/com_advform.ini`
   ```ini
   COM_ADVFORM_FIELD_TYPE_NEWTYPE="New Type"
   ```

3. **Update filter**: `forms/filter_fields.xml`

### Query Fields

```php
use Joomla\CMS\Factory;

$db = Factory::getDbo();
$query = $db->getQuery(true);

$query->select('*')
    ->from($db->quoteName('#__advform_fields'))
    ->where($db->quoteName('state') . ' = 1')
    ->order($db->quoteName('ordering') . ' ASC');

$db->setQuery($query);
$fields = $db->loadObjectList();
```

### Get Field by Name

```php
$db = Factory::getDbo();
$query = $db->getQuery(true);

$query->select('*')
    ->from($db->quoteName('#__advform_fields'))
    ->where($db->quoteName('name') . ' = ' . $db->quote('field_name'));

$db->setQuery($query);
$field = $db->loadObject();
```

### Check Permission

```php
use Joomla\CMS\Factory;

$user = Factory::getApplication()->getIdentity();

// Check if user can create
if ($user->authorise('core.create', 'com_advform')) {
    // User can create
}

// Check if user can edit
if ($user->authorise('core.edit', 'com_advform')) {
    // User can edit
}

// Check if user can delete
if ($user->authorise('core.delete', 'com_advform')) {
    // User can delete
}
```

## URL Structure

### Admin URLs

- List: `index.php?option=com_advform&view=fields`
- Edit: `index.php?option=com_advform&view=field&layout=edit&id=X`
- New: `index.php?option=com_advform&view=field&layout=edit`

### Tasks

- Save: `task=field.save`
- Save & Close: `task=field.save`
- Save & New: `task=field.save2new`
- Save as Copy: `task=field.save2copy`
- Cancel: `task=field.cancel`
- Publish: `task=fields.publish`
- Unpublish: `task=fields.unpublish`
- Delete: `task=fields.delete`

## Language Strings

### Key Patterns

- `COM_ADVFORM_*` - General component strings
- `COM_ADVFORM_FIELD_*` - Field-related strings
- `COM_ADVFORM_FIELDSET_*` - Form fieldset labels
- `COM_ADVFORM_HEADING_*` - Table column headings
- `COM_ADVFORM_ERROR_*` - Error messages

### Example Usage

```php
use Joomla\CMS\Language\Text;

// In PHP
echo Text::_('COM_ADVFORM_FIELD_TYPE_TEXT');

// In templates
<?php echo Text::_('COM_ADVFORM_MANAGER_FIELDS'); ?>
```

## Permissions (ACL)

| Permission | Action |
|------------|--------|
| core.admin | Access component configuration |
| core.manage | Access administration interface |
| core.create | Create new fields |
| core.delete | Delete fields |
| core.edit | Edit any field |
| core.edit.state | Change published state |
| core.edit.own | Edit own fields |

## Form Rendering

### In Controllers

```php
// Get form
$form = $this->getModel()->getForm();

// Set form data
$form->bind($data);

// Validate
if (!$form->validate($data)) {
    $errors = $form->getErrors();
}
```

### In Views

```php
// Render entire fieldset
echo $this->form->renderFieldset('general');

// Render single field
echo $this->form->renderField('title');

// Get field value
$value = $this->form->getValue('title');
```

## JavaScript Integration

### Web Assets

```php
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
   ->useScript('form.validate')
   ->useScript('table.columns')
   ->useScript('multiselect');
```

## Debugging

### Enable Debug Mode

In Joomla's `configuration.php`:
```php
public $debug = '1';
public $error_reporting = 'maximum';
```

### Check Logs

- PHP error log: Usually in `/logs/php_errors.log`
- Joomla error log: `administrator/logs/error.php`

### Common Issues

1. **Class not found**: Clear cache, check namespaces
2. **Language strings not showing**: Clear cache, check language files
3. **Database errors**: Check table prefix, verify SQL syntax
4. **Permission denied**: Check ACL permissions

## Build & Deploy

### Build Package

```bash
./build.sh
```

Generates: `build/com_advform_1.0.0.zip`

### Validate Component

```bash
./validate.sh
```

### Install

1. Upload via Joomla installer
2. Or manually copy files and install SQL

## Testing Checklist

- [ ] Create new field
- [ ] Edit existing field
- [ ] Delete field
- [ ] Publish/unpublish
- [ ] Search fields
- [ ] Filter by type
- [ ] Filter by state
- [ ] Reorder fields
- [ ] Batch operations
- [ ] Check-in/check-out
- [ ] Permissions work correctly
- [ ] Language strings display
- [ ] No PHP errors
- [ ] No JavaScript errors

## Resources

- [README.md](README.md) - Full documentation
- [INSTALLATION.md](INSTALLATION.md) - Installation guide
- [CONTRIBUTING.md](CONTRIBUTING.md) - Contributing guidelines
- [CHANGELOG.md](CHANGELOG.md) - Version history

## Support

- Issues: https://github.com/STotla/com_advform/issues
- Email: admin@samwebtechnologies.com

---

**Last Updated:** February 2026  
**Version:** 1.0.0
