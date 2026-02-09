# Changelog

All notable changes to the com_advform component will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-02-09

### Added - Initial Release

#### Admin Field Manager
- Complete backend field management system
- Fields list view with filtering and search
- Field edit view with tabbed interface
- Support for 12+ field types:
  - Text, Textarea, Email, URL, Telephone, Number
  - Calendar (Date), List (Dropdown), Radio, Checkbox, Checkboxes, Editor

#### Field Management Features
- Create, read, update, delete (CRUD) operations for fields
- Publish/Unpublish functionality
- Trash and restore capability
- Drag-and-drop field ordering
- Batch operations (publish, unpublish, delete multiple fields)
- Check-in/check-out functionality to prevent concurrent editing

#### Field Configuration Options
- **General Tab:**
  - Title (required field)
  - Field type selection
  - Auto-generated unique name from title
  - Field label for display
  - Description/help text
  - Required field toggle
  - Default value setting
  - Published state management

- **Options Tab:**
  - Repeatable field options for list-based field types
  - Value and text pairs for each option
  - Add, remove, and reorder options

- **Field Settings Tab:**
  - Show on User Profile toggle
  - Show in Registration Form toggle
  - Editable by User toggle
  - Display in Admin List toggle
  - Placeholder text
  - Custom CSS class
  - Field ordering

- **Publishing Tab:**
  - Created date and author
  - Modified date and modifier
  - Field ID display

#### Filtering and Search
- Search by field title or name
- Filter by published state (Published/Unpublished/Trashed)
- Filter by field type
- Sort by multiple columns
- Pagination support

#### Database
- Complete database schema with `#__advform_fields` table
- Installation SQL script
- Uninstallation SQL script
- Proper indexing for performance

#### Access Control
- Full ACL (Access Control List) integration
- Permissions for:
  - Configure (core.admin)
  - Access Administration Interface (core.manage)
  - Create (core.create)
  - Delete (core.delete)
  - Edit (core.edit)
  - Edit State (core.edit.state)
  - Edit Own (core.edit.own)

#### Technical Implementation
- Joomla 5 MVC architecture
- Proper namespace: `SamWebTechnologies\Component\Advform`
- Service provider for dependency injection
- Table class with validation
- Admin and List models
- Form and Admin controllers
- HTML views for list and edit
- XML form definitions
- Bootstrap 5 UI components

#### Language Support
- English (en-GB) language files
- System language files
- Comprehensive language strings for all UI elements

#### Documentation
- Comprehensive README.md
- Detailed INSTALLATION.md guide
- License file (GPL v2+)
- Build script for package creation
- .gitignore for clean repository

#### Frontend
- Basic placeholder structure for Phase 2 development

### Technical Details

**Namespace:** `SamWebTechnologies\Component\Advform`  
**Component Name:** `com_advform`  
**Database Tables:** `#__advform_fields`  
**Joomla Version:** 5.0+  
**PHP Version:** 8.1+  
**MySQL Version:** 5.7+ / MariaDB 10.3+

### Files Included

- 21 PHP source files
- 6 XML configuration/form files
- 2 language files (.ini)
- 2 SQL scripts (install/uninstall)
- 4 documentation files

### Known Limitations

- Frontend functionality not yet implemented (Phase 2)
- No user profile integration yet (Phase 2)
- No form rendering on frontend (Phase 2)
- No field value storage/retrieval (Phase 2)

## [Unreleased] - Future Versions

### Planned for Version 2.0.0 (Phase 2)

#### Frontend Integration
- User profile field display
- Registration form integration
- Field value storage and retrieval
- User profile edit functionality

#### Additional Features
- Field groups/categories
- Conditional field display logic
- Field validation rules
- Import/Export fields
- Field templates
- Multi-language field support
- API endpoints for headless usage

#### Improvements
- Advanced field types (file upload, multi-select, etc.)
- Field dependencies
- Custom validation messages
- Field search in user list
- Bulk field operations
- Field usage statistics

---

## Version History

- **1.0.0** (2026-02-09) - Initial release with admin field manager
- **Future** - Frontend integration and advanced features

## Upgrade Notes

### From Development to 1.0.0
- Initial public release
- No upgrade path needed

### Future Upgrade Guidelines
- Always backup your database before upgrading
- Review changelog for breaking changes
- Test in staging environment first
- Clear Joomla cache after upgrade

## Support

For questions, issues, or feature requests:
- GitHub Issues: https://github.com/STotla/com_advform/issues
- Documentation: https://samwebtechnologies.com/docs/com-advform

## Credits

**Author:** Sam Web Technologies  
**Copyright:** Copyright (C) 2026 Sam Web Technologies  
**License:** GNU GPL v2.0 or later
