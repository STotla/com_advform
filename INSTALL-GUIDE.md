# Quick Installation Guide

## For End Users

If you received the `com_advform_1.0.0.zip` file, follow these simple steps to install it:

### Step 1: Access Joomla Administrator

1. Open your web browser
2. Go to your Joomla administrator URL (usually `https://yoursite.com/administrator`)
3. Log in with your administrator credentials

### Step 2: Navigate to Extension Installer

1. Click on **System** in the top menu
2. Click on **Install** in the left sidebar
3. Click on **Extensions** (or you might already be on the Extensions page)

### Step 3: Upload and Install

1. You should see tabs at the top, click on **Upload Package File**
2. Click the **Browse** or **Choose File** button
3. Select the `com_advform_1.0.0.zip` file from your computer
4. Click **Upload & Install** button
5. Wait for the installation to complete (usually takes a few seconds)

### Step 4: Verify Installation

You should see a success message that says:
```
Installation of the component was successful.
```

### Step 5: Access the Component

1. Click on **Components** in the top menu
2. You should see **Advanced Form** in the dropdown
3. Click on **Advanced Form** → **Fields**
4. You're now in the Advanced Form component!

## For Developers

If you cloned the repository from GitHub:

```bash
# 1. Clone the repository
git clone https://github.com/STotla/com_advform.git
cd com_advform

# 2. Build the installation package
chmod +x build.sh
./build.sh

# 3. Install the generated file
# The file is now available at: build/com_advform_1.0.0.zip
# Follow the "For End Users" steps above to install it
```

## Troubleshooting

### "Error: File upload is larger than allowed"

**Solution:** Increase PHP upload limits:
1. Edit your `php.ini` file
2. Set `upload_max_filesize = 32M`
3. Set `post_max_size = 32M`
4. Restart your web server

### "Error: Could not find a Joomla! XML setup file"

**Solution:** The ZIP file structure is incorrect. Make sure:
1. You're using the file from the `build/` directory
2. The `advform.xml` file is at the root of the ZIP (not in a subdirectory)
3. Re-run `./build.sh` to regenerate the package

### "Component menu doesn't appear"

**Solution:**
1. Go to **System** → **Clear Cache**
2. Log out and log back into the administrator
3. The menu should now appear under **Components**

### "Database tables not created"

**Solution:**
1. Check that your database user has CREATE TABLE permissions
2. Check Joomla's error logs for specific database errors
3. Manually run the SQL installation script if needed:
   ```sql
   mysql -u username -p database_name < administrator/components/com_advform/sql/install.mysql.utf8.sql
   ```

## System Requirements

Before installing, ensure your system meets these requirements:

- ✅ Joomla 5.0 or higher
- ✅ PHP 8.1 or higher
- ✅ MySQL 5.7+ or MariaDB 10.3+
- ✅ Web server (Apache 2.4+ or Nginx 1.18+)

## What Gets Installed

The component will install:

1. **Database Table:** `#__advform_fields` - Stores custom field definitions
2. **Backend Files:** Administrator component files in `administrator/components/com_advform/`
3. **Frontend Files:** Site component files in `components/com_advform/`
4. **Menu Item:** "Advanced Form" menu item under Components menu
5. **Permissions:** ACL permissions for managing fields

## Next Steps

After successful installation:

1. **Configure Permissions:**
   - Go to **Components** → **Advanced Form** → **Options**
   - Set permissions for different user groups

2. **Create Your First Field:**
   - Go to **Components** → **Advanced Form** → **Fields**
   - Click **New** to create a custom field

3. **Read Documentation:**
   - See [README.md](README.md) for complete features list
   - See [INSTALLATION.md](INSTALLATION.md) for advanced installation methods
   - See [FEATURES.md](FEATURES.md) for detailed feature descriptions

## Uninstalling

To uninstall the component:

1. Go to **System** → **Manage** → **Extensions**
2. Search for "Advanced Form" or filter by "Component"
3. Select the checkbox next to the component
4. Click **Uninstall**

⚠️ **Warning:** Uninstalling will delete all field data. Backup your database first!

## Support

Need help? 

- Check the [INSTALLATION.md](INSTALLATION.md) troubleshooting section
- Visit the GitHub repository: https://github.com/STotla/com_advform
- Report issues: https://github.com/STotla/com_advform/issues

---

**Version:** 1.0.0  
**Last Updated:** February 2026  
**Joomla Compatibility:** 5.0+
