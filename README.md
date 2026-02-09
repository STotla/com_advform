# com_advform - Joomla 5 Advanced Form Component

A comprehensive Joomla 5 component for creating and managing custom fields with a field manager interface similar to Joomla's core custom fields functionality.

## Features

- **Admin Field Manager** - Complete backend interface for managing custom fields
- **Multiple Field Types** - Support for 12+ field types including text, textarea, email, URL, telephone, number, calendar, list, radio, checkbox, checkboxes, and editor
- **Field Options Management** - Repeatable field options interface for list-based field types
- **Advanced Settings** - Control field visibility on profile, registration, and admin areas
- **Filtering & Search** - Filter fields by status and type, search by title or name
- **Drag & Drop Ordering** - Easy field reordering with drag-and-drop support
- **Access Control** - Full ACL integration with Joomla's permission system
- **Batch Operations** - Publish, unpublish, delete multiple fields at once
- **Check-in/Check-out** - Prevent concurrent editing conflicts

## Requirements

- Joomla 5.0 or higher
- PHP 8.1 or higher
- MySQL 5.7 or higher / MariaDB 10.3 or higher

## Installation

### Method 1: Install from Package

1. Download the latest release package `com_advform_1.0.0.zip`
2. Log into your Joomla Administrator panel
3. Go to **System** → **Install** → **Extensions**
4. Click "Upload Package File" and select the downloaded ZIP file
5. Click "Upload & Install"
6. Once installed, go to **Components** → **Advanced Form** to start managing fields

### Method 2: Install from Repository

1. Clone this repository:
   ```bash
   git clone https://github.com/STotla/com_advform.git
   cd com_advform
   ```

2. Build the installation package:
   ```bash
   chmod +x build.sh
   ./build.sh
   ```

3. Install the generated package `build/com_advform_1.0.0.zip` through Joomla's extension installer

### Method 3: Manual Installation (Development)

For development purposes, you can manually copy the component files:

```bash
# Copy administrator files
cp -r administrator/components/com_advform /path/to/joomla/administrator/components/

# Copy site files
cp -r components/com_advform /path/to/joomla/components/

# Install the database tables manually
mysql -u username -p database_name < administrator/components/com_advform/sql/install.mysql.utf8.sql
```

## Component Structure

```
com_advform/
├── administrator/components/com_advform/    # Backend component
│   ├── access.xml                           # ACL permissions
│   ├── advform.xml                          # Component manifest
│   ├── config.xml                           # Component configuration
│   ├── forms/                               # XML form definitions
│   │   ├── field.xml                        # Field edit form
│   │   ├── option.xml                       # Field option subform
│   │   └── filter_fields.xml                # List filters
│   ├── language/en-GB/                      # Language files
│   │   ├── com_advform.ini
│   │   └── com_advform.sys.ini
│   ├── services/
│   │   └── provider.php                     # Dependency injection container
│   ├── sql/                                 # Database scripts
│   │   ├── install.mysql.utf8.sql
│   │   └── uninstall.mysql.utf8.sql
│   ├── src/                                 # PHP source files (namespaced)
│   │   ├── Controller/
│   │   │   ├── FieldController.php
│   │   │   └── FieldsController.php
│   │   ├── Extension/
│   │   │   └── AdvformComponent.php
│   │   ├── Model/
│   │   │   ├── FieldModel.php
│   │   │   └── FieldsModel.php
│   │   ├── Table/
│   │   │   └── FieldTable.php
│   │   └── View/
│   │       ├── Field/HtmlView.php
│   │       └── Fields/HtmlView.php
│   └── tmpl/                                # Template files
│       ├── field/edit.php
│       └── fields/default.php
└── components/com_advform/                  # Frontend component (placeholder)
    └── src/
```

## Usage

### Managing Fields

1. Navigate to **Components** → **Advanced Form** → **Fields**
2. Click **New** to create a new field
3. Fill in the field details:
   - **General Tab**: Title, type, label, description, required status
   - **Options Tab**: For list/radio/checkboxes - define the options
   - **Settings Tab**: Configure visibility and display settings
   - **Publishing Tab**: View creation and modification details

