# Installation Guide - com_advform

This guide provides detailed instructions for installing the Advanced Form component in Joomla 5.

## Prerequisites

Before installing com_advform, ensure your environment meets these requirements:

- **Joomla Version:** 5.0 or higher
- **PHP Version:** 8.1 or higher
- **MySQL:** 5.7 or higher (or MariaDB 10.3+)
- **Web Server:** Apache 2.4+ or Nginx 1.18+
- **Required PHP Extensions:**
  - mysqli
  - json
  - xml
  - mbstring

## Installation Methods

### Method 1: Standard Installation via Joomla Installer (Recommended)

This is the easiest and recommended method for most users.

#### Step 1: Download the Package

Download the latest release package `com_advform_1.0.0.zip` from the releases page.

#### Step 2: Access Joomla Administrator

1. Log into your Joomla Administrator panel
2. URL is typically: `https://yoursite.com/administrator`

#### Step 3: Install the Extension

1. Navigate to **System** → **Install** → **Extensions**
2. Click on the **Upload Package File** tab
3. Click **Browse** and select the `com_advform_1.0.0.zip` file
4. Click **Upload & Install**

#### Step 4: Verify Installation

1. You should see a success message: "Installation of the component was successful"
2. Navigate to **Components** → **Advanced Form** in the admin menu
3. You should see the Fields management interface

### Method 2: Build and Install from Source

This method is for developers who want to build from the repository.

#### Step 1: Clone the Repository

```bash
git clone https://github.com/STotla/com_advform.git
cd com_advform
```

#### Step 2: Build the Package

```bash
chmod +x build.sh
./build.sh
```

This will create `build/com_advform_1.0.0.zip`

#### Step 3: Install via Joomla

Follow steps 2-4 from Method 1 using the generated package.

### Method 3: Manual Installation (For Development)

This method is for developers who need direct access to files during development.

#### Step 1: Copy Administrator Files

```bash
cp -r administrator/components/com_advform /path/to/joomla/administrator/components/
```

#### Step 2: Copy Site Files

```bash
cp -r components/com_advform /path/to/joomla/components/
```

#### Step 3: Install Database Tables

Connect to your MySQL/MariaDB database and run:

```bash
mysql -u your_username -p your_database_name < administrator/components/com_advform/sql/install.mysql.utf8.sql
```

Or using phpMyAdmin:
1. Open phpMyAdmin
2. Select your Joomla database
3. Go to the SQL tab
4. Copy and paste the contents of `administrator/components/com_advform/sql/install.mysql.utf8.sql`
4. Click "Go" to execute

#### Step 4: Register the Extension

You need to manually add the extension record to the `#__extensions` table:

```sql
INSERT INTO `#__extensions` 
(`extension_id`, `package_id`, `name`, `type`, `element`, `folder`, `client_id`, `enabled`, `access`, `protected`, `manifest_cache`, `params`, `custom_data`, `checked_out`, `checked_out_time`, `ordering`, `state`) 
VALUES 
(NULL, 0, 'com_advform', 'component', 'com_advform', '', 1, 1, 1, 0, '', '{}', '', 0, '0000-00-00 00:00:00', 0, 0);
```

Note: You may need to clear Joomla's cache after manual installation.

## Post-Installation Configuration

### 1. Set Permissions

After installation, configure permissions for different user groups:

1. Go to **Components** → **Advanced Form**
2. Click the **Options** button in the toolbar
3. Click the **Permissions** tab
4. Configure permissions for each user group:
   - **Configure** - Who can access component options
   - **Access Administration Interface** - Who can access the backend
   - **Create** - Who can create new fields
   - **Delete** - Who can delete fields
   - **Edit** - Who can edit any field
   - **Edit State** - Who can publish/unpublish fields
   - **Edit Own** - Who can edit their own created fields

5. Click **Save & Close**

### 2. Create Your First Field

1. Navigate to **Components** → **Advanced Form** → **Fields**
2. Click **New** in the toolbar
3. Fill in the field details:
   - **Title**: Enter a descriptive title (e.g., "Phone Number")
   - **Type**: Select field type (e.g., "Telephone")
   - **Label**: How the field appears to users
   - **Description**: Help text for the field
   - **Required**: Select "Yes" if mandatory
4. Configure the **Options** tab (for list-based fields)
5. Set visibility in the **Settings** tab
6. Click **Save & Close**

### 3. Access the Component

The component can be accessed from:

**Administrator Panel:**
- **Components** → **Advanced Form** → **Fields**

## Verification

To verify the installation was successful:

1. Check the database table exists:
   ```sql
   SHOW TABLES LIKE '%advform%';
   ```
   You should see: `#__advform_fields`

2. Check the component is registered:
   ```sql
   SELECT * FROM `#__extensions` WHERE `element` = 'com_advform';
   ```

3. Navigate to **Components** → **Advanced Form** in the admin menu

4. Try creating a test field

## Troubleshooting

### Issue: Component menu not appearing

**Solution:**
1. Clear Joomla cache: **System** → **Clear Cache**
2. Log out and log back into administrator
3. Check if your user has appropriate permissions

### Issue: Database tables not created

**Solution:**
1. Check the SQL file exists: `administrator/components/com_advform/sql/install.mysql.utf8.sql`
2. Manually run the SQL script in phpMyAdmin or command line
3. Verify database user has CREATE TABLE permissions

### Issue: White screen or 500 error

**Solution:**
1. Enable error reporting in Joomla: **System** → **Global Configuration** → **Server** tab
2. Check PHP error logs
3. Verify PHP version is 8.1 or higher
4. Check file permissions (directories: 755, files: 644)

### Issue: "Class not found" errors

**Solution:**
1. Verify all files are in the correct directories
2. Check namespace is correct: `SamWebTechnologies\Component\Advform`
3. Clear Joomla's cache completely
4. Reinstall the component

### Issue: Language strings showing as constants

**Solution:**
1. Verify language files exist in: `administrator/components/com_advform/language/en-GB/`
2. Go to **System** → **Manage** → **Languages**
3. Click **Install Languages** and ensure English (United Kingdom) is installed
4. Clear cache

## Updating

To update to a newer version:

1. **Backup your database** - especially the `#__advform_fields` table
2. Download the new version package
3. Install using **System** → **Install** → **Extensions**
4. Joomla will automatically update the component
5. Verify the update: Check version in **System** → **Manage** → **Extensions**

## Uninstallation

To completely remove the component:

1. Go to **System** → **Manage** → **Extensions**
2. Search for "Advanced Form" or filter by "Component"
3. Select the checkbox next to "Advanced Form"
4. Click **Uninstall**

This will:
- Remove all component files
- Drop the `#__advform_fields` database table
- Remove the extension registration

**Warning:** Uninstalling will permanently delete all field data. Make sure to backup first!

## Support

If you encounter issues during installation:

1. Check this guide's troubleshooting section
2. Review the main [README.md](README.md) file
3. Submit an issue on GitHub: https://github.com/STotla/com_advform/issues
4. Include:
   - Joomla version
   - PHP version
   - Error messages
   - Installation method used

## Next Steps

After successful installation:

1. Read the [README.md](README.md) for component features and usage
2. Configure field settings according to your needs
3. Set up user permissions
4. Create custom fields for your site
5. Stay tuned for Phase 2 updates (frontend integration)

---

**Version:** 1.0.0  
**Last Updated:** February 2026  
**Joomla Compatibility:** 5.0+