### Field Types

The component supports the following field types:

- **Text** - Single line text input
- **Textarea** - Multi-line text input
- **Email** - Email address with validation
- **URL** - Website URL with validation
- **Telephone** - Phone number input
- **Number** - Numeric input
- **Calendar** - Date picker
- **List** - Dropdown selection
- **Radio** - Radio button group
- **Checkbox** - Single checkbox
- **Checkboxes** - Multiple checkboxes
- **Editor** - WYSIWYG editor

### Field Settings

Each field can be configured with:

- **Show on Profile** - Display field on user profile pages
- **Show on Registration** - Include field in registration form
- **Editable by User** - Allow users to edit the field value
- **Display in Admin List** - Show field in admin user list
- **Placeholder Text** - Hint text for input fields
- **CSS Class** - Custom CSS classes for styling
- **Ordering** - Control the display order of fields

## Database Schema

The component creates one database table:

### #__advform_fields

Stores all custom field definitions:

| Column | Type | Description |
|--------|------|-------------|
| id | INT(10) UNSIGNED | Primary key |
| title | VARCHAR(255) | Field title |
| name | VARCHAR(255) | Unique field name (auto-generated) |
| type | VARCHAR(50) | Field type |
| label | VARCHAR(255) | Display label |
| description | TEXT | Help text |
| required | TINYINT(1) | Required field flag |
| default_value | TEXT | Default value |
| state | TINYINT(3) | Published state (1=published, 0=unpublished, -2=trashed) |
| ordering | INT(11) | Display order |
| params | TEXT | JSON encoded parameters (options, placeholder, CSS class) |
| show_on_profile | TINYINT(1) | Display on profile |
| show_on_registration | TINYINT(1) | Show in registration |
| user_editable | TINYINT(1) | User can edit |
| show_in_admin | TINYINT(1) | Display in admin |
| created | DATETIME | Creation date |
| created_by | INT(10) UNSIGNED | Creator user ID |
| modified | DATETIME | Last modification date |
| modified_by | INT(10) UNSIGNED | Last modifier user ID |
| checked_out | INT(10) UNSIGNED | Checked out user ID |
| checked_out_time | DATETIME | Check out time |

## Development

### Namespace

The component uses the namespace: `SamWebTechnologies\Component\Advform`

### Coding Standards

This component follows:
- Joomla 5 MVC architecture
- Joomla coding standards
- PSR-12 coding style
- Proper namespacing and autoloading

### Future Development (Roadmap)

Phase 2 planned features:
- Frontend user profile integration
- Frontend form rendering
- Field value storage and retrieval
- User profile display with custom fields
- Registration form integration
- API endpoints for headless usage

## Permissions

The component supports the following permissions:

- **Configure** (core.admin) - Access component configuration
- **Access Administration Interface** (core.manage) - Access backend
- **Create** (core.create) - Create new fields
- **Delete** (core.delete) - Delete fields
- **Edit** (core.edit) - Edit any field
- **Edit State** (core.edit.state) - Change published state
- **Edit Own** (core.edit.own) - Edit own created fields

## Uninstallation

To uninstall the component:

1. Go to **System** → **Manage** → **Extensions**
2. Search for "Advanced Form"
3. Select the component
4. Click **Uninstall**

This will remove all component files and drop the database table.

## Support

For issues, questions, or contributions:
- GitHub Issues: https://github.com/STotla/com_advform/issues
- Documentation: https://samwebtechnologies.com/docs/com-advform

## License

GNU General Public License version 2 or later

## Credits

**Author:** Sam Web Technologies  
**Copyright:** Copyright (C) 2026 Sam Web Technologies. All rights reserved.  
**Version:** 1.0.0  
**Release Date:** February 2026

## Changelog

### Version 1.0.0 (2026-02)
- Initial release
- Admin field manager with full CRUD operations
- Support for 12+ field types
- Filtering and search functionality
- Drag-and-drop ordering
- Field options management for list-based types
- Advanced field settings
- Full ACL integration
- Check-in/check-out functionality